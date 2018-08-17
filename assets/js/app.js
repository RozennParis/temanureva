import axios from 'axios'

require('../css/app.css');
var app = new Vue({
    el: '#observation-autocomplete',
    delimiters: ['${', '}'],
    data: {
        autcomplete: '',
        items: []
    },
    mounted () {
        $('input.autocomplete').autocomplete({
            onAutocomplete: (v) => {
                $('#observation_bird').val(v)
            }
        });
    },
    methods: {
        search (v) {
            $('input.autocomplete').autocomplete('updateData', {});
            axios.get('/ajout-observation/autocomplete?dataBird='+v.target.value).then(
                response => {
                    $('input.autocomplete').css('border-bottom', '1px solid green')
                    this.items = response.data
                    if (this.items.length === 0){
                        $('input.autocomplete').css('border-bottom', '1px solid red')
                    }
                    let valuesObject = {}
                    this.items.map(i => {
                        valuesObject[i] = ''
                    })
                    $('input.autocomplete').autocomplete('updateData', valuesObject);
                }
            )
        }
    }
})