function toggleSearch() {
    const navRow = document.getElementById('nav-row');
    const searchBar = document.getElementById('search-bar');
    const navbar = document.querySelector('.navbar');
    
    if (searchBar.style.display === 'none' || searchBar.style.display === '') {
        // Show search bar
        searchBar.style.display = 'flex';
        searchBar.style.alignItems = 'center';
        searchBar.style.height = navbar.offsetHeight + 'px';
        navRow.style.visibility = 'hidden';
        
        // Style the container and input
        const container = searchBar.querySelector('.container');
        container.style.width = '100%';
        container.style.padding = '0 15px';
        
        // Create search input if it doesn't exist
        if (!searchBar.querySelector('.search-input')) {
            const input = document.createElement('input');
            input.type = 'text';
            input.className = 'form-control search-input';
            input.placeholder = 'Search...';
            input.style.width = '100%';
            input.style.padding = '10px';
            container.innerHTML = ''; // Clear existing content
            container.appendChild(input);
            
            // Add close button
            const closeBtn = document.createElement('button');
            closeBtn.className = 'btn btn-light position-absolute';
            closeBtn.innerHTML = '<i class="fas fa-times"></i>';
            closeBtn.style.right = '25px';
            closeBtn.style.top = '50%';
            closeBtn.style.transform = 'translateY(-50%)';
            closeBtn.onclick = toggleSearch;
            container.appendChild(closeBtn);
        }
        
        // Focus on input
        searchBar.querySelector('input').focus();
    } else {
        searchBar.style.display = 'none';
        navRow.style.visibility = 'visible';
    }
}


document.addEventListener("DOMContentLoaded", () => {
    const mainNavbar = document.getElementById('site-header');

    // Function to enable sticky navbar for mobile devices
    function handleScroll() {
        if (window.scrollY > 100) {
            mainNavbar.classList.add("sticky");
        } else {
            mainNavbar.classList.remove("sticky");
        }
    }

    // Check if the screen size is mobile and attach event listeners
    function enableStickyNavbarForMobile() {
        if (window.innerWidth <= 768) {
            window.addEventListener("scroll", handleScroll);
        } else {
            window.removeEventListener("scroll", handleScroll); // Remove listener for larger devices
            mainNavbar.classList.remove("sticky"); // Reset navbar state
        }
    }

    // Enable on load and resize
    enableStickyNavbarForMobile();
    window.addEventListener("resize", enableStickyNavbarForMobile);
});







// start js code for toggle hamburger icon in mobile
const mobileMenu = document.getElementById('mobile-menu');



// Toggle Mobile Menu
function toggleMobileMenu() {
    const mobileMenu = document.getElementById('mobile-menu');
    mobileMenu.classList.toggle('active');
}

// Event listener for the hamburger icon to open the menu
document.querySelector('.fa-bars').parentElement.addEventListener('click', (e) => {
    e.preventDefault();
    toggleMobileMenu();
});

// Event listener for the cross button to close the menu
document.querySelector('.close-btn').addEventListener('click', () => {
    const mobileMenu = document.getElementById('mobile-menu');
    mobileMenu.classList.remove('active'); // Remove 'active' class when cross button is clicked
});


// start js code for toggle hamburger icon in mobile









document.addEventListener("DOMContentLoaded", () => {  
    
   
    const userDropdown = document.getElementById('user-dropdown');
    const userIcon = document.querySelector('.fa-user').parentElement;
    
    // Toggle Cart
    
    
    
    
 

    
    // Function to toggle dropdown on click
    function toggleDropdown() {
        if (userDropdown.style.display === 'block') {
            userDropdown.style.display = 'none'; // Hide dropdown
        } else {
            userDropdown.style.display = 'block'; // Show dropdown
        }
    }
    
    // Function to hide dropdown when clicking outside
    function hideDropdownOnClickOutside(event) {
        if (!userIcon.contains(event.target) && !userDropdown.contains(event.target)) {
            userDropdown.style.display = 'none'; // Hide dropdown
        }
    }
    
    // Event listener for mobile toggle behavior
    userIcon.addEventListener('click', () => {
        toggleDropdown();
    });
    
    // Add event listener to document for outside clicks
    document.addEventListener('click', (event) => {
        hideDropdownOnClickOutside(event);
    });
    

});


document.addEventListener('DOMContentLoaded', () => {
    const userDropdown = document.getElementById('sticky-nav-user-dropdown');
    const userIcon = document.getElementById('sticky-nav-dropdown-icon');

    // Toggle dropdown visibility when user icon is clicked
    userIcon.addEventListener('click', (e) => {
        e.preventDefault();
        userDropdown.style.display = userDropdown.style.display === 'block' ? 'none' : 'block';
    });

    // Close dropdown if clicked outside
    document.addEventListener('click', (e) => {
        if (!userDropdown.contains(e.target) && !userIcon.contains(e.target)) {
            userDropdown.style.display = 'none';
        }
    });
});



document.addEventListener('DOMContentLoaded', () => {
    const userDropdown = document.getElementById('user-scroll-desktop-dropdown');
    const userIcon = document.getElementById('user-scroll-icon');

    // Toggle dropdown visibility when user icon is clicked
    userIcon.addEventListener('click', (e) => {
        e.preventDefault();
        userDropdown.style.display = userDropdown.style.display === 'block' ? 'none' : 'block';
    });

    // Close dropdown if clicked outside
    document.addEventListener('click', (e) => {
        if (!userDropdown.contains(e.target) && !userIcon.contains(e.target)) {
            userDropdown.style.display = 'none';
        }
    });
});


