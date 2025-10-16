 document.querySelectorAll('.nav-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const title = this.getAttribute('title');
                alert(`سيتم فتح ${title}`);
            });
        });