$(document).ready(function () {
    // Опции для toastr plugin
    toastr.options = {
        closeButton: true,
        positionClass: 'toast-bottom-right',

    };
    // Если переменная определена то выводить сообщение
    if (typeof successToastr !== "undefined") {
        toastr.success(successToastr);
    } else if (typeof errorToastr !== "undefined") {
        toastr.error(errorToastr);
    }
});

function ajaxDelete(filename, token, studioID) {
    let table = $('#theTable');
    let trID = 'trID_' + studioID;
    $.ajax({
        type: 'POST',
        data: {_method: 'DELETE', _token: token},
        url: filename,
        success: function (data) {
            $('#modalDelete').modal('hide');
            if (data.error) {
                toastr.error(data.error);
            } else {
                toastr.success(data.success);
                table.find('#' + trID).fadeOut('slow');
            }
        },
        error: function (xhr, status, error) {
            alert(xhr.responseText);
        }
    });
}

function ajaxDeleteEvent(filename, token, eventID) {
    let table = $('#theTable');
    let trID = 'trID_' + eventID;
    $.ajax({
        type: 'POST',
        data: {_method: 'DELETE', _token: token},
        url: filename,
        success: function (data) {
            $('#modalDelete').modal('hide');
            if (data.error) {
                toastr.error(data.error);
            } else {
                toastr.success(data.message);
                table.find('#' + trID).fadeOut('slow');
            }
        },
        error: function (xhr, status, error) {
            alert(xhr.responseText);
        }
    });
}

$('#modalDelete').on('show.bs.modal', function (event) {
    let button = $(event.relatedTarget);
    $('#delete_id').val(button.data('id'));
    $('#delete_token').val(button.data('token'));
});