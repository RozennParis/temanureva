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

    myMarker = L.marker([lat, lon], {draggable: true}, {autoPan: true}, {interactive: true}).addTo(macarte);
}


window.onload = function(){
    // Fonction d'initialisation qui s'exécute lorsque le DOM est chargé
    initMap();
    myMarker.getLatLng();
    console.log(myMarker.getLatLng());
    myMarker.on('dragend', function(e) {
        console.log('myMarker dragend event');
        var newCoordonates = myMarker.getLatLng();
        console.log(myMarker.getLatLng());
        console.log(newCoordonates.lat);
        $('#observation_latitude').val(newCoordonates.lat);
        $('#observation_longitude').val(newCoordonates.lng);

    });


};

