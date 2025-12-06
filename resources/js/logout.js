/**
 * Logout Handler with CSRF Token Refresh
 * Fixes 419 Page Expired error
 */

document.addEventListener('DOMContentLoaded', function() {
    // Get all logout forms
    const logoutForms = document.querySelectorAll('#logout-form, .nav-logout-form');
    
    if (logoutForms.length === 0) {
        return;
    }
    
    logoutForms.forEach(function(form) {
        form.addEventListener('submit', function(e) {
            // Always ensure CSRF token is fresh before submitting
            const tokenMeta = document.querySelector('meta[name="csrf-token"]');
            const tokenInput = form.querySelector('input[name="_token"]');
            
            // Update form token from meta tag if available
            if (tokenMeta && tokenInput) {
                const freshToken = tokenMeta.getAttribute('content');
                if (freshToken) {
                    tokenInput.value = freshToken;
                }
            }
            
            // If no JavaScript fetch support, allow normal form submission
            if (typeof fetch === 'undefined') {
                return true;
            }
            
            // Try AJAX submission first
            e.preventDefault();
            
            const formElement = this;
            const formData = new FormData(formElement);
            
            // Get CSRF token
            let csrfToken = tokenMeta?.getAttribute('content') || tokenInput?.value;
            
            if (!csrfToken) {
                // Fallback to normal submission if no token
                formElement.submit();
                return;
            }
            
            // Show loading state
            const submitButton = formElement.querySelector('button[type="submit"]');
            const originalText = submitButton?.textContent;
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.textContent = submitButton.textContent || 'Logging out...';
            }
            
            // Submit via fetch
            fetch(formElement.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            })
            .then(response => {
                // Handle redirects
                if (response.redirected) {
                    window.location.href = response.url;
                    return;
                }
                
                // Handle 419 error - token expired
                if (response.status === 419) {
                    // Try to refresh page to get new token, then retry
                    window.location.reload();
                    return;
                }
                
                // Handle other errors
                if (!response.ok) {
                    // Fallback to normal form submission
                    formElement.submit();
                    return;
                }
                
                // Success - check if we need to redirect
                return response.json().catch(() => {
                    // If not JSON, just reload
                    window.location.reload();
                });
            })
            .then(data => {
                if (data && data.redirect) {
                    window.location.href = data.redirect;
                } else if (data) {
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Logout error:', error);
                // Fallback: submit form normally
                if (submitButton) {
                    submitButton.disabled = false;
                    if (originalText) {
                        submitButton.textContent = originalText;
                    }
                }
                formElement.submit();
            });
        });
    });
});

