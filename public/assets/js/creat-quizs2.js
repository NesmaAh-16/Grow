    document.addEventListener('DOMContentLoaded', () => {
        const questionsContainer = document.getElementById('questions-container');
        const addQuestionBtn = document.getElementById('add-question-btn');

        const updateQuestionAttributes = (card, questionNumber) => {
            card.dataset.questionId = questionNumber;
            card.querySelector('.question-title').textContent = `السؤال ${questionNumber}`;

            const typeSelect = card.querySelector('.question-type-select');
            if (typeSelect) typeSelect.id = `question-type-${questionNumber}`;
            
            const textLabel = card.querySelector('label[for^="question-text-"]');
            if (textLabel) textLabel.setAttribute('for', `question-text-${questionNumber}`);
            
            const textInput = card.querySelector('input[id^="question-text-"]');
            if (textInput) textInput.id = `question-text-${questionNumber}`;
            
            card.querySelectorAll('input[name^="correct-mc-answer-"]').forEach(radio => {
                radio.name = `correct-mc-answer-${questionNumber}`;
            });

            const tfRadios = card.querySelectorAll('input[name^="correct-tf-answer-"]');
            tfRadios.forEach(radio => {
                const oldId = radio.id;
                const newId = `${oldId.substring(0, oldId.lastIndexOf('-'))}-${questionNumber}`;
                radio.name = `correct-tf-answer-${questionNumber}`;
                radio.id = newId;
                const label = card.querySelector(`label[for="${oldId}"]`);
                if (label) {
                    label.setAttribute('for', newId);
                }
            });
        };

        const updateAllQuestionTitles = () => {
            const questionCards = questionsContainer.querySelectorAll('.question-card');
            questionCards.forEach((card, index) => {
                updateQuestionAttributes(card, index + 1);
            });
        };

        const handleQuestionTypeChange = (e) => {
            if (e.target.classList.contains('question-type-select')) {
                const card = e.target.closest('.question-card');
                const mcContainer = card.querySelector('.answer-type-mc');
                const tfContainer = card.querySelector('.answer-type-tf');

                if (e.target.value === 'mc') {
                    mcContainer.classList.remove('hidden');
                    tfContainer.classList.add('hidden');
                } else {
                    mcContainer.classList.add('hidden');
                    tfContainer.classList.remove('hidden');
                }
            }
        };
        
        const handleDeleteQuestion = (e) => {
            if (e.target.classList.contains('btn-delete-question')) {
                if (questionsContainer.querySelectorAll('.question-card').length > 1) {
                    e.target.closest('.question-card').remove();
                    updateAllQuestionTitles();
                } else {
                    alert('يجب أن يحتوي الاختبار على سؤال واحد على الأقل.');
                }
            }
        };

        questionsContainer.addEventListener('change', handleQuestionTypeChange);
        questionsContainer.addEventListener('click', handleDeleteQuestion);

        addQuestionBtn.addEventListener('click', () => {
            const firstCard = questionsContainer.querySelector('.question-card');
            const newCard = firstCard.cloneNode(true);

            newCard.querySelector('input[id^="question-text-"]').value = '';
            newCard.querySelectorAll('.answer-option input[type="text"]').forEach(input => input.value = '');
            
            newCard.querySelector('.question-type-select').value = 'mc';
            newCard.querySelector('.answer-type-mc').classList.remove('hidden');
            newCard.querySelector('.answer-type-tf').classList.add('hidden');

            newCard.querySelector('input[name^="correct-mc-answer-"]').checked = true;
            newCard.querySelector('input[name^="correct-tf-answer-"]').checked = true;

            questionsContainer.appendChild(newCard);
            updateAllQuestionTitles();
        });

        updateAllQuestionTitles();
    });