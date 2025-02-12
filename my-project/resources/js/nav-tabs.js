document.addEventListener("DOMContentLoaded", function () {
    const navLinks = document.querySelectorAll(".users-nav-link");
    const currentUrl = window.location.href;

    console.log("Current URL:", currentUrl);

    const savedTab = localStorage.getItem("activeTab");

    navLinks.forEach(function (navLink) {
        const href = navLink.href;

        if (currentUrl === href || (savedTab && savedTab === href)) {
            navLink.classList.add("active");
            navLink.setAttribute("aria-current", "page");
        } else {
            navLink.classList.remove("active");
            navLink.removeAttribute("aria-current");
        }

        navLink.addEventListener("click", function () {
            localStorage.setItem("activeTab", href);
        });
    });
});
