// Helper function to safely close Bootstrap modals (compatible with Bootstrap 4 and 5)
function closeModal(modalId) {
    const modalElement = document.getElementById(modalId);
    if (!modalElement) return;
    
    // Try Bootstrap 5 method first
    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        try {
            const modal = bootstrap.Modal.getInstance(modalElement);
            if (modal) {
                modal.hide();
                return;
            }
        } catch (e) {
            // Fall through to jQuery method
        }
    }
    
    // Fallback to jQuery (Bootstrap 4)
    if (typeof jQuery !== 'undefined' && jQuery(modalElement).modal) {
        jQuery(modalElement).modal('hide');
        return;
    }
    
    // Last resort: manually hide
    modalElement.classList.remove('show');
    modalElement.style.display = 'none';
    document.body.classList.remove('modal-open');
    const backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) backdrop.remove();
}
