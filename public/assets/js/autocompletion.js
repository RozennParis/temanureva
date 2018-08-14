
window.onload = function () {
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
};


/*$(document).ready(function() {
    $(function() {
        $('input.bird_research').autocomplete({
            minLength: 1,
            source: function(request, response){
                var letter = $('input.bird_research').val();
                var dataBird = 'letter=' + letter;
                console.log(dataBird);
                $.ajax({
                    type: "GET",
                    url: '/ajout-observation/autocomplete',
                    dataType: 'json',
                    data: dataBird,

                    success : function(arrayOfData){
                        response($.map(arrayOfData, function(objet){
                            return objet;
                        }));
                    }
                });
            }
        });
    })
});*/


/*$(document).ready(function(){
    $('#observation_bird').autocomplete({
        data: {
            "Apple": 'Apple',
            "Microsoft": 'Microsoft',
            "Google": 'https://placehold.it/250x250'
        },
    });
});*/



//AUTOCOMPLETION
/*$(function () {
    $('input.bird_research').autocomplete({
        minLength: 2,
        source : function(requete, reponse){

            var motcle = $('input.bird_research').val();
            var dataBird = 'motcle=' + motcle;
            $.ajax({
                type: "POST",
                url: "{{ path('autocomp') }}",
                dataType: 'json',
                data: dataBird,

                success : function(donnee){
                    reponse($.map(donnee, function(objet){
                        return objet;
                    }, setInterval(1500)));
                }
            });
        }
    });
});*/
