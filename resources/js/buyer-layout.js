/* ==========================================================================
   LastBite — Buyer Layout JS (Connected to DB products)
   File: resources/js/buyer-layout.js
   Notes:
   - Blade uses inline onclick="...": functions MUST be attached to window.
   - Works with Vite bundling.
   - Sends filter params aligned with products table:
     q, min_price, max_price, rating/min_rating, category/categories,
     is_active, in_stock, not_expired
   ========================================================================== */

(() => {
    // ---------- Small helpers ----------
    const $ = (sel, root = document) => root.querySelector(sel);
    const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel));

    const safeJSON = (str, fallback) => {
        try { return JSON.parse(str); } catch { return fallback; }
    };

    const debounce = (fn, wait = 250) => {
        let t;
        return (...args) => {
            clearTimeout(t);
            t = setTimeout(() => fn(...args), wait);
        };
    };

    const clamp = (n, min, max) => Math.min(Math.max(n, min), max);

    const formatRupiah = (num) => {
        const n = Number(num) || 0;
        return "Rp " + n.toLocaleString("id-ID");
    };

    const parseNumber = (v, fallback = 0) => {
        const n = Number(v);
        return Number.isFinite(n) ? n : fallback;
    };

    const isTruthy = (v) => v === true || v === 1 || v === "1" || v === "true";

    const escapeHtml = (str) => {
        return String(str ?? "")
            .replaceAll("&", "&amp;")
            .replaceAll("<", "&lt;")
            .replaceAll(">", "&gt;")
            .replaceAll('"', "&quot;")
            .replaceAll("'", "&#039;");
    };

    const escapeAttr = (str) => escapeHtml(str).replaceAll("`", "&#096;");

    // Resolve image_url:
    // - DB sometimes stores: "products/xxx.jpg"
    // - Public storage path normally: "/storage/products/xxx.jpg"
    // - If already absolute http(s) => keep
    // - If already starts with /storage or storage/ => normalize to /storage/...
    const resolveImageUrl = (raw) => {
        const url = String(raw || "").trim();
        if (!url) return "";

        if (/^https?:\/\//i.test(url)) return url;

        // normalize "storage/xxx"
        if (url.startsWith("storage/")) return "/" + url;

        // already absolute path
        if (url.startsWith("/")) return url;

        // common: "products/xxx"
        if (url.startsWith("products/")) return "/storage/" + url;

        // fallback: treat as storage relative
        return "/storage/" + url;
    };

    const formatDateID = (iso) => {
        // expiry_date in DB is date. Example: "2026-01-09"
        const s = String(iso || "").trim();
        if (!s) return "";
        const d = new Date(s);
        if (Number.isNaN(d.getTime())) return s;
        return d.toLocaleDateString("id-ID", { day: "2-digit", month: "short", year: "numeric" });
    };

    const daysLeft = (iso) => {
        const s = String(iso || "").trim();
        if (!s) return null;
        const d = new Date(s);
        if (Number.isNaN(d.getTime())) return null;
        const now = new Date();
        // normalize start of day
        const a = new Date(now.getFullYear(), now.getMonth(), now.getDate()).getTime();
        const b = new Date(d.getFullYear(), d.getMonth(), d.getDate()).getTime();
        return Math.floor((b - a) / (24 * 60 * 60 * 1000));
    };

    // ---------- State ----------
    const STORAGE_KEYS = {
        SEARCH_HISTORY: "lastbite_search_history",
        THEME: "lastbite_theme",
        CART_COUNT: "lastbite_cart_count",
    };

    const state = {
        q: "",
        filters: {
            minPrice: 0,
            maxPrice: 50000,
            minRating: null,         // number | null (maps to product.rating)
            categories: new Set(),   // string set (maps to product.category)
        },
        resultsOpen: false,
        dropdownOpen: false,
        filterOpen: false,
        lastResults: [],
        isSearching: false,
    };

    // API endpoint fallback (override from global.js if needed)
    const SEARCH_URL = window.LASTBITE_SEARCH_URL || "/api/search";

    // Product detail link template (optional):
    // set window.LASTBITE_PRODUCT_URL_TEMPLATE = "/buyer/products/{id}";
    const PRODUCT_URL_TEMPLATE = window.LASTBITE_PRODUCT_URL_TEMPLATE || "/products/{id}";

    // ---------- DOM refs ----------
    const dom = {
        navbar: null,
        searchInput: null,
        searchDropdown: null,
        searchContainer: null,
        historySection: null,
        historyList: null,
        filterSection: null,
        filterBadge: null,

        minPriceInput: null,
        maxPriceInput: null,
        priceSlider: null,
        priceValue: null,

        ratingValue: null,
        categoryValue: null,
        activeFilters: null,

        resultsContainer: null,
        resultsGrid: null,
        resultsCount: null,
        resultsSummary: null,

        notification: null,
        notificationMessage: null,

        cartCount: null,
        scrollToTop: null,

        newsletterEmail: null,
    };

    function cacheDom() {
        dom.navbar = $("#navbarContainer");
        dom.searchInput = $("#searchInput");
        dom.searchDropdown = $("#searchDropdown");
        dom.searchContainer = $("#searchContainer");
        dom.historySection = $("#historySection");
        dom.historyList = $("#historyList");
        dom.filterSection = $("#filterSection");
        dom.filterBadge = $("#filterBadge");

        dom.minPriceInput = $("#minPriceInput");
        dom.maxPriceInput = $("#maxPriceInput");
        dom.priceSlider = $("#priceSlider");
        dom.priceValue = $("#priceValue");

        dom.ratingValue = $("#ratingValue");
        dom.categoryValue = $("#categoryValue");
        dom.activeFilters = $("#activeFilters");

        dom.resultsContainer = $("#searchResultsContainer");
        dom.resultsGrid = $("#searchResultsGrid");
        dom.resultsCount = $("#resultsCount");
        dom.resultsSummary = $("#resultsSummary");

        dom.notification = $("#notification");
        dom.notificationMessage = $("#notificationMessage");

        dom.cartCount = $("#cartCount");
        dom.scrollToTop = $("#scrollToTop");

        dom.newsletterEmail = $("#newsletterEmail");
    }

    // ---------- History ----------
    function getHistory() {
        const raw = localStorage.getItem(STORAGE_KEYS.SEARCH_HISTORY);
        const list = safeJSON(raw, []);
        return Array.isArray(list) ? list : [];
    }

    function setHistory(list) {
        localStorage.setItem(STORAGE_KEYS.SEARCH_HISTORY, JSON.stringify(list.slice(0, 10)));
    }

    function addHistory(term) {
        const t = (term || "").trim();
        if (!t) return;
        let list = getHistory();
        list = list.filter(x => (x || "").toLowerCase() !== t.toLowerCase());
        list.unshift(t);
        setHistory(list);
    }

    function clearHistoryInternal() {
        setHistory([]);
        renderHistory();
        toast("History cleared");
    }

    function renderHistory() {
        if (!dom.historyList) return;
        const items = getHistory();

        dom.historyList.innerHTML = "";
        if (!items.length) {
            dom.historyList.innerHTML = `
        <div style="padding:10px 2px; color: rgba(78,31,0,.65); font-size: 13px;">
          No recent searches.
        </div>
      `;
            return;
        }

        items.forEach(term => {
            const row = document.createElement("button");
            row.type = "button";
            row.className = "history-item";
            row.style.cssText = `
        width:100%;
        text-align:left;
        border:0;
        background: transparent;
        padding:10px 10px;
        border-radius: 12px;
        cursor:pointer;
        display:flex;
        align-items:center;
        gap:10px;
      `;
            row.innerHTML = `
        <i class="fas fa-history" style="opacity:.7"></i>
        <span style="flex:1">${escapeHtml(term)}</span>
        <i class="fas fa-arrow-up-right-from-square" style="opacity:.5"></i>
      `;
            row.addEventListener("mouseenter", () => row.style.background = "rgba(254,186,23,.12)");
            row.addEventListener("mouseleave", () => row.style.background = "transparent");
            row.addEventListener("click", () => {
                dom.searchInput.value = term;
                state.q = term;
                performSearch();
            });
            dom.historyList.appendChild(row);
        });
    }

    // ---------- Filters UI ----------
    function hasActiveFilters() {
        if (state.filters.minPrice > 0) return true;
        if (state.filters.maxPrice < 100000) return true;
        if (state.filters.minRating != null) return true;
        if (state.filters.categories.size) return true;
        return false;
    }

    function updateFilterBadge() {
        if (!dom.filterBadge) return;
        let n = 0;
        if (state.filters.minPrice > 0) n++;
        if (state.filters.maxPrice < 100000) n++;
        if (state.filters.minRating != null) n++;
        if (state.filters.categories.size) n++;

        dom.filterBadge.textContent = String(n);
        dom.filterBadge.style.display = "inline-flex";
    }

    function updatePriceLabel() {
        if (dom.priceValue) {
            dom.priceValue.textContent = `${formatRupiah(state.filters.minPrice)} - ${formatRupiah(state.filters.maxPrice)}`;
        }
    }

    function updateRatingLabel() {
        if (!dom.ratingValue) return;
        dom.ratingValue.textContent = state.filters.minRating == null ? "All" : `${state.filters.minRating}.0+`;
    }

    function updateCategoryLabel() {
        if (!dom.categoryValue) return;
        if (!state.filters.categories.size) dom.categoryValue.textContent = "All";
        else dom.categoryValue.textContent = `${state.filters.categories.size} selected`;
    }

    function renderActiveFilters() {
        if (!dom.activeFilters) return;
        dom.activeFilters.innerHTML = "";

        const tags = [];

        if (state.filters.minPrice > 0 || state.filters.maxPrice < 100000) {
            tags.push({
                key: "price",
                label: `${formatRupiah(state.filters.minPrice)} – ${formatRupiah(state.filters.maxPrice)}`,
                remove: () => {
                    state.filters.minPrice = 0;
                    state.filters.maxPrice = 50000;
                    syncPriceInputsFromState();
                }
            });
        }

        if (state.filters.minRating != null) {
            tags.push({
                key: "rating",
                label: `Rating ${state.filters.minRating}.0+`,
                remove: () => {
                    state.filters.minRating = null;
                    highlightRatingOption(null);
                }
            });
        }

        if (state.filters.categories.size) {
            Array.from(state.filters.categories).forEach(cat => {
                tags.push({
                    key: `cat:${cat}`,
                    label: `Category: ${cat}`,
                    remove: () => {
                        state.filters.categories.delete(cat);
                        highlightCategoryChips();
                    }
                });
            });
        }

        tags.forEach(t => {
            const chip = document.createElement("button");
            chip.type = "button";
            chip.className = "active-filter-tag";
            chip.style.cssText = `
        border: 0;
        background: rgba(116,81,45,.12);
        color: rgba(78,31,0,.92);
        padding: 6px 10px;
        border-radius: 999px;
        font-size: 12px;
        display:inline-flex;
        align-items:center;
        gap:8px;
        cursor:pointer;
      `;
            chip.innerHTML = `
        <span>${escapeHtml(t.label)}</span>
        <i class="fas fa-times" style="opacity:.7"></i>
      `;
            chip.addEventListener("click", () => {
                t.remove();
                updateFilterBadge();
                updateRatingLabel();
                updateCategoryLabel();
                updatePriceLabel();
                renderActiveFilters();
                updateResultsSummary();

                // auto re-search if results already open OR keyword exists
                autoSearchIfNeeded();
            });
            dom.activeFilters.appendChild(chip);
        });
    }

    function updateResultsSummary() {
        if (!dom.resultsSummary) return;

        const parts = [];
        if (state.filters.minPrice > 0 || state.filters.maxPrice < 100000) {
            parts.push(`Price: ${formatRupiah(state.filters.minPrice)}–${formatRupiah(state.filters.maxPrice)}`);
        }
        if (state.filters.minRating != null) parts.push(`Rating: ${state.filters.minRating}.0+`);
        if (state.filters.categories.size) parts.push(`Categories: ${Array.from(state.filters.categories).join(", ")}`);

        dom.resultsSummary.textContent = parts.length ? parts.join(" • ") : "No filters applied";
    }

    function syncPriceInputsFromState() {
        if (dom.minPriceInput) dom.minPriceInput.value = String(state.filters.minPrice);
        if (dom.maxPriceInput) dom.maxPriceInput.value = String(state.filters.maxPrice);
        if (dom.priceSlider) dom.priceSlider.value = String(state.filters.maxPrice);

        updatePriceLabel();
        updateFilterBadge();
        renderActiveFilters();
        updateResultsSummary();
    }

    function highlightRatingOption(rating) {
        const options = $$(".rating-option");
        options.forEach(el => el.classList.remove("active"));

        // options order: [All, 4+, 3+]
        if (rating == null) {
            if (options[0]) options[0].classList.add("active");
        } else {
            if (rating >= 4 && options[1]) options[1].classList.add("active");
            else if (rating >= 3 && options[2]) options[2].classList.add("active");
        }

        updateRatingLabel();
        updateFilterBadge();
        renderActiveFilters();
        updateResultsSummary();
    }

    function inferCategoryKeyFromOnclick(el) {
        const s = el.getAttribute("onclick") || "";
        const m = s.match(/toggleCategory\('([^']+)'\)/);
        return m ? m[1] : null;
    }

    function highlightCategoryChips() {
        const chips = $$(".category-chip");
        chips.forEach(chip => {
            const key =
                chip.dataset.key ||
                inferCategoryKeyFromOnclick(chip) ||
                (chip.textContent || "").trim().toLowerCase();

            const isOn = state.filters.categories.has(key);
            chip.classList.toggle("active", isOn);
            chip.style.background = isOn ? "rgba(254,186,23,.25)" : "";
            chip.style.borderColor = isOn ? "rgba(254,186,23,.8)" : "";
        });

        updateCategoryLabel();
        updateFilterBadge();
        renderActiveFilters();
        updateResultsSummary();
    }

    // ---------- Dropdown open/close ----------
    function openDropdown() {
        if (!dom.searchDropdown) return;
        dom.searchDropdown.classList.add("active");
        state.dropdownOpen = true;
        renderHistory();
    }

    function closeDropdown() {
        if (!dom.searchDropdown) return;
        dom.searchDropdown.classList.remove("active");
        state.dropdownOpen = false;
        showHistoryMode();
    }

    function showFilterMode() {
        if (!dom.filterSection || !dom.historySection) return;
        dom.filterSection.style.display = "block";
        dom.historySection.style.display = "none";
        state.filterOpen = true;

        syncPriceInputsFromState();
        highlightRatingOption(state.filters.minRating);
        highlightCategoryChips();
    }

    function showHistoryMode() {
        if (!dom.filterSection || !dom.historySection) return;
        dom.filterSection.style.display = "none";
        dom.historySection.style.display = "block";
        state.filterOpen = false;
        renderHistory();
    }

    // ---------- Results container ----------
    function openResults() {
        if (!dom.resultsContainer) return;
        dom.resultsContainer.classList.add("active");
        state.resultsOpen = true;
    }

    function closeResultsInternal() {
        if (!dom.resultsContainer) return;
        dom.resultsContainer.classList.remove("active");
        state.resultsOpen = false;
    }

    // ---------- Search core ----------
    function buildSearchParams() {
        const params = new URLSearchParams();
        const q = (dom.searchInput?.value || "").trim();
        state.q = q;

        // IMPORTANT: allow search even if q empty as long as filters active.
        if (q) params.set("q", q);

        // Map to DB columns:
        // price
        params.set("min_price", String(state.filters.minPrice || 0));
        params.set("max_price", String(state.filters.maxPrice || 50000));

        // rating (DB: rating decimal)
        if (state.filters.minRating != null) {
            // send both names to be compatible with backend
            params.set("rating", String(state.filters.minRating));
            params.set("min_rating", String(state.filters.minRating));
        }

        // category (DB: category string)
        if (state.filters.categories.size) {
            const cats = Array.from(state.filters.categories);
            params.set("categories", cats.join(",")); // preferred multi
            if (cats.length === 1) params.set("category", cats[0]); // common single param
        }

        // default safety filters (DB has columns)
        // backend can ignore if not implemented
        params.set("is_active", "1");   // product.is_active = 1
        params.set("in_stock", "1");    // stock > 0
        params.set("not_expired", "1"); // expiry_date >= today

        // pagination (optional)
        params.set("page", "1");
        params.set("per_page", "12");

        return params;
    }

    async function fetchSearchResults() {
        const params = buildSearchParams();
        const url = `${SEARCH_URL}?${params.toString()}`;

        const csrf = $('meta[name="csrf-token"]')?.getAttribute("content");

        const res = await fetch(url, {
            method: "GET",
            headers: {
                "Accept": "application/json",
                ...(csrf ? { "X-CSRF-TOKEN": csrf } : {}),
            },
            credentials: "same-origin",
        });

        if (!res.ok) {
            let msg = `Search failed (${res.status})`;
            try {
                const j = await res.json();
                if (j?.message) msg = j.message;
            } catch { }
            throw new Error(msg);
        }

        return res.json();
    }

    function normalizeSearchPayload(payload) {
        // Supported payload shapes:
        // A) { success:true, data:[...] }
        // B) { data:{ data:[...] } } paginator
        // C) { items:[...] }
        // D) plain array
        if (Array.isArray(payload)) return payload;

        const data = payload?.data;
        if (Array.isArray(data)) return data;

        const nested = data?.data;
        if (Array.isArray(nested)) return nested;

        if (Array.isArray(payload?.items)) return payload.items;

        return [];
    }

    function productHref(item) {
        const id = item?.id;
        if (!id) return "#";
        return PRODUCT_URL_TEMPLATE.replace("{id}", String(id));
    }

    function renderResults(items) {
        if (!dom.resultsGrid) return;

        const list = Array.isArray(items) ? items : [];
        state.lastResults = list;

        if (dom.resultsCount) dom.resultsCount.textContent = `(${list.length} items)`;
        updateResultsSummary();

        dom.resultsGrid.innerHTML = "";

        if (!list.length) {
            dom.resultsGrid.innerHTML = `
        <div style="
          grid-column: 1 / -1;
          padding: 18px 14px;
          border-radius: 16px;
          background: rgba(254,186,23,.10);
          color: rgba(78,31,0,.85);
        ">
          <strong>No results.</strong>
          <div style="margin-top:6px; font-size:13px; opacity:.9">
            Try a different keyword or relax your filters.
          </div>
        </div>
      `;
            return;
        }

        list.forEach(item => {
            // === DB mapping ===
            const name = item?.name ?? "Untitled";
            const brand = item?.brand ?? "";
            const category = item?.category ?? "";
            const price = parseNumber(item?.price, null);
            const original = parseNumber(item?.original_price, null);
            const discountPercent = parseNumber(item?.discount_percent, 0);
            const rating = item?.rating != null ? parseNumber(item.rating, 0) : null;
            const ratingCount = parseNumber(item?.rating_count, 0);
            const stock = parseNumber(item?.stock, 0);
            const isActive = isTruthy(item?.is_active);
            const isFlash = isTruthy(item?.is_flash_sale);
            const isRec = isTruthy(item?.is_recommended);
            const expiry = item?.expiry_date ?? null;
            const img = resolveImageUrl(item?.image_url || item?.image || item?.thumbnail || "");

            // derived
            const href = item?.url || productHref(item);
            const left = daysLeft(expiry);
            const expLabel =
                left == null ? "" :
                    left < 0 ? "Expired" :
                        left === 0 ? "Expires today" :
                            left === 1 ? "1 day left" :
                                `${left} days left`;

            const showStrike = original != null && price != null && original > price;
            const showDiscount = discountPercent > 0 || (showStrike && Math.round(((original - price) / original) * 100) > 0);
            const effectiveDiscount =
                discountPercent > 0 ? Math.round(discountPercent) :
                    (showStrike ? Math.round(((original - price) / original) * 100) : 0);

            const badgeParts = [];
            if (isFlash) badgeParts.push(`<span class="lb-badge lb-badge-flash">Flash</span>`);
            if (isRec) badgeParts.push(`<span class="lb-badge lb-badge-rec">Recommended</span>`);
            if (expLabel) badgeParts.push(`<span class="lb-badge lb-badge-exp">${escapeHtml(expLabel)}</span>`);
            if (!isActive) badgeParts.push(`<span class="lb-badge lb-badge-off">Inactive</span>`);
            if (stock <= 0) badgeParts.push(`<span class="lb-badge lb-badge-oos">Out of stock</span>`);

            const card = document.createElement("div");
            card.className = "search-result-card card-base";
            card.style.cssText = `border-radius: 18px; overflow: hidden;`;

            card.innerHTML = `
        <a href="${escapeAttr(href)}" style="display:block; text-decoration:none; color:inherit;">
          <div style="position:relative; aspect-ratio: 4/3; background: rgba(116,81,45,.08); display:flex; align-items:center; justify-content:center;">
            ${img
                    ? `<img src="${escapeAttr(img)}" alt="${escapeAttr(name)}" style="width:100%; height:100%; object-fit:cover;" loading="lazy">`
                    : `<div style="font-size:14px; opacity:.7">No Image</div>`
                }

            <div style="position:absolute; left:10px; top:10px; display:flex; flex-wrap:wrap; gap:6px; max-width: calc(100% - 20px);">
              ${badgeParts.join("")}
            </div>

            ${showDiscount && effectiveDiscount > 0
                    ? `<div style="
                    position:absolute; right:10px; top:10px;
                    background: rgba(254,186,23,.92);
                    color: rgba(78,31,0,.95);
                    padding: 6px 10px;
                    border-radius: 999px;
                    font-weight: 800;
                    font-size: 12px;
                    box-shadow: 0 10px 25px rgba(0,0,0,.10);
                  ">-${effectiveDiscount}%</div>`
                    : ``
                }
          </div>

          <div style="padding: 12px 12px 14px;">
            <div style="display:flex; align-items:flex-start; justify-content:space-between; gap:10px;">
              <div style="min-width:0;">
                <div style="font-weight: 800; font-size: 14px; line-height: 1.2; color: rgba(78,31,0,.95); white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                  ${escapeHtml(name)}
                </div>
                <div style="margin-top:6px; display:flex; flex-wrap:wrap; gap:8px; font-size:12px; color: rgba(78,31,0,.70);">
                  ${brand ? `<span><i class="fas fa-tag" style="opacity:.6"></i> ${escapeHtml(brand)}</span>` : ``}
                  ${category ? `<span><i class="fas fa-utensils" style="opacity:.6"></i> ${escapeHtml(category)}</span>` : ``}
                  <span><i class="fas fa-box" style="opacity:.6"></i> Stock: ${escapeHtml(String(stock))}</span>
                </div>
              </div>

              ${rating != null
                    ? `<div style="flex:0 0 auto; display:flex; align-items:center; gap:6px; font-size:12px; color: rgba(78,31,0,.85);">
                      <i class="fas fa-star" style="color: rgba(254,186,23,.95)"></i>
                      <strong>${escapeHtml(rating.toFixed(1))}</strong>
                      <span style="opacity:.65">(${escapeHtml(String(ratingCount))})</span>
                    </div>`
                    : ``
                }
            </div>

            <div style="margin-top:10px; display:flex; align-items:center; justify-content:space-between; gap:10px;">
              <div style="display:flex; align-items:baseline; gap:10px;">
                <div style="font-weight: 900; color: rgba(78,31,0,.95); font-size: 14px;">
                  ${price != null ? escapeHtml(formatRupiah(price)) : `<span style="opacity:.7; font-weight:700;">—</span>`}
                </div>
                ${showStrike
                    ? `<div style="font-size:12px; text-decoration:line-through; opacity:.55;">
                        ${escapeHtml(formatRupiah(original))}
                      </div>`
                    : ``
                }
              </div>

              <div style="font-size:12px; opacity:.7;">
                ${expiry ? `Exp: ${escapeHtml(formatDateID(expiry))}` : ``}
              </div>
            </div>
          </div>
        </a>
      `;

            dom.resultsGrid.appendChild(card);
        });

        // inject badge styles once
        if (!$("#lbBadgeStyle")) {
            const style = document.createElement("style");
            style.id = "lbBadgeStyle";
            style.textContent = `
        .lb-badge{
          display:inline-flex;
          align-items:center;
          padding: 6px 10px;
          border-radius: 999px;
          font-size: 11px;
          font-weight: 800;
          line-height: 1;
          backdrop-filter: blur(8px);
        }
        .lb-badge-flash{ background: rgba(255, 77, 79, .92); color: #fff; }
        .lb-badge-rec{ background: rgba(46, 213, 115, .92); color: #fff; }
        .lb-badge-exp{ background: rgba(116, 81, 45, .85); color: #fff; }
        .lb-badge-off{ background: rgba(120, 120, 120, .85); color:#fff; }
        .lb-badge-oos{ background: rgba(0, 0, 0, .70); color:#fff; }
      `;
            document.head.appendChild(style);
        }
    }

    async function performSearchInternal() {
        const q = (dom.searchInput?.value || "").trim();

        // IMPORTANT CHANGE:
        // allow filter-only search (q empty) as long as filters active
        if (!q && !hasActiveFilters()) {
            toast("Type something to search");
            openDropdown();
            showHistoryMode();
            return;
        }

        if (state.isSearching) return;
        state.isSearching = true;

        try {
            if (q) addHistory(q);
            closeDropdown();

            openResults();
            if (dom.resultsGrid) {
                dom.resultsGrid.innerHTML = `
          <div style="grid-column:1/-1; padding:14px; border-radius:16px; background: rgba(116,81,45,.08);">
            Searching…
          </div>
        `;
            }

            const payload = await fetchSearchResults();
            const items = normalizeSearchPayload(payload);
            renderResults(items);
        } catch (err) {
            renderResults([]);
            toast(err?.message || "Search failed");
        } finally {
            state.isSearching = false;
        }
    }

    const autoSearchIfNeeded = debounce(() => {
        // Auto refresh results when user changes filters AND:
        // - results container already open, or
        // - keyword exists
        const q = (dom.searchInput?.value || "").trim();
        if (state.resultsOpen || q) {
            performSearchInternal();
        }
    }, 350);

    // ---------- Notification ----------
    function toast(message) {
        if (!dom.notification || !dom.notificationMessage) return;
        dom.notificationMessage.textContent = message || "Done";

        dom.notification.classList.add("show");
        clearTimeout(toast._t);
        toast._t = setTimeout(() => {
            dom.notification.classList.remove("show");
        }, 2200);
    }

    // ---------- Cart count ----------
    function syncCartCount() {
        if (!dom.cartCount) return;
        const n = Number(localStorage.getItem(STORAGE_KEYS.CART_COUNT) || "0") || 0;
        dom.cartCount.textContent = String(n);
    }

    // ---------- Footer actions ----------
    function handleNewsletterSubmitInternal(e) {
        e?.preventDefault?.();
        const email = (dom.newsletterEmail?.value || "").trim();
        if (!email) {
            toast("Please enter your email");
            return;
        }
        toast("Subscribed! (demo)");
        if (dom.newsletterEmail) dom.newsletterEmail.value = "";
    }

    function scrollToTopInternal() {
        window.scrollTo({ top: 0, behavior: "smooth" });
    }

    // ---------- Inline-called functions (MUST be window.*) ----------
    function toggleFilterInternal() {
        openDropdown();
        if (state.filterOpen) showHistoryMode();
        else showFilterMode();
    }

    function clearAllInternal() {
        state.filters.minPrice = 0;
        state.filters.maxPrice = 50000;
        state.filters.minRating = null;
        state.filters.categories.clear();

        syncPriceInputsFromState();
        highlightRatingOption(null);
        highlightCategoryChips();

        openDropdown();
        showHistoryMode();

        if (dom.searchInput) dom.searchInput.value = "";
        state.q = "";

        closeResultsInternal();
        toast("Cleared");
    }

    function updatePriceFromSliderInternal() {
        const max = clamp(Number(dom.priceSlider?.value || 50000), 0, 100000);
        state.filters.maxPrice = max;

        state.filters.minPrice = clamp(state.filters.minPrice, 0, max);

        if (dom.maxPriceInput) dom.maxPriceInput.value = String(state.filters.maxPrice);
        if (dom.minPriceInput) dom.minPriceInput.value = String(state.filters.minPrice);

        updatePriceLabel();
        updateFilterBadge();
        renderActiveFilters();
        updateResultsSummary();

        autoSearchIfNeeded();
    }

    function updatePriceFromInputInternal() {
        const min = clamp(Number(dom.minPriceInput?.value || 0), 0, 100000);
        const max = clamp(Number(dom.maxPriceInput?.value || 50000), 0, 100000);

        const finalMin = Math.min(min, max);
        const finalMax = Math.max(min, max);

        state.filters.minPrice = finalMin;
        state.filters.maxPrice = finalMax;

        if (dom.minPriceInput) dom.minPriceInput.value = String(finalMin);
        if (dom.maxPriceInput) dom.maxPriceInput.value = String(finalMax);
        if (dom.priceSlider) dom.priceSlider.value = String(finalMax);

        updatePriceLabel();
        updateFilterBadge();
        renderActiveFilters();
        updateResultsSummary();

        autoSearchIfNeeded();
    }

    function selectRatingInternal(rating) {
        // FIX: make "All Ratings" send null, not (4, event)
        if (rating === null || rating === undefined) {
            state.filters.minRating = null;
            highlightRatingOption(null);
            autoSearchIfNeeded();
            return;
        }

        const r = Number(rating);
        state.filters.minRating = Number.isFinite(r) ? r : null;
        highlightRatingOption(state.filters.minRating);
        autoSearchIfNeeded();
    }

    function toggleCategoryInternal(catKey) {
        const key = String(catKey || "").trim();
        if (!key) return;

        if (state.filters.categories.has(key)) state.filters.categories.delete(key);
        else state.filters.categories.add(key);

        highlightCategoryChips();
        autoSearchIfNeeded();
    }

    function closeResultsPublic() {
        closeResultsInternal();
    }

    // ---------- Keep your existing animations/interactions ----------
    function initSwiper() {
        const swiperEl = document.querySelector(".swiper");
        if (!swiperEl) return;
        if (typeof window.Swiper === "undefined") return;

        // eslint-disable-next-line no-new
        new window.Swiper(".swiper", {
            loop: true,
            pagination: { el: ".swiper-pagination", clickable: true, dynamicBullets: true },
            navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
            autoplay: { delay: 5000, disableOnInteraction: false },
            effect: "slide",
            speed: 600,
            breakpoints: {
                320: { slidesPerView: 1, spaceBetween: 16 },
                640: { slidesPerView: 2, spaceBetween: 20 },
                1024: { slidesPerView: 3, spaceBetween: 30 },
                1280: { slidesPerView: 4, spaceBetween: 30 },
            },
        });
    }

    function initProductCards() {
        const cards = $$(".product-card");
        if (!cards.length) return;

        const observerOptions = { threshold: 0.1, rootMargin: "0px 0px 100px 0px" };
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("card-visible");
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        cards.forEach((card) => {
            card.style.opacity = "0";
            card.style.transform = "translateY(20px)";
            observer.observe(card);

            card.addEventListener("mouseenter", function () {
                if (window.innerWidth > 768) {
                    this.style.transform = "translateY(-4px)";
                    this.style.boxShadow = "var(--shadow-hover)";
                }
            });
            card.addEventListener("mouseleave", function () {
                if (window.innerWidth > 768) {
                    this.style.transform = "translateY(0)";
                    this.style.boxShadow = "var(--shadow-sm)";
                }
            });
        });

        const style = document.createElement("style");
        style.textContent = `
      .product-card.card-visible { animation: cardAppear 0.6s ease forwards; }
      @keyframes cardAppear {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
      }
    `;
        document.head.appendChild(style);
    }

    function initMicroInteractions() {
        $$('button:not(.dropdown-item):not(.search-action-btn)').forEach((button) => {
            button.addEventListener("mouseenter", function () {
                this.style.transform = "translateY(-1px)";
            });
            button.addEventListener("mouseleave", function () {
                this.style.transform = "translateY(0)";
            });
        });

        $$(".card-base").forEach((card) => {
            card.addEventListener("mouseenter", function () {
                this.style.transform = "translateY(-2px)";
            });
            card.addEventListener("mouseleave", function () {
                this.style.transform = "translateY(0)";
            });
        });

        $$('a:not(.dropdown-item):not(.social-icon):not(.app-button)').forEach((link) => {
            link.addEventListener("mouseenter", function () {
                this.style.transform = "translateY(-1px)";
            });
            link.addEventListener("mouseleave", function () {
                this.style.transform = "translateY(0)";
            });
        });

        const mainContent = document.querySelector("main");
        if (mainContent) {
            mainContent.style.opacity = "0";
            mainContent.style.transform = "translateY(20px)";
            setTimeout(() => {
                mainContent.style.transition = "opacity 0.5s ease, transform 0.5s ease";
                mainContent.style.opacity = "1";
                mainContent.style.transform = "translateY(0)";
            }, 100);
        }
    }

    function initLazyLoading() {
        if ("loading" in HTMLImageElement.prototype) {
            $$('img[loading="lazy"]').forEach((img) => {
                if (img.dataset.src) img.src = img.dataset.src;
            });
        }
    }

    function initThemePreference() {
        const theme = localStorage.getItem(STORAGE_KEYS.THEME) || "light";
        if (theme === "dark") document.body.classList.add("dark-mode");
    }

    function initTooltips() {
        const tooltipElements = $$("[title]");
        tooltipElements.forEach((element) => {
            element.addEventListener("mouseenter", function () {
                const tooltip = document.createElement("div");
                tooltip.className = "custom-tooltip";
                tooltip.textContent = this.title;

                tooltip.style.cssText = `
          position: absolute;
          background: var(--chocolate-dark);
          color: white;
          padding: 6px 12px;
          border-radius: 6px;
          font-size: 12px;
          font-weight: 500;
          z-index: 9999;
          white-space: nowrap;
          pointer-events: none;
          transform: translateY(-100%) translateX(-50%);
          left: 50%;
          top: -8px;
          opacity: 0;
          transition: opacity 0.2s ease;
        `;

                document.body.appendChild(tooltip);
                const rect = this.getBoundingClientRect();
                tooltip.style.left = `${rect.left + rect.width / 2}px`;
                tooltip.style.top = `${rect.top - 8}px`;

                setTimeout(() => (tooltip.style.opacity = "1"), 10);
                this._tooltip = tooltip;
            });

            element.addEventListener("mouseleave", function () {
                if (!this._tooltip) return;
                this._tooltip.style.opacity = "0";
                setTimeout(() => {
                    if (this._tooltip?.parentNode) this._tooltip.parentNode.removeChild(this._tooltip);
                    this._tooltip = null;
                }, 200);
            });
        });
    }

    // ---------- Events wiring ----------
    function wireEvents() {
        if (dom.searchInput) {
            dom.searchInput.addEventListener("focus", () => {
                openDropdown();
                showHistoryMode();
            });

            dom.searchInput.addEventListener("input", debounce(() => {
                const q = (dom.searchInput.value || "").trim();
                state.q = q;
                openDropdown();
                showHistoryMode();
            }, 200));

            dom.searchInput.addEventListener("keydown", (e) => {
                if (e.key === "Enter") {
                    e.preventDefault();
                    performSearchInternal();
                }
            });
        }

        // Click outside closes dropdown
        document.addEventListener("click", (e) => {
            const t = e.target;
            if (!dom.searchDropdown || !dom.searchContainer) return;

            const clickedInside =
                dom.searchContainer.contains(t) ||
                dom.searchDropdown.contains(t);

            if (!clickedInside && state.dropdownOpen) closeDropdown();
        });

        // Scroll-to-top visibility
        window.addEventListener("scroll", () => {
            if (!dom.scrollToTop) return;
            dom.scrollToTop.classList.toggle("show", window.scrollY > 400);
        });

        // Keyboard shortcuts
        document.addEventListener("keydown", (e) => {
            if (e.key === "Escape") {
                if (dom.searchDropdown?.classList.contains("active")) {
                    closeDropdown();
                    dom.searchInput?.blur();
                }
                if (dom.resultsContainer?.classList.contains("active")) closeResultsInternal();
            }

            if ((e.ctrlKey || e.metaKey) && e.key === "k") {
                e.preventDefault();
                dom.searchInput?.focus();
                dom.searchInput?.select?.();
            }
        });
    }

    // ---------- Public API (for Blade inline onclick) ----------
    function exposeToWindow() {
        window.toggleFilter = toggleFilterInternal;
        window.performSearch = performSearchInternal;
        window.clearAll = clearAllInternal;
        window.clearHistory = clearHistoryInternal;
        window.updatePriceFromInput = updatePriceFromInputInternal;
        window.updatePriceFromSlider = updatePriceFromSliderInternal;
        window.selectRating = selectRatingInternal;          // FIXED signature
        window.toggleCategory = toggleCategoryInternal;
        window.closeResults = closeResultsPublic;
        window.handleNewsletterSubmit = handleNewsletterSubmitInternal;
        window.scrollToTop = scrollToTopInternal;
    }

    // ---------- Boot ----------
    document.addEventListener("DOMContentLoaded", () => {
        cacheDom();
        exposeToWindow();

        syncCartCount();
        renderHistory();
        updateFilterBadge();
        updatePriceLabel();
        updateRatingLabel();
        updateCategoryLabel();
        renderActiveFilters();
        updateResultsSummary();

        initSwiper();
        initProductCards();
        initMicroInteractions();
        initLazyLoading();
        initThemePreference();

        setTimeout(initTooltips, 600);
        wireEvents();
    });

    // ========== MICRO-INTERACTIONS & VISUAL ENHANCEMENTS ==========
    // Tidak mengubah logika existing, hanya efek visual tambahan

    function initVisualEnhancements() {
        // ---------- Navbar Scroll Effect ----------
        const navbar = document.querySelector('.navbar-container');
        if (navbar) {
            let lastScrollTop = 0;

            window.addEventListener('scroll', function () {
                const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                if (scrollTop > 20) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }

                lastScrollTop = scrollTop;
            }, { passive: true });
        }

        // ---------- Button Ripple Effects ----------
        document.addEventListener('click', function (e) {
            const button = e.target.closest('.btn, .search-action-btn, .cart-btn, .profile-btn');
            if (!button) return;

            const rect = button.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            const ripple = document.createElement('span');
            ripple.style.cssText = `
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.7);
            transform: scale(0);
            animation: ripple-animation 0.6s linear;
            pointer-events: none;
        `;

            const size = Math.max(rect.width, rect.height);
            ripple.style.width = ripple.style.height = size + 'px';
            ripple.style.left = x - size / 2 + 'px';
            ripple.style.top = y - size / 2 + 'px';

            button.style.position = 'relative';
            button.style.overflow = 'hidden';
            button.appendChild(ripple);

            setTimeout(() => {
                if (ripple.parentNode === button) {
                    ripple.remove();
                }
            }, 600);
        });

        // ---------- Card Hover Effects ----------
        const cards = document.querySelectorAll('.card-base, .search-result-card');

        cards.forEach(card => {
            card.addEventListener('mouseenter', function () {
                this.style.transition = 'all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1)';
            });

            card.addEventListener('mouseleave', function () {
                this.style.transition = 'all 0.2s ease';
            });
        });

        // ---------- Image Loading Effects ----------
        const images = document.querySelectorAll('img:not([data-no-blur])');

        images.forEach(img => {
            if (!img.complete) {
                img.style.filter = 'blur(10px)';
                img.style.transition = 'filter 0.3s ease';

                img.addEventListener('load', function () {
                    this.style.filter = 'blur(0)';
                });
            }

            if (img.closest('.card-base, .search-result-card')) {
                const parent = img.closest('.card-base, .search-result-card');
                parent.addEventListener('mouseenter', () => {
                    img.style.transform = 'scale(1.05)';
                    img.style.transition = 'transform 0.5s cubic-bezier(0.34, 1.56, 0.64, 1)';
                });

                parent.addEventListener('mouseleave', () => {
                    img.style.transform = 'scale(1)';
                    img.style.transition = 'transform 0.3s ease';
                });
            }
        });

        // ---------- Input Focus Effects ----------
        const inputs = document.querySelectorAll('.input-base, .search-input, .price-input, .newsletter-input');

        inputs.forEach(input => {
            input.addEventListener('focus', function () {
                this.parentElement?.classList.add('focused');
            });

            input.addEventListener('blur', function () {
                this.parentElement?.classList.remove('focused');
            });
        });

        // ---------- Staggered Animations for Search Results ----------
        function animateSearchResults() {
            const results = document.querySelectorAll('.search-results-grid > *');
            results.forEach((item, index) => {
                item.style.setProperty('--item-index', index);
            });
        }

        // Panggil ketika search results ditampilkan
        const observer = new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                if (mutation.type === 'childList') {
                    animateSearchResults();
                }
            });
        });

        const resultsGrid = document.getElementById('searchResultsGrid');
        if (resultsGrid) {
            observer.observe(resultsGrid, { childList: true });
        }

        // ---------- Smooth Scrolling for Anchor Links ----------
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href === '#') return;

                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    window.scrollTo({
                        top: target.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // ---------- Scroll to Top Button Animation ----------
        window.addEventListener('scroll', function () {
            const scrollToTopBtn = document.getElementById('scrollToTop');
            if (scrollToTopBtn) {
                if (window.scrollY > 400) {
                    scrollToTopBtn.classList.add('show');
                } else {
                    scrollToTopBtn.classList.remove('show');
                }
            }
        });

        // ---------- Add Ripple Animation CSS ----------
        const style = document.createElement('style');
        style.textContent = `
        @keyframes ripple-animation {
            to {
                transform: scale(4);
                opacity: 0;
            }
        }

        .search-results-grid > * {
            animation: scaleIn 0.3s ease forwards;
            animation-delay: calc(var(--item-index, 0) * 0.05s);
            opacity: 0;
        }
    `;
        document.head.appendChild(style);
    }

    // Panggil enhancement setelah DOM ready
    document.addEventListener('DOMContentLoaded', function () {
        // Tunggu sedikit untuk memastikan semua element sudah dirender
        setTimeout(initVisualEnhancements, 100);
    });

    // Ekspos fungsi ke window jika diperlukan oleh inline onclick
    window.initVisualEnhancements = initVisualEnhancements;

})();
