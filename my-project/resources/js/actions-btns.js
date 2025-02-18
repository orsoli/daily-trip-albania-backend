document.addEventListener("DOMContentLoaded", function () {
    let deleteModal = document.getElementById("deleteModal");
    let deleteModalHeader = document.getElementById("deleteModalLabel");
    let deleteModalBody = document.getElementById("deleteModalBody");
    let deleteForm = document.getElementById("deleteForm");

    deleteModal.addEventListener("show.bs.modal", function (event) {
        let button = event.relatedTarget; // Open Modal Button
        if (!button) return; // Prevent errors if button is null
        let dataName = button.getAttribute("data-name");
        let formAction = button.getAttribute("data-form-action");
        let modalHeader = button.getAttribute("data-modal-header");
        let modalBody = button.getAttribute("data-modal-body");

        // Set attributes
        deleteModalHeader.textContent = modalHeader + " " + dataName;
        deleteModalBody.textContent = modalBody + " " + dataName;
        deleteForm.setAttribute("action", formAction);
    });
});
