 const confirmForm = document.getElementById('confirmForm');
    const confirmationCodeInput = document.getElementById('confirmationCode');
    const messageBox = document.getElementById('messageBox');
    const resendCodeLink = document.getElementById('resendCodeLink');
    const submitBtn = document.querySelector('.submit-btn');

    confirmForm.addEventListener('submit', function(e) {
      e.preventDefault();
      const code = confirmationCodeInput.value.trim();

      if (!code || code.length !== 6 || !/^\d+$/.test(code)) {
        showMessage('الرجاء إدخال رمز تأكيد صالح مكون من 6 أرقام.', 'error');
        return;
      }

      showMessage('', ''); // Clear previous messages
      submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري التأكيد...';
      submitBtn.disabled = true;

      // Simulate API call for code verification
      setTimeout(() => {
        // In a real application, you'd send the code to your server for verification.
        // For this example, we'll simulate a successful verification.
        const isCodeValid = (code === '123456'); // Example valid code

        if (isCodeValid) {
          showMessage('تم تأكيد الرمز بنجاح! سيتم توجيهك لتعيين كلمة مرور جديدة.', 'success');
          // Redirect to a new password setting page
          setTimeout(() => {
            window.location.href = 'reset_password.html'; // Create this page next
          }, 2000);
        } else {
          showMessage('رمز التأكيد غير صحيح. الرجاء المحاولة مرة أخرى.', 'error');
          submitBtn.innerHTML = 'تأكيد';
          submitBtn.disabled = false;
        }
      }, 1500);
    });

    resendCodeLink.addEventListener('click', function(e) {
        e.preventDefault();
        // Simulate resending the code
        resendCodeLink.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الإرسال...';
        resendCodeLink.style.pointerEvents = 'none'; // Disable link during resend

        setTimeout(() => {
            showMessage('تم إعادة إرسال الرمز بنجاح إلى بريدك الإلكتروني .', 'success');
            resendCodeLink.innerHTML = 'إعادة إرسال الرمز؟';
            resendCodeLink.style.pointerEvents = 'auto'; // Re-enable link
        }, 2000);
    });

    function showMessage(message, type) {
      messageBox.textContent = message;
      messageBox.className = 'message-box'; // Reset classes
      if (message) {
        messageBox.style.display = 'block';
        if (type === 'error') {
          messageBox.classList.add('error');
        } else if (type === 'success') {
          messageBox.classList.add('success');
        }
      } else {
        messageBox.style.display = 'none';
      }
    }
