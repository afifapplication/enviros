
fetch('partial/footer.html')
    .then(response => response.text())
    .then(data => {
        document.getElementById('footer').innerHTML = data;
    });



fetch('partial/header.html')
    .then(res => res.text())
    .then(data => {
        document.getElementById('header').innerHTML = data;

        const toggle = document.getElementById('navbarToggle');
        const menu = document.getElementById('navbarMenu');

        if (toggle && menu) {
            toggle.addEventListener('click', function () {
                menu.classList.toggle('show');
            });
        }

        // Set active menu item based on URL
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('#navbarMenu li a');

        navLinks.forEach(link => {
            const href = link.getAttribute('href');

            // Consider root path or index.html as "Home"
            if (
                (currentPath === '/' || currentPath.endsWith('index.html')) &&
                href === 'index.html'
            ) {
                link.classList.add('active');
            } else {
                link.classList.remove('active');
            }
        });
    });
