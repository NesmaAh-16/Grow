const tabs = document.querySelectorAll('.tab');
const studentForm = document.getElementById('student-form');
const teacherForm = document.getElementById('teacher-form');

tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');

        if (tab.dataset.tab === 'student') {
            studentForm.style.display = 'flex';
            teacherForm.style.display = 'none';
        } else {
            studentForm.style.display = 'none';
            teacherForm.style.display = 'flex';
        }
    });
});

document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', e => {
        //e.preventDefault();
        const successBox = form.querySelector('.success-box');

        form.querySelectorAll('input, select, .btn-primary, .tabs').forEach(el => {
            if (!el.classList.contains('tabs')) {
                el.style.display = 'none';
            }
        });

        document.querySelector('.tabs').style.display = 'none';

        successBox.style.display = 'block';

        /* setTimeout(() => {
           window.location.href = '/login';
         }, 3000);*/
    });

});
