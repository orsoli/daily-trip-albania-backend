document.addEventListener("DOMContentLoaded", function () {
    const navLinks = document.querySelectorAll(".users-nav-link");
    const currentUrl = window.location.href;

    // Get the last selected tab from localStorage (if it exists)
    const savedTab = localStorage.getItem("activeTab");

    navLinks.forEach((link) => {
        // Check if the link's href matches the current URL OR matches the saved tab
        if (
            link.href === currentUrl ||
            link.getAttribute("data-tab") === savedTab
        ) {
            link.classList.add("active", "disabled"); // Make it active
        }

        // Add event listener to each tab
        link.addEventListener("click", function () {
            // Remove "active" class from all links before setting a new one
            navLinks.forEach((l) => l.classList.remove("active", "disabled"));

            // Add "active" class to the clicked link
            this.classList.add("active", "disabled");

            // Save the clicked tab in localStorage using its data-tab value
            localStorage.setItem("activeTab", this.getAttribute("data-tab"));
        });
    });
});
