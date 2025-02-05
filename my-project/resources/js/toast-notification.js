import { Toast } from "bootstrap";

document.addEventListener("DOMContentLoaded", function () {
    const toastList = document.querySelectorAll(".toast");
    toastList.forEach((toastElement) => {
        const toast = new Toast(toastElement);
        toast.show();
    });
});
