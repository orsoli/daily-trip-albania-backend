document.addEventListener("submit", function () {
    let itineraries = [];

    // Get all itinerary containers
    const itineraryContainers = document.querySelectorAll(
        ".itinerary-container"
    );

    itineraryContainers.forEach((container) => {
        // Initialize an object for each itinerary
        let itinerary = {};

        // Get all input fields inside the container
        const itineraryInputs = container.querySelectorAll("input, textarea");

        itineraryInputs.forEach((input) => {
            // Save the name and value of each input field in the itinerary object
            itinerary[input.name] = input.value;
        });

        // Push the itinerary object to the itineraries array
        itineraries.push(itinerary);
    });

    // Save the itineraries array in localStorage
    localStorage.setItem("itineraries", JSON.stringify(itineraries));
});
