function updateRemainingTime() {
            const timeRemainingEl = document.getElementById('time-remaining');
            const dueDate = new Date('August 22, 2025 23:59:59').getTime();
            
            const interval = setInterval(() => {
                const now = new Date().getTime();
                const distance = dueDate - now;
                
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                timeRemainingEl.innerHTML = `${days} يوم و ${hours} ساعة متبقية`;
            }, 1000);
        }

        document.addEventListener('DOMContentLoaded', () => {
            const submissionStatusEl = document.getElementById('submission-status');
            const addSubmissionBtn = document.getElementById('add-submission-btn');
            
            const homeworkStatus = localStorage.getItem('homeworkStatus');

            
            addSubmissionBtn.addEventListener('click', () => {
       
                window.location.href = 'submitHomework.html';
            });

    
            updateRemainingTime();
        });