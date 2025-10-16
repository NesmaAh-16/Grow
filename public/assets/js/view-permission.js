 document.addEventListener('DOMContentLoaded', () => {
            const selectAllCheckbox = document.getElementById('select-all');
            const permissionCheckboxes = document.querySelectorAll('.permissions-list input[type="checkbox"]');

            selectAllCheckbox.addEventListener('change', (e) => {
                permissionCheckboxes.forEach(checkbox => {
                    checkbox.checked = e.target.checked;
                });
            });
        });