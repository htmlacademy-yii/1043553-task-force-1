$(document).ready(function () {
    ymaps.ready(init);

    function init() {
        // Создание карты.
        var myMap = new ymaps.Map("map", {
            center: [lat, lon],
            zoom: 13
        });
    }
});

