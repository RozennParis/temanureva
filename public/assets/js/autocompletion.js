$(document).ready(function() {
    $('input.bird_research').autocomplete({
        data : {
            "Moineau domestique": 'Moineau domestique',
            "Moineau espagnol": 'Moineau espagnol',
            "Moineau cisalpin": 'Moineau cisalpin',
            "Moineau friquet": 'Moineau friquet',
            "Moineau soulcie": 'Moineau soulcie',
            "Épervier": 'Épervier',
            "Mouette rieuse": 'Mouette rieuse',
            "Rouge-gorge": 'Rouge-gorge',
            "Perroquet": 'Perroquet',
            "Buse": 'Buse',
            "Aigle royal": 'Aigle royal',
            "Vautour": 'Vautour',
            "Goéland": 'Goéland',
            "Mésange charbonnière": 'Mésange charbonnière'
        },
        minLength: 1,
    });
});