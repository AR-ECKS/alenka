

$(document).ready(function () {
    $(".floatNumberField").change(function() {
        $(this).val(parseFloat($(this).val()).toFixed(2));
    });
    // $(".select2").select2({
    //     width: "100%",

    //     language: {
    //         noResults: function () {
    //             return '<button id="mostrar" class="btn btn-success  btn-sm" onclick="noResultsButtonClicked()">No existe, Cree el cliente</a>';
    //         },
    //     },
    //     escapeMarkup: function (markup) {
    //         return markup;
    //     },
    // });

    // let myNumericInput = new AutoNumeric('.total',{decimalPlaces: 2});

    // document.querySelector('.total').addEventListener('keyup',() =>{
    //   console.log(myNumericInput.getNumber())
    // })

    // let myNumericInput1 = new AutoNumeric('.total1',{decimalPlaces: 2});

    // document.querySelector('.total1').addEventListener('keyup',() =>{
    //   console.log(myNumericInput.getNumber())
    // })
});
