$(document).ready(function () {
    var emailVerifiedToast = document.getElementById("emailVerifiedToast");
    if (emailVerifiedToast) {
        var toastBootstrap =
            bootstrap.Toast.getOrCreateInstance(emailVerifiedToast);
        toastBootstrap.show();
    }
});
