document.addEventListener("DOMContentLoaded", function () {
    const navLinks = document.querySelectorAll(".users-nav-link");
    const currentUrl = window.location.href;

    navLinks.forEach((link) => {
        // Hiq klasat nga të gjithë linkët për të siguruar një pastrim të pastër
        link.classList.remove("active-tab", "disabled");

        // Kontrollo nëse href i linkut përputhet me URL-në aktuale
        if (link.href === currentUrl) {
            link.classList.add("active-tab", "disabled");
        } else {
            link.classList.add("deactive-tab");
        }
    });
});
