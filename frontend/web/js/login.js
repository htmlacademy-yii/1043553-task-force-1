$(document).ready(function () {
    let form = $("#loginForm");
    let errorMessage = $('#errorMessage');
    let alertMessage = 'Ошибка, попробуйте позже';
    let redirectAfterLogin = "/tasks";

    $(document).on("click", "#loginSubmit", function () {
        $.ajax({
            type: 'POST',
            url: 'landing',
            data: form.serializeArray(),
        })
        //Если запрос отправлен
            .done(function (data) {
                if (data.loginResult) {
                    window.location.replace(redirectAfterLogin);
                }
                showErrorMessage(errorMessage, data.error);
            })
            //Если запрос не ушел
            .fail(function () {
                alert(alertMessage);
            });
    });
});

function showErrorMessage(element,message)
{
    element.css("display", "block");
    element.text(message);
}