;(function($) {
    $( document ).ready(function() {    

        var hidePreview = function() {
            $('.mobile-preview-window').hide();
            $('body').removeClass('in-mobile-preview');
        };

        // Show preview when link is clicked
        $('[href="#mobile-preview"]').on('click', function(){
            $('.mobile-preview-window').toggle();
            $('body').toggleClass('in-mobile-preview');
            document.documentElement.style.overflow = 'hidden';
            return false;
        });

        // Hide preview on keyup
        $(document).keyup(hidePreview);

        // Hide preview when you click on the overlay
        $('.mobile-preview-window').on('click', hidePreview);

     }); // end document ready

})(jQuery);
