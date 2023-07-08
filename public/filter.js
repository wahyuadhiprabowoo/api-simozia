$("#puskesmasDropdown").change(function () {
    var id_puskesmas = $(this).val();
    if (id_puskesmas) {
        $.ajax({
            type: "GET",
            url: "/getposyandu?id_puskesmas=" + id_puskesmas,
            dataType: "JSON",
            success: function (res) {
                if (res) {
                    $("#posyanduDropdown").empty();
                    $("#posyanduDropdown").append(
                        "<option>Pilih Posyandu</option>"
                    );
                    $.each(res, function (id, nama) {
                        $("#posyanduDropdown").append(
                            '<option value="' + nama + '">' + id + "</option>"
                        );
                        console.log(res);
                    });
                } else {
                    $("#posyanduDropdown").empty();
                }
            },
        });
    } else {
        $("#posyanduDropdown").empty();
    }
});
