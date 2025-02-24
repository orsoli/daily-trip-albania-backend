document.addEventListener("DOMContentLoaded", function () {
    const navLinks = document.querySelectorAll(".data-nav-link");
    const currentUrl = window.location.href;

    navLinks.forEach((link) => {
        // Remove classes from all links to ensure a clean reset
        link.classList.remove("active-tab", "disabled");

        // Check if the link's href matches the current URL
        if (link.href === currentUrl) {
            link.classList.add("active-tab", "disabled");
        } else {
            link.classList.add("deactive-tab");
        }
    });
});
