document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('form[id]');

    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const submitButton = form.querySelector('button[type="submit"], input[type="submit"]');
            const originalButtonText = submitButton ? submitButton.textContent || submitButton.value : '';

            if (submitButton) {
                submitButton.disabled = true;
                if (submitButton.tagName === 'BUTTON') {
                    submitButton.textContent = 'Enviando...';
                } else if (submitButton.tagName === 'INPUT') {
                    submitButton.value = 'Enviando...';
                }
            }

            const options = {
                reload: false,
                onSuccess: function(response) {
                    if (submitButton) {
                        submitButton.disabled = false;
                        if (submitButton.tagName === 'BUTTON') {
                            submitButton.textContent = originalButtonText;
                        } else if (submitButton.tagName === 'INPUT') {
                            submitButton.value = originalButtonText;
                        }
                    }
                },
                onError: function(error) {
                    if (submitButton) {
                        submitButton.disabled = false;
                        if (submitButton.tagName === 'BUTTON') {
                            submitButton.textContent = originalButtonText;
                        } else if (submitButton.tagName === 'INPUT') {
                            submitButton.value = originalButtonText;
                        }
                    }
                }
            };

            // Usar RequestManager si está disponible, sino buscar sendAjax
            if (typeof window.submitForm === 'function') {
                window.submitForm(this, options);
            } else if (typeof sendAjax === 'function') {
                sendAjax(this, options);
            } else {
                console.error('RequestManager or sendAjax function not found');
                if (submitButton) {
                    submitButton.disabled = false;
                    if (submitButton.tagName === 'BUTTON') {
                        submitButton.textContent = originalButtonText;
                    } else if (submitButton.tagName === 'INPUT') {
                        submitButton.value = originalButtonText;
                    }
                }
            }
        });
    });
});