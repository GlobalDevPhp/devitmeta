(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
    $( window ).load(function() {
        var error1 = true;
        var error2 = true;
        var error3 = true;
        var error4 = true;
        $('input#js-phone').unbind().blur( function(){
            var id = $(this).attr('id');
            var val = $(this).val();
            switch(id)
            {
                case 'js-phone':
                    var rv_phone = /^([+]38)?((3[\d]{2})([ ,\-,\/]){0,1}([\d, ]{6,9}))|(((0[\d]{1,4}))([ ,\-,\/]){0,1}([\d, ]{5,10}))$/;
                    if(rv_phone.test(val) || val == '')
                    {
                        $(this).addClass('not_error');
                        $(this).next('.error-box').hide();
                        error4 = false;
                    }
                    else
                    {
                        console.log(val);
                        $(this).removeClass('not_error').addClass('error');
                        $(this).next('.error-box').show();
                        error4 = true;
                    }
                    break;
            } // end switch(...)

        }); // end blur()
    });
})( jQuery );

function hidefam(){
    var e = document.getElementById("gensel");
    var genval = e.options[e.selectedIndex].value;
    if (genval == 2){
        document.getElementById("fa1").style.display = 'none';
        document.getElementById("fa2").style.display = 'none';
        document.getElementById("fa3").style.display = 'none';
        document.getElementById("fa4").style.display = 'none';

        document.getElementById("fa5").style.display = 'block';
        document.getElementById("fa6").style.display = 'block';
        document.getElementById("fa7").style.display = 'block';
        document.getElementById("family").value = "0";
    }
    else if (genval == 3) {
        document.getElementById("fa1").style.display = 'block';
        document.getElementById("fa2").style.display = 'block';
        document.getElementById("fa3").style.display = 'block';
        document.getElementById("fa4").style.display = 'block';

        document.getElementById("fa5").style.display = 'none';
        document.getElementById("fa6").style.display = 'none';
        document.getElementById("fa7").style.display = 'none';
        document.getElementById("family").value = "0";
    }
    else {
        document.getElementById("fa1").style.display = 'none';
        document.getElementById("fa2").style.display = 'none';
        document.getElementById("fa3").style.display = 'none';
        document.getElementById("fa4").style.display = 'none';
        document.getElementById("fa5").style.display = 'none';
        document.getElementById("fa6").style.display = 'none';
        document.getElementById("fa7").style.display = 'none';
    }

}

