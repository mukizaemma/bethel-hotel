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
        var bs = modalInstance(modalEl);
        if (bs && typeof bs.show === 'function') {
            bs.show();
            return;
        }
        if (typeof jQuery !== 'undefined' && jQuery.fn.modal) {
            jQuery(modalEl).modal('show');
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
        var superOpt = document.getElementById('role_option_super_admin');
        if (superOpt) superOpt.setAttribute('hidden', 'hidden');
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
            var showUrl = c.dataset.urlShow.replace('__ID__', id);
            fetch(showUrl, {
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
                .then(function (r) {
                    if (!r.ok) {
                        throw new Error('HTTP ' + r.status);
                    }
                    return r.json();
                })
                .then(function (data) {
                    window.__userMgmtCurrentUserId = id;
                    var superOpt = document.getElementById('role_option_super_admin');
                    if (superOpt) {
                        if (data.role && data.role.slug === 'super-admin') {
                            superOpt.removeAttribute('hidden');
                        } else {
                            superOpt.setAttribute('hidden', 'hidden');
                        }
                    }
                    document.getElementById('user_id').value = data.id;
                    document.getElementById('user_name').value = data.name;
                    document.getElementById('user_email').value = data.email;
                    document.getElementById('user_role_id').value = data.role_id || '';
                    document.getElementById('user_password').required = false;
                    document.getElementById('passwordLabel').textContent =
                        '(leave blank to keep current)';
                    document.getElementById('userModalTitle').textContent = 'Edit User';
                    var vic = document.getElementById('verifyImmediatelyContainer');
                    if (vic) vic.style.display = 'none';

                    showModal(document.getElementById('userModal'));
                })
                .catch(function (err) {
                    if (String((err && err.message) || '').indexOf('403') !== -1) {
                        alert('You are not allowed to edit this user with the current account.');
                        return;
                    }
                    alert('Could not load user. Please refresh and try again.');
                });
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
                    return r.json();
                })
                .then(function (data) {
                    if (data.success) location.reload();
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
            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken(),
                    Accept: 'application/json',
                },
                body: new FormData(e.target),
            })
                .then(function (r) {
                    return r.json();
                })
                .then(function (data) {
                    if (data.success) {
                        closeModal('userModal');
                        setTimeout(function () {
                            location.reload();
                        }, 300);
                    }
                });
        }
    });

    window.__userMgmtCurrentUserId = null;
})();
