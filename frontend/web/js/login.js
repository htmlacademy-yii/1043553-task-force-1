$(document).ready(function () {
    let error = false;
    let form = $("#loginForm");

    $(document).on("click", "#loginSubmit", function () {
        $.ajax({
            type: 'POST',
            url: 'landing',
            data: form.serializeArray(),
        })
        //Если запрос отправлен
            .done(function (data) {
                if (data == true) {
                    window.location.replace("/tasks");
                }
                showErrorMessage();
            })
            //Если запрос не ушел
            .fail(function () {

                alert('Ошибка, попробуйте позже');
            });


        return false; // Отменить синхронную отправку данных
    });


});

function showErrorMessage()
{
    $('#errorMessage').css("display", "block");
}