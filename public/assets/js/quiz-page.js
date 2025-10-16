 function toggleButton() {
      const checkbox = document.getElementById('pledge-checkbox');
      const button = document.getElementById('start-quiz-btn');
     
      if (checkbox.checked) {
        button.classList.remove('disabled'); 
        button.removeAttribute('aria-disabled'); 
      } else {
        button.classList.add('disabled');
        button.setAttribute('aria-disabled', 'true');
      }
    }

 
    document.getElementById('start-quiz-btn').addEventListener('click', function(event) {
      if (this.classList.contains('disabled')) {
        event.preventDefault();
      }
    });

  
    document.addEventListener('DOMContentLoaded', toggleButton);