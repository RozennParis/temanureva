$(document).ready(function ({}) {

    let url = "/observer-carte-oiseaux/rechercher";

    $('#btn-search').click(function () {
        console.log('yes');

        let bird_id = $('#explo_search_bird').val();

        console.log(bird_id);

        $.ajax({
            url: url,
            data: {bird_id: bird_id}
        }).done(function (e) {
            console.log(e);
        })
         return false;
    })


    var map = L.map('mappex', {
        center: [46.70973594407157, 2.6367187500000004],
        zoom: 6,
        zoomControl: false
    })
    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken: 'pk.eyJ1IjoiamVzZGF4IiwiYSI6ImNqbGlqcnJjazAxemsza3MxbGhvMTljd2UifQ.Sj-xlNYTfb_hU1R0XseFag',
    }).addTo(map);



    /*var map = L.map('mappex', null, {zoomControl:false}).setView([46.70973594407157, 2.6367187500000004],6);
    L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken: 'pk.eyJ1IjoiamVzZGF4IiwiYSI6ImNqbGlqcnJjazAxemsza3MxbGhvMTljd2UifQ.Sj-xlNYTfb_hU1R0XseFag',
    }).addTo(map);*/

})








