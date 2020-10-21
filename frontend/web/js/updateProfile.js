$(document).ready(function () {
    let form = $("#profileForm");
    let alertMessage = 'Ошибка, попробуйте позже';

    $(document).on("click", "#formSubmit", function () {
        $.ajax({
            type: 'POST',
            url: 'profile/update',
            data: form.serializeArray(),
        })
        //Если запрос отправлен
            .done(function (data) {
                removeErrorMessages();
                if (data.updateResult) {
                    form.submit();
                } else {
                    showErrorMessages(data.error);
                }
            })
            //Если запрос не ушел
            .fail(function () {
                alert(alertMessage);
            });
    });
});

function showErrorMessages(errors)
{
    let keys = Object.keys(errors);

    keys.forEach(showError);

    function showError(item)
    {
        $('#' + item + 'ErrorMessage').css("display", "block");
        $('#' + item + 'ErrorMessage').text(errors[item]);
    }

    element.css("display", "block");
    element.text(message);
}

function removeErrorMessages()
{
    $('#nameErrorMessage').css("display", "none");
    $('#emailErrorMessage').css("display", "none");
    $('#descriptionErrorMessage').css("display", "none");
    $('#phoneErrorMessage').css("display", "none");
    $('#skypeErrorMessage').css("display", "none");
    $('#otherAppErrorMessage').css("display", "none");
    $('#avatarErrorMessage').css("display", "none");

}