
$(document).ready(function(){
    $(".favorite-button").click(function() {
        var self = $(this);
        var id = $(this).data('id');
        var isFavorite = !$(this).hasClass('favorite');
        $.ajax({
            url: '/api/fruits/' + id + '/favorite',
            type: 'PUT',
            data: { favorite: !isFavorite },
            success: function(response) {
                if (response.success) {
                    // Update the button's favorite status

                    if (isFavorite) {
                        self.addClass('favorite');
                    } else {
                        self.removeClass('favorite');
                    }
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Failed to update favorite status');
            }
        });
    });
});
