const elements = {
      questionArea: document.getElementById('question-area'),
      submitBtn: document.getElementById('submit-btn'),
      timer: document.getElementById('timer'),
      qNav: document.getElementById('questions-nav')
    };

    let quizData = [];
    let testInfo = {};
    let userAnswers = [];
    let timerInterval;

    function fetchQuizData() {
      return new Promise((resolve, reject) => {
        const savedQuizJSON = localStorage.getItem('currentQuiz');
        if (savedQuizJSON) {
          const quizDataObject = JSON.parse(savedQuizJSON);
          resolve(quizDataObject);
        } else {
          reject('لا يوجد اختبار منشور حالياً. الرجاء إنشاء اختبار أولاً من لوحة تحكم المعلم.');
        }
      });
    }

    function renderAllQuestions() {
      elements.questionArea.innerHTML = '';
      quizData.forEach((q, index) => {
        const block = document.createElement('div');
        block.className = 'question-block';
        block.id = `question-${index}`;

        let optionsHtml = '';
        q.options.forEach(optionText => {
          optionsHtml += `
            <label for="q${index}_${optionText}" class="option">
              <input type="radio" id="q${index}_${optionText}" name="q_answer_${index}" value="${optionText}" data-question-index="${index}" />
              <span class="option-label"></span>
              <span>${optionText}</span>
            </label>`;
        });

        block.innerHTML = `
          <div class="question-header">
            <span class="question-counter">السؤال ${index + 1}</span>
            <p class="question-text">${q.question}</p>
          </div>
          <div class="options-container">${optionsHtml}</div>`;

        elements.questionArea.appendChild(block);
      });
    }

    function renderNavButtons() {
      elements.qNav.innerHTML = '';
      quizData.forEach((_, index) => {
        const btn = document.createElement('button');
        btn.className = 'q-nav-btn';
        btn.innerText = index + 1;
        if (userAnswers[index] !== null) btn.classList.add('answered');
        btn.onclick = () => {
          document.getElementById(`question-${index}`).scrollIntoView({
            behavior: 'smooth',
            block: 'center'
          });
        };
        elements.qNav.appendChild(btn);
      });
    }

    function startTimer(durationInMinutes) {
      if (timerInterval) clearInterval(timerInterval);
      let timeInSeconds = durationInMinutes * 60;

      timerInterval = setInterval(() => {
        const minutes = Math.floor(timeInSeconds / 60);
        const seconds = timeInSeconds % 60;
        elements.timer.innerText = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

        if (--timeInSeconds < 0) {
          clearInterval(timerInterval);
          alert('انتهى الوقت!');
          elements.submitBtn.click();
        }
      }, 1000);
    }

    async function initializeQuiz() {
      elements.questionArea.innerHTML = '<h2 style="text-align:center;color:#64748b;">جاري تحميل الاختبار...</h2>';
      try {
        const data = await fetchQuizData();
        testInfo = { title: data.title, duration: data.duration };
        quizData = data.questions;
        userAnswers = new Array(quizData.length).fill(null);
        renderAllQuestions();
        renderNavButtons();
        startTimer(testInfo.duration);
      } catch (error) {
        elements.questionArea.innerHTML = `<h2 style="text-align:center;color:#ef4444;">خطأ: ${error}</h2>`;
      }
    }

    // Event Listeners
    elements.questionArea.addEventListener('change', (e) => {
      if (e.target.type === 'radio') {
        const idx = parseInt(e.target.dataset.questionIndex);
        userAnswers[idx] = e.target.value;
        renderNavButtons();
      }
    });

    elements.submitBtn.onclick = () => {
      clearInterval(timerInterval);
      if (confirm('هل أنت متأكد من رغبتك في تسليم الاختبار؟')) {
        alert('تم تسليم الاختبار بنجاح.');
      }
    };

    window.onload = initializeQuiz;