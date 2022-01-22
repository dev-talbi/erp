const containerAllservices = $('#allServicesContainer');

if (containerAllservices.length) {
    $(".delete").each(function() {
        $(this).click(function(){
            const url = $(this).attr("data-url")
            const id = {id:$(this).attr("data-id")}

            $.ajax({
                url: url,
                type:'POST',
                data: id,
                dataType: "JSON",
                success: function (data) {
                    console.log('success')
                    window.location.reload();
                },
                error: function (xhr, desc, err) {
                    console.log('error')
                }
            })
        })
    });

}