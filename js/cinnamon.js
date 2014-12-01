jQuery(document).ready(function($) { 
	/**
	* Detect touch device
	*/
	if( is_touch_device() == false ){
		$('body').addClass( 'not-touch-device' );
	}

	/**
	* Hover state for menu
	*/
	$('#site-navigation .menu-item-has-children').hover(
		function(){
			$(this).addClass( 'hovered' );
		},
		function(){
			$(this).removeClass( 'hovered' );
		}
	);
});

/**
* Detect touch device
*/
function is_touch_device() {
	return 'ontouchstart' in window // works on most browsers 
		|| 'onmsgesturechange' in window; // works on ie10
};