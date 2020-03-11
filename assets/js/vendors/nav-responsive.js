/* *********************
*
*   Responsive Bars
* 
********************* */

/* FILTROS-------------------------- */

$("#mobile-nav-filter").hide();

$(function () {
	
	$(window).scroll(function () {
		
		if ($(this).scrollTop() > 150) {
			$('#mobile-nav-filter').fadeIn();
		}  
			
		else {
			$('#mobile-nav-filter').fadeOut();
		}
	});

});


/* RECURSOS TURISTICOS ------------------------- */

$("#nav-rrtt").hide();

$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 450) {
				$('#nav-rrtt').fadeIn();
			}  
			
			else {
				$('#nav-rrtt').fadeOut();
			}
		});

});



/* POR RANGO -------------------------- */

$("#nav_alt").hide();


$(function() {

    $(document).on('scroll', function() {
        var top = $(document).scrollTop();

        if (top > 100 && top < 3000) {
            $('#nav_alt').fadeIn();
        } else {
            $('#nav_alt').fadeOut();
        }
    });

});
