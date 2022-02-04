import Sortable from 'sortablejs';

require('select2')
const containerAddQuote = $('#container_create_quote');

if (containerAddQuote.length) {

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
                        console.log({data})
                        const description = data[0].description
                        const price = data[0].price;
                        const velocity = data[0].velocity;
                        const id = data[0].id;
                        input.parent("td").next().children(".description").val(description);
                        input.parent("td").next().next().children(".velocity").val(velocity);
                        input.parent("td").next().next().next().children(".price").val(price);
                        input.parent("td").next().next().next().next().children(".id").val(id);
                    },
                    error: function (xhr, desc, err) {
                        setTimeout(function () {
                            $(".alert-danger").hide();
                        }, 3000);
                    }
                })


            })

        })

    }

    function total(){
        $( ".price" ).change(function() {
            alert("change")
            let reductyion = $('#discount').val()
            let sum = 0

            $(this).each(function(){
                sum += parseFloat($(this).val());
            });
            console.log($(this).val())
            $('#total').val(sum)
        });
    }






    $(document).ready(function () {
        updateData()

        let $tableBody = $('#recipeTableBody');
        let $menu = $('#menu');
        $(document).on('click', '.recipe-table__add-row-btn', function (e) {
            let $el = $(e.currentTarget);
            let htmlString = $('#rowTemplate').html();
            $tableBody.append(htmlString);
            return false;
        });

        getService()

        $tableBody.on('click', '.recipe-table__del-row-btn', function (e) {
            let $el = $(e.currentTarget);
            let $row = $el.closest('tr');
            $row.remove();
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
    });
}