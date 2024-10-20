document.getElementById('change-img-btn').addEventListener('click', function () {
    
});

const navLinks = document.querySelectorAll('.nav-links a');
navLinks.forEach(link => {
    link.addEventListener('click', function (event) {
        // Hide all sections
        document.querySelectorAll('.section').forEach(sec => sec.style.display = 'none');
        
        // Show the clicked section
        const section = document.querySelector(this.getAttribute('href'));
        section.style.display = 'block';

        // Remove active class from all links
        navLinks.forEach(nav => nav.classList.remove('active'));

        // Add active class to the clicked link
        this.classList.add('active');

        event.preventDefault();
    });
});

// Initially show personal information section only
document.querySelectorAll('.section').forEach(sec => sec.style.display = 'none');
document.getElementById('personal-info').style.display = 'block';
