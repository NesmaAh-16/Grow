 document.addEventListener('DOMContentLoaded', () => {
            const params = new URLSearchParams(window.location.search);
            const className = params.get('class');

            const classData = {
                "الصف السابع 'أ'": { students: 28, subject: "العلوم" },
                "الصف الثامن 'ب'": { students: 30, subject: "الرياضيات" },
                "الصف التاسع 'ج'": { students: 25, subject: "اللغة العربية" },
                "الصف العاشر 'أ'": { students: 22, subject: "الفيزياء" },
                "الصف الحادي عشر 'د'": { students: 27, subject: "التاريخ" }
            };

            const classInfo = classData[className];

            if (classInfo) {
                document.getElementById('class-name-title').textContent = className;
                document.getElementById('student-count').textContent = classInfo.students;
                document.getElementById('subject-name').textContent = classInfo.subject;
            } else {
                document.getElementById('class-name-title').textContent = "الصف غير موجود";
                document.getElementById('student-count').textContent = "---";
                document.getElementById('subject-name').textContent = "---";
            }
        });
        
        const addLessonModal = document.getElementById('add-lesson-modal');
        const addLessonBtn = document.getElementById('add-lesson-btn');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const saveBtn = document.getElementById('save-btn');
        const saveDraftBtn = document.getElementById('save-draft-btn');
        
        const confirmationModal = document.getElementById('confirmation-modal');
        const confirmationMessage = document.getElementById('confirmation-message');
        const confirmDeleteBtn = document.getElementById('confirm-delete-btn');
        const cancelDeleteBtn = document.getElementById('cancel-delete-btn');
        
        const messageBox = document.getElementById('message-box');
        
        function showMessage(message, type = 'success') {
            messageBox.textContent = message;
            messageBox.className = `message-box ${type}`;
            messageBox.style.display = 'block';
            setTimeout(() => {
                messageBox.style.display = 'none';
            }, 3000);
        }

        function addLessonToList(title) {
            const lessonsList = document.querySelector('.lessons-list');
            const newLessonItem = document.createElement('li');
            newLessonItem.classList.add('lesson-item');
            newLessonItem.innerHTML = `
                <div class="lesson-title">${title}</div>
                <div class="lesson-actions">
                    <i class="fas fa-edit action-icon edit" title="تعديل الدرس"></i>
                    <i class="fas fa-trash-alt action-icon delete" title="حذف الدرس"></i>
                </div>
            `;
            
            const editIcon = newLessonItem.querySelector('.action-icon.edit');
            const deleteIcon = newLessonItem.querySelector('.action-icon.delete');
            
            editIcon.addEventListener('click', () => {
                showMessage(`سيتم فتح صفحة تعديل الدرس: "${title}"`);
            });
            
            deleteIcon.addEventListener('click', () => {
                confirmationMessage.textContent = `هل أنت متأكد من رغبتك في حذف الدرس: "${title}"؟`;
                confirmationModal.style.display = 'flex';
                confirmDeleteBtn.onclick = () => {
                    newLessonItem.remove();
                    showMessage('تم حذف الدرس بنجاح.', 'success');
                    confirmationModal.style.display = 'none';
                };
            });
            
            lessonsList.appendChild(newLessonItem);
        }

        addLessonBtn.addEventListener('click', (e) => {
            e.preventDefault();
            addLessonModal.style.display = 'flex';
        });

        closeModalBtn.addEventListener('click', () => {
            addLessonModal.style.display = 'none';
        });

        window.addEventListener('click', (e) => {
            if (e.target === addLessonModal) {
                addLessonModal.style.display = 'none';
            }
            if (e.target === confirmationModal) {
                confirmationModal.style.display = 'none';
            }
        });
        
        cancelDeleteBtn.addEventListener('click', () => {
            confirmationModal.style.display = 'none';
        });

        saveBtn.addEventListener('click', () => {
            const title = document.getElementById('lesson-title').value;
            const content = document.getElementById('lesson-content').value;

            if (!title) {
                showMessage('الرجاء إدخال عنوان الدرس.', 'error');
                return;
            }
            
            addLessonToList(title);

            showMessage('تم حفظ الدرس بنجاح!', 'success');
            
            document.getElementById('lesson-title').value = '';
            document.getElementById('lesson-content').value = '';
            document.getElementById('lesson-video').value = '';
            document.getElementById('lesson-pdf').value = '';

            addLessonModal.style.display = 'none';
        });

        saveDraftBtn.addEventListener('click', () => {
            const title = document.getElementById('lesson-title').value;
            showMessage('تم حفظ الدرس كمسودة.', 'warning');
            addLessonModal.style.display = 'none';
        });

        document.querySelectorAll('.action-icon.edit').forEach(icon => {
            icon.addEventListener('click', function() {
                const lessonTitle = this.closest('.lesson-item').querySelector('.lesson-title').textContent;
                showMessage(`سيتم فتح صفحة تعديل الدرس: "${lessonTitle}"`);
            });
        });

        document.querySelectorAll('.action-icon.delete').forEach(icon => {
            icon.addEventListener('click', function() {
                const lessonItem = this.closest('.lesson-item');
                const lessonTitle = lessonItem.querySelector('.lesson-title').textContent;
                confirmationMessage.textContent = `هل أنت متأكد من رغبتك في حذف الدرس: "${lessonTitle}"؟`;
                confirmationModal.style.display = 'flex';
                
                confirmDeleteBtn.onclick = () => {
                    lessonItem.remove();
                    showMessage('تم حذف الدرس بنجاح.', 'success');
                    confirmationModal.style.display = 'none';
                };
            });
        });
        
        document.querySelectorAll('.nav-btn, .logout-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const title = this.getAttribute('title') || this.querySelector('span')?.textContent;
                if (title) {
                    showMessage(`سيتم فتح ${title}`);
                }
            });
        });