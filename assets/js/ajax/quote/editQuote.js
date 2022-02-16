const buttonEdit = $('#edit_quote');

if (buttonEdit.length) {

    $('#edit_quote').click(function (){
        const url = buttonEdit.attr('data-url');
        let arrayName = [];
        let arrayDescription = [];
        let arrayVelocity = [];
        let arrayPrice = [];
        let arrayId = [];
        $('.select_name').each(function(i){
            arrayName.push($(this).val());
        })
        $('.select_name_show').each(function(i){
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
        console.log({services})

        $.ajax({
            url: url,
            type: 'POST',
            data: {formData: clientData, servicesData: services},
            dataType: "JSON",
            success: function (data) {
                console.log('success')
            },
            error: function (xhr, desc, err) {
                setTimeout(function () {
                    $(".alert-danger").hide();
                }, 3000);
            }
        })


    })



}
