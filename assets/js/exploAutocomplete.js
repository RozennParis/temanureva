import axios from "axios";

require('../css/app.css');

var exploCompletion = new Vue({
    el: '#exploration-autocomplete',
    delimiters: ['${', '}'],
    data: {
        autocomplete: '',
        items: []
    },

    mounted () {
        $('input.autocomplete').autocomplete({
            onAutocomplete: (v) => {
                let item = this.items.find(i => {
                    return i.name === v
                })
                $('#explo_search_bird').val(item.id)
            }
        });
    },
    methods: {
        search (v) {
            axios.get('/autocomplete?dataBird='+v.target.value).then(
                response => {
                    $('input.autocomplete').css('border-bottom', '1px solid green')
                    this.items = response.data
                    if (this.items.length === 0){
                        $('input.autocomplete').css('border-bottom', '1px solid red')
                    }
                    let valuesObject = {}
                    let mapfn = i => {
                        valuesObject[i.name] = ''
                    }
                    this.items.map(mapfn)

                    $('input.autocomplete').autocomplete('updateData', valuesObject);
                }
            )
        }
    }
})
