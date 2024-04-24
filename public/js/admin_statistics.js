$(document).ready(function () {
    google.charts.load("current", { packages: ["corechart", "bar"] });

    function drawBasic(expected, fact) {
        var data = new google.visualization.DataTable();
        data.addColumn("string", "месяц");
        data.addColumn("number", "часы по записи");
        data.addColumn("number", "отработано часов");
        data.addRows([
            ["январь", expected[1], fact[1]],
            ["февраль", expected[2], fact[2]],
            ["март", expected[3], fact[3]],
            ["апрель", expected[4], fact[4]],
            ["май", expected[5], fact[5]],
            ["июнь", expected[6], fact[6]],
            ["июль", expected[7], fact[7]],
            ["август", expected[8], fact[8]],
            ["сентябрь", expected[9], fact[9]],
            ["октябрь", expected[10], fact[10]],
            ["ноябрь", expected[11], fact[11]],
            ["декабрь", expected[12], fact[12]],
        ]);

        var options = {
            title: "Статистика планируемого и фактического отработанного времени",
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
                google.charts.setOnLoadCallback(drawBasic(data.expected_time, data.fact_time));
            },
        });
    });
});
