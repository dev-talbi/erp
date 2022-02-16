import Sortable from 'sortablejs';

require('select2')
const containerAddQuote = $('#container_create_quote');

if (containerAddQuote.length) {

    // get all servie in select2 select 
    function getService() {
        let selectService = $('.select_name');
        let url = selectService.attr("data-url")
        selectService.each(function () {
            $(this).select2({
                theme: "bootstrap",
                ajax: {
                    url: url,
                    data: function (params) {
                        return {
                            searchTerm: params.term // search term
                        };
                    },
                    processResults: function (data, params) {
                        params.page = params.page || 1;
                        return {
                            results: data,
                        };
                    },
                    cache: true,
                    success: function (data) {
                        console.log('success')
                    },
                    error: function (xhr, desc, err) {
                        console.log('error')
                    }
                }
            })
        });
    }

    //transform the select of service select after the click on "+" to a select2 select
    $('.recipe-table__add-row-btn').click(function () {
        setTimeout(function () {
            getService()
            updateData()
            total()
          /*  destroySelect2()*/
        }, 500)


    });

    //update missing data foreach input after name of reduction.
    function updateData(){
        $(".select_name").each(function () {
            $(this).on("change", function () {
                let url = $("#recipeTable").attr("data-url")
                const data = {data: $(this).val()}
                let input = $(this)
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: data,
                    dataType: "JSON",
                    success: function (data) {
                        const description = data.description
                        const price = data.price;
                        const velocity = data.velocity;
                        const id = data.id;
                        input.parent("td").next().children(".description").val(description);
                        input.parent("td").next().next().children(".velocity").val(velocity);
                        input.parent("td").next().next().next().children(".price").val(price);
                        input.parent("td").next().next().next().next().children(".id").val(id);
                        total()
                    },
                    error: function (xhr, desc, err) {
                        console.log({err})

                    }
                })
            })
        })
    }

/*    function destroySelect2(){
        $( ".unlock" ).each(function() {
            $(this).on("click", function(){
                event.preventDefault();
                if ($(this).hasClass("open")){
                    $(this).parent("td").prev().prev().prev().prev().prev().children(".select_name").select2('destroy');
                    $(this).parent("td").prev().prev().prev().prev().prev().children(".select_name").replaceWith( "<input name='select_name' placeholder='Nom du service' class='select_name form-control'>" );
                    $(this).children().first().removeAttr("data-icon");
                    $(this).children().first().attr("data-icon", "lock");
                    $(this).removeClass("open");
                    $(this).addClass("close");
                    $(this).hide();
                }
            })
        });
    }*/

    // calculate the total of the quote and put the result in total field
    function total(){
        let sum = 0;
        let discount = parseFloat($('#discount').val());
        $('.price').each(function(){
            sum += parseFloat($(this).val());
        });
        let total = sum - ((sum * discount)/100)
        $('#total_price').val(total)
    }

    $("#discount").on("change", function () {
        total()
    })


    // create the quote in bdd
    $('#submit_quote').click(function (){
        const url = $('#submit_quote').attr('data-url');
            let arrayName = [];
            let arrayDescription = [];
            let arrayVelocity = [];
            let arrayPrice = [];
            let arrayId = [];
            $('.select_name').each(function(i){
                arrayName.push($(this).val());
            })
            $('.description').each(function(i){
                arrayDescription.push($(this).val());
            })
            $('.velocity').each(function(i){
                arrayVelocity.push($(this).val());
            })
            $('.price').each(function(i){
                arrayPrice.push($(this).val());
            })
            $('.id').each(function(i){
                arrayId.push($(this).val());
            })

            let services = arrayName.map((arrayName, index)=>{
                return{
                    name: arrayName,
                    description: arrayDescription,
                    velocity: arrayVelocity,
                    price: arrayPrice,
                    id: arrayId
                }
            });
        const clientData = $('#form_create_quote').serialize();
        $.ajax({
            url: url,
            type: 'POST',
            data: {formData: clientData, servicesData: services},
            dataType: "JSON",
            success: function (data) {
                $('.alert-success').show()
                setTimeout(function() { $(".alert-success").hide(); }, 3000);
            },
            error: function (xhr, desc, err) {
                $('.alert-danger').show()
                setTimeout(function() { $(".alert-danger").hide(); }, 3000);
            }
        })



    })

    $(document).ready(function () {
        updateData();
/*        destroySelect2();*/
        let $tableBody = $('#recipeTableBody');
        let $menu = $('#menu');
        $(document).on('click', '.recipe-table__add-row-btn', function (e) {
            let $el = $(e.currentTarget);
            let htmlString = $('#rowTemplate').html();
            $tableBody.append(htmlString);
            return false;
        });

        $tableBody.on('click', '.recipe-table__del-row-btn', function (e) {
            let $el = $(e.currentTarget);
            let $row = $el.closest('tr');
            $row.remove();
            total()
            return false;
        });

        Sortable.create(
            $tableBody[0],
            {
                animation: 150,
                scroll: true,
                handle: '.drag-handler',
                onEnd: function () {
                    console.log('More see in https://github.com/RubaXa/Sortable');
                }
            }
        );

        total()
        getService()
    });
}