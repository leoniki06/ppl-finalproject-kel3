// resources/js/checkout.js
// LASTBITE - Checkout Page JS (FIXED)
// Goals:
// - Jangan bikin item "hilang" kalau /cart/summary error / session issue
// - Tetap validasi ulang dari server kalau tersedia
// - Selection source: checkout_data.items -> selectionMap -> default all
// - Render fallback dari checkout_data kalau server kosong

(function () {
    "use strict";

    // -----------------------------
    // Config
    // -----------------------------
    const CFG = window.CHECKOUT_CFG || {};
    const URLS = {
        cartSummary: CFG.cartSummaryUrl || "/cart/summary",
        cartIndex: CFG.cartIndexUrl || "/cart",
    };

    const DELIVERY_FEE = Number(CFG.deliveryFee ?? 10000);
    const SERVICE_FEE = Number(CFG.serviceFee ?? 2000);

    const CSRF =
        document.querySelector('meta[name="csrf-token"]')?.content ||
        window.__CSRF__ ||
        "";

    // -----------------------------
    // Storage keys (MUST match cart.js)
    // -----------------------------
    const LS = {
        payment: "lastbite_payment_method",
        voucher: "lastbite_voucher",
        checkout: "lastbite_checkout_data",
        selection: "lastbite_cart_selected_map",
    };

    // -----------------------------
    // State
    // -----------------------------
    let serverCartItems = []; // items from /cart/summary (normalized)
    let selectedItems = [];   // items to render on checkout
    let selectedPaymentMethod = null;
    let appliedVoucher = null;

    // -----------------------------
    // Helpers
    // -----------------------------
    function el(id) {
        return document.getElementById(id);
    }

    function safeParseJSON(str, fallback) {
        try {
            return JSON.parse(str);
        } catch {
            return fallback;
        }
    }

    function moneyIDR(n) {
        const val = Number(n || 0);
        return "Rp" + val.toLocaleString("id-ID");
    }

    function escapeHtml(str) {
        return String(str ?? "")
            .replaceAll("&", "&amp;")
            .replaceAll("<", "&lt;")
            .replaceAll(">", "&gt;")
            .replaceAll('"', "&quot;")
            .replaceAll("'", "&#039;");
    }

    function toast(message, type = "success") {
        if (window.Swal) {
            Swal.fire({
                toast: true,
                position: "top-end",
                timer: 1800,
                showConfirmButton: false,
                icon: type,
                title: message,
            });
            return;
        }
        console.log(`[${type}] ${message}`);
    }

    function isJsonResponse(res) {
        const ct = res.headers.get("content-type") || "";
        return ct.includes("application/json");
    }

    async function fetchJSON(url, opts = {}) {
        const res = await fetch(url, {
            credentials: "same-origin",
            ...opts,
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": CSRF,
                ...(opts.headers || {}),
            },
        });

        // IMPORTANT: kalau server balikin HTML (redirect/login page)
        if (!isJsonResponse(res)) {
            const text = await res.text().catch(() => "");
            const snippet = text.slice(0, 140);
            const err = new Error(`Non-JSON response (${res.status}). ${snippet}`);
            err.status = res.status;
            throw err;
        }

        const data = await res.json();
        if (!res.ok) {
            const err = new Error(data?.message || `Request failed (${res.status})`);
            err.status = res.status;
            err.data = data;
            throw err;
        }
        return data;
    }

    function normalizeItem(it) {
        const id = Number(it.id || it.product_id || 0);
        const price = Number(it.price || 0);
        const qty = Number(it.quantity || 0);

        return {
            id,
            product_id: id,
            name: it.name || it.product_name || "Product",
            price,
            quantity: qty,
            image_url:
                it.image_url ||
                it.image ||
                "https://images.unsplash.com/photo-1509440159596-0249088772ff?auto=format&fit=crop&w=500&q=80",
            brand: it.brand || "LastBite",
            category: it.category || "Product",
            description: it.description || "",
            expiry_date: it.expiry_date || it.exp || "",
            rating: it.rating || 4.5,
            rating_count: it.rating_count || 10,
        };
    }

    function loadPayment() {
        selectedPaymentMethod = localStorage.getItem(LS.payment) || null;
    }

    function loadVoucher() {
        appliedVoucher = safeParseJSON(localStorage.getItem(LS.voucher) || "null", null);
    }

    function loadCheckoutData() {
        return safeParseJSON(localStorage.getItem(LS.checkout) || "null", null);
    }

    function loadSelectionMap() {
        return safeParseJSON(localStorage.getItem(LS.selection) || "{}", {});
    }

    // -----------------------------
    // Selection logic (FIXED)
    // -----------------------------
    function pickSelectedIds() {
        const checkoutData = loadCheckoutData();
        const selectionMap = loadSelectionMap();

        // 1) Prefer checkout_data.items (paling valid untuk checkout flow)
        if (checkoutData?.items?.length) {
            const ids = checkoutData.items
                .map((x) => Number(x.id || x.product_id || 0))
                .filter((n) => n > 0);
            return { source: "checkout_data", ids, checkoutItems: checkoutData.items };
        }

        // 2) Fallback: selectionMap
        const mapKeys = Object.keys(selectionMap || {});
        if (mapKeys.length) {
            const ids = mapKeys
                .filter((k) => selectionMap[k] === true)
                .map((k) => Number(k))
                .filter((n) => n > 0);
            return { source: "selection_map", ids, checkoutItems: [] };
        }

        // 3) Default: empty means "select all" later if server exists
        return { source: "default_all", ids: [], checkoutItems: [] };
    }

    function mergeServerWithCheckoutFallback(serverItems, checkoutItemsFallback) {
        // Kalau server tersedia: update qty/price/name dari server untuk ID yang sama
        const serverMap = new Map(serverItems.map((x) => [Number(x.id), x]));

        return checkoutItemsFallback
            .map(normalizeItem)
            .map((it) => {
                const s = serverMap.get(Number(it.id));
                if (!s) return it; // item mungkin sudah dihapus dari cart, tetap tampil dulu
                return {
                    ...it,
                    // server override (lebih akurat)
                    name: s.name,
                    price: s.price,
                    quantity: s.quantity,
                    image_url: s.image_url,
                    brand: s.brand,
                    category: s.category,
                    description: s.description,
                    expiry_date: s.expiry_date,
                    rating: s.rating,
                    rating_count: s.rating_count,
                };
            });
    }

    // -----------------------------
    // Totals
    // -----------------------------
    function calcTotals(items) {
        const subtotal = items.reduce((acc, it) => acc + it.price * it.quantity, 0);
        const totalQty = items.reduce((acc, it) => acc + it.quantity, 0);

        let delivery = items.length ? DELIVERY_FEE : 0;
        let service = items.length ? SERVICE_FEE : 0;

        let discount = 0;
        if (appliedVoucher && items.length) {
            if (appliedVoucher.discountType === "delivery") {
                delivery = 0;
            } else {
                const pct = Number(appliedVoucher.discount || 0);
                discount = (subtotal * pct) / 100;
            }
        }

        const total = items.length ? subtotal + delivery + service - discount : 0;

        return { subtotal, delivery, service, discount, total, totalQty };
    }

    // -----------------------------
    // Render
    // -----------------------------
    function renderPaymentMethod() {
        const wrap = el("paymentMethodDisplay");
        if (!wrap) return;

        if (!selectedPaymentMethod) {
            wrap.innerHTML = `
        <div style="padding:16px;border:2px dashed rgba(63,35,5,.15);border-radius:12px;color:var(--text-light);">
          Payment method not selected yet. Please go back to cart and choose one.
        </div>
      `;
            return;
        }

        const map = {
            cash: { label: "Cash on Delivery", icon: "fa-money-bill-wave" },
            "e-wallet": { label: "E-Wallet", icon: "fa-wallet" },
            qris: { label: "QRIS", icon: "fa-qrcode" },
        };

        const info = map[selectedPaymentMethod] || {
            label: selectedPaymentMethod,
            icon: "fa-credit-card",
        };

        wrap.innerHTML = `
      <div style="background:var(--white);border-radius:14px;padding:18px;box-shadow:var(--shadow-light);border:2px solid rgba(63,35,5,.08);display:flex;gap:14px;align-items:center;">
        <div style="width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;background:rgba(63,35,5,.06);color:var(--primary-color);">
          <i class="fas ${info.icon}"></i>
        </div>
        <div style="flex:1;">
          <div style="font-weight:700;color:var(--text-dark);">${escapeHtml(info.label)}</div>
          <div style="font-size:13px;color:var(--text-light);margin-top:2px;">Selected from cart</div>
        </div>
      </div>
    `;
    }

    function renderVoucher() {
        const box = el("voucherApplied");
        const codeText = el("voucherCodeText");
        const discText = el("voucherDiscountText");

        if (!box || !codeText || !discText) return;

        if (!appliedVoucher) {
            box.style.display = "none";
            return;
        }

        box.style.display = "flex";
        codeText.textContent = appliedVoucher.code || "";
        discText.textContent =
            appliedVoucher.discountType === "delivery"
                ? "FREE SHIPPING"
                : `${Number(appliedVoucher.discount || 0)}% OFF`;
    }

    function renderItems(items, noteHtml = "") {
        const container = el("orderItemsContainer");
        if (!container) return;

        container.innerHTML = "";

        if (noteHtml) {
            const note = document.createElement("div");
            note.innerHTML = noteHtml;
            container.appendChild(note);
        }

        if (!items.length) {
            container.innerHTML += `
        <div style="padding:18px;border-radius:12px;background:rgba(220,53,69,.06);border:1px solid rgba(220,53,69,.15);color:#b02a37;">
          <strong>No items selected for checkout.</strong><br/>
          Go back to cart and select at least one item.
          <div style="margin-top:12px;">
            <a href="${URLS.cartIndex}" style="display:inline-flex;align-items:center;gap:10px;padding:10px 16px;border-radius:999px;background:var(--primary-color);color:#fff;text-decoration:none;font-weight:600;">
              <i class="fas fa-arrow-left"></i> Back to Cart
            </a>
          </div>
        </div>
      `;
            return;
        }

        items.forEach((it) => {
            const row = document.createElement("div");
            row.className = "order-item";

            row.innerHTML = `
        <div class="order-item-image">
          <img src="${it.image_url}" alt="${escapeHtml(it.name)}">
        </div>
        <div class="order-item-details">
          <div class="order-item-name">${escapeHtml(it.name)}</div>
          <div class="order-item-quantity">Qty: ${Number(it.quantity)}</div>
        </div>
        <div style="text-align:right;">
          <div class="order-item-price">${moneyIDR(it.price * it.quantity)}</div>
          <div style="font-size:12px;color:var(--text-light);">${moneyIDR(it.price)}/item</div>
        </div>
      `;

            container.appendChild(row);
        });
    }

    function renderTotals(items) {
        const totals = calcTotals(items);

        if (el("summarySubtotal")) el("summarySubtotal").textContent = moneyIDR(totals.subtotal);
        if (el("summaryDelivery")) el("summaryDelivery").textContent = moneyIDR(totals.delivery);
        if (el("summaryService")) el("summaryService").textContent = moneyIDR(totals.service);
        if (el("summaryDiscount"))
            el("summaryDiscount").textContent = totals.discount ? `-` + moneyIDR(totals.discount) : "-Rp0";
        if (el("summaryTotal")) el("summaryTotal").textContent = moneyIDR(totals.total);

        return totals;
    }

    // -----------------------------
    // Load Server Cart
    // -----------------------------
    async function loadServerCart() {
        const data = await fetchJSON(URLS.cartSummary, { method: "GET" });
        if (!data?.success) throw new Error(data?.message || "Failed to load cart summary");

        const items = Array.isArray(data.cart_items) ? data.cart_items : [];
        serverCartItems = items.map(normalizeItem);
    }

    // -----------------------------
    // Bind Buttons
    // -----------------------------
    function bindButtons() {
        const removeBtn = el("removeVoucherBtn");
        if (removeBtn) {
            removeBtn.addEventListener("click", () => {
                appliedVoucher = null;
                localStorage.removeItem(LS.voucher);
                renderVoucher();
                renderTotals(selectedItems);
                toast("Voucher removed", "info");
            });
        }

        el("changePaymentBtn")?.addEventListener("click", () => {
            toast("Change payment from Cart page", "info");
            window.location.href = URLS.cartIndex;
        });

        // (optional) kamu bisa bikin modal address nanti
        el("changeAddressBtn")?.addEventListener("click", () => {
            toast("Change address (connect to profile/address later)", "info");
        });

        el("confirmPaymentBtn")?.addEventListener("click", async () => {
            if (!selectedItems.length) {
                toast("No items selected", "warning");
                return;
            }
            if (!selectedPaymentMethod) {
                toast("Payment method not selected", "warning");
                window.location.href = URLS.cartIndex;
                return;
            }

            const totals = calcTotals(selectedItems);

            const r = await Swal.fire({
                title: "Confirm Payment?",
                html: `
      <div style="text-align:left;">
        <div><strong>Items:</strong> ${selectedItems.length}</div>
        <div><strong>Total:</strong> ${moneyIDR(totals.total)}</div>
        <div><strong>Payment:</strong> ${escapeHtml(selectedPaymentMethod)}</div>
      </div>
    `,
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, Pay Now",
                cancelButtonText: "Cancel",
            });

            if (!r.isConfirmed) return;

            // loading state
            Swal.fire({
                title: "Processing...",
                text: "Creating your order...",
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => Swal.showLoading(),
            });

            try {
                // Ambil alamat: kalau belum ada UI address, pakai fallback dari config / atau placeholder
                const shippingAddress =
                    CFG.shippingAddress ||
                    el("shippingAddressInput")?.value || // kalau suatu saat kamu punya input address
                    "Alamat belum diisi";

                const payload = {
                    shipping_address: shippingAddress,
                    payment_method: selectedPaymentMethod,
                    items: selectedItems.map((it) => ({
                        product_id: Number(it.product_id || it.id),
                        quantity: Number(it.quantity || 1),
                    })),
                };

                // 🔥 INI YANG SEBELUMNYA TIDAK ADA: POST KE BACKEND
                const resp = await fetchJSON("/checkout/process", {
                    method: "POST",
                    body: JSON.stringify(payload),
                });

                // sukses → bersihin localStorage + redirect
                localStorage.removeItem(LS.checkout);
                // (opsional) kalau kamu mau bersihin selection juga:
                // localStorage.removeItem(LS.selection);

                await Swal.fire({
                    title: "Payment Success!",
                    text: `Order created: ${resp.order_id || "OK"}`,
                    icon: "success",
                });

                window.location.href = "/dashboard#recommendations";
            } catch (err) {
                console.error(err);

                // tampilkan error yang benar (422/419/500)
                const msg =
                    err?.data?.message ||
                    err?.message ||
                    "Checkout failed. Please try again.";

                await Swal.fire({
                    title: "Checkout Failed",
                    text: msg,
                    icon: "error",
                });
            }
        });

    }

    // -----------------------------
    // Init (FIXED FLOW)
    // -----------------------------
    async function init() {
        loadPayment();
        loadVoucher();

        const pick = pickSelectedIds();
        const checkoutData = loadCheckoutData();

        // kalau checkout_data gak ada sama sekali + selection map kosong,
        // checkout page tetap bisa jalan, tapi akan default select all (jika server ok).
        // kalau server gagal, kita arahkan balik cart.
        let serverOk = true;

        try {
            await loadServerCart();
        } catch (err) {
            serverOk = false;
            console.error("loadServerCart failed:", err);

            // kalau server gagal dan gak ada checkout_data items: gak ada sumber untuk render
            if (!checkoutData?.items?.length) {
                toast("Session/Cart not available. Please go back to cart.", "error");
                // jangan paksa redirect kalau kamu mau debug, tapi untuk UX bagus:
                window.location.href = URLS.cartIndex;
                return;
            }
        }

        // Tentukan selectedItems:
        if (serverOk) {
            // server tersedia, pilih berdasarkan ids
            if (pick.source === "default_all") {
                selectedItems = [...serverCartItems];
            } else {
                const wanted = new Set((pick.ids || []).map((n) => Number(n)));
                selectedItems = serverCartItems.filter((it) => wanted.has(Number(it.id)));
            }

            // Kalau hasil filter kosong tapi checkout_data.items ada → fallback render checkout_data
            if (!selectedItems.length && checkoutData?.items?.length) {
                selectedItems = mergeServerWithCheckoutFallback(serverCartItems, checkoutData.items);
                toast("Using saved checkout items (server selection mismatch).", "info");
            }
        } else {
            // server gagal, fallback dari checkout_data.items
            selectedItems = (checkoutData.items || []).map(normalizeItem);
            toast("Loaded checkout items from saved data (server unreachable).", "warning");
        }

        // Render warning note kalau server mismatch / server fail
        let noteHtml = "";
        if (!serverOk) {
            noteHtml = `
        <div style="margin-bottom:12px;padding:12px;border-radius:12px;background:rgba(255,193,7,.12);border:1px solid rgba(255,193,7,.25);color:rgba(35,24,10,.85);">
          <strong>Note:</strong> Cart summary from server failed. Showing saved checkout items.
          If you changed cart in another tab/device, please go back to cart.
        </div>
      `;
        } else if (checkoutData?.items?.length && pick.source === "checkout_data" && !pick.ids.length) {
            // unlikely, but keep safe
            noteHtml = `
        <div style="margin-bottom:12px;padding:12px;border-radius:12px;background:rgba(13,110,253,.08);border:1px solid rgba(13,110,253,.16);color:rgba(35,24,10,.85);">
          <strong>Info:</strong> Checkout selection not found. Please re-select items from cart.
        </div>
      `;
        }

        // Render UI
        renderPaymentMethod();
        renderVoucher();
        renderItems(selectedItems, noteHtml);
        renderTotals(selectedItems);

        bindButtons();
    }

    document.addEventListener("DOMContentLoaded", init);
})();
