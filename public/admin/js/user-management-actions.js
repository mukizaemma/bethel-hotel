/**
 * System Users page — delegated clicks + Bootstrap 5 modal helper.
 * Livewire navigations do not reliably execute inline <script> in component HTML;
 * this file is loaded once from adminBase.
 */
(function () {
    if (window.__userManagementActionsInitialized) return;
    window.__userManagementActionsInitialized = true;

    function cfg() {
        return document.getElementById('user-mgmt-config');
    }

    function canManageUsers() {
        var c = cfg();
        return c && c.dataset.canManage === '1';
    }

    function getCsrfToken() {
        var m = document.querySelector('meta[name="csrf-token"]');
        return m ? m.getAttribute('content') : '';
    }

    function modalInstance(modalEl) {
        if (!modalEl) return null;
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            var Modal = bootstrap.Modal;
            if (typeof Modal.getOrCreateInstance === 'function') {
                return Modal.getOrCreateInstance(modalEl);
            }
            var existing = Modal.getInstance(modalEl);
            return existing || new Modal(modalEl);
        }
        return null;
    }

    function showModal(modalEl) {
        if (!modalEl) return;
        if (typeof jQuery !== 'undefined' && jQuery.fn && typeof jQuery.fn.modal === 'function') {
            try {
                jQuery(modalEl).modal('show');
                return;
            } catch (e) {}
        }
        try {
            var bs = modalInstance(modalEl);
            if (bs && typeof bs.show === 'function') {
                bs.show();
                return;
            }
        } catch (e) {}
        modalEl.classList.add('show');
        modalEl.style.display = 'block';
        modalEl.removeAttribute('aria-hidden');
        document.body.classList.add('modal-open');
        if (!document.querySelector('.modal-backdrop')) {
            var backdrop = document.createElement('div');
            backdrop.className = 'modal-backdrop fade show';
            document.body.appendChild(backdrop);
        }
    }

    function hideModalEl(modalEl) {
        if (!modalEl) return;
        var bs = modalInstance(modalEl);
        if (bs && typeof bs.hide === 'function') {
            bs.hide();
            return;
        }
        if (typeof jQuery !== 'undefined' && jQuery.fn.modal) {
            jQuery(modalEl).modal('hide');
        }
    }

    function closeModal(id) {
        hideModalEl(document.getElementById(id));
    }

    window.closeUserModal = function () {
        closeModal('userModal');
    };
    window.closeResetPasswordModal = function () {
        closeModal('resetPasswordModal');
    };

    window.resetUserForm = function () {
        if (!canManageUsers()) return;
        var form = document.getElementById('userForm');
        if (!form) return;
        window.__userMgmtCurrentUserId = null;
        form.reset();
        document.getElementById('user_id').value = '';
        document.getElementById('user_password').required = true;
        document.getElementById('passwordLabel').textContent = '*';
        document.getElementById('userModalTitle').textContent = 'Add New User';
        var vic = document.getElementById('verifyImmediatelyContainer');
        if (vic) vic.style.display = 'block';
        var chk = document.getElementById('verify_immediately');
        if (chk) chk.checked = true;
    };

    document.addEventListener('click', function (e) {
        var openBtn = e.target.closest('[data-open-add-user-modal]');
        if (openBtn && canManageUsers()) {
            e.preventDefault();
            window.resetUserForm();
            showModal(document.getElementById('userModal'));
            return;
        }

        var btn = e.target.closest('[data-user-action]');
        if (!btn || !cfg()) return;

        if (!canManageUsers()) return;

        var action = btn.getAttribute('data-user-action');
        var id = btn.getAttribute('data-user-id');
        if (!action || !id) return;

        var c = cfg();

        if (action === 'edit') {
            e.preventDefault();
            var form = document.getElementById('userForm');
            if (!form || !document.getElementById('user_name')) {
                alert('The edit form is missing. Refresh the page and try again.');
                return;
            }
            window.__userMgmtCurrentUserId = id;
            document.getElementById('user_id').value = id;
            document.getElementById('user_name').value = btn.getAttribute('data-user-name') || '';
            document.getElementById('user_email').value = btn.getAttribute('data-user-email') || '';
            var roleSelect = document.getElementById('user_role_id');
            var roleSlug = btn.getAttribute('data-user-role-slug') || '';
            if (roleSelect) {
                roleSelect.value = roleSlug;
                if (roleSelect.value !== roleSlug && btn.getAttribute('data-user-role-id')) {
                    var match = roleSelect.querySelector('option[data-role-id="' + btn.getAttribute('data-user-role-id') + '"]');
                    if (match) roleSelect.value = match.value;
                }
            }
            document.getElementById('user_password').required = false;
            document.getElementById('user_password').value = '';
            document.getElementById('passwordLabel').textContent = '(leave blank to keep current)';
            document.getElementById('userModalTitle').textContent = 'Edit User';
            var vic = document.getElementById('verifyImmediatelyContainer');
            if (vic) vic.style.display = 'none';
            showModal(document.getElementById('userModal'));
            return;
        }

        var token = getCsrfToken();

        if (action === 'verify') {
            if (!confirm("Verify this user's email?")) return;
            fetch(c.dataset.urlVerify.replace('__ID__', id), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                },
            })
                .then(function (r) {
                    return r.json();
                })
                .then(function (data) {
                    if (data.success) location.reload();
                });
            return;
        }

        if (action === 'resend') {
            fetch(c.dataset.urlResend.replace('__ID__', id), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                },
            })
                .then(function (r) {
                    return r.json();
                })
                .then(function (data) {
                    if (data.success) alert('Verification email sent successfully!');
                });
            return;
        }

        if (action === 'reset-password') {
            var hid = document.getElementById('reset_password_user_id');
            var form = document.getElementById('resetPasswordForm');
            if (!hid || !form) return;
            hid.value = id;
            form.reset();
            hid.value = id;
            showModal(document.getElementById('resetPasswordModal'));
            return;
        }

        if (action === 'delete') {
            if (!confirm('Are you sure you want to delete this user?')) return;
            fetch(c.dataset.urlDestroy.replace('__ID__', id), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': token,
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                },
            })
                .then(function (r) {
                    return r.json().then(function (data) {
                        return { ok: r.ok, data: data };
                    });
                })
                .then(function (res) {
                    if (res.ok && res.data.success) location.reload();
                    else alert((res.data && res.data.message) || 'Could not delete this user.');
                });
        }
    });

    document.addEventListener('submit', function (e) {
        if (!cfg() || !canManageUsers()) return;

        if (e.target.id === 'resetPasswordForm') {
            e.preventDefault();
            var userId = document.getElementById('reset_password_user_id').value;
            var pwd = document.getElementById('new_password').value;
            var pwd2 = document.getElementById('new_password_confirmation').value;
            if (pwd !== pwd2) {
                alert('Passwords do not match!');
                return;
            }
            if (pwd.length < 8) {
                alert('Password must be at least 8 characters long!');
                return;
            }
            var c = cfg();
            var fd = new FormData();
            fd.append('password', pwd);
            fd.append('password_confirmation', pwd2);
            fetch(c.dataset.urlResetPassword.replace('__ID__', userId), {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    Accept: 'application/json',
                },
                body: fd,
            })
                .then(function (r) {
                    return r.json();
                })
                .then(function (data) {
                    if (data.success) {
                        alert(data.message || 'Password reset successfully!');
                        closeModal('resetPasswordModal');
                    } else {
                        alert(data.message || 'Failed to reset password.');
                    }
                })
                .catch(function () {
                    alert('An error occurred. Please try again.');
                });
            return;
        }

        if (e.target.id === 'userForm') {
            e.preventDefault();
            var currentId = window.__userMgmtCurrentUserId;
            var url = currentId
                ? cfg().dataset.urlUpdate.replace('__ID__', currentId)
                : cfg().dataset.urlStore;
            var fd = new FormData(e.target);
            var roleSelect = e.target.querySelector('[name="role_slug"]');
            if (roleSelect) {
                fd.set('role_slug', roleSelect.value);
            }
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: fd,
            })
                .then(function (r) {
                    return r.json().then(function (data) {
                        return { ok: r.ok, data: data };
                    });
                })
                .then(function (res) {
                    if (res.ok && res.data.success) {
                        try { closeModal('userModal'); } catch (err) {}
                        window.location.reload();
                        return;
                    }
                    var data = res.data || {};
                    var message = data.message;
                    if (!message && data.errors) {
                        message = Object.keys(data.errors)
                            .map(function (key) {
                                var value = data.errors[key];
                                return Array.isArray(value) ? value.join(' ') : String(value);
                            })
                            .join('\n');
                    }
                    alert(message || 'Could not save this user.');
                })
                .catch(function () {
                    alert('Could not save this user. Please try again.');
                });
        }
    });

    window.__userMgmtCurrentUserId = null;
})();
