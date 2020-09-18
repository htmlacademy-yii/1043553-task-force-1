$(document).ready(function () {
    let form = $("#taskResponseForm");
    let errorMessagePrice = $('#errorMessagePrice');
    let errorMessageComment = $('#errorMessageComment');
    let alertMessage = 'Ошибка, попробуйте позже';
    let redirectAfterResponseCreation = window.location.href;
    let taskId = window.location.href.substring(window.location.href.lastIndexOf('/') + 1);

    $(document).on("click", "#taskResponseFormSubmit", function () {
        $.ajax({
            type: 'POST',
            url: "/task-action/respond?taskId=" + taskId,
            data: form.serializeArray(),
        })
        //Если запрос отправлен
            .done(function (data) {
                if (data.result) {
                    window.location.replace(redirectAfterResponseCreation);
                } else {
                    showErrorMessage(errorMessagePrice, data.errors.price);
                    showErrorMessage(errorMessageComment, data.errors.comment);
                }
            })
            //Если запрос не ушел
            .fail(function () {
                alert(alertMessage);
            });
    });
});

function showErrorMessage(element, message) {
    element.css("display", "block");
    element.text(message);
}