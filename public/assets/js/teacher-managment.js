 function showToast(message, type = 'success') {
            const toast = document.getElementById('toastNotification');
            toast.textContent = message;
            toast.className = 'toast-notification show ' + type;

            setTimeout(() => {
                toast.className = toast.className.replace('show', '');
            }, 3000);
        }

        const modal = document.getElementById('teacherDetailsModal');
        const closeButton = document.querySelector('.close-button');

        function showTeacherDetails() {
           
            document.getElementById('modalTeacherId').textContent = '402589123';
            document.getElementById('modalTeacherName').textContent = 'أحمد';
            document.getElementById('modalTeacherSubjects').textContent = 'الرياضيات';
            document.getElementById('modalTeacherStatus').textContent = 'مفعل';
            document.getElementById('modalCreationDate').textContent = '2023-01-15';
            modal.style.display = 'block';
        }

        closeButton.onclick = function() {
            modal.style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = 'none';
            }
        }