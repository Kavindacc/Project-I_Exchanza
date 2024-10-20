document.addEventListener('DOMContentLoaded', function () {
    const categoryDropdown = document.getElementById('categoryDropdown');
    const categoryMenu = categoryDropdown.nextElementSibling; // This selects the ul under categoryDropdown

    categoryDropdown.addEventListener('click', function (event) {
        event.preventDefault(); // Prevent default link behavior
        categoryMenu.classList.toggle('show'); // Toggle the show class
    });

    // Close the dropdown if clicked outside
    window.addEventListener('click', function (event) {
        if (!categoryDropdown.contains(event.target) && !categoryMenu.contains(event.target)) {
            categoryMenu.classList.remove('show'); // Remove show class
        }
    });
});

document.querySelectorAll('.dropdown-submenu').forEach(function (submenu) {
    submenu.addEventListener('mouseover', function () {
      let dropdownMenu = submenu.querySelector('.dropdown-menu');
      if (dropdownMenu) {
        dropdownMenu.classList.add('show');
      }
    });
    
    submenu.addEventListener('mouseleave', function () {
      let dropdownMenu = submenu.querySelector('.dropdown-menu');
      if (dropdownMenu) {
        dropdownMenu.classList.remove('show');
      }
    });
  });
  