;(function($) {
    $( document ).ready(function() {    
        $('[href="#mobile-preview"]').on('click', function(){
            $('.mobile-preview-window').toggle();
            $('body').toggleClass('in-mobile-preview');
            document.documentElement.style.overflow = 'hidden';
            return false;
        });

        $(document).keyup(function(e) {
            $('.mobile-preview-window').hide();
            $('body').removeClass('in-mobile-preview');
        });

     }); // end document ready

})(jQuery);
