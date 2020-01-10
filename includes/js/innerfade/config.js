$(document).ready(function(){
			$('ul#imagenes').innerfade({
			speed: 500,
			timeout: 6000,
			type: 'sequence',
			containerheight: 	'590px',
			slide_timer_on: 	'yes',
			slide_ui_parent: 	'imagenes',
			slide_ui_text:		'null',
			pause_button_id: 	'null',
			slide_nav_id:		'slide_nav'
			});
			$.setOptionsButtonEvent();
	
});


