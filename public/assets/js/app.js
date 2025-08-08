/*!
 * E-Learning System JavaScript
 * Main application JavaScript file
 * Generated with Claude Code
 */

(function(window, document) {
    'use strict';

    // Application namespace
    const ELearning = {
        init: function() {
            this.initFormValidation();
            this.initPasswordToggle();
            this.initSidebar();
            this.initModals();
            this.initFileUploads();
            this.initTooltips();
            this.initSearchFunctionality();
            console.log('E-Learning System initialized');
        },

        // Form validation
        initFormValidation: function() {
            const forms = document.querySelectorAll('form[data-validate]');
            
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    if (!ELearning.validateForm(form)) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                });

                // Real-time validation
                const inputs = form.querySelectorAll('input, textarea, select');
                inputs.forEach(input => {
                    input.addEventListener('blur', function() {
                        ELearning.validateField(input);
                    });
                });
            });
        },

        validateForm: function(form) {
            let isValid = true;
            const inputs = form.querySelectorAll('input[required], textarea[required], select[required]');
            
            inputs.forEach(input => {
                if (!ELearning.validateField(input)) {
                    isValid = false;
                }
            });

            return isValid;
        },

        validateField: function(field) {
            const value = field.value.trim();
            const type = field.type;
            let isValid = true;
            let message = '';

            // Required validation
            if (field.hasAttribute('required') && !value) {
                isValid = false;
                message = 'This field is required';
            }

            // Email validation
            if (type === 'email' && value) {
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    isValid = false;
                    message = 'Please enter a valid email address';
                }
            }

            // Password validation
            if (type === 'password' && value) {
                if (value.length < 8) {
                    isValid = false;
                    message = 'Password must be at least 8 characters long';
                }
            }

            // Phone validation
            if (field.name === 'phone' && value) {
                const phoneRegex = /^[\+]?[\d\s\-\(\)]{10,}$/;
                if (!phoneRegex.test(value)) {
                    isValid = false;
                    message = 'Please enter a valid phone number';
                }
            }

            // Update field appearance
            ELearning.updateFieldValidation(field, isValid, message);
            return isValid;
        },

        updateFieldValidation: function(field, isValid, message) {
            const formGroup = field.closest('.form-group, .input-group');
            const feedback = formGroup ? formGroup.querySelector('.invalid-feedback, .error-text') : null;

            // Remove existing classes
            field.classList.remove('is-valid', 'is-invalid', 'error');

            if (isValid) {
                field.classList.add('is-valid');
            } else {
                field.classList.add('is-invalid', 'error');
                
                if (feedback) {
                    feedback.textContent = message;
                } else if (formGroup) {
                    const errorElement = document.createElement('div');
                    errorElement.className = 'invalid-feedback error-text';
                    errorElement.textContent = message;
                    formGroup.appendChild(errorElement);
                }
            }
        },

        // Password visibility toggle
        initPasswordToggle: function() {
            const toggleButtons = document.querySelectorAll('.toggle-password');
            
            toggleButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const passwordField = this.parentElement.querySelector('input[type="password"], input[type="text"]');
                    const icon = this.querySelector('i') || this;
                    
                    if (passwordField.type === 'password') {
                        passwordField.type = 'text';
                        icon.classList.replace('fa-eye', 'fa-eye-slash');
                    } else {
                        passwordField.type = 'password';
                        icon.classList.replace('fa-eye-slash', 'fa-eye');
                    }
                });
            });
        },

        // Sidebar functionality
        initSidebar: function() {
            const sidebarToggle = document.querySelector('[data-sidebar-toggle]');
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    if (mainContent) {
                        mainContent.classList.toggle('sidebar-open');
                    }
                });
            }

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(e) {
                if (window.innerWidth <= 768 && sidebar && sidebar.classList.contains('show')) {
                    if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                        sidebar.classList.remove('show');
                        if (mainContent) {
                            mainContent.classList.remove('sidebar-open');
                        }
                    }
                }
            });
        },

        // Modal functionality
        initModals: function() {
            const modalTriggers = document.querySelectorAll('[data-modal-target]');
            const modals = document.querySelectorAll('.modal');
            
            modalTriggers.forEach(trigger => {
                trigger.addEventListener('click', function(e) {
                    e.preventDefault();
                    const modalId = this.getAttribute('data-modal-target');
                    const modal = document.querySelector(modalId);
                    if (modal) {
                        ELearning.showModal(modal);
                    }
                });
            });

            modals.forEach(modal => {
                // Close modal when clicking backdrop
                modal.addEventListener('click', function(e) {
                    if (e.target === modal) {
                        ELearning.hideModal(modal);
                    }
                });

                // Close modal when clicking close button
                const closeButtons = modal.querySelectorAll('[data-modal-close]');
                closeButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        ELearning.hideModal(modal);
                    });
                });
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const openModal = document.querySelector('.modal.show');
                    if (openModal) {
                        ELearning.hideModal(openModal);
                    }
                }
            });
        },

        showModal: function(modal) {
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
            
            // Focus first input in modal
            setTimeout(() => {
                const firstInput = modal.querySelector('input, textarea, select');
                if (firstInput) {
                    firstInput.focus();
                }
            }, 100);
        },

        hideModal: function(modal) {
            modal.classList.remove('show');
            document.body.style.overflow = '';
        },

        // File upload handling
        initFileUploads: function() {
            const fileInputs = document.querySelectorAll('input[type="file"]');
            
            fileInputs.forEach(input => {
                input.addEventListener('change', function() {
                    ELearning.handleFileUpload(this);
                });
            });
        },

        handleFileUpload: function(input) {
            const files = input.files;
            const maxSize = parseInt(input.getAttribute('data-max-size')) || 10485760; // 10MB default
            const allowedTypes = input.getAttribute('data-allowed-types');
            
            if (files.length === 0) return;

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                
                // Check file size
                if (file.size > maxSize) {
                    ELearning.showAlert('File size must not exceed ' + (maxSize / 1024 / 1024).toFixed(1) + 'MB', 'error');
                    input.value = '';
                    return;
                }
                
                // Check file type
                if (allowedTypes) {
                    const allowed = allowedTypes.split(',').map(type => type.trim());
                    const fileExtension = file.name.split('.').pop().toLowerCase();
                    
                    if (!allowed.includes(fileExtension)) {
                        ELearning.showAlert('File type not allowed. Allowed types: ' + allowed.join(', '), 'error');
                        input.value = '';
                        return;
                    }
                }
            }

            // Show file preview if it's an image
            if (files[0] && files[0].type.startsWith('image/')) {
                ELearning.showImagePreview(input, files[0]);
            }
        },

        showImagePreview: function(input, file) {
            const reader = new FileReader();
            const previewContainer = input.parentElement.querySelector('.image-preview') || 
                                   input.parentElement.insertAdjacentHTML('afterend', '<div class="image-preview"></div>') && 
                                   input.parentElement.querySelector('.image-preview');
            
            reader.onload = function(e) {
                previewContainer.innerHTML = `
                    <img src="${e.target.result}" alt="Preview" style="max-width: 200px; max-height: 200px; border-radius: 8px; margin-top: 10px;">
                    <button type="button" class="btn btn-sm btn-secondary" onclick="this.parentElement.remove()">Remove</button>
                `;
            };
            
            reader.readAsDataURL(file);
        },

        // Tooltip initialization
        initTooltips: function() {
            const tooltipElements = document.querySelectorAll('[data-tooltip]');
            
            tooltipElements.forEach(element => {
                element.addEventListener('mouseenter', function() {
                    ELearning.showTooltip(this);
                });
                
                element.addEventListener('mouseleave', function() {
                    ELearning.hideTooltip(this);
                });
            });
        },

        showTooltip: function(element) {
            const text = element.getAttribute('data-tooltip');
            const tooltip = document.createElement('div');
            tooltip.className = 'tooltip';
            tooltip.textContent = text;
            tooltip.style.cssText = `
                position: absolute;
                background: #333;
                color: white;
                padding: 5px 10px;
                border-radius: 4px;
                font-size: 12px;
                z-index: 1000;
                pointer-events: none;
                opacity: 0;
                transition: opacity 0.3s;
            `;
            
            document.body.appendChild(tooltip);
            
            const rect = element.getBoundingClientRect();
            tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
            tooltip.style.top = rect.top - tooltip.offsetHeight - 5 + 'px';
            
            setTimeout(() => tooltip.style.opacity = '1', 10);
            element._tooltip = tooltip;
        },

        hideTooltip: function(element) {
            if (element._tooltip) {
                element._tooltip.remove();
                delete element._tooltip;
            }
        },

        // Search functionality
        initSearchFunctionality: function() {
            const searchInputs = document.querySelectorAll('[data-search-target]');
            
            searchInputs.forEach(input => {
                let searchTimeout;
                
                input.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    const query = this.value.toLowerCase();
                    const targetSelector = this.getAttribute('data-search-target');
                    
                    searchTimeout = setTimeout(() => {
                        ELearning.performSearch(query, targetSelector);
                    }, 300);
                });
            });
        },

        performSearch: function(query, targetSelector) {
            const items = document.querySelectorAll(targetSelector);
            
            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                const matches = text.includes(query);
                
                item.style.display = matches || query === '' ? '' : 'none';
                
                if (matches && query !== '') {
                    // Highlight matching text
                    ELearning.highlightText(item, query);
                } else {
                    ELearning.removeHighlight(item);
                }
            });
        },

        highlightText: function(element, query) {
            const walker = document.createTreeWalker(
                element,
                NodeFilter.SHOW_TEXT,
                null,
                false
            );
            
            const textNodes = [];
            let node;
            
            while (node = walker.nextNode()) {
                if (node.textContent.toLowerCase().includes(query)) {
                    textNodes.push(node);
                }
            }
            
            textNodes.forEach(textNode => {
                const parent = textNode.parentNode;
                const text = textNode.textContent;
                const regex = new RegExp(`(${query})`, 'gi');
                const highlightedHTML = text.replace(regex, '<mark>$1</mark>');
                
                const wrapper = document.createElement('span');
                wrapper.innerHTML = highlightedHTML;
                parent.replaceChild(wrapper, textNode);
            });
        },

        removeHighlight: function(element) {
            const highlights = element.querySelectorAll('mark');
            highlights.forEach(mark => {
                mark.outerHTML = mark.innerHTML;
            });
        },

        // Utility functions
        showAlert: function(message, type = 'info') {
            const alertContainer = document.querySelector('.alert-container') || 
                                 document.body.insertAdjacentHTML('afterbegin', '<div class="alert-container" style="position: fixed; top: 20px; right: 20px; z-index: 2000;"></div>') && 
                                 document.querySelector('.alert-container');
            
            const alert = document.createElement('div');
            alert.className = `alert alert-${type} fade-in`;
            alert.style.cssText = `
                margin-bottom: 10px;
                min-width: 300px;
                opacity: 0;
                transform: translateX(100%);
                transition: all 0.3s ease;
            `;
            alert.innerHTML = `
                ${message}
                <button type="button" class="btn-close" onclick="this.parentElement.remove()">×</button>
            `;
            
            alertContainer.appendChild(alert);
            
            // Animate in
            setTimeout(() => {
                alert.style.opacity = '1';
                alert.style.transform = 'translateX(0)';
            }, 10);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (alert.parentElement) {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateX(100%)';
                    setTimeout(() => alert.remove(), 300);
                }
            }, 5000);
        },

        // CSRF token management
        getCSRFToken: function() {
            const tokenMeta = document.querySelector('meta[name="csrf-token"]');
            const tokenInput = document.querySelector('input[name="csrf_token"]');
            
            if (tokenMeta) {
                return tokenMeta.getAttribute('content');
            } else if (tokenInput) {
                return tokenInput.value;
            }
            
            return null;
        },

        // AJAX helper with CSRF protection
        ajax: function(options) {
            const defaults = {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin'
            };
            
            // Add CSRF token to headers
            const csrfToken = ELearning.getCSRFToken();
            if (csrfToken) {
                defaults.headers['X-CSRF-TOKEN'] = csrfToken;
            }
            
            const config = Object.assign({}, defaults, options);
            
            return fetch(config.url, config)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .catch(error => {
                    console.error('AJAX Error:', error);
                    ELearning.showAlert('An error occurred. Please try again.', 'error');
                    throw error;
                });
        },

        // Format file size
        formatFileSize: function(bytes) {
            if (bytes === 0) return '0 Bytes';
            
            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        },

        // Debounce function
        debounce: function(func, wait, immediate) {
            let timeout;
            return function executedFunction() {
                const context = this;
                const args = arguments;
                
                const later = function() {
                    timeout = null;
                    if (!immediate) func.apply(context, args);
                };
                
                const callNow = immediate && !timeout;
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
                
                if (callNow) func.apply(context, args);
            };
        }
    };

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', ELearning.init.bind(ELearning));
    } else {
        ELearning.init();
    }

    // Make ELearning available globally
    window.ELearning = ELearning;

})(window, document);