;(function($) {
    $( document ).ready(function() {    
        $('[href="#mobile-preview"]').on('click', function(){
            $('.mobile-preview-window').toggle();
            $('body').toggleClass('in-mobile-preview');
            document.documentElement.style.overflow = 'hidden';
            return false;
        });

     }); // end document ready

})(jQuery);
