 function showToast(message, type = 'success') {
            const toast = document.getElementById('toastNotification');
            toast.textContent = message;
            toast.className = 'toast-notification show ' + type;

            setTimeout(() => {
                toast.className = toast.className.replace('show', '');
            }, 3000);
        }

        function handleApproval(action) {
            if (action === 'approve') {
                showToast('تمت الموافقة على الحساب بنجاح!', 'success');
            } else if (action === 'reject') {
                if (confirm('هل أنت متأكد من رفض هذا الحساب؟')) {
                    showToast('تم رفض الحساب.', 'error');
                }
            }
        }