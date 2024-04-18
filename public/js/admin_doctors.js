$(document).ready(function () {
    function deleteDoctor(e) {
        clearMessageFields();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        var id = e.target.id.includes("imgdelete")
            ? e.target.id.replace("imgdelete", "")
            : e.target.id;
        var ajaxurl =
            "/admin/delete_doctor/" +
            id;
        $.ajax({
            type: "GET",
            url: ajaxurl,
            success: function (data) {
                $("#tr" + id).remove();
                alert("Врач с ID: " + id + " успешно удален");
            },
        });
    }

    function editDoctor(e) {
        clearMessageFields();
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        var id = e.target.id.includes("imgedit")
            ? e.target.id.replace("imgedit", "")
            : e.target.id.substring(e.target.id.indexOf("-") + 1);
        var name = $("#inputdoc-" + id).val();
        var photo = $("#photodoc-" + id)[0].files[0];
        var spec = $("#specdoc-" + id).val();
        var email = $("#emaildoc-" + id).val();
        var formData = new FormData();

        formData.append("name", name);
        if (photo) {
            formData.append("photo", photo);
        }
        formData.append("speciality_id", spec);
        formData.append("email", email);

        if (name.length > 0 && email.length>0) {
            $("#inputdoc-" + id).css("border-color", "rgb(206, 212, 218)");
            $("#emaildoc-" + id).css("border-color", "rgb(206, 212, 218)");
            var ajaxurl =
                "/admin/update_doctor/" +
                id;
            $.ajax({
                type: "POST",
                url: ajaxurl,
                contentType: false,
                processData: false,
                data: formData,
                cache: false,
                dataType: "json",
                success: function (data) {
                    if (data.message) {
                        $("#AjaxHelp").text(data.message);
                    } else {
                        alert("Врач с ID: " + id + " успешно отредактирован");
                    }
                    $("#photodoc-" + id).val("");
                },
            });
        } else {
            name.length == 0 ? $("#inputdoc-" + id).css("border-color", "red") : $("#inputdoc-" + id).css("border-color", "rgb(206, 212, 218)");
            email.length == 0 ? $("#emaildoc-" + id).css("border-color", "red") : $("#emaildoc-" + id).css("border-color", "rgb(206, 212, 218)");
        }
    }

    function clearMessageFields(){
        $("#DoctorSuccessHelp").text("");
        $("#DoctorErrorHelp").text("");
        $("#PhotoErrorHelp").text("");
        $("#AjaxHelp").text("");
    }

    $("#InputDoctor").on('input', clearMessageFields);
    $("#InputSpeciality").change(clearMessageFields);
    $("#PhotoDoctor").on('input', clearMessageFields);
    $("#EmailDoctor").on('input', clearMessageFields);

    var all_docdeletes = document.querySelectorAll(".DocDelete");
    all_docdeletes.forEach((el) => {
        el.addEventListener("click", deleteDoctor);
    });

    var all_docedits = document.querySelectorAll(".DocEdit");
    all_docedits.forEach((el) => {
        el.addEventListener("click", editDoctor);
    });
});
