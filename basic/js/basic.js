/*
 * Modal Dialog
 */
jQuery(document).ready(function($) 
{  
	// Load dialog on click
	$('.popup a').each(function (e1) 
	{
		$(this).click(function(e) {
			e.preventDefault();
			var id=$(this).attr('id');
			$(this).parent().next().modal();
		});
	});

	$('.avoid-clicks').click(function(e) {
		e.preventDefault();
	});

	$("#owl-demo").owlCarousel({
		loop:true,
        margin:10,
        nav:true,
		autoPlay: 3000000,
		pagination:false,
		items : 3,
		itemsDesktop : [1199,3],
		itemsDesktopSmall : [979,3],
		temsTablet : [768, 2],
		itemsMobile : [680, 1],
		navigation: true,
		navigationText: [
		"<i class='icon-chevron-left icon-white'></i>",
		"<i class='icon-chevron-right icon-white'></i>"
		]
	});
});