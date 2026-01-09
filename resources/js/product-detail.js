/* ==========================================================================
   Product Detail JS — Page Scoped
   File: resources/js/product-detail.js
   Depends:
   - window.addToCart (global cart function yang sudah ada di buyer layout / global JS kamu)
   - meta csrf-token jika fitur favorit dipakai (di code kamu ada)
   ========================================================================== */

(function () {
    "use strict";

    const product = window.__LASTBITE_PRODUCT__ || null;
    const cartRedirectUrl = window.__LASTBITE_CART_REDIRECT__ || "/cart";

    function safeParseJSON(value, fallback) {
        try { return JSON.parse(value); } catch { return fallback; }
    }

    function updateCartCount() {
        try {
            const cart = safeParseJSON(localStorage.getItem("lastbite_cart") || "[]", []);
            const totalItems = cart.reduce((t, item) => t + (item.quantity || 1), 0);
            const el = document.getElementById("cartCount");
            if (!el) return;

            el.textContent = totalItems;

            if (totalItems > 0) {
                el.style.transform = "scale(1.15)";
                setTimeout(() => (el.style.transform = "scale(1)"), 240);
            }
        } catch (e) {
            console.error("Error updating cart count:", e);
        }
    }

    function showNotification(message, type = "success") {
        const existing = document.querySelector(".notification");
        if (existing) existing.remove();

        const notif = document.createElement("div");
        notif.className = `notification notification-${type}`;
        notif.innerHTML = `
      <i class="fas fa-${type === "success" ? "check-circle" : "exclamation-circle"}"></i>
      <span>${message}</span>
    `;

        document.body.appendChild(notif);

        setTimeout(() => notif.classList.add("show"), 80);

        setTimeout(() => {
            notif.classList.remove("show");
            setTimeout(() => notif.remove(), 300);
        }, 2800);
    }

    function addToCart(productId, productName, price) {
        if (!product || !window.addToCart) {
            console.warn("Global addToCart not found or product data missing.");
            return;
        }

        window.addToCart(
            productId,
            productName,
            price,
            product.image_url,
            product.brand,
            product.category,
            product.rating,
            product.rating_count
        );

        updateCartCount();
        showNotification("Added to cart!", "success");
    }

    function buyNow(productId) {
        if (!product || !window.addToCart) {
            console.warn("Global addToCart not found or product data missing.");
            return;
        }

        window.addToCart(
            productId,
            product.name,
            product.price,
            product.image_url,
            product.brand,
            product.category,
            product.rating,
            product.rating_count
        );

        updateCartCount();
        showNotification("Added to cart. Redirecting…", "success");

        setTimeout(() => {
            window.location.href = cartRedirectUrl;
        }, 450);
    }

    // Public helper for card add-to-cart (stopPropagation)
    function addToCartFromCard(event, productId, productName, price) {
        if (event) event.stopPropagation();
        // Untuk kartu rekomendasi, pakai data minimal (tanpa product detail object)
        if (!window.addToCart) return;

        window.addToCart(productId, productName, price);
        updateCartCount();
        showNotification("Added to cart!", "success");
    }

    // Bind events
    function bindActions() {
        const buyBtn = document.querySelector("[data-buy-now]");
        const cartBtn = document.querySelector("[data-add-to-cart]");

        if (buyBtn) {
            buyBtn.addEventListener("click", () => {
                const id = Number(buyBtn.getAttribute("data-buy-now"));
                buyNow(id);
            });
        }

        if (cartBtn) {
            cartBtn.addEventListener("click", () => {
                const id = Number(cartBtn.getAttribute("data-add-to-cart"));
                const name = cartBtn.getAttribute("data-product-name") || (product ? product.name : "Product");
                const price = Number(cartBtn.getAttribute("data-product-price")) || (product ? product.price : 0);
                addToCart(id, name, price);
            });
        }
    }

    document.addEventListener("DOMContentLoaded", () => {
        updateCartCount();
        bindActions();

        // kalau ada navbar initializer dari layout, biarkan berjalan (tidak diubah)
        if (typeof window.initializeNavbar === "function") {
            window.initializeNavbar();
        }
    });

    // expose (biar onclick di card aman dan tidak ganggu page)
    window.LastBiteProductDetail = {
        addToCartFromCard,
    };
})();
