// resources/js/profile.js

(function () {
    const cfg = window.__PROFILE__ || {};
    const csrfToken = cfg.csrfToken;

    // ---------- Helpers ----------
    function qs(sel, root = document) { return root.querySelector(sel); }
    function qsa(sel, root = document) { return Array.from(root.querySelectorAll(sel)); }

    function showNotification(message, type = 'success') {
        const existing = qs('.notification');
        if (existing) existing.remove();

        const el = document.createElement('div');
        el.className = `notification show notification-${type}`;

        let icon = 'fas fa-check-circle';
        if (type === 'error') icon = 'fas fa-exclamation-circle';
        if (type === 'warning') icon = 'fas fa-exclamation-triangle';
        if (type === 'info') icon = 'fas fa-info-circle';

        el.innerHTML = `<i class="${icon}"></i><span>${message}</span>`;
        document.body.appendChild(el);

        setTimeout(() => {
            el.classList.remove('show');
            setTimeout(() => el.remove(), 300);
        }, 2600);
    }

    function updateNavbarAvatar(srcOrInitial) {
        const nav = qs('#navbarProfileAvatar');
        if (!nav) return;

        if (srcOrInitial && srcOrInitial.startsWith('http')) {
            nav.innerHTML = `<img src="${srcOrInitial}" alt="Profile">`;
        } else {
            nav.innerHTML = `<div class="profile-avatar-fallback">${srcOrInitial || (cfg.user?.initial || 'U')}</div>`;
        }
    }

    function updateMainAvatar(srcOrInitial) {
        const main = qs('#profileAvatar');
        if (!main) return;

        if (srcOrInitial && srcOrInitial.startsWith('http')) {
            main.innerHTML = `
        <img src="${srcOrInitial}" alt="Profile Photo" style="width:100%;height:100%;object-fit:cover;border-radius:50%;">
        <div class="avatar-overlay"><i class="fas fa-camera"></i></div>
      `;
        } else {
            main.innerHTML = `
        <div id="avatarInitial" class="avatar-initial">${srcOrInitial || (cfg.user?.initial || 'U')}</div>
        <div class="avatar-overlay"><i class="fas fa-camera"></i></div>
      `;
        }
    }

    function updateModalPreview(srcOrInitial) {
        const preview = qs('#photoPreview');
        if (!preview) return;

        if (srcOrInitial && srcOrInitial.startsWith('http')) {
            if (preview.tagName === 'IMG') {
                preview.src = srcOrInitial;
            } else {
                const img = document.createElement('img');
                img.id = 'photoPreview';
                img.src = srcOrInitial;
                img.alt = 'preview';
                preview.parentNode.replaceChild(img, preview);
            }
        } else {
            // fallback to initial
            if (preview.tagName === 'IMG') {
                const div = document.createElement('div');
                div.id = 'photoPreview';
                div.className = 'avatar-preview-fallback';
                div.textContent = srcOrInitial || (cfg.user?.initial || 'U');
                preview.parentNode.replaceChild(div, preview);
            } else {
                preview.textContent = srcOrInitial || (cfg.user?.initial || 'U');
            }
        }
    }

    function withTimestamp(url) {
        if (!url) return url;
        const t = Date.now();
        return url + (url.includes('?') ? '&' : '?') + 't=' + t;
    }

    // ---------- Public functions (dipakai inline onclick di Blade) ----------
    window.triggerPhotoUpload = function () {
        const input = qs('#profilePhotoInput');
        if (input) input.click();
    };

    window.previewPhoto = function (event) {
        const input = event?.target;
        if (!input || !input.files || !input.files[0]) return;

        const file = input.files[0];
        const reader = new FileReader();

        reader.onload = function (e) {
            const dataUrl = e.target.result;
            updateModalPreview(dataUrl);
        };

        reader.readAsDataURL(file);
    };

    window.uploadProfilePhoto = function (input) {
        if (!input || !input.files || !input.files[0]) return;

        const file = input.files[0];
        const maxSize = 2 * 1024 * 1024;
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];

        if (file.size > maxSize) {
            showNotification('File terlalu besar. Maksimal 2MB.', 'error');
            input.value = '';
            return;
        }

        if (!validTypes.includes(file.type)) {
            showNotification('Format file tidak didukung. Gunakan JPEG, PNG, JPG, atau GIF.', 'error');
            input.value = '';
            return;
        }

        // optimistic preview
        const reader = new FileReader();
        reader.onload = function (e) {
            updateMainAvatar(e.target.result);
            updateNavbarAvatar(e.target.result);
        };
        reader.readAsDataURL(file);

        showNotification('Mengupload foto...', 'info');

        const formData = new FormData();
        formData.append('profile_photo', file);
        formData.append('_token', csrfToken);
        formData.append('name', cfg.user?.name || '');
        formData.append('email', ''); // controller kamu wajib handle existing email kalau kosong? -> lebih aman isi dari cfg
        if (cfg.user?.email) formData.set('email', cfg.user.email);

        fetch(cfg.routes?.updateProfile, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
            .then(async (res) => {
                const data = await res.json().catch(() => ({}));
                if (!res.ok) throw new Error(data?.message || `HTTP ${res.status}`);
                return data;
            })
            .then((data) => {
                if (data.success) {
                    const url = data.avatar_url ? withTimestamp(data.avatar_url) : null;
                    if (url) {
                        updateMainAvatar(url);
                        updateNavbarAvatar(url);
                        updateModalPreview(url);
                    }
                    showNotification('Foto profil berhasil diupload!', 'success');
                } else {
                    throw new Error(data.message || 'Gagal upload foto');
                }
            })
            .catch((err) => {
                console.error(err);
                showNotification('Terjadi kesalahan saat upload foto: ' + err.message, 'error');

                // revert to current state
                const current = cfg.user?.currentPhotoUrl ? withTimestamp(cfg.user.currentPhotoUrl) : null;
                if (current) {
                    updateMainAvatar(current);
                    updateNavbarAvatar(current);
                    updateModalPreview(current);
                } else {
                    const initial = cfg.user?.initial || 'U';
                    updateMainAvatar(initial);
                    updateNavbarAvatar(initial);
                    updateModalPreview(initial);
                }
            })
            .finally(() => {
                input.value = '';
            });
    };

    window.deleteProfilePhoto = function () {
        if (!confirm('Apakah Anda yakin ingin menghapus foto profil?')) return;

        showNotification('Menghapus foto profil...', 'info');

        fetch(cfg.routes?.deletePhoto, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify({})
        })
            .then(async (res) => {
                const data = await res.json().catch(() => ({}));
                if (!res.ok) throw new Error(data?.message || `HTTP ${res.status}`);
                return data;
            })
            .then((data) => {
                if (!data.success) throw new Error(data.message || 'Gagal menghapus foto');

                const initial = cfg.user?.initial || 'U';
                updateMainAvatar(initial);
                updateNavbarAvatar(initial);
                updateModalPreview(initial);

                showNotification('Foto profil berhasil dihapus!', 'success');
            })
            .catch((err) => {
                console.error(err);
                showNotification('Terjadi kesalahan saat menghapus foto: ' + err.message, 'error');
            });
    };

    window.togglePasswordSection = function () {
        const sec = qs('#passwordSection');
        if (!sec) return;
        const isHidden = sec.style.display === 'none' || !sec.style.display;
        sec.style.display = isHidden ? 'block' : 'none';

        if (!isHidden) {
            const ids = ['current_password', 'new_password', 'new_password_confirmation'];
            ids.forEach((id) => { const el = qs('#' + id); if (el) el.value = ''; });
        }
    };

    window.togglePasswordVisibility = function (inputId) {
        const input = qs('#' + inputId);
        if (!input) return;
        const btn = input.nextElementSibling;
        const icon = btn ? btn.querySelector('i') : null;

        if (input.type === 'password') {
            input.type = 'text';
            if (icon) { icon.classList.remove('fa-eye'); icon.classList.add('fa-eye-slash'); }
        } else {
            input.type = 'password';
            if (icon) { icon.classList.remove('fa-eye-slash'); icon.classList.add('fa-eye'); }
        }
    };

    window.showHelp = function (topic) {
        const helpMessages = {
            'edit-profile': 'Klik tombol “Edit Profile” untuk memperbarui data akun kamu.',
            'track-order': 'Buka tab “Orders” untuk melihat semua riwayat pesanan dari database.',
            'change-password': 'Di modal Edit Profile, klik “Change Password” lalu isi password baru.'
        };
        alert(helpMessages[topic] || 'Help information not available for this topic.');
    };

    // ---------- Tabs + Init ----------
    function activateTab(tabId) {
        qsa('.tab-btn').forEach(btn => btn.classList.toggle('is-active', btn.dataset.tab === tabId));
        qsa('.tab-panel').forEach(panel => panel.classList.toggle('is-active', panel.id === tabId));
        history.replaceState(null, '', `#${tabId}`);
    }

    document.addEventListener('DOMContentLoaded', function () {
        // tab handlers
        qsa('.tab-btn').forEach(btn => {
            btn.addEventListener('click', () => activateTab(btn.dataset.tab));
        });

        qsa('[data-jump-tab]').forEach(el => {
            el.addEventListener('click', () => activateTab(el.getAttribute('data-jump-tab')));
        });

        // open tab from hash
        const hash = (location.hash || '').replace('#', '');
        if (hash === 'tab-orders' || hash === 'tab-profile') activateTab(hash);

        // search enter (keep your behavior, no backend call)
        const search = qs('#searchInput');
        if (search) {
            search.addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    const q = this.value.trim();
                    if (q) showNotification(`Searching for: ${q}`, 'info');
                    else showNotification('Please enter a search keyword', 'warning');
                }
            });
        }

        // form validation (same logic)
        const form = qs('#editProfileForm');
        if (form) {
            form.addEventListener('submit', function (e) {
                const newPassword = qs('#new_password')?.value;
                const confirmPassword = qs('#new_password_confirmation')?.value;

                if (newPassword || confirmPassword) {
                    if (newPassword && newPassword.length < 8) {
                        e.preventDefault();
                        showNotification('New password must be at least 8 characters', 'error');
                        return;
                    }
                    if (newPassword !== confirmPassword) {
                        e.preventDefault();
                        showNotification('New passwords do not match', 'error');
                        return;
                    }
                }

                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
                    submitBtn.disabled = true;
                }
            });
        }
    });
})();
