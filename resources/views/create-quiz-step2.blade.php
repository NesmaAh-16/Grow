<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إضافة أسئلة الاختبار</title>
    <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/create-quiz.css') }}">
    <style>
        .hidden {
            display: none !important
        }
    </style>
</head>

<body>
    <div class="page-container">


        <main class="main-content">
            <header class="page-header">
                <div class="step-indicator">الخطوة 2 من 2</div>
                <h1>إضافة الأسئلة</h1>
                <p class="subtitle">
                    اختبار: <b>{{ $quiz->title }}</b> — عدد الأسئلة الحالية:
                    <b id="q-count">{{ $quiz->questions_count ?? 0 }}</b>
                </p>
            </header>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form class="create-quiz-form" method="POST"
                action="{{ route('quizzes.questions.store', ['quiz' => $quiz->id]) }}">
                @csrf
                <section class="form-section">
                    <h2 class="section-title">إعداد الأسئلة</h2>

                    <div id="questions-container">

                        <div class="question-card" data-index="0">
                            <div class="question-header">
                                <h3 class="question-title">السؤال 1</h3>
                                <button type="button" class="btn-delete-question" title="حذف السؤال"
                                    onclick="removeQuestion(this)">&times;</button>
                            </div>

                            <div class="form-grid-2-col">
                                <div class="form-group">
                                    <label>نوع السؤال</label>
                                    <select class="question-type-select" name="questions[0][type]"
                                        onchange="toggleAnswerArea(this)">
                                        <option value="mc" selected>اختيار من متعدد</option>
                                        <option value="tf">صح وخطأ</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>نص السؤال</label>
                                    <input type="text" name="questions[0][text]" placeholder="اكتب نص السؤال هنا..."
                                        required>
                                </div>
                            </div>

                            <div class="answer-area">

                                <div class="answer-type-mc">
                                    <label class="answers-group-label">الخيارات (حدد الإجابة الصحيحة)</label>

                                    @for ($i = 1; $i <= 4; $i++)
                                        <div class="answer-option">
                                            <input type="radio" name="questions[0][correct]"
                                                value="{{ $i }}" {{ $i === 1 ? 'checked' : '' }}>
                                            <input type="text" name="questions[0][options][]"
                                                placeholder="الخيار {{ ['أ', 'ب', 'ج', 'د'][$i - 1] }}">
                                        </div>
                                    @endfor
                                </div>


                                <div class="answer-type-tf hidden">
                                    <label class="answers-group-label">الإجابة الصحيحة</label>
                                    <div class="tf-options-container">
                                        <div class="tf-option">
                                            <input type="radio" id="tf-true-0" name="questions[0][correct_tf]"
                                                value="1" checked>
                                            <label for="tf-true-0">صح</label>
                                        </div>
                                        <div class="tf-option">
                                            <input type="radio" id="tf-false-0" name="questions[0][correct_tf]"
                                                value="0">
                                            <label for="tf-false-0">خطأ</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="questions[0][points]" value="1">
                            <input type="hidden" name="questions[0][ord]" value="1">
                        </div>
                    </div>

                    <button type="button" id="add-question-btn" class="btn-add-question" onclick="addQuestion()">+
                        إضافة سؤال آخر</button>
                </section>

                <footer class="form-actions">
                    <a href="{{ route('quizzes.create') }}" class="btn btn-secondary">السابق</a>
                    <button type="submit" class="btn btn-primary">حفظ الاختبار</button>
                </footer>
            </form>

        </main>
    </div>

   {{-- <script>
        let qIndex = 0;

        function toggleAnswerArea(sel) {
            const card = sel.closest('.question-card');
            const isMC = sel.value === 'mc';
            card.querySelector('.answer-type-mc').classList.toggle('hidden', !isMC);
            card.querySelector('.answer-type-tf').classList.toggle('hidden', isMC);
        }

        function removeQuestion(btn) {
            const card = btn.closest('.question-card');
            const container = document.getElementById('questions-container');
            if (container.children.length === 1) {
                alert('لا يمكن حذف كل الأسئلة.');
                return;
            }
            card.remove();
            renumber();
        }

        function addQuestion() {
            qIndex++;
            const container = document.getElementById('questions-container');
            const first = container.querySelector('.question-card');
            const clone = first.cloneNode(true);

            // تحديث المؤشرات والأسماء
            clone.setAttribute('data-index', qIndex);
            clone.querySelector('.question-title').textContent = 'السؤال ' + (qIndex + 1);

            // نظّف القيم
            clone.querySelectorAll('input').forEach(inp => {
                if (inp.type === 'text') inp.value = '';
                if (inp.type === 'radio') inp.checked = false;
            });

            // أسماء الحقول
            clone.querySelectorAll('[name]').forEach(el => {
                el.name = el.name.replace(/questions\[\d+\]/g, 'questions[' + qIndex + ']');
                // عدل ids لعناصر TF لتكون فريدة
                if (el.id && el.id.startsWith('tf-')) {
                    const base = el.id.split('-')[1]; // true/false
                    el.id = `tf-${base}-${qIndex}`;
                }
            });

            // اضبط راديوهات افتراضية
            clone.querySelectorAll('.answer-type-mc input[type=radio][name$="[correct]"]').forEach((r, i) => {
                if (i === 0) r.checked = true;
            });
            const tfTrue = clone.querySelector(`#tf-true-${qIndex}`);
            if (tfTrue) tfTrue.checked = true;

            // ارجع الـ MC ظاهرًا افتراضيًا
            clone.querySelector('.answer-type-mc').classList.remove('hidden');
            clone.querySelector('.answer-type-tf').classList.add('hidden');
            clone.querySelector('.question-type-select').value = 'mc';

            container.appendChild(clone);
            renumber();
        }

        function renumber() {
            const cards = document.querySelectorAll('.question-card');
            cards.forEach((c, i) => {
                c.querySelector('.question-title').textContent = 'السؤال ' + (i + 1);
                // ترتيب العرض
                let ord = c.querySelector('input[name^="questions"][name$="[ord]"]');
                if (ord) ord.value = (i + 1);
            });
        }
    </script> --}}
    <script>
  // خلي المؤشر يبدأ من عدد الكروت الحالية - 1
  let qIndex = document.querySelectorAll('#questions-container .question-card').length - 1;

  function updateQuestionCount() {
    const cnt = document.querySelectorAll('#questions-container .question-card').length;
    const el  = document.getElementById('q-count');
    if (el) el.textContent = cnt;
  }

  // أول ما تفتح الصفحة
  window.addEventListener('DOMContentLoaded', updateQuestionCount);

  function toggleAnswerArea(sel) {
    const card = sel.closest('.question-card');
    const isMC = sel.value === 'mc';
    card.querySelector('.answer-type-mc').classList.toggle('hidden', !isMC);
    card.querySelector('.answer-type-tf').classList.toggle('hidden', isMC);
  }

  function removeQuestion(btn) {
    const card = btn.closest('.question-card');
    const container = document.getElementById('questions-container');
    if (container.children.length === 1) {
      alert('لا يمكن حذف كل الأسئلة.');
      return;
    }
    card.remove();
    renumber();
    updateQuestionCount(); // ← مهم
  }

  function addQuestion() {
    qIndex++;
    const container = document.getElementById('questions-container');
    const first = container.querySelector('.question-card');
    const clone = first.cloneNode(true);

    // حدّث العناوين والمفاتيح
    clone.setAttribute('data-index', qIndex);
    clone.querySelector('.question-title').textContent = 'السؤال ' + (qIndex + 1);

    // نظّف القيم
    clone.querySelectorAll('input').forEach(inp => {
      if (inp.type === 'text') inp.value = '';
      if (inp.type === 'radio') inp.checked = false;
    });

    // عدّل الأسماء والـ ids
    clone.querySelectorAll('[name]').forEach(el => {
      el.name = el.name.replace(/questions\[\d+\]/g, 'questions[' + qIndex + ']');
      if (el.id && el.id.startsWith('tf-')) {
        const base = el.id.split('-')[1]; // true/false
        el.id = `tf-${base}-${qIndex}`;
      }
    });

    // الحالة الافتراضية
    clone.querySelector('.question-type-select').value = 'mc';
    clone.querySelector('.answer-type-mc').classList.remove('hidden');
    clone.querySelector('.answer-type-tf').classList.add('hidden');

    // علم أول خيار صحيح في MC، وصح في TF
    const mcCorrect = clone.querySelectorAll('.answer-type-mc input[type=radio][name$="[correct]"]');
    if (mcCorrect.length) mcCorrect[0].checked = true;
    const tfTrue = clone.querySelector(`#tf-true-${qIndex}`);
    if (tfTrue) tfTrue.checked = true;

    container.appendChild(clone);
    renumber();
    updateQuestionCount(); // ← مهم
  }

  function renumber() {
    const cards = document.querySelectorAll('.question-card');
    cards.forEach((c, i) => {
      c.querySelector('.question-title').textContent = 'السؤال ' + (i + 1);
      let ord = c.querySelector('input[name^="questions"][name$="[ord]"]');
      if (ord) ord.value = (i + 1);
    });
  }
</script>


</body>

</html>
