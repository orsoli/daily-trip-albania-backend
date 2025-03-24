// 🚀 Remove `localStorage` after the page is refreshed
window.addEventListener("load", () => {
    localStorage.removeItem("itineraries");
});
