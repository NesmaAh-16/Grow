        function showToast(message, type = 'success') {
            const toast = document.getElementById('toastNotification');
            toast.textContent = message;
            toast.className = 'toast-notification show ' + type;

            setTimeout(() => {
                toast.className = toast.className.replace('show', '');
            }, 3000);
        }

        document.querySelector('.settings-form').addEventListener('submit', function(event) {
            event.preventDefault();
    
            setTimeout(() => {
                showToast('تم حفظ التغييرات بنجاح!', 'success');
               
            }, 500);
        });

        document.querySelector('.btn-secondary').addEventListener('click', function(event) {
            event.preventDefault(); 
            showToast('تم إلغاء التغييرات.', 'error');
            setTimeout(() => {
                window.location.href = 'super-admin-dashboard.html';
            }, 1000);
        });