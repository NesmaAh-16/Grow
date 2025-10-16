const aboutButton = document.getElementById('about-btn');
      const modalOverlay = document.getElementById('about-modal-overlay');
      const closeModalButton = document.getElementById('close-modal-btn');

      // Function to open the modal
      function openModal() {
        modalOverlay.classList.add('active');
      }

      // Function to close the modal
      function closeModal() {
        modalOverlay.classList.remove('active');
      }

      // Event listener for the "About Us" button
      aboutButton.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default link behavior
        openModal();
      });

      // Event listener for the close button
      closeModalButton.addEventListener('click', closeModal);

      // Event listener to close modal when clicking on the overlay
      modalOverlay.addEventListener('click', function(event) {
        // We check if the click was on the overlay itself, not its children
        if (event.target === modalOverlay) {
          closeModal();
        }
      });