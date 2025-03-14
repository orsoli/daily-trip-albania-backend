function initMap() {
    const name = document.getElementById("map").dataset.name;
    // Coordinates of the destination
    const location = {
        lat: parseFloat(document.getElementById("map").dataset.lat),
        lng: parseFloat(document.getElementById("map").dataset.lng),
    };

    // Initialization of the map
    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 12,
        center: location,
    });

    // Placing the marker on the map
    new google.maps.Marker({
        position: location,
        map: map,
        title: name,
    });
}
