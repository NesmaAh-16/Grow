

       function showToast(message, type = 'success') {
            const toast = document.getElementById('toastNotification');
            toast.textContent = message;
            toast.className = 'toast-notification show ' + type;

            setTimeout(() => {
                toast.className = toast.className.replace('show', '');
            }, 3000);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const selectAllCheckbox = document.getElementById('select-all');
            const permissionCheckboxes = document.querySelectorAll('.permissions-list input[type="checkbox"]');
            const showAddPermissionInputBtn = document.getElementById('show-add-permission-input');
            const addPermissionSection = document.querySelector('.add-permission-section');
            const newPermissionInput = document.getElementById('new-permission-input');
            const confirmAddPermissionBtn = document.getElementById('confirm-add-permission');
            const cancelAddPermissionBtn = document.getElementById('cancel-add-permission');
            const permissionsList = document.querySelector('.permissions-list');


            selectAllCheckbox.addEventListener('change', (e) => {
                permissionCheckboxes.forEach(checkbox => {
                    checkbox.checked = e.target.checked;
                });
            });

            showAddPermissionInputBtn.addEventListener('click', () => {
                addPermissionSection.style.display = 'flex'; 
                showAddPermissionInputBtn.style.display = 'none';  
                newPermissionInput.focus(); 
            });

            cancelAddPermissionBtn.addEventListener('click', () => {
                addPermissionSection.style.display = 'none';
                showAddPermissionInputBtn.style.display = 'block'; 
                newPermissionInput.value = ''; 
            });

         
            confirmAddPermissionBtn.addEventListener('click', () => {
                const permissionText = newPermissionInput.value.trim();

                if (permissionText) {
                    const newPermissionId = 'perm-' + permissionText.toLowerCase().replace(/\s/g, '-');
                    
                    const existingPermissions = Array.from(permissionsList.querySelectorAll('label')).map(label => label.textContent.trim());
                    if (existingPermissions.includes(permissionText)) {
                        showToast('هذه الصلاحية موجودة بالفعل!', 'error');
                        return;
                    }

                    const newListItem = document.createElement('li');
                    newListItem.innerHTML = `
                        <label>
                            <input type="checkbox" name="${newPermissionId}"> ${permissionText}
                        </label>
                    `;
                    permissionsList.appendChild(newListItem);
                    showToast(`تم إضافة الصلاحية "${permissionText}" بنجاح!`, 'success');
                    
                    addPermissionSection.style.display = 'none';
                    showAddPermissionInputBtn.style.display = 'block';
                    newPermissionInput.value = '';
                } else {
                    showToast('الرجاء إدخال اسم الصلاحية.', 'error');
                }
            });


            document.querySelector('.permissions-form').addEventListener('submit', function(event) {
                event.preventDefault();
              
                setTimeout(() => {
                    showToast('تم حفظ التغييرات بنجاح!', 'success');
                    
                }, 500);
            });

            document.querySelector('.form-actions .btn-secondary').addEventListener('click', function(event) {
                event.preventDefault(); 
                showToast('تم إلغاء التغييرات.', 'error');
                setTimeout(() => {
                    window.location.href = 'super-admin-dashboard.html';
                }, 1000);
            });
        });