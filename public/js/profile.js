$(document).ready(function () {
    var buttons = document.querySelectorAll('button[id^="but"]');
    for (let i = 0; i < buttons.length; i++) {
        let date = buttons[i].id.substring(3);
        var appDate = Date.parse(date);
        if (appDate < Date.now()) {
            //buttons[i].remove();
            buttons[i].disabled = true;
            document.getElementById("a" + date).href = "";
            document
                .getElementById("a" + date)
                .addEventListener("click", function (e) {
                    e.preventDefault();
                });
        }
    }
});
