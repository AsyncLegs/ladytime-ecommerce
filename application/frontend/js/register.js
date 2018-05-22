import {showNotififation} from "./notifications";
import {sleep} from "./helpers";

$(document).ready(function () {
    $('#auth').easyResponsiveTabs({
        type: 'default',
        width: 'auto',
        fit: true
    });
});

$('#form_login').validator().on('submit', function (e) {
    if (!e.isDefaultPrevented()) {
        let login_form = $('#form_login');
        let serializedForm = login_form.serialize();
        $.post(login_form.attr('action'), serializedForm)
            .done((data) => {
                let messageType = data.logged ? 'success' : 'error';
                showNotififation(data.message, messageType);
                if (data.logged) {
                    sleep(2000).then(() => {
                        location.href = data.url;
                    });
                }
            });
    }
});

$('#form_register').validator().on('submit', function (e) {
    if (e.isDefaultPrevented()) {
    } else {
        e.preventDefault();
        let form = $(e.target);
        let formSerialized = form.serialize();
        $.post($(form).attr('action'), formSerialized)
            .done((data) => {
                if (data.errors) {
                    $.each(data.errors, function (key, value) {
                        showNotififation(value, 'error');
                    });
                } else {
                    showNotififation(data.message);
                    if (data.logged) {
                        sleep(2000).then(() => {
                            location.href = data.url;
                        });
                    }
                }
            });
    }
});