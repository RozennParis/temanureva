
/*window.onload = function () {
    $('input.bird_research').keyup(function () {
        let dataBird = $('input.bird_research').val();

        if (dataBird == "") return false;
        console.log(dataBird);
        $.ajax({
            method: "GET",
            url: "/ajout-observation/autocomplete",
            dataType: 'json',
            data: {dataBird: dataBird}
        })
           .done(function (result) {
               $("#resultList").html(result);
            });
    });
};*/




/*$(document).ready(function(){
    $('#observation_bird').autocomplete({
        data: {
            "Apple": 'Apple',
            "Microsoft": 'Microsoft',
            "Google": 'https://placehold.it/250x250'
        },
    });
});*/


/*
//AUTOCOMPLETION
$(document).ready(function () {
    $('input.bird_research').autocomplete({
        minLength: 2,
        /*source : function(requete, reponse){

            var motcle = $('input.bird_research').val();
            var dataBird = 'motcle=' + motcle;
            $.ajax({
                type: "GET",
                url: "/ajout-observation/autocomplete",
                dataType: 'json',
                data: dataBird,

                success : function(donnee){
                    reponse($.map(donnee, function(objet){
                        return objet;
                    }, setInterval(1500)));
                }
            });
        }*/
       /* data: {
            "Apple": 'Apple',
            "Microsoft": 'Microsoft',
            "Google": 'https://placehold.it/250x250',
            "Vautour": 'Vautour',
            "Machin a cravate noire": 'Machin à cravate noire',
        },
    });
});
*/



