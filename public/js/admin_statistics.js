$(document).ready(function () {
    google.charts.load("current", { packages: ["corechart", "bar"] });

    function drawBasic(items) {
        var data = new google.visualization.DataTable();
        data.addColumn("string", "месяц");
        data.addColumn("number", "отработано часов");
        data.addRows([
            ["январь", items[1]],
            ["февраль", items[2]],
            ["март", items[3]],
            ["апрель", items[4]],
            ["май", items[5]],
            ["июнь", items[6]],
            ["июль", items[7]],
            ["август", items[8]],
            ["сентябрь", items[9]],
            ["октябрь", items[10]],
            ["ноябрь", items[11]],
            ["декабрь", items[12]],
        ]);

        var options = {
            title: "Таблица отработанного времени (с пациентами)",
            hAxis: {},
            vAxis: {},
        };

        var chart = new google.visualization.ColumnChart(
            document.getElementById("chart")
        );

        chart.draw(data, options);
    }

    $("select#doctor").change(function () {
        if ($(this).val() == 0) {
            $("button#ShowStatBtn").attr("disabled", true);
        } else {
            $("button#ShowStatBtn").attr("disabled", false);
        }
    });

    $("button#ShowStatBtn").click(function () {
        $("div#chart").empty();

        let ajaxurl =
            "/admin/show_stat/" +
            $("select#doctor").val() +
            "_" +
            $("select#year").val();

        $.ajax({
            type: "GET",
            url: ajaxurl,
            success: function (data) {
                google.charts.setOnLoadCallback(drawBasic(data.work_time));
            },
        });
    });
});
