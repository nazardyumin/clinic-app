$(document).ready(function () {
    function openPatient(e){
        var id = e.target.id.substring(e.target.id.indexOf("_") + 1);
        window.location =
        "/staff/" + id;
    }

    $("button[id*='btnPatient']").each(function () {
        $(this).click(openPatient);
    });
});
