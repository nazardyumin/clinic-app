$(document).ready(function () {
    function imgClick(e) {
        e.preventDefault();
        var id = e.target.id;
        var rate = parseInt(id.substring(id.length - 1));
        for (var i = 1; i <= 5; i++) {
            var src = $("#star" + i).attr("src");
            if (i <= rate) {
                src = src.replace("(", ")");
            } else {
                src = src.replace(")", "(");
            }
            $("#star" + i).attr("src", src);
        }
        $("#starRate").val(rate);
    }

    $("img[id^='star']").each(function () {
        $(this).click(imgClick);
    });
});
