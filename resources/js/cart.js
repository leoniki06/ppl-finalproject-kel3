/* ==========================================================================
   CART PAGE LOGIC
   File: resources/js/cart.js
   ========================================================================== */

(function () {
    const CFG = window.CART_CFG || {};
    const CSRF =
        CFG.csrf ||
        window.__CSRF__ ||
        document.querySelector('meta[name="csrf-token"]')?.content;

    const IS_AUTH = !!(CFG.isAuth ?? window.__IS_AUTH__);

    const URLS = {
        summary: CFG.summaryUrl || window.__CART_SUMMARY_URL__,
        add: CFG.addUrl || window.__CART_ADD_URL__,
        update: CFG.updateUrl || window.__CART_UPDATE_URL__,
        remove: CFG.removeUrl || window.__CART_REMOVE_URL__,
        checkout: CFG.checkoutUrl || window.__CHECKOUT_URL__,
        dashboard: CFG.dashboardUrl || window.__DASHBOARD_URL__,
    };

    const FEES = {
        delivery: Number(CFG.deliveryFee ?? 10000),
        service: Number(CFG.serviceFee ?? 2000),
    };

    const el = (id) => document.getElementById(id);

    const state = {
        items: [],
        selectedIds: new Set(),
        voucher: null,
        paymentMethod: null,
        loading: true,
        syncing: new Set(),
    };

    // -----------------------------
    // Helpers
    // -----------------------------
    function rupiah(n) {
        const num = Number(n || 0);
        return "Rp" + num.toLocaleString("id-ID");
    }

    function safeNum(v, fallback = 0) {
        const n = Number(v);
        return Number.isFinite(n) ? n : fallback;
    }

    function showAlert(message, tone = "info") {
        const box = el("cartAlert");
        if (!box) return;
        box.hidden = false;
        box.textContent = message;

        if (tone === "danger") {
            box.style.background = "rgba(229,72,77,.10)";
            box.style.borderColor = "rgba(229,72,77,.30)";
        } else if (tone === "success") {
            box.style.background = "rgba(35,162,109,.10)";
            box.style.borderColor = "rgba(35,162,109,.30)";
        } else {
            box.style.background = "rgba(254,186,23,.08)";
            box.style.borderColor = "rgba(78,31,0,.10)";
        }
    }

    function hideAlert() {
        const box = el("cartAlert");
        if (!box) return;
        box.hidden = true;
        box.textContent = "";
    }

    async function api(url, method = "GET", body = null) {
        const opts = {
            method,
            headers: {
                Accept: "application/json",
            },
            credentials: "same-origin",
        };

        if (method !== "GET") {
            opts.headers["Content-Type"] = "application/json";
            if (CSRF) opts.headers["X-CSRF-TOKEN"] = CSRF;
            opts.body = JSON.stringify(body || {});
        }

        const res = await fetch(url, opts);
        const ct = res.headers.get("content-type") || "";
        const data = ct.includes("application/json")
            ? await res.json()
            : await res.text();

        if (!res.ok) {
            const msg =
                data && data.message ? data.message : `Request failed (${res.status})`;
            throw new Error(msg);
        }
        return data;
    }

    function normalizeItems(raw) {
        const arr = Array.isArray(raw) ? raw : raw?.items || raw?.data || [];
        return (arr || [])
            .map((it) => {
                const id = Number(it.product_id ?? it.id ?? it.product?.id ?? 0);
                const name = String(it.name ?? it.product_name ?? it.product?.name ?? "");
                const price = safeNum(it.price ?? it.product?.price ?? 0);
                const original = safeNum(
                    it.original_price ?? it.product?.original_price ?? price
                );
                const qty = Math.max(1, safeNum(it.quantity ?? it.qty ?? 1, 1));
                const brand = String(it.brand ?? it.product?.brand ?? "");
                const category = String(it.category ?? it.product?.category ?? "");
                const image =
                    it.image_full_url ||
                    it.image_url ||
                    it.product?.image_full_url ||
                    it.product?.image_url ||
                    null;

                return {
                    id,
                    name,
                    price,
                    original_price: original,
                    quantity: qty,
                    brand,
                    category,
                    image,
                };
            })
            .filter((x) => x.id);
    }

    function escapeHtml(s) {
        return String(s || "")
            .replaceAll("&", "&amp;")
            .replaceAll("<", "&lt;")
            .replaceAll(">", "&gt;")
            .replaceAll('"', "&quot;")
            .replaceAll("'", "&#039;");
    }

    function imageHtml(url) {
        if (!url) {
            return `<div class="image-empty" aria-hidden="true"><i class="fas fa-image"></i></div>`;
        }
        return `<img src="${escapeHtml(url)}" alt="" loading="lazy">`;
    }

    function isInteractiveTarget(target) {
        if (!target) return false;
        return !!target.closest(
            'button, a, input, select, textarea, label, [role="button"], [data-action]'
        );
    }

    // -----------------------------
    // Rendering
    // -----------------------------
    function render() {
        const container = el("cartItemsContainer");
        const skeleton = el("cartSkeleton");
        if (!container) return;

        if (state.loading) {
            if (skeleton) skeleton.style.display = "grid";
            return;
        }
        if (skeleton) skeleton.style.display = "none";

        if (!state.items.length) {
            container.innerHTML = `
        <div class="cart-empty">
          <i class="fas fa-shopping-basket"></i>
          <h3>Your cart is empty</h3>
          <p>Add some products from the dashboard to start your order.</p>
          <a href="${URLS.dashboard}"><i class="fas fa-store"></i> Browse Products</a>
        </div>
      `;
            updateSummaryUI();
            return;
        }

        container.innerHTML = state.items
            .map((item) => {
                const checked = state.selectedIds.has(item.id);
                const syncing = state.syncing.has(item.id);
                const subtotal = item.price * item.quantity;

                return `
        <div class="cart-item" data-id="${item.id}">
          <div class="cart-item-inner">
            <div class="item-check">
              <button class="item-checkbox ${checked ? "is-checked" : ""}"
                      type="button"
                      data-action="toggle"
                      aria-pressed="${checked}">
                <i class="fas fa-check"></i>
              </button>
            </div>

            <div class="item-media">
              ${imageHtml(item.image)}
            </div>

            <div class="item-info">
              <h3 class="item-name">${escapeHtml(item.name)}</h3>
              <div class="item-meta">
                ${item.category
                        ? `<span class="meta-pill"><i class="fas fa-tag"></i>${escapeHtml(
                            item.category
                        )}</span>`
                        : ""
                    }
                ${item.brand
                        ? `<span class="meta-pill"><i class="fas fa-store"></i>${escapeHtml(
                            item.brand
                        )}</span>`
                        : ""
                    }
              </div>

              <div class="price-line">
                <span class="item-price">${rupiah(item.price)}</span>
                ${item.original_price > item.price
                        ? `<span class="item-price-original">${rupiah(
                            item.original_price
                        )}</span>`
                        : ""
                    }
              </div>
            </div>

            <div class="item-controls">
              <div class="qty-row">
                <button class="qty-btn" type="button" data-action="dec" ${syncing ? "disabled" : ""
                    } aria-label="Decrease quantity">
                  <i class="fas fa-minus"></i>
                </button>
                <input class="qty-input" type="number" min="1" inputmode="numeric"
                       value="${item.quantity}"
                       data-action="qty" ${syncing ? "disabled" : ""} />
                <button class="qty-btn" type="button" data-action="inc" ${syncing ? "disabled" : ""
                    } aria-label="Increase quantity">
                  <i class="fas fa-plus"></i>
                </button>
              </div>

              <div class="item-subtotal">Item total: <strong>${rupiah(
                        subtotal
                    )}</strong></div>

              <div class="item-actions">
                <button class="icon-btn danger" type="button" data-action="remove" ${syncing ? "disabled" : ""
                    } aria-label="Remove item">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      `;
            })
            .join("");

        updateSummaryUI();
        updateSelectAllUI();
    }

    function updateSelectAllUI() {
        const btn = el("selectAll");
        const selectedCountEl = el("selectedCount");

        const selectable = state.items.length;
        const selected = state.selectedIds.size;

        if (selectedCountEl) selectedCountEl.textContent = String(selected);

        const allSelected = selectable > 0 && selected === selectable;
        if (btn) btn.setAttribute("aria-pressed", allSelected ? "true" : "false");

        const checkoutCount = el("checkoutCount");
        if (checkoutCount) checkoutCount.textContent = String(selected);
    }

    function computeTotals() {
        const selectedItems = state.items.filter((i) => state.selectedIds.has(i.id));
        const itemCount = selectedItems.reduce((acc, i) => acc + i.quantity, 0);
        const subtotal = selectedItems.reduce(
            (acc, i) => acc + i.price * i.quantity,
            0
        );

        let delivery = selectedItems.length ? FEES.delivery : 0;
        let service = selectedItems.length ? FEES.service : 0;

        let discount = 0;
        if (state.voucher && selectedItems.length) {
            if (state.voucher.type === "percent") {
                discount = Math.round(subtotal * (state.voucher.value / 100));
            } else if (state.voucher.type === "delivery") {
                discount = delivery;
            } else if (state.voucher.type === "flat") {
                discount = Math.min(subtotal, state.voucher.value);
            }
        }

        const total = Math.max(0, subtotal + delivery + service - discount);
        return { itemCount, subtotal, delivery, service, discount, total };
    }

    function updateSummaryUI() {
        const { itemCount, subtotal, delivery, service, discount, total } =
            computeTotals();

        const subtotalItems = el("subtotalItems");
        const subtotalPlural = el("subtotalPlural");
        if (subtotalItems) subtotalItems.textContent = String(itemCount);
        if (subtotalPlural) subtotalPlural.textContent = itemCount === 1 ? "" : "s";

        if (el("subtotal")) el("subtotal").textContent = rupiah(subtotal);
        if (el("delivery")) el("delivery").textContent = rupiah(delivery);
        if (el("service")) el("service").textContent = rupiah(service);
        if (el("total")) el("total").textContent = rupiah(total);

        if (el("modalSubtotal")) el("modalSubtotal").textContent = rupiah(subtotal);
        if (el("modalDelivery")) el("modalDelivery").textContent = rupiah(delivery);
        if (el("modalService")) el("modalService").textContent = rupiah(service);
        if (el("modalDiscount"))
            el("modalDiscount").textContent = "-" + rupiah(discount).replace("Rp", "Rp");
        if (el("modalTotal")) el("modalTotal").textContent = rupiah(total);

        const checkoutBtn = el("checkoutBtn");
        const enabled = state.selectedIds.size > 0;
        if (checkoutBtn) checkoutBtn.disabled = !enabled;
    }

    // -----------------------------
    // Data loading
    // -----------------------------
    async function loadSummary() {
        state.loading = true;
        render();
        hideAlert();

        try {
            if (!URLS.summary) throw new Error("Missing cart summary endpoint.");
            const data = await api(URLS.summary, "GET");
            state.items = normalizeItems(data);
        } catch (e) {
            const fallback = window.__CART_ITEMS__ || CFG.initialItems || [];
            state.items = normalizeItems(fallback);
            showAlert(
                `Could not load cart from server. Showing cached data. (${e.message})`,
                "danger"
            );
        } finally {
            state.loading = false;
            state.selectedIds = new Set(state.items.map(i => i.id));
            render();
        }
    }

    // -----------------------------
    // Actions
    // -----------------------------
    function toggleSelect(id) {
        if (state.selectedIds.has(id)) state.selectedIds.delete(id);
        else state.selectedIds.add(id);

        updateSelectAllUI();
        updateSummaryUI();
    }

    function selectAll() {
        const allSelected =
            state.items.length > 0 && state.selectedIds.size === state.items.length;

        if (allSelected) state.selectedIds.clear();
        else state.items.forEach((i) => state.selectedIds.add(i.id));

        updateSelectAllUI();
        updateSummaryUI();

        const btn = el("selectAll");
        if (btn) btn.setAttribute("aria-pressed", (!allSelected).toString());
        render();
    }

    async function updateQty(id, nextQty) {
        nextQty = Math.max(1, Number(nextQty || 1));
        const item = state.items.find((i) => i.id === id);
        if (!item) return;

        item.quantity = nextQty;
        state.syncing.add(id);
        render();

        try {
            if (!URLS.update) throw new Error("Missing cart update endpoint.");
            await api(URLS.update, "POST", { product_id: id, quantity: nextQty });
            state.syncing.delete(id);
            render();
        } catch (e) {
            state.syncing.delete(id);
            showAlert(`Failed to update quantity: ${e.message}`, "danger");
            render();
        }
    }

    async function removeItem(id) {
        const item = state.items.find((i) => i.id === id);
        if (!item) return;

        const confirm = await Swal.fire({
            title: "Remove item?",
            text: `Remove "${item.name}" from your cart?`,
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Remove",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#E5484D",
        });

        if (!confirm.isConfirmed) return;

        state.syncing.add(id);
        render();

        try {
            if (!URLS.remove) throw new Error("Missing cart remove endpoint.");
            await api(URLS.remove, "POST", { product_id: id });

            state.items = state.items.filter((i) => i.id !== id);
            state.selectedIds.delete(id);
            state.syncing.delete(id);

            Swal.fire({
                title: "Removed",
                icon: "success",
                timer: 1200,
                showConfirmButton: false,
            });
            render();
        } catch (e) {
            state.syncing.delete(id);
            showAlert(`Failed to remove item: ${e.message}`, "danger");
            render();
        }
    }

    async function checkout() {
        if (!IS_AUTH) {
            Swal.fire({
                title: "Login required",
                text: "Please login to continue checkout.",
                icon: "info",
                confirmButtonText: "OK",
            });
            return;
        }

        if (!state.selectedIds.size) return;

        const selected = state.items.filter((i) => state.selectedIds.has(i.id));
        localStorage.setItem("lastbite_checkout_items", JSON.stringify(selected));

        if (state.paymentMethod)
            localStorage.setItem("lastbite_payment_method", state.paymentMethod);
        if (state.voucher)
            localStorage.setItem("lastbite_voucher", JSON.stringify(state.voucher));
        else localStorage.removeItem("lastbite_voucher");

        window.location.href = URLS.checkout;
    }

    // -----------------------------
    // Voucher + Payment
    // -----------------------------
    function setPayment(method) {
        state.paymentMethod = method;

        document.querySelectorAll(".payment-method").forEach((node) => {
            const v = node.querySelector('input[type="radio"]')?.value;
            node.classList.toggle("is-selected", v === method);
            if (v === method)
                node.querySelector('input[type="radio"]')?.setAttribute("checked", "checked");
            else node.querySelector('input[type="radio"]')?.removeAttribute("checked");
        });
    }

    function setVoucher(voucher) {
        state.voucher = voucher;
        updateSummaryUI();
    }

    function parseVoucherCode(code) {
        code = String(code || "").trim().toUpperCase();
        if (!code) return null;

        if (code === "LASTBITE10") return { code, type: "percent", value: 10 };
        if (code === "FOODSAVER20") return { code, type: "percent", value: 20 };
        if (code === "FLASH15") return { code, type: "percent", value: 15 };
        if (code === "FREESHIP") return { code, type: "delivery", value: 0 };
        return null;
    }

    function bindModals() {
        // payment selection (fallback kalau id belum dipasang)
        const methodsWrap =
            el("paymentMethods") || document.querySelector(".payment-methods");

        if (methodsWrap) {
            methodsWrap.addEventListener("click", (e) => {
                const label = e.target.closest(".payment-method");
                if (!label) return;
                const input = label.querySelector('input[type="radio"]');
                if (!input) return;
                setPayment(input.value);
            });
        }

        const confirmPaymentBtn = el("confirmPaymentMethodBtn");
        if (confirmPaymentBtn) {
            confirmPaymentBtn.addEventListener("click", () => {
                if (!state.paymentMethod) {
                    Swal.fire({
                        title: "Select a method",
                        text: "Please choose a payment method.",
                        icon: "info",
                    });
                    return;
                }
                localStorage.setItem("lastbite_payment_method", state.paymentMethod);
                Swal.fire({ title: "Saved", icon: "success", timer: 1000, showConfirmButton: false });
            });
        }

        const applyVoucherBtn = el("applyVoucherBtn");
        const voucherInput = el("voucherCodeInput");
        const voucherMessage = el("voucherMessage");

        if (applyVoucherBtn) {
            applyVoucherBtn.addEventListener("click", () => {
                const v = parseVoucherCode(voucherInput?.value);
                if (!v) {
                    if (voucherMessage) {
                        voucherMessage.textContent = "Voucher code not found.";
                        voucherMessage.style.color = "rgba(229,72,77,.95)";
                    }
                    return;
                }
                setVoucher(v);
                if (voucherMessage) {
                    voucherMessage.textContent = `Voucher applied: ${v.code}`;
                    voucherMessage.style.color = "rgba(35,162,109,.95)";
                }
            });
        }

        document.querySelectorAll(".voucher-card").forEach((card) => {
            card.addEventListener("click", () => {
                document.querySelectorAll(".voucher-card").forEach((c) => c.classList.remove("is-selected"));
                card.classList.add("is-selected");
            });
        });

        const applySelectedVoucherBtn = el("applySelectedVoucherBtn");
        if (applySelectedVoucherBtn) {
            applySelectedVoucherBtn.addEventListener("click", () => {
                const selected = document.querySelector(".voucher-card.is-selected");
                if (!selected) {
                    Swal.fire({ title: "Select a voucher", text: "Choose one voucher first.", icon: "info" });
                    return;
                }

                const code = selected.getAttribute("data-code");
                const discountType = selected.getAttribute("data-discount-type");
                const discount = selected.getAttribute("data-discount");

                let v = null;
                if (discountType === "delivery") {
                    v = { code, type: "delivery", value: 0 };
                } else if (discount) {
                    v = { code, type: "percent", value: Number(discount) };
                }

                setVoucher(v);
                localStorage.setItem("lastbite_voucher", JSON.stringify(v));
                Swal.fire({ title: "Voucher applied", icon: "success", timer: 1100, showConfirmButton: false });
            });
        }
    }

    // -----------------------------
    // Recommended: robust click handling (NO accidental redirect)
    // -----------------------------
    function bindRecommended() {
        const root =
            document.querySelector(".recommendations-grid") ||
            document.querySelector(".recommendations-section");

        if (!root) return;

        // Click: if click add-to-cart -> add. else if click card -> go detail.
        root.addEventListener("click", async (e) => {
            const addBtn = e.target.closest('button[data-action="add-to-cart"]');
            if (addBtn) {
                e.preventDefault();
                e.stopPropagation();

                const productId = Number(addBtn.getAttribute("data-product-id") || 0);
                const productName = addBtn.getAttribute("data-product-name") || "";
                if (!productId) return;

                await addToCartFromRecommended(e, { id: productId, name: productName });
                return;
            }

            const card = e.target.closest(".js-product-card");
            if (!card) return;

            // kalau klik elemen interaktif lain, jangan redirect
            if (isInteractiveTarget(e.target)) return;

            const href = card.getAttribute("data-href");
            if (href) window.location.href = href;
        });

        // Keyboard support
        root.addEventListener("keydown", (e) => {
            const card = e.target.closest(".js-product-card");
            if (!card) return;

            if (e.key === "Enter" || e.key === " ") {
                // kalau fokus di button, biarkan default
                if (isInteractiveTarget(e.target) && e.target !== card) return;

                e.preventDefault();
                const href = card.getAttribute("data-href");
                if (href) window.location.href = href;
            }
        });
    }

    // -----------------------------
    // Cart events
    // -----------------------------
    function bindEvents() {
        const selectAllBtn = el("selectAll");
        if (selectAllBtn) selectAllBtn.addEventListener("click", selectAll);

        const container = el("cartItemsContainer");
        if (container) {
            container.addEventListener("click", (e) => {
                const itemEl = e.target.closest(".cart-item");
                if (!itemEl) return;
                const id = Number(itemEl.getAttribute("data-id") || 0);
                if (!id) return;

                const btn = e.target.closest("[data-action]");
                if (!btn) return;

                const action = btn.getAttribute("data-action");
                if (action === "toggle") toggleSelect(id);
                else if (action === "inc") {
                    const item = state.items.find((i) => i.id === id);
                    updateQty(id, (item?.quantity || 1) + 1);
                } else if (action === "dec") {
                    const item = state.items.find((i) => i.id === id);
                    updateQty(id, Math.max(1, (item?.quantity || 1) - 1));
                } else if (action === "remove") removeItem(id);
            });

            container.addEventListener("change", (e) => {
                const input = e.target.closest('input[data-action="qty"]');
                if (!input) return;
                const itemEl = e.target.closest(".cart-item");
                if (!itemEl) return;

                const id = Number(itemEl.getAttribute("data-id") || 0);
                if (!id) return;

                const next = Math.max(1, Number(input.value || 1));
                updateQty(id, next);
            });
        }

        const checkoutBtn = el("checkoutBtn");
        if (checkoutBtn) checkoutBtn.addEventListener("click", checkout);
    }

    // -----------------------------
    // Public API: add to cart
    // -----------------------------
    async function addToCartFromRecommended(_event, product) {
        try {
            if (!URLS.add) throw new Error("Missing cart add endpoint.");
            await api(URLS.add, "POST", { product_id: product.id, quantity: 1 });

            Swal.fire({
                title: "Added to cart",
                text: product?.name ? `${product.name} added.` : "Item added.",
                icon: "success",
                timer: 1100,
                showConfirmButton: false,
            });

            await loadSummary();
        } catch (e) {
            Swal.fire({
                title: "Failed",
                text: e.message || "Could not add item to cart.",
                icon: "error",
            });
        }
    }

    // -----------------------------
    // Init
    // -----------------------------
    function initFromStorage() {
        const pm = localStorage.getItem("lastbite_payment_method");
        if (pm) setPayment(pm);

        const v = localStorage.getItem("lastbite_voucher");
        if (v) {
            try {
                setVoucher(JSON.parse(v));
            } catch (_) { }
        }
    }

    async function init() {
        window.CartPage = window.CartPage || {};
        window.CartPage.addToCartFromRecommended = addToCartFromRecommended;

        initFromStorage();
        bindEvents();
        bindModals();
        bindRecommended();

        await loadSummary();
    }

    document.addEventListener("DOMContentLoaded", init);
})();
