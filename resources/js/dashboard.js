// resources/js/dashboard.js
(function () {
    "use strict";

    // =========================
    // Helpers
    // =========================
    const $ = (sel, root = document) => root.querySelector(sel);
    const $$ = (sel, root = document) => Array.from(root.querySelectorAll(sel));

    const CFG = window.DASHBOARD_CFG || {};
    const heroSlides = Array.isArray(window.heroSlides) ? window.heroSlides : [];

    function getCsrf() {
        return (
            CFG.csrf ||
            document.querySelector('meta[name="csrf-token"]')?.getAttribute("content") ||
            ""
        );
    }

    // Use existing notification element in layout (preferred)
    function notify(message, type = "success") {
        const notif = $("#notification") || $(".notification");
        const msgEl = $("#notificationMessage");

        if (notif && msgEl) {
            notif.classList.remove("notification-success", "notification-error", "show");
            notif.classList.add(type === "error" ? "notification-error" : "notification-success");
            msgEl.textContent = String(message || "");
            // swap icon if exists
            const icon = notif.querySelector("i");
            if (icon) {
                icon.className = `fas ${type === "error" ? "fa-times-circle" : "fa-check-circle"}`;
            }
            requestAnimationFrame(() => notif.classList.add("show"));
            clearTimeout(notify._t);
            notify._t = setTimeout(() => notif.classList.remove("show"), 2600);
            return;
        }

        // fallback if layout doesn't have the notification node
        let el = $(".notification");
        if (!el) {
            el = document.createElement("div");
            el.className = "notification";
            document.body.appendChild(el);
        }
        el.classList.remove("notification-success", "notification-error", "show");
        el.classList.add(type === "error" ? "notification-error" : "notification-success");
        el.innerHTML = `
      <i class="fas ${type === "error" ? "fa-times-circle" : "fa-check-circle"}"></i>
      <div style="line-height:1.2">${escapeHtml(String(message || ""))}</div>
    `;
        requestAnimationFrame(() => el.classList.add("show"));
        clearTimeout(notify._t);
        notify._t = setTimeout(() => el.classList.remove("show"), 2600);
    }

    function safeJson(res) {
        return res
            .json()
            .catch(() => ({}))
            .then((data) => ({ ok: res.ok, status: res.status, data }));
    }

    // =========================
    // HERO SLIDER
    // =========================
    function buildHero() {
        const banner = $("#heroBanner");
        const dotsWrap = $("#heroDots");
        if (!banner || !dotsWrap) return;

        const slides =
            heroSlides.length > 0
                ? heroSlides
                : [
                    {
                        image:
                            "https://images.unsplash.com/photo-1504754524776-8f4f37790ca0?auto=format&fit=crop&w=1600&q=80",
                        tagline: "SAVE FOOD, SAVE MONEY",
                        title: "LastBite",
                        subtitle: "Near-expiry foods. Premium deals.",
                        description:
                            "Temukan makanan berkualitas dengan harga lebih hemat sebelum kedaluwarsa.",
                        cta_text: "Browse Products",
                        cta_link: "/products",
                    },
                ];

        banner.innerHTML = "";
        dotsWrap.innerHTML = "";

        slides.forEach((s, idx) => {
            const slide = document.createElement("div");
            slide.className = "hero-slide" + (idx === 0 ? " active" : "");
            const bg = s.image_url || s.image || s.background || "";
            slide.style.backgroundImage = `url("${bg}")`;

            const ctaText = s.cta_text || "Shop Now";
            const ctaLink = s.cta_link || "#flash-sale";

            slide.innerHTML = `
        <div class="hero-content">
          ${s.tagline
                    ? `<div class="hero-tagline">${escapeHtml(String(s.tagline))}</div>`
                    : ""
                }
          ${s.title
                    ? `<div class="hero-title">${escapeHtml(String(s.title))}</div>`
                    : ""
                }
          ${s.subtitle
                    ? `<div class="hero-subtitle">${escapeHtml(String(s.subtitle))}</div>`
                    : ""
                }
          ${s.description
                    ? `<div class="hero-description">${escapeHtml(String(s.description))}</div>`
                    : ""
                }
          <a class="hero-cta" href="${escapeAttr(String(ctaLink))}">
            ${escapeHtml(String(ctaText))}
          </a>
        </div>
      `;

            banner.appendChild(slide);

            // dot (button for accessibility)
            const dot = document.createElement("button");
            dot.type = "button";
            dot.className = "hero-dot" + (idx === 0 ? " active" : "");
            dot.setAttribute("aria-label", `Slide ${idx + 1}`);
            dot.addEventListener("click", () => setHeroSlide(idx));
            dotsWrap.appendChild(dot);
        });

        let cur = 0;

        clearInterval(buildHero._t);
        buildHero._t = setInterval(() => {
            cur = (cur + 1) % slides.length;
            setHeroSlide(cur);
        }, 5200);

        function setHeroSlide(i) {
            const all = $$(".hero-slide", banner);
            const dots = $$(".hero-dot", dotsWrap);
            all.forEach((el, idx) => el.classList.toggle("active", idx === i));
            dots.forEach((el, idx) => el.classList.toggle("active", idx === i));
            cur = i;
        }
    }

    // =========================
    // CATEGORIES (DB-driven via window.categories from Blade)
    // =========================
    function buildCategories() {
        const grid = $("#categoriesGrid");
        if (!grid) return;

        // IMPORTANT: now categories should come from Blade (DB-driven)
        const categories = Array.isArray(window.categories) ? window.categories : [];

        // fallback (kalau Blade belum inject) - tetap aman
        const fallback = [
            { name: "Bakery", icon: "fa-bread-slice", link: "/?category=bakery&scroll=recommendations#recommendations" },
            { name: "Meals", icon: "fa-bowl-food", link: "/?category=meals&scroll=recommendations#recommendations" },
            { name: "Drinks", icon: "fa-mug-hot", link: "/?category=drinks&scroll=recommendations#recommendations" },
            { name: "Snacks", icon: "fa-cookie-bite", link: "/?category=snacks&scroll=recommendations#recommendations" },
            { name: "Fresh", icon: "fa-carrot", link: "/?category=fresh&scroll=recommendations#recommendations" },
        ];

        const src = categories.length ? categories : fallback;

        grid.innerHTML = src
            .map((c) => {
                const name = c?.name ? String(c.name) : "Category";
                const icon = c?.icon ? String(c.icon) : "fa-utensils";
                const link = c?.link ? String(c.link) : "#recommendations";
                return `
          <a class="category-item" href="${escapeAttr(link)}">
            <div class="category-circle" aria-hidden="true">
              <i class="fas ${escapeAttr(icon)} category-icon"></i>
            </div>
            <div class="category-name">${escapeHtml(name)}</div>
          </a>
        `;
            })
            .join("");
    }

    // =========================
    // FLASH SALE: COUNTDOWN
    // =========================
    function initCountdown() {
        const el = $("#countdownTimer");
        if (!el) return;

        let seconds = 24 * 60 * 60;

        clearInterval(initCountdown._t);
        initCountdown._t = setInterval(() => {
            seconds = Math.max(0, seconds - 1);
            const h = String(Math.floor(seconds / 3600)).padStart(2, "0");
            const m = String(Math.floor((seconds % 3600) / 60)).padStart(2, "0");
            const s = String(seconds % 60).padStart(2, "0");
            el.textContent = `${h}:${m}:${s}`;
        }, 1000);
    }

    // =========================
    // SWIPER INIT
    // =========================
    function initSwiper() {
        const target = $("#flashSaleSwiper");
        if (!target) return;

        const SwiperCtor = window.Swiper;
        if (typeof SwiperCtor !== "function") {
            return;
        }

        const dotsEl = $("#flashSaleDots");

        // eslint-disable-next-line no-new
        const sw = new SwiperCtor(target, {
            slidesPerView: 1,
            spaceBetween: 16,
            loop: false,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            breakpoints: {
                640: { slidesPerView: 2 },
                1024: { slidesPerView: 4 },
            },
            on: {
                init: function () {
                    if (dotsEl) renderDots(this);
                },
                slideChange: function () {
                    if (dotsEl) renderDots(this);
                },
                resize: function () {
                    if (dotsEl) renderDots(this);
                },
            },
        });

        function renderDots(swiper) {
            const total = swiper.slides?.length || 0;
            const idx = typeof swiper.realIndex === "number" ? swiper.realIndex : (swiper.activeIndex || 0);

            dotsEl.innerHTML = "";
            const maxDots = Math.min(total, 8);

            for (let i = 0; i < maxDots; i++) {
                const dot = document.createElement("button");
                dot.type = "button";
                dot.className = "flash-sale-dot" + (i === idx ? " active" : "");
                dot.setAttribute("aria-label", `Flash slide ${i + 1}`);
                dot.addEventListener("click", () => swiper.slideTo(i));
                dotsEl.appendChild(dot);
            }
        }

        window.__flashSwiper = sw;
    }

    // =========================
    // FAVORITES (localStorage + optional server)
    // =========================
    const FAV_KEY = "LB_FAVORITES_V1";

    function loadFavSet() {
        try {
            const raw = localStorage.getItem(FAV_KEY);
            const arr = raw ? JSON.parse(raw) : [];
            return new Set(arr.map((x) => String(x)));
        } catch {
            return new Set();
        }
    }

    function saveFavSet(set) {
        try {
            localStorage.setItem(FAV_KEY, JSON.stringify(Array.from(set)));
        } catch { }
    }

    function syncFavButtons() {
        const favs = loadFavSet();
        $$(".favorite-btn[data-product-id]").forEach((btn) => {
            const id = String(btn.getAttribute("data-product-id") || "");
            btn.classList.toggle("active", favs.has(id));
            const icon = btn.querySelector("i");
            if (icon) {
                icon.classList.toggle("fas", favs.has(id));
                icon.classList.toggle("far", !favs.has(id));
            }
        });
    }

    async function toggleFavorite(productId) {
        const id = String(productId);
        const favs = loadFavSet();
        const next = !favs.has(id);

        if (next) favs.add(id);
        else favs.delete(id);

        saveFavSet(favs);
        syncFavButtons();

        if (CFG.favToggleUrl) {
            try {
                const res = await fetch(CFG.favToggleUrl, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": getCsrf(),
                        "X-Requested-With": "XMLHttpRequest",
                        Accept: "application/json",
                    },
                    body: JSON.stringify({ product_id: productId }),
                    credentials: "same-origin",
                });

                const out = await safeJson(res);
                if (!out.ok) {
                    if (next) favs.delete(id);
                    else favs.add(id);
                    saveFavSet(favs);
                    syncFavButtons();
                    notify(out.data?.message || "Gagal update favorite (server).", "error");
                    return;
                }
            } catch {
                notify("Favorite tersimpan lokal, tapi server tidak merespons.", "error");
            }
        }
    }

    window.toggleFavorite = toggleFavorite;

    // =========================
    // CART: ADD TO CART
    // =========================
    async function addToCart(evt, productId) {
        evt?.preventDefault?.();
        evt?.stopPropagation?.();

        const cfg = window.DASHBOARD_CFG || {};
        const url = cfg.cartAddUrl || "";
        const csrf =
            cfg.csrf || document.querySelector('meta[name="csrf-token"]')?.content || "";

        if (!url) {
            notify("cartAddUrl belum dikonfigurasi (DASHBOARD_CFG.cartAddUrl).", "error");
            return;
        }

        const btn =
            evt?.currentTarget ||
            document.querySelector(`.js-add-to-cart[data-product-id="${productId}"]`);

        if (btn) {
            btn.disabled = true;
            btn.style.opacity = "0.75";
        }

        try {
            const fd = new FormData();
            fd.append("product_id", String(productId));
            fd.append("quantity", "1");

            const res = await fetch(url, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrf,
                    "X-Requested-With": "XMLHttpRequest",
                    Accept: "application/json",
                },
                body: fd,
                credentials: "same-origin",
            });

            const out = await res.json().catch(() => ({}));

            if (!res.ok) {
                const msg =
                    out?.message ||
                    (out?.errors ? Object.values(out.errors).flat().join(" ") : "") ||
                    "Gagal menambahkan ke cart.";
                notify(msg, "error");
                return;
            }

            notify(out?.message || "Product added to cart", "success");

            if (typeof out?.cart_count === "number") {
                const cartCount = $("#cartCount");
                if (cartCount) cartCount.textContent = out.cart_count > 99 ? "99+" : String(out.cart_count);
            }

            window.dispatchEvent(new CustomEvent("cart:updated", { detail: out }));
        } catch {
            notify("Network error saat add to cart.", "error");
        } finally {
            if (btn) {
                btn.disabled = false;
                btn.style.opacity = "1";
            }
        }
    }

    window.addToCart = addToCart;

    // =========================
    // Escape helpers
    // =========================
    function escapeHtml(str) {
        return String(str).replace(/[&<>"']/g, (m) => {
            switch (m) {
                case "&": return "&amp;";
                case "<": return "&lt;";
                case ">": return "&gt;";
                case '"': return "&quot;";
                case "'": return "&#039;";
                default: return m;
            }
        });
    }
    function escapeAttr(str) {
        return escapeHtml(str).replace(/`/g, "&#096;");
    }

    // =========================
    // Boot
    // =========================
    document.addEventListener("DOMContentLoaded", () => {
        buildHero();
        buildCategories();
        initCountdown();
        initSwiper();
        syncFavButtons();
    });

    // resources/js/dashboard.js - Tambahan micro-interactions saja

    // Image lazy loading dengan shimmer effect
    document.addEventListener('DOMContentLoaded', function () {
        const productImages = document.querySelectorAll('.product-image');

        productImages.forEach(img => {
            const container = img.closest('.product-image-container');
            if (container && !img.complete) {
                container.classList.add('loading');

                img.addEventListener('load', () => {
                    container.classList.remove('loading');
                });

                img.addEventListener('error', () => {
                    container.classList.remove('loading');
                    // Fallback image handling jika diperlukan
                });
            }
        });

        // Success feedback untuk cart button
        const cartButtons = document.querySelectorAll('.js-add-to-cart');
        cartButtons.forEach(btn => {
            const originalHtml = btn.innerHTML;

            btn.addEventListener('click', function (e) {
                // Jangan ganggu event listener yang sudah ada
                const clonedBtn = this.cloneNode(true);

                // Tambah class success sementara
                this.classList.add('success');

                setTimeout(() => {
                    this.classList.remove('success');
                }, 600);
            });
        });

        // Smooth scroll untuk internal anchors
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#') {
                    const target = document.querySelector(href);
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            });
        });
    });
})();
