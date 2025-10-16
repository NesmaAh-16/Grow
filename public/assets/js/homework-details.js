
 document.addEventListener('DOMContentLoaded', () => {
 
            const assignmentDetails = {
                title: "حل معادلات من الدرجة الثانية",
                class: "الصف الثامن",
                publishDate: "2024-05-28",
                dueDate: "2024-06-05",
                submitted: 15,
                totalStudents: 30,
                attachments: ["تمرين_1_الجبر.pdf", "مثال_المعادلات.docx"]
            };

            const studentSubmissions = [
                { name: "أحمد علي", submissionDate: "2024-06-03", grade: null },
                { name: "فاطمة محمود", submissionDate: "2024-06-04", grade: null },
                { name: "محمد خالد", submissionDate: "2024-06-05", grade: null },
                { name: "سارة حسن", submissionDate: "2024-06-04", grade: null },
            ];

     
            const messageBox = document.getElementById('message-box');
            const editAssignmentBtnTrigger = document.getElementById('edit-assignment-btn-trigger'); 
            const submissionsTableBody = document.getElementById('submissions-table-body');
            
          
            const editAssignmentSection = document.getElementById('edit-assignment-section');
            const cancelEditBtn = document.getElementById('cancel-edit-btn');
            const saveEditBtn = document.getElementById('save-edit-btn');
            const editTitleInput = document.getElementById('edit-title');
            const editClassInput = document.getElementById('edit-class'); 
            const editDueDateInput = document.getElementById('edit-due-date');
            const editAttachmentsList = document.getElementById('edit-attachments-list');
            const addNewFileInput = document.getElementById('add-new-file');

        
            function showMessage(message, type = 'success') {
                messageBox.textContent = message;
                messageBox.className = `message-box ${type}`;
                messageBox.style.display = 'block';
                setTimeout(() => {
                    messageBox.style.display = 'none';
                }, 3000);
            }

    
            function renderAssignmentDetails() {
                document.getElementById('assignment-title').textContent = assignmentDetails.title;
                document.getElementById('assignment-class').textContent = assignmentDetails.class;
                document.getElementById('assignment-publish-date').textContent = assignmentDetails.publishDate;
                document.getElementById('assignment-due-date').textContent = assignmentDetails.dueDate;
                document.getElementById('assignment-submitted-count').textContent = assignmentDetails.submitted;
                document.getElementById('assignment-total-count').textContent = assignmentDetails.totalStudents;

                const attachmentsList = document.getElementById('assignment-attachments');
                attachmentsList.innerHTML = '';
                if (assignmentDetails.attachments.length > 0) {
                    assignmentDetails.attachments.forEach(file => {
                        const listItem = document.createElement('li');
                        listItem.innerHTML = `<i class="fas fa-paperclip"></i> <a href="#">${file}</a>`;
                        attachmentsList.appendChild(listItem);
                    });
                } else {
                    attachmentsList.innerHTML = '<li>لا يوجد مرفقات</li>';
                }
            }
            

            function renderEditAttachments() {
                editAttachmentsList.innerHTML = '';
                if (assignmentDetails.attachments.length > 0) {
                    assignmentDetails.attachments.forEach((file, index) => {
                        const listItem = document.createElement('li');
                        listItem.className = 'file-item';
                        listItem.innerHTML = `
                            <span>${file}</span>
                            <button class="delete-file-btn" data-index="${index}">&times;</button>
                        `;
                        editAttachmentsList.appendChild(listItem);
                    });
                } else {
                    const listItem = document.createElement('li');
                    listItem.className = 'file-item';
                    listItem.textContent = 'لا يوجد مرفقات حالية';
                    editAttachmentsList.appendChild(listItem);
                }


       
                document.querySelectorAll('.delete-file-btn').forEach(button => {
                    button.addEventListener('click', (e) => {
                        const index = e.target.getAttribute('data-index');
                        assignmentDetails.attachments.splice(index, 1);
                        renderEditAttachments();
                        showMessage('تم حذف المرفق.', 'error');
                    });
                });
            }

      
            function renderSubmissions() {
                submissionsTableBody.innerHTML = '';
                studentSubmissions.forEach(submission => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${submission.name}</td>
                        <td>${submission.submissionDate}</td>
                        <td>
                            <input type="number" class="grade-input" min="0" max="10" placeholder="0-10">
                        </td>
                        <td>
                            <button class="view-btn">عرض الواجب</button>
                        </td>
                    `;
                    submissionsTableBody.appendChild(row);
                });
                
     
                document.querySelectorAll('.submissions-table .view-btn').forEach(button => {
                    button.addEventListener('click', () => {
                        showMessage('سيتم عرض الواجب المسلّم من قبل الطالب.');
                    });
                });
            }

    
            renderAssignmentDetails();
            renderSubmissions();

       
            editAssignmentBtnTrigger.addEventListener('click', () => {
                editTitleInput.value = assignmentDetails.title;
                editClassInput.value = assignmentDetails.class; 
                editDueDateInput.value = assignmentDetails.dueDate;
                renderEditAttachments();
                
                editAssignmentSection.style.display = 'flex'; 
                editAssignmentBtnTrigger.style.display = 'none'; 
                window.scrollTo({ top: editAssignmentSection.offsetTop, behavior: 'smooth' }); 
            });
            
    
            cancelEditBtn.addEventListener('click', () => {
                editAssignmentSection.style.display = 'none'; 
                editAssignmentBtnTrigger.style.display = 'inline-flex'; 
            });


            saveEditBtn.addEventListener('click', () => {
                const newTitle = editTitleInput.value;
                const newDueDate = editDueDateInput.value;
                const newFiles = addNewFileInput.files;

                if (!newTitle || !newDueDate) {
                    showMessage('الرجاء تعبئة جميع الحقول المطلوبة.', 'error');
                    return;
                }

                assignmentDetails.title = newTitle;
                assignmentDetails.dueDate = newDueDate;

     
                if (newFiles.length > 0) {
                    for (let i = 0; i < newFiles.length; i++) {
                        assignmentDetails.attachments.push(newFiles[i].name);
                    }
                    addNewFileInput.value = '';
                }

                renderAssignmentDetails();
                editAssignmentSection.style.display = 'none'; 
                editAssignmentBtnTrigger.style.display = 'inline-flex'; 
                showMessage('تم حفظ التعديلات بنجاح!', 'success');
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
        });