document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("form");
    const buttons = document.querySelectorAll(".btn");
    const initialValues = {};

    // Save the initial values of the inputs
    if (form) {
        Array.from(form.elements).forEach((input) => {
            if (input.name) {
                initialValues[input.name] = input.value;
            }
        });

        // Function to check for changes
        function checkChanges() {
            let formChanged = false;
            Array.from(form.elements).forEach((input) => {
                if (input.name && input.value !== initialValues[input.name]) {
                    formChanged = true;
                }
            });

            // Enable or disable buttons
            buttons.forEach((button) => {
                button.disabled = !formChanged;
            });
        }

        // Monitor inputs for changes
        form.addEventListener("input", checkChanges);

        // Event listener to disable buttons when one of them is clicked
        buttons.forEach((button) => {
            if (button.type === "reset") {
                button.addEventListener("click", function (e) {
                    e.preventDefault();
                    form.reset();
                    buttons.forEach((btn) => {
                        btn.disabled = true;
                    });
                });
            }
        });
    }
});
