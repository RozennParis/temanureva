// On initialise la latitude et la longitude de Paris (centre de la carte)
var lat = 48.852969;
var lon = 2.349903;
var macarte = null;
var myMarker = null;
// Fonction d'initialisation de la carte
function initMap() {
    // Créer l'objet "macarte" et l'insèrer dans l'élément HTML qui a l'ID "map"
    macarte = L.map('map').setView([lat, lon], 5);
    // Leaflet ne récupère pas les cartes (tiles) sur un serveur par défaut. Nous devons lui préciser où nous souhaitons les récupérer. Ici, openstreetmap.fr
    L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
        // Il est toujours bien de laisser le lien vers la source des données
        attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
        minZoom: 1,
        maxZoom: 20
    }).addTo(macarte);

    myMarker = L.marker([lat, lon], {draggable: true}, {interactive: true}).addTo(macarte);
}


window.onload = function(){
    // Fonction d'initialisation qui s'exécute lorsque le DOM est chargé
    initMap();

    /**
     * function to retrieve geographical coordinates
     */
    myMarker.on('dragend', function(e) {
        var newCoordinates = myMarker.getLatLng();
        $('#observation_latitude').val(newCoordinates.lat);
        $('#observation_longitude').val(newCoordinates.lng);
        $('#location-input').val(newCoordinates.lat + '/ ' + newCoordinates.lng);
    });

    /**
     * to show the map when user clicks into the location-input
     */
    $('#location-input').click(function(){
        $('#observation-map').show();
        macarte.invalidateSize();
    });

    /**
     * to hide map when user clicks on button "validate" below the map
     */
    $('#hide').click(function(){
        $('#observation-map').hide();
    });
};

