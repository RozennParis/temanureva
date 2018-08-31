

$(document).ready(function(){

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
        },
        /*maxDate: today,*/
        onSelect: function (date) {
            var selectedDay = date;
            return selectedDay;
        }
    });

    $('.timepicker').timepicker({
        twelveHour: false,
        onSelect: function (hour, minute){
            var selectedTime = hour + ':' + minute;
            return selectedTime;
        },
    });

});

window.onload = function () {
    var selectedDate = $('.datepicker').datepicker('toString');
    console.log(selectedDate);
};