$(document).ready(function () {
    function getDoctors(e) {
        $("#DoctorsTimeTable").empty();
        $("#SubmitHelp").text("");
        $("#TableHelp").text("");
        $("#DoctorSelectionHelp").removeClass("text-danger");
        $("#appointmentId").val("");
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        e.preventDefault();
        var id = $("#SpecialitySelection").val();
        if (parseInt(id) > 0) {
            $("#SpecialitySelectionHelp").text("");
            var type = "GET";
            var ajaxurl = "get_doctors/" + id;
            $.ajax({
                type: type,
                url: ajaxurl,
                success: function (data) {
                    $("#DoctorSelection").empty();
                    $("#DoctorSelection").append(
                        $("<option>", {
                            value: 0,
                            text: "-- Не выбран --",
                        })
                    );
                    data.forEach((doc) => {
                        $("#DoctorSelection").append(
                            $("<option>", {
                                value: doc.id,
                                text: doc.name,
                            })
                        );
                    });
                },
                error: function (data) {
                    console.log(data);
                },
            });
        } else {
            $("#SpecialitySelectionHelp").text("Специалист не выбран");
            $("#DoctorSelection").empty();
        }
    }

    function getAppointments(e) {
        $("#DoctorsTimeTable").empty();
        $("#SubmitHelp").text("");
        $("#TableHelp").text("");
        $("#appointmentId").val("");
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        e.preventDefault();
        var id = $("#DoctorSelection").val();
        if (parseInt(id) > 0) {
            $("#DoctorSelectionHelp").removeClass("text-danger");
            var type = "GET";
            var ajaxurl = "get_appointments/" + id;
            $.ajax({
                type: type,
                url: ajaxurl,
                success: function (data) {
                    $("#doctor_id").val(id);
                    if (Object.keys(data.appointments).length > 0) {
                        $("#DoctorsTimeTable").append(
                            $("<thead>", {
                                id: "thead",
                                class: "sticky-md-top",
                            })
                        );
                        $("#thead").css("background-color", "white");
                        $("#thead").append(
                            $("<tr>", {
                                id: "trh",
                            })
                        );

                        Object.keys(data.appointments).forEach((item) => {
                            $("#trh").append(
                                $("<td>", {}).html(
                                    item.substring(item.indexOf("|") + 1)
                                )
                            );
                        });

                        $("#DoctorsTimeTable").append(
                            $("<tbody>", {
                                id: "tbody",
                            })
                        );
                        for (let i = 0; i < data.count; i++) {
                            $("#tbody").append(
                                $("<tr>", {
                                    id: "tr" + i,
                                })
                            );
                            Object.keys(data.appointments).forEach((key) => {
                                if (data.appointments[key][i]) {
                                    let button = $("<button>", {
                                        id: data.appointments[key][i].id,
                                        class: data.appointments[key][i].user_id
                                            ? "btn btn-danger"
                                            : "btn btn-light availableTd",
                                        disabled: data.appointments[key][i]
                                            .user_id
                                            ? true
                                            : false,
                                    })
                                        .text(data.appointments[key][i].time)
                                        .click(tdIsChecked);

                                    let td = $("<td>", {});

                                    td.append(button);

                                    $("#tr" + i).append(td);
                                } else {
                                    $("#tr" + i).append($("<td>", {}));
                                }
                            });
                        }
                    } else {
                        $("#TableHelp").text("Расписание не заполнено");
                    }
                },
                error: function (data) {
                    console.log(data);
                },
            });
        } else {
            $("#doctor_id").val("");
            $("#DoctorSelectionHelp").attr("class", "text-danger");
        }
    }

    function tdIsChecked(e) {
        e.preventDefault();
        var id = $(".btn-info").attr("id");
        $("#" + id).removeClass("btn btn-info");
        $("#" + id).attr("class", "btn btn-light");
        $("#" + e.target.id).removeClass("btn-light");
        $("#" + e.target.id).attr("class", "btn btn-info");
        $("#appointmentId").val($("#" + e.target.id).attr("id"));
        $("#SubmitHelp").text("");
    }

    var all_tds = document.querySelectorAll(".availableTd");
    all_tds.forEach((el) => {
        el.addEventListener("click", tdIsChecked);
    });

    $("#SpecialitySelection").change(getDoctors);
    $("#DoctorSelection").change(getAppointments);
});
