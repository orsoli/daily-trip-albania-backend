document.addEventListener("DOMContentLoaded", function () {
    let deleteModal = document.getElementById("deleteModal");
    let deleteModalHeader = document.getElementById("deleteModalLabel");
    let deleteModalBody = document.getElementById("deleteModalBody");
    let deleteForm = document.getElementById("deleteForm");

    //  data-user-name="{{$user_name}}"
    //  data-form-action="{{$form_action}}"
    //  data-modal-header="{{$modal_header}}"
    //  data-modal-body="{{$modal_body}}"

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
