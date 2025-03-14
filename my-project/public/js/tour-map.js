function initMap() {
    const destinations = [];

    // Merr të dhënat nga elementët me klasën .destination
    document.querySelectorAll(".destination").forEach(function (element) {
        const destination = {
            lat: parseFloat(element.getAttribute("data-lat")),
            lng: parseFloat(element.getAttribute("data-lng")),
            name: element.getAttribute("data-name"),
            description: element.getAttribute("data-description"),
        };
        destinations.push(destination);
    });

    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 1,
        center: { lat: destinations[0].lat, lng: destinations[0].lng },
    });

    destinations.forEach(function (destination) {
        const marker = new google.maps.Marker({
            position: { lat: destination.lat, lng: destination.lng },
            map: map,
            title: destination.name,
        });

        const infowindow = new google.maps.InfoWindow({
            content: destination.description,
        });

        marker.addListener("click", function () {
            infowindow.open(map, marker);
        });

        console.log(destination.description);
    });
}
