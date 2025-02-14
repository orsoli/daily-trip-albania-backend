document.addEventListener("DOMContentLoaded", function () {
    let deleteModal = document.getElementById("deleteModal");
    let deleteModalHeader = document.getElementById("deleteModalLabel");
    let deleteModalBody = document.getElementById("deleteModalBody");
    let deleteForm = document.getElementById("deleteForm");

    deleteModal.addEventListener("show.bs.modal", function (event) {
        let button = event.relatedTarget; // Open Modal Button
        let userName = button.getAttribute("data-user-name");
        let formAction = button.getAttribute("data-form-action");
        let modalHeader = button.getAttribute("data-modal-header");
        let modalBody = button.getAttribute("data-modal-body");

        // Set attributes
        deleteModalHeader.textContent = modalHeader + " " + userName;
        deleteModalBody.textContent = modalBody + " " + userName;
        deleteForm.setAttribute("action", formAction);
    });
});
