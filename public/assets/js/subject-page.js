 document.querySelectorAll('.lesson-checkbox').forEach(checkbox => {
      checkbox.addEventListener('change', function() {
        const lesson = this.closest('.lesson');
        if (this.checked) {
          lesson.classList.add('completed');
        } else {
          lesson.classList.remove('completed');
        }
        updateUnitProgress(this);
      });
    });
    
    function updateUnitProgress(checkbox) {
      const unitCard = checkbox.closest('.unit-card');
      const totalLessons = unitCard.querySelectorAll('.lesson-checkbox').length;
      const completedLessons = unitCard.querySelectorAll('.lesson-checkbox:checked').length;
      const progressPercent = (completedLessons / totalLessons) * 100;
      
      unitCard.querySelector('.progress-bar').style.width = `${progressPercent}%`;
    }
    
    // Simulate some completed lessons for demo
    document.addEventListener('DOMContentLoaded', function() {
      // Set initial state without triggering the change event
      const lesson1_1 = document.getElementById('lesson1-1');
      if(lesson1_1) {
        lesson1_1.checked = true;
        lesson1_1.closest('.lesson').classList.add('completed');
        updateUnitProgress(lesson1_1);
      }
      
      const lesson1_3 = document.getElementById('lesson1-3');
      if(lesson1_3) {
        lesson1_3.checked = true;
        lesson1_3.closest('.lesson').classList.add('completed');
        updateUnitProgress(lesson1_3);
      }

      const lesson2_2 = document.getElementById('lesson2-2');
      if(lesson2_2) {
        lesson2_2.checked = true;
        lesson2_2.closest('.lesson').classList.add('completed');
        updateUnitProgress(lesson2_2);
      }
    });