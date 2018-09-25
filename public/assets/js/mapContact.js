var mapContact = L.map('mapContact', {
    center: [48.863027, 2.361770],
    zoom: 15,
    scrollWheelZoom: false
})
L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox.streets',
    accessToken: 'pk.eyJ1IjoiamVzZGF4IiwiYSI6ImNqbGlqcnJjazAxemsza3MxbGhvMTljd2UifQ.Sj-xlNYTfb_hU1R0XseFag',
}).addTo(mapContact);

L.marker([48.863027, 2.361770]).addTo(mapContact);