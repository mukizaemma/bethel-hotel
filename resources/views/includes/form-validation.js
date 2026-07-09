// Shared form validation helper
function setupFormValidation(formId, options = {}) {
    const form = document.getElementById(formId);
    if (!form) return;
    
    const errorDivId = options.errorDivId || formId + 'Errors';
    const submitBtn = form.querySelector('button[type="submit"]');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        e.stopPropagation();
        
        // Check HTML5 validation
        if (!form.checkValidity()) {
            form.classList.add('was-validated');
            // Highlight invalid fields
            form.querySelectorAll(':invalid').forEach(field => {
                field.classList.add('is-invalid');
            });
            return false;
        }
        
        // Show loading state
        if (submitBtn) {
            submitBtn.disabled = true;
            const spinner = submitBtn.querySelector('.spinner-border');
            if (spinner) spinner.classList.remove('d-none');
        }
        
        const formData = new FormData(form);
        const url = options.getUrl ? options.getUrl() : form.action;
        const method = options.method || 'POST';
        
        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (submitBtn) {
                submitBtn.disabled = false;
                const spinner = submitBtn.querySelector('.spinner-border');
                if (spinner) spinner.classList.add('d-none');
            }
            
            if (data.success) {
                if (options.onSuccess) {
                    options.onSuccess(data);
                } else {
                    const modal = bootstrap.Modal.getInstance(form.closest('.modal'));
                    if (modal) modal.hide();
                    location.reload();
                }
            } else {
                // Show validation errors
                const errorDiv = document.getElementById(errorDivId);
                if (errorDiv) {
                    errorDiv.style.display = 'block';
                    let errorHtml = '<strong>Please fix the following errors:</strong><ul class="mb-0">';
                    
                    if (data.errors) {
                        Object.keys(data.errors).forEach(field => {
                            errorHtml += `<li>${data.errors[field][0]}</li>`;
                            const input = form.querySelector(`[name="${field}"]`);
                            if (input) {
                                input.classList.add('is-invalid');
                            }
                        });
                    } else if (data.message) {
                        errorHtml += `<li>${data.message}</li>`;
                    }
                    errorHtml += '</ul>';
                    errorDiv.innerHTML = errorHtml;
                }
            }
        })
        .catch(error => {
            if (submitBtn) {
                submitBtn.disabled = false;
                const spinner = submitBtn.querySelector('.spinner-border');
                if (spinner) spinner.classList.add('d-none');
            }
            const errorDiv = document.getElementById(errorDivId);
            if (errorDiv) {
                errorDiv.style.display = 'block';
                errorDiv.innerHTML = `<strong>Error:</strong> ${error.message || 'An error occurred. Please try again.'}`;
            }
        });
    });
}

function resetFormValidation(formId, errorDivId = null) {
    const form = document.getElementById(formId);
    if (!form) return;
    
    form.reset();
    form.classList.remove('was-validated');
    form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
    
    const errorDiv = document.getElementById(errorDivId || formId + 'Errors');
    if (errorDiv) {
        errorDiv.style.display = 'none';
        errorDiv.innerHTML = '';
    }
}
