        document.addEventListener('DOMContentLoaded', () => {
            const assignments = [
                {
                    class: "الصف السابع",
                    title: "مراجعة قوانين الجبر",
                    dueDate: "2024-05-25",
                    submitted: 22,
                    totalStudents: 28,
                    status: "منتهي"
                },
                {
                    class: "الصف الثامن",
                    title: "حل معادلات من الدرجة الثانية",
                    dueDate: "2024-05-28",
                    submitted: 15,
                    totalStudents: 30,
                    status: "قيد التصليح"
                },
                {
                    class: "الصف التاسع",
                    title: "الهندسة الفراغية: تمرين 1",
                    dueDate: "2024-06-01",
                    submitted: 18,
                    totalStudents: 25,
                    status: "قيد التصليح"
                },
                {
                    class: "الصف السابع",
                    title: "العمليات على الأعداد الصحيحة",
                    dueDate: "2024-05-18",
                    submitted: 28,
                    totalStudents: 28,
                    status: "منتهي"
                },
            ];

            const classes = ["الصف الأول", "الصف الثاني", "الصف الثالث", "الصف الرابع", "الصف الخامس", "الصف السادس", "الصف السابع", "الصف الثامن", "الصف التاسع", "الصف العاشر", "الصف الحادي عشر", "الصف الثاني عشر"];

            // DOM elements
            const tableBody = document.getElementById('assignments-table-body');
            const messageBox = document.getElementById('message-box');
            const addAssignmentBtn = document.getElementById('add-assignment-btn');
            const addAssignmentModal = document.getElementById('add-assignment-modal');
            const closeModalBtn = document.getElementById('close-modal-btn');
            const cancelAddBtn = document.getElementById('cancel-add-btn');
            const saveAssignmentBtn = document.getElementById('save-assignment-btn');
            const assignmentClassSelect = document.getElementById('assignment-class');
            const assignmentTitleInput = document.getElementById('assignment-title');
            const assignmentFileInput = document.getElementById('assignment-file');
            const assignmentDueDateInput = document.getElementById('assignment-due-date');

            function showMessage(message, type = 'success') {
                messageBox.textContent = message;
                messageBox.className = `message-box ${type}`;
                messageBox.style.display = 'block';
                setTimeout(() => {
                    messageBox.style.display = 'none';
                }, 3000);
            }

            function populateClassDropdown() {
                assignmentClassSelect.innerHTML = '';
                classes.forEach(cls => {
                    const option = document.createElement('option');
                    option.value = cls;
                    option.textContent = cls;
                    assignmentClassSelect.appendChild(option);
                });
            }

            function renderAssignments() {
                tableBody.innerHTML = '';
                assignments.forEach(assignment => {
                    const row = document.createElement('tr');

                    const statusClass = assignment.status === 'منتهي' ? 'completed' : 'in-review';

                    row.innerHTML = `
                        <td>${assignment.class}</td>
                        <td>${assignment.title}</td>
                        <td>${assignment.dueDate}</td>
                        <td><span class="progress-text">${assignment.submitted} / ${assignment.totalStudents}</span></td>
                        <td>
                            <div class="status-cell">
                                <span class="status-badge ${statusClass}">${assignment.status}</span>
                                <button class="view-btn">عرض</button>
                            </div>
                        </td>
                    `;
                    tableBody.appendChild(row);
                });

                document.querySelectorAll('.view-btn').forEach(button => {
                    button.addEventListener('click', () => {
                        showMessage('سيتم عرض تفاصيل هذا الواجب.');
                    });
                });
            }

            populateClassDropdown();
            renderAssignments();

            addAssignmentBtn.addEventListener('click', () => {
                assignmentTitleInput.value = '';
                assignmentDueDateInput.value = '';
                assignmentFileInput.value = '';

                addAssignmentModal.style.display = 'flex';
            });

            closeModalBtn.addEventListener('click', () => {
                addAssignmentModal.style.display = 'none';
            });

            cancelAddBtn.addEventListener('click', () => {
                addAssignmentModal.style.display = 'none';
            });

            window.addEventListener('click', (e) => {
                if (e.target === addAssignmentModal) {
                    addAssignmentModal.style.display = 'none';
                }
            });

            saveAssignmentBtn.addEventListener('click', () => {
                const selectedClass = assignmentClassSelect.value;
                const title = assignmentTitleInput.value;
                const dueDate = assignmentDueDateInput.value;
                const file = assignmentFileInput.files[0];

                if (!title || !dueDate) {
                    showMessage('الرجاء تعبئة جميع الحقول المطلوبة (عنوان الواجب وتاريخ التسليم).', 'error');
                    return;
                }

                const newAssignment = {
                    class: selectedClass,
                    title: title,
                    dueDate: dueDate,
                    submitted: 0,
                    totalStudents: 30,
                    status: "قيد التصليح",
                    file: file ? file.name : null,// Store file name or
                };

                assignments.push(newAssignment);
                
                renderAssignments();
                addAssignmentModal.style.display = 'none';
                showMessage('تم إضافة الواجب بنجاح!', 'success');
            });
        });
