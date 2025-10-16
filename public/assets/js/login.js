const typeButtons = document.querySelectorAll('.user-type-btn');
const emailField  = document.getElementById('emailField');
const idField     = document.getElementById('idField');

typeButtons.forEach(btn => {
  btn.addEventListener('click', () => {
    typeButtons.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const isStudent = btn.dataset.type === 'student';
    emailField.style.display = isStudent ? 'none' : 'block';
    idField.style.display    = isStudent ? 'block' : 'none';
  });
});

function ensureHidden(form, name, value){
  let el = form.querySelector(`input[name="${name}"]`);
  if (!el) {
    el = document.createElement('input');
    el.type = 'hidden';
    el.name = name;
    form.prepend(el);
  }
  el.value = value;
}

document.getElementById('loginForm').addEventListener('submit', function(e){
  const activeType = document.querySelector('.user-type-btn.active').dataset.type; // admin|teacher|student
  const email = document.getElementById('email').value.trim();
  const idNum = document.getElementById('studentId').value.trim();
  const pass  = document.getElementById('password').value.trim();
  const errorEl = document.getElementById('error');

  const needEmail = (activeType === 'admin' || activeType === 'teacher');
  const needId    = (activeType === 'student');

  if ((needEmail && !email) || (needId && !idNum) || !pass) {
    e.preventDefault();
    errorEl.style.display = 'block';
    errorEl.textContent = 'الرجاء تعبئة الحقول المطلوبة.';
    return;
  }

  // فقط نضيف login_as. لا نفحص meta ولا نضيف _token لأن @csrf تولده داخل الفورم
  ensureHidden(this, 'login_as', activeType);

  // لا تمنعي الإرسال — خليه POST فعلياً للـ route
});
