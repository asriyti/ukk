document.addEventListener('DOMContentLoaded', function () {
    const hamburgerIcon = document.getElementById('hamburgerIcon');
    const dropdownMenu = document.getElementById('dropdownMenu');

    hamburgerIcon.addEventListener('click', function () {
        dropdownMenu.style.display = (dropdownMenu.style.display === 'block') ? 'none' : 'block';
    });

    // Close the dropdown when clicking outside of it
    window.addEventListener('click', function (event) {
        if (!event.target.matches('.hamburger')) {
            if (dropdownMenu.style.display === 'block') {
                dropdownMenu.style.display = 'none';
            }
        }
    });
});
