const containerEditService = $('#showServicesContainer');

if (containerEditService.length) {
    $(document).on("submit", "#form_edit_service", function (form) {
        form.preventDefault();
        const url = $(this).attr("data-url")
        const form_data = $(this).serialize() ;
        $.ajax({
            url: url,
            type:'POST',
            data: form_data,
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

}