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

        // Save itineraries in localStorage
        form.addEventListener("submit", function (event) {
            event.preventDefault();

            let itineraries = [];

            // Get all itinerary containers
            const itineraryContainers = document.querySelectorAll(
                ".itinerary-container"
            );

            itineraryContainers.forEach((container) => {
                // Initialize an object for each itinerary
                let itinerary = {};

                // Get all input fields inside the container
                const itineraryInputs =
                    container.querySelectorAll("input, textarea");

                itineraryInputs.forEach((input) => {
                    // Save the name and value of each input field in the itinerary object
                    itinerary[input.name] = input.value;
                });

                // Push the itinerary object to the itineraries array
                itineraries.push(itinerary);
            });

            // Save the itineraries array in localStorage
            localStorage.setItem("itineraries", JSON.stringify(itineraries));

            form.submit();
        });
    }
});
