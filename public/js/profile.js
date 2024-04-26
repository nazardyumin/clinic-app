$(document).ready(function () {
    var buttons = document.querySelectorAll('button[id^="but"]');
    for (let i = 0; i < buttons.length; i++) {
        let date = buttons[i].id.substring(3);
        var appDate = Date.parse(date);
        if (appDate < Date.now()) {
            buttons[i].disabled = true;
            buttons[i].textContent = "Запись просрочена";
            buttons[i].classList.replace("btn-danger", "btn-outline-secondary");
            document.getElementById("a" + date).href = "";
            document
                .getElementById("a" + date)
                .addEventListener("click", function (e) {
                    e.preventDefault();
                });
        }
    }

    var emailVerifiedToast = document.getElementById("emailVerifiedToast");
    if(emailVerifiedToast){
        var toastBootstrap =
        bootstrap.Toast.getOrCreateInstance(emailVerifiedToast);
        toastBootstrap.show();
    }
});
