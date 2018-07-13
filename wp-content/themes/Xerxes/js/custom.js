jQuery(document).ready(function() {


/* Back to top */

	
	// Animate the scroll to top
	jQuery('.go-top').click(function(event) {
		event.preventDefault();
		
		jQuery('html, body').animate({scrollTop: 0}, 300);
	})
	
  jQuery('#slide').flexslider({
        animation: "fade",
        directionNav:true,
        controlNav:false,
        prevText:"",
        nextText:""
      });	
	
});