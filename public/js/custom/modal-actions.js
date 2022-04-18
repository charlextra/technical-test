function renderSuccessMessage(form, message) {
    $(form).find('.alert').remove();

    const alertSuccessHtml = getAlertHtmlTemplate(message, 'success');
    $(alertSuccessHtml).insertBefore($(form).find('.modal-body .form-group').first());
    $('.alert').alert();
}

function renderValidationErrors(form, message, errors) {
    $(form).find('.alert').remove();

    const alertSuccessHtml = getAlertHtmlTemplate(message, 'danger');
    $(alertSuccessHtml).insertBefore($(form).find('.modal-body .form-group').first());
    $('.alert').alert();

    if (Object.values(errors).length) {
        const errorsElement = $('<ul class="mb-0"></ul>');
        Object.values(errors).forEach(function (error) {
            const entityErrorsElement = $('<li></li>').text(error);
            errorsElement.append(entityErrorsElement);
        });
        errorsElement.insertAfter($(form).find('.alert strong').first());
    }
}

function getAlertHtmlTemplate(message, alertStatusClass)
{
    return '<div class="alert alert-'+ alertStatusClass +'" role="alert">'
                +'<button type="button" data-dismiss="alert" class="close" aria-label="Close">'
                    +'<span aria-hidden="true">&times;</span>'
                +'</button>'
                +'<strong>'+message+'</strong>'
            +'</div>'
        ;
}

function ajaxFormListenerHandler(event) {
    NProgress.start();
    event.preventDefault();
    const formData = new FormData(this);
    const form = this;

    $.ajax({
        type: $(this).attr('method'),
        url: $(this).attr('action'),
        data: formData,
        dataType: "json",
        contentType: false,
        processData: false,
        success: function(response) {
            renderSuccessMessage(form, response.message);
            NProgress.done();
        },
        error: function (response) {
            const responseJSON = response.responseJSON;
            renderValidationErrors(form, responseJSON.message, responseJSON.errors);
            NProgress.done();
        }
    });
}

$(function () {
    $('.delegate-ajax-submit').on('submit', 'form', ajaxFormListenerHandler);
    $('.ajax-submit').submit(ajaxFormListenerHandler);
});
