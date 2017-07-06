var modal = $('#modal');
function handleJson(data) {
    if (data.success) {
        modal.find('.modal-content').html(data.html);
    } else {
        modal.find('.modal-content').html(data.error);
    }
    // if (data.update) {
    //     updateContact(data.update);
    // }
}
function handleError(data) {
    modal.find('.modal-content').html('UNAUTHORISED ACTION!');
}
function counterTick(event) {
    var button = $(event.target);
    switch (event.which) {
        default:
        case 1:
            button.load(button.data('link'));
            break;
        case 3:
            button.load(button.data('undolink'));
            break;
    }
}
$(function () {
    $('body').on('click', '.counter-tick', counterTick);
    modal.on('show.bs.modal', function (event) {
        var link = $(event.relatedTarget);
        $.get(link.data('link'), handleJson).fail(handleError);
    }).on('hidden.bs.modal', function () {
        modal.find('.modal-content').html('');
    }).on('click', '.modal-link', function(event){
        event.preventDefault();
        var link = $(event.target);
        $.get(link.attr('href'), handleJson).fail(handleError);
    }).on('submit', 'form', function (event) {
        var form  = $(this);
        if (form.data('result') == 'redirect') {
            return true;
        }
        event.preventDefault();
        $.post(form.attr('action'), form.serialize(), handleJson).fail(handleError);
    }).on('click', '.toggle-input', function (event) {
        event.preventDefault();
        var input = $(this).find('input');
        input.attr('checked', !input.attr('checked'));
        modal.find('.toggle-input').each(function (i, el) {
            $el = $(el);
            if ($el.find('input').attr('checked')) {
                $el.removeClass('fa-square-o').addClass('fa-check-square-o').css('color', 'green');
            } else {
                $el.removeClass('fa-check-square-o').addClass('fa-square-o').css('color', '');
            }
        });
    });
});