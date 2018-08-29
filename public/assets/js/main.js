$(document).ready(function(){
    $('.slider').slider({
        interval: 2000,
        height: 864,
        indicators: false,
    });
    $('.scrollspy').scrollSpy({
        scrollOffset: 1000,
    });
    $('.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        yearRange: 100,
        firstDay: 1,
        i18n: {
            months: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"],
            monthsShort: ["Jan", "Fev", "Mar", "Avr", "Mai", "Jun", "Jul", "Aou", "Sep", "Oct", "Nov", "Dec"],
            weekdays: ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"],
            weekdaysShort: ["Dim", "Lun", "Mar", "Mer", "Jeu", "Ven", "Sam"],
            weekdaysAbbrev: ["D", "L", "M", "M", "J", "V", "S"]
        }
    });

    $(document).ready(function(){
        $('select').formSelect();
    });

    $(document).ready(function(){
        $('.collapsible').collapsible();
    });
});
