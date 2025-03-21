let itineraryIndex = 1;

window.addItinerary = function () {
    // Find the div where itineraries will be added
    let container = document.getElementById("itineraries-container");

    // Get data attribute values
    const dayLabel = container.dataset.dayLabel;
    const startTimeLabel = container.dataset.startTimeLabel;
    const lunchTimeLabel = container.dataset.lunchTimeLabel;
    const endTimeLabel = container.dataset.endTimeLabel;
    const activitiesLabel = container.dataset.activitiesLabel;

    // New HTML for the itinerary to be added
    let newItinerary = `
        <div class="row row-cols-1 row-cols-lg-4 itinerary-container border rounded-3 py-1 mx-auto mb-4 position-relative">
            <!-- Day -->
            <div class="col input-container">
                <div class="position-relative">
                    <input id="day-${itineraryIndex}" type="text"
                        class="form-control text-light position-relative"
                        name="itineraries[${itineraryIndex}][day]" required autocomplete="day" autofocus>
                    <label for="day-${itineraryIndex}">${dayLabel} *</label>
                </div>
            </div>

            <!-- Start Time -->
            <div class="col input-container">
                <div class="position-relative">
                    <input id="start-time-${itineraryIndex}" type="time"
                        class="form-control custom-time text-light position-relative"
                        name="itineraries[${itineraryIndex}][start_at]" required autocomplete="off" autofocus>
                    <label for="start-time-${itineraryIndex}">${startTimeLabel} *</label>
                </div>
            </div>

            <!-- Lunch Time -->
            <div class="col input-container">
                <div class="position-relative">
                    <input id="lunch-time-${itineraryIndex}" type="time"
                        class="form-control custom-time text-light position-relative"
                        name="itineraries[${itineraryIndex}][lunch_time]" required autocomplete="off" autofocus>
                    <label for="lunch-time-${itineraryIndex}">${lunchTimeLabel} *</label>
                </div>
            </div>

            <!-- End Time -->
            <div class="col input-container">
                <div class="position-relative">
                    <input id="end-time-${itineraryIndex}" type="time"
                        class="form-control custom-time text-light position-relative"
                        name="itineraries[${itineraryIndex}][end_at]" required autocomplete="off" autofocus>
                    <label for="end-time-${itineraryIndex}">${endTimeLabel} *</label>
                </div>
            </div>

            <!-- Activities -->
            <div class="col col-lg-12 input-container">
                <div class="position-relative">
                    <textarea id="activities-${itineraryIndex}" name="itineraries[${itineraryIndex}][activities]"
                        class="form-control" rows="2" maxlength="500" required autocomplete="activities"
                        autofocus></textarea>
                    <label for="activities-${itineraryIndex}">${activitiesLabel} *</label>
                </div>
            </div>

            <!-- Delete Itinerary Button -->
            <div class="w-auto p-0 position-absolute top-0 end-0 translate-middle">
                <button class="btn btn-sm bg-danger rounded-5" onclick="removeItinerary(this)">
                    <i class="bi bi-trash3 text-light"></i>
                </button>
            </div>
        </div>
    `;

    // Add the new HTML to the end of the 'itinerary-container' div
    container.insertAdjacentHTML("beforeend", newItinerary);

    // Increment the index to maintain a unique name for future fields
    itineraryIndex++;
};

// Function to remove the added itinerary
window.removeItinerary = function (button) {
    // Remove the corresponding div
    button.closest(".itinerary-container").remove();
};
