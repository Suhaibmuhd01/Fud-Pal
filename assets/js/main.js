document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu functionality
    const menuButton = document.getElementById('menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuPanel = document.getElementById('menu-panel');
    const closeMenu = document.getElementById('close-menu');
    
    // Open menu
    if (menuButton) {
        menuButton.addEventListener('click', function() {
            mobileMenu.classList.remove('hidden');
            setTimeout(() => {
                menuPanel.classList.remove('-translate-x-full');
            }, 10);
        });
    }
    
    // Close menu
    if (closeMenu) {
        closeMenu.addEventListener('click', closeMenuFunction);
    }
    
    // Close menu when clicking overlay
    if (mobileMenu) {
        mobileMenu.addEventListener('click', function(e) {
            if (e.target === mobileMenu) {
                closeMenuFunction();
            }
        });
    }
    
    // Close menu function
    function closeMenuFunction() {
        menuPanel.classList.add('-translate-x-full');
        setTimeout(() => {
            mobileMenu.classList.add('hidden');
        }, 300);
    }
    
    // Close mobile menu when nav link is clicked
    const mobileNavLinks = document.querySelectorAll('#menu-panel a');
    mobileNavLinks.forEach(link => {
        link.addEventListener('click', closeMenuFunction);
    });
    
    // Notification read status
    const notificationItems = document.querySelectorAll('.notification-item');
    notificationItems.forEach(item => {
        item.addEventListener('click', function() {
            const notificationId = this.getAttribute('data-id');
            
            // Mark as read via AJAX
            if (notificationId) {
                fetch(`${siteUrl}/api/notifications.php?action=mark_read&id=${notificationId}`, {
                    method: 'POST'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Update UI if needed
                        this.classList.remove('bg-blue-50', 'dark:bg-blue-900');
                        this.classList.add('bg-gray-50', 'dark:bg-gray-800');
                        
                        // Update notification counter
                        updateNotificationCounter();
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        });
    });
    
    // Function to update notification counter
    function updateNotificationCounter() {
        fetch(`${siteUrl}/api/notifications.php?action=count`)
        .then(response => response.json())
        .then(data => {
            const counterElem = document.querySelector('.notification-counter');
            if (counterElem) {
                if (data.count > 0) {
                    counterElem.textContent = data.count;
                    counterElem.classList.remove('hidden');
                } else {
                    counterElem.classList.add('hidden');
                }
            }
        })
        .catch(error => console.error('Error:', error));
    }
    
    // Password toggle visibility
    const togglePassword = document.getElementById('toggle-password');
    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            
            // Toggle eye icon
            if (type === 'text') {
                this.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                this.innerHTML = '<i class="fas fa-eye"></i>';
            }
        });
    }
    
    // Form validation feedback
    const forms = document.querySelectorAll('form[data-validate]');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            let isValid = true;
            const requiredFields = form.querySelectorAll('[required]');
            
            requiredFields.forEach(field => {
                // Remove previous error styling
                field.classList.remove('border-red-500');
                const errorMsg = field.parentNode.querySelector('.error-message');
                if (errorMsg) {
                    errorMsg.remove();
                }
                
                if (!field.value.trim()) {
                    isValid = false;
                    
                    // Add error styling
                    field.classList.add('border-red-500');
                    
                    // Add error message
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'error-message text-red-500 text-xs mt-1';
                    errorDiv.textContent = 'This field is required';
                    field.parentNode.appendChild(errorDiv);
                } else if (field.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(field.value)) {
                    // Email validation
                    isValid = false;
                    field.classList.add('border-red-500');
                    
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'error-message text-red-500 text-xs mt-1';
                    errorDiv.textContent = 'Please enter a valid email address';
                    field.parentNode.appendChild(errorDiv);
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                
                // Scroll to first error
                const firstError = form.querySelector('.border-red-500');
                if (firstError) {
                    firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
    });
});