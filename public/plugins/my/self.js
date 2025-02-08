/*
* My functions for admin panel
*/

function preloader() {
    $(".loader-in").fadeOut();
    $(".loader").delay(150).fadeOut("fast");
    $(".wrapper").fadeIn("fast");
    $("#app").fadeIn("fast");
}

//Initialize Select2 Elements
$('.select2').select2({
    theme: 'bootstrap4'
});

//Initialize Select2 Elements
$('.select2bs4').select2({
    theme: 'bootstrap4'
});

//select all
$("#checkAll").click(function () {
    $('input:checkbox').not(this).prop('checked', this.checked);

});

$('.duallistbox').bootstrapDualListbox({
    nonSelectedListLabel: 'Не разрешено',
    selectedListLabel: 'Разрешено',
});


<<<<<<< HEAD


=======
>>>>>>> 6bda4a5 (Initial commit)
function alertMessage(message = '', type = 'default') {

    let messageDiv =
        '<div class="alert alert-default-' + type + ' alert-dismissible fade show" role="alert">\n' +
        message + '\n' +
        '  <button type="button" class="close" data-dismiss="alert" aria-label="Close">\n' +
        '    <span aria-hidden="true">&times;</span>\n' +
        '  </button>\n' +
        '</div>';

    return messageDiv;
}

$('form').submit(function () {
    let button = $(this).find("button[type=submit]:focus");
    button.prop('disabled', true);
    button.html('<i class="spinner-border spinner-border-sm text-light"></i> ' + $(button).text() + '...');
});

$('.submitButton').click(function () {

    if (confirm('Confirm action')) {
        $(this).prop('disabled', true);
        $(this).html('<i class="spinner-border spinner-border-sm text-light"></i> ' + $($(this)).text() + '...');
        $(this).parents('form:first').submit();
    }

});

function SpinnerGo(obj) {
    $(obj).prop('disabled', true);
    $(obj).html('<i class="spinner-border spinner-border-sm text-light"></i> ' + $($(obj)).text());
}

function SpinnerStop(obj) {
    $(obj).prop('disabled', false);
    $(obj).html($($(obj)).text());
}

function afterSubmit(obj) {
    $(obj).prop('disabled', true);
    $(obj).html('<i class="spinner-border spinner-border-sm text-light"></i> ' + $($(obj)).text());
    obj.form.submit();
}

function toggle_avtospisaniya(client_id, token, obj) {

    $.ajax({
        url: '/clients/auto-toggle',
        type: "post", //send it through post method
        data: {
            _token: token,
            client_id: client_id
        },
        beforeSend: function () {
            // $(obj).removeAttr('class');
            $(obj).attr('class', 'spinner-border spinner-border-sm text-secondary');
        },
        success: function (result) {

            if (result.auto === true) {
                $(obj).attr('class', 'fas fa-check-circle text-success');
            } else if (result.auto === false) {
                $(obj).attr('class', 'fas fa-times-circle text-danger');
            } else {
                $(obj).attr('class', 'fas fa-question-circle text-warning');
            }
        },
        error: function (err) {
            $(obj).attr('class', 'fas fa-question-circle text-warning');
        }
    })
}

$(function () {
    var Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
    });

    $('.swalDefaultSuccess').click(function () {
        Toast.fire({
            icon: 'success',
            title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
    });
    $('.swalDefaultInfo').click(function () {
        Toast.fire({
            icon: 'info',
            title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
    });
    $('.swalDefaultError').click(function () {
        Toast.fire({
            icon: 'error',
            title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
    });
    $('.swalDefaultWarning').click(function () {
        Toast.fire({
            icon: 'warning',
            title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
    });
    $('.swalDefaultQuestion').click(function () {
        Toast.fire({
            icon: 'question',
            title: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
    });

    $('.toastrDefaultSuccess').click(function () {
        toastr.success('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $('.toastrDefaultInfo').click(function () {
        toastr.info('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $('.toastrDefaultError').click(function () {
        toastr.error('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });
    $('.toastrDefaultWarning').click(function () {
        toastr.warning('Lorem ipsum dolor sit amet, consetetur sadipscing elitr.')
    });

    $('.toastsDefaultDefault').click(function () {
        $(document).Toasts('create', {
            title: 'Toast Title',
            body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
    });
    $('.toastsDefaultTopLeft').click(function () {
        $(document).Toasts('create', {
            title: 'Toast Title',
            position: 'topLeft',
            body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
    });
    $('.toastsDefaultBottomRight').click(function () {
        $(document).Toasts('create', {
            title: 'Toast Title',
            position: 'bottomRight',
            body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
    });
    $('.toastsDefaultBottomLeft').click(function () {
        $(document).Toasts('create', {
            title: 'Toast Title',
            position: 'bottomLeft',
            body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
    });
    $('.toastsDefaultAutohide').click(function () {
        $(document).Toasts('create', {
            title: 'Toast Title',
            autohide: true,
            delay: 750,
            body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
    });
    $('.toastsDefaultNotFixed').click(function () {
        $(document).Toasts('create', {
            title: 'Toast Title',
            fixed: false,
            body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
    });
    $('.toastsDefaultFull').click(function () {
        $(document).Toasts('create', {
            body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
            title: 'Toast Title',
            subtitle: 'Subtitle',
            icon: 'fas fa-envelope fa-lg',
        })
    });
    $('.toastsDefaultFullImage').click(function () {
        $(document).Toasts('create', {
            body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.',
            title: 'Toast Title',
            subtitle: 'Subtitle',
            image: '../../dist/img/user3-128x128.jpg',
            imageAlt: 'User Picture',
        })
    });
    $('.toastsDefaultSuccess').click(function () {
        $(document).Toasts('create', {
            class: 'bg-success',
            title: 'Toast Title',
            subtitle: 'Subtitle',
            body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
    });
    $('.toastsDefaultInfo').click(function () {
        $(document).Toasts('create', {
            class: 'bg-info',
            title: 'Toast Title',
            subtitle: 'Subtitle',
            body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
    });
    $('.toastsDefaultWarning').click(function () {
        $(document).Toasts('create', {
            class: 'bg-warning',
            title: 'Toast Title',
            subtitle: 'Subtitle',
            body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
    });
    $('.toastsDefaultDanger').click(function () {
        $(document).Toasts('create', {
            class: 'bg-danger',
            title: 'Toast Title',
            subtitle: 'Subtitle',
            body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
    });
    $('.toastsDefaultMaroon').click(function () {
        $(document).Toasts('create', {
            class: 'bg-maroon',
            title: 'Toast Title',
            subtitle: 'Subtitle',
            body: 'Lorem ipsum dolor sit amet, consetetur sadipscing elitr.'
        })
    });
});


<<<<<<< HEAD

=======
>>>>>>> 6bda4a5 (Initial commit)
$(document).on('click', '.toggle-password', function () {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var input = $($(this).attr("toggle"));
    if (input.attr("type") == "password") {
        input.attr("type", "text");
    } else {
        input.attr("type", "password");
    }
});


<<<<<<< HEAD

=======
>>>>>>> 6bda4a5 (Initial commit)
$('#password-field, #password-confirm').on('keyup', function () {
    if ($('#password-field').val() === $('#password-confirm').val()) {
        $('#message').html('Tasdiqlandi').css('color', 'green');
    } else {
        $('#message').html('Parol mos kelmadi').css('color', 'red');
    }
});

$(document).on('click', '.toggle-editor', function () {
    $(this).toggleClass("fa-eye fa-eye-slash");
    var editor = $('#myeditor');
    if (editor.css('display') === 'none') {
        editor.css('display', 'block');
    } else {
        editor.css('display', 'none');
    }
});
