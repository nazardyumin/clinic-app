$(document).ready(function () {
    function checkTimetableAdded() {
        $("#TimetableErrorFromAjaxHelp").text("");
        $("#TimetableSuccessHelp").text("");
        $("#TimetableErrorHelp").text("");
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        var id = $("#ChooseDoctor").val();
        if (parseInt(id) != 0) {
            var ajaxurl =
                "/admin/timetable/" +
                id +
                "-" +
                $("#yearSelect").val() +
                "-" +
                $("#monthSelect").val();

            $.ajax({
                type: "GET",
                url: ajaxurl,
                success: function (data) {
                    data.recordExists
                        ? $("#btnTimetableSubmit").attr("disabled", true)
                        : $("#btnTimetableSubmit").attr("disabled", false);
                    data.recordExists
                        ? $("#TimetableErrorFromAjaxHelp").text(
                                "Расписание для этого врача на этот месяц уже было добавлено"
                            )
                        : $("#TimetableErrorFromAjaxHelp").text("");
                },
            });
        } else {
            $("#TimetableErrorFromAjaxHelp").text("Врач не выбран");
        }
    }

    function changeMinutesToVal(e) {
        var id = e.target.id.substring(e.target.id.indexOf("_") + 1);
        if ($("#hoursTo_" + id).val() == "20") {
            $("#minutesTo_" + id).val("00");
        }
    }

    $("select[id*='minutesTo']").each(function () {
        $(this).change(changeMinutesToVal);
    });

    $("select[id*='hoursTo']").each(function () {
        $(this).change(changeMinutesToVal);
    });

    $("#ChooseDoctor").change(checkTimetableAdded);

    $("#newDocCheckbox").change(function () {
        $("#TimetableErrorFromAjaxHelp").text("");
        $("#TimetableSuccessHelp").text("");
        $("#TimetableErrorHelp").text("");

        let year = $("#yearSelect").val();
        let month = $("#monthSelect").val();
        let doc_id = parseInt($("#ChooseDoctor").val());

        if (this.checked && doc_id == 0) {
            $("#TimetableErrorFromAjaxHelp").text("Врач не выбран");
            this.checked = false;
        } else if (this.checked && doc_id > 0) {
            window.location =
                "/admin/newdoc/" + doc_id + "-" + year + "-" + month + "-1";
        } else if (!this.checked && doc_id == 0) {
            $("#TimetableErrorFromAjaxHelp").text("Врач не выбран");
        } else {
            window.location =
                "/admin/newdoc/" + doc_id + "-" + year + "-" + month + "-0";
        }
    });
});
