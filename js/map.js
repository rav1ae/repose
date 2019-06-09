var myMap, myPlacemark;

var initMap = function () {

    myMap = new ymaps.Map('js-map', {
        center: [43.25441863, 76.93178319],
        zoom: 16,
        behavior: {
            ZoomScroll: false
        },
        controls: ['zoomControl', 'typeSelector', 'fullscreenControl']
    });
    myMap.behaviors.disable('scrollZoom');


    for (var i in Locations) {

        if (Locations[i]['lat'] > 0 && Locations[i]['lon'] > 0) {

            var myPlacemark = new ymaps.Placemark([Locations[i]['lat'], Locations[i]['lon']], {
                hintContent: Locations[i]['title'],
                balloonContent: '<h3>' + Locations[i]['title'] + '</h3><p>' + Locations[i]['desc'] + '</p>'
            });

            myMap.geoObjects.add(myPlacemark);
        }

    }

};


