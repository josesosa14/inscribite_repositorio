<script type="text/javascript" src="//maps.google.com/maps/api/js"></script>
<script src="<?= base_url() ?>public/js/prettify.js" type="text/javascript"></script>
<script src="<?= base_url() ?>public/js/gmaps.js" type="text/javascript"></script>
<script type="text/javascript">
    var map;

    var map = new google.maps.Map(document.getElementById('map'), {
        zoom: 7,
        center: {lat: -36.87083216, lng: -60.32043457},
        mapTypeId: google.maps.MapTypeId.TERRAIN
    });

    var puntos1 = [
        {lat: -38.78834536, lng: -63.35266113},
        {lat: -40.53885153, lng: -63.3416748},
        {lat: -40.44694706, lng: -62.45178223},
        {lat: -38.81403111, lng: -62.34191895},
        {lat: -38.78834536, lng: -63.35266113}
    ];
    var poligono1 = new google.maps.Polygon({
        path: puntos1,
        geodesic: true,
        strokeColor: '#FF0000',
        strokeOpacity: 1.0,
        strokeWeight: 2
    });
    poligono1.setMap(map);
    var puntos2 = [
        {lat: -34.42503613, lng: -63.36364746},
        {lat: -35.51434313, lng: -63.35266113},
        {lat: -35.43381992, lng: -62.12219238},
        {lat: -34.59704152, lng: -60.94665527},
        {lat: -34.14363482, lng: -61.44104004},
        {lat: -34.42503613, lng: -63.36364746}
    ];
    var poligono2 = new google.maps.Polygon({
        path: puntos2,
        geodesic: true,
        strokeColor: '#6699cc',
        strokeOpacity: 1.0,
        strokeWeight: 2
    });
    poligono2.setMap(map);
    google.maps.event.addListener(poligono2, 'click', function (event) {
        alert('zona 2');
    });
    google.maps.event.addListener(poligono1, 'click', function (event) {
        alert('zona 1');
    });
</script>