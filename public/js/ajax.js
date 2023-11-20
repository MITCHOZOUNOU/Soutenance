$(document).ready(function() {

    var $submitButton = $('#submitButton');
    var $loader = $submitButton.find('.loader');

    $('#add_ouv').submit(function(event) {
        event.preventDefault();

        var formData = $("#add_ouv").serialize();

        $submitButton.attr('disabled', true);
        $loader.show();

        $.ajax({
            url: 'ouvrages/traitement_ajouter_ouvrage',
            method: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('.container').prepend('<div class="alert alert-success mt-3">' + response.message + '</div>');
                    setTimeout(function() {
                        window.location.href = response.redirectUrl;
                    }, 500);
                } else {
                    $('.container').prepend('<div class="alert alert-danger mt-3">' + response.message + '</div>');
                }

                $submitButton.attr('disabled', false);
                $loader.hide();
            },
            error: function(xhr, status, error) {
                console.log('Erreur lors de la requête AJAX : ' + error);

                $submitButton.attr('disabled', false);
                $loader.hide();
            }
        });
    });   

});