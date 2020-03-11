/* ***********************************
* 
*        SHOW/HIDE MENU RESPONSIVE
*
*********************************** */


function hideshow(which){
	if (!document.getElementById)
	return
	if (which.style.display=="block")
	which.style.display="none"
	else
	which.style.display="block"
}

function toggle2(id,objclick) {
	var state = document.getElementById(id).style.display;
	var texto = objclick.innerHTML;
	//texto = texto.substr(0,texto.length-1);
	
	if (state == 'block') {
		document.getElementById(id).style.display = 'none';
		texto = texto.replace("-","+")
		objclick.innerHTML = texto;
		} else {
			document.getElementById(id).style.display = 'block';
			texto = texto.replace("+","-")
			objclick.innerHTML = texto;
		}
	return false;
};



/** Tabs */

$(document).ready(function() {
	
	jQuery('.tabs .tab-links a').on('click', function(e)  {
		var currentAttrValue = jQuery(this).attr('href');
		
		// Show/Hide Tabs
		
		jQuery('.tabs ' + currentAttrValue).show().siblings().hide();
		// Change/remove current tab to active
		jQuery(this).parent('li').addClass('active').siblings().removeClass('active');
		e.preventDefault();
	});
				
});

//// MUESTRA O NO EL CONTENIDO OCULTO
	
$(document).ready(function() {
	$(document).find('.btn-expand-extra-content').click(function(){
		$(this).next().slideToggle('fast');
	});
});

/* ***********************************
* 
*        Init owl.carousel
*
*********************************** */

// Carousel de related content (casas relacionadas)

$(document).ready(function() {
	
	$(".owl-related").owlCarousel({
		items : 3, //10 items above 1000px browser width
		itemsDesktop : [1120,3], //5 items between 1000px and 901px
		itemsDesktopSmall : [900,2], // betweem 900px and 601px
		itemsTablet: [800,2], //2 items between 600 and 0
		itemsMobile : [550,1],// itemsMobile disabled - inherit from itemsTablet option
	});
	
	// Carousel de  lugares HOME
	
	$(".owl-places").owlCarousel({
		items : 4, //10 items above 1000px browser width
		itemsDesktop : [1120,4], //5 items between 1000px and 901px
		itemsDesktopSmall : [900,3], // betweem 900px and 601px
		itemsTablet: [700,2], //2 items between 600 and 0
		itemsMobile : [479,1],// itemsMobile disabled - inherit from itemsTablet option
	});
	
	// Carousel de  lugares RElacionados (páginas interiores)
	
	$(".owl-related-places").owlCarousel({
		items : 3, //10 items above 1000px browser width
		itemsDesktop : [1120,3], //5 items between 1000px and 901px
		itemsDesktopSmall : [900,3], // betweem 900px and 601px
		itemsTablet: [700,2], //2 items between 600 and 0
		itemsMobile : [479,1],// itemsMobile disabled - inherit from itemsTablet option
		
	});
	
	$(".photos-carousel").owlCarousel({
		navigation : true,
		singleItem:true,
		rewindNav: true,
		navigationText : false,

	});

});



/* ***********************************
*        Init SELECTED2 (SELECT CON BUSCADOR)
*********************************** */

$(document).ready(function() {
	
	$("#e2").select2({
		placeholder: "Donde quieres ir?",
		allowClear: true
	});
	
	$("#select-distribuidora").select2({
		placeholder: "Todas las comarcas",
		allowClear: true
	});	
}); 

/* ***********************************
*        Init DATA PICKER
*********************************** */

/* Datepicker de maqueta

$(document).ready(function() {

	$(function() {
		
	    $( "#from" ).datepicker({
	      //defaultDate: "+1w",
	      changeMonth: false,
	      monthNames: ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
	      dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
	      dateFormat: "dd-mm-yy",
	      numberOfMonths: 1,
	      firstDay: 1,
	      minDate: new Date(),
	      beforeShowDay:false,
	      defaultDate: +1,
	      onClose: function( selectedDate ) {
	        $( "#to" ).datepicker( "option", "minDate", selectedDate );
	      }
	    });
	    $( "#to" ).datepicker({
	      defaultDate: "+1w",
	      changeMonth: false,
		  monthNames: ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
	      dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
	      dateFormat: "dd-mm-yy",
	      numberOfMonths: 1,
	      firstDay: 1,
		  onClose: function( selectedDate ) {
	        $( "#from" ).datepicker( "option", "maxDate", selectedDate );
	      }
	    });
	  });
});

*/

/** DatePicker Producción */


function beforeShowDay(date){

    if (typeof detalle_de_disponiblidad !== 'undefined') {
        var ymd = jQuery.datepicker.formatDate('yy-mm-dd',date);
        var disponibilidad = detalle_de_disponiblidad[ymd];
        // console.log(date , ymd, disponibilidad);
        if (typeof disponibilidad === 'undefined' ){
            return [false,"","unAvailable"];
        }

        if (disponibilidad.status == 'available') {
            return [true, "","Available"];
        } else{
            return [false,"","unAvailable"];

        }
    }
}

$(document).ready(function() {

    $(function() {
        var  monthNames = ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"];
        var dayNamesMin = ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ];
        var dateFormat = "dd-mm-yy";
        $( "#FormSearch #from" ).datepicker({
            //defaultDate: "+1w",
            changeMonth: false,
            monthNames: monthNames,
            dayNamesMin: dayNamesMin,
            dateFormat: dateFormat,
            numberOfMonths: 1,
            firstDay: 1,
            minDate: new Date(),
            beforeShowDay:false,
            defaultDate: +1,
            onClose: function( selectedDate ) {
                $( "#FormSearch #to" ).datepicker( "option", "minDate", selectedDate );
            }
        });
        $( "#FormSearch #to" ).datepicker({
            defaultDate: "+1w",
            changeMonth: false,
            monthNames: monthNames,
            dayNamesMin: dayNamesMin,
            dateFormat: dateFormat,
            numberOfMonths: 1,
            firstDay: 1,
            onClose: function( selectedDate ) {
                $( "#FormSearch #from" ).datepicker( "option", "maxDate", selectedDate );
            }
        });


        $( "#BookForm #from" ).datepicker({
            //defaultDate: "+1w",
            changeMonth: false,
            monthNames: monthNames,
            dayNamesMin: dayNamesMin,
            dateFormat: dateFormat,
            numberOfMonths: 1,
            firstDay: 1,
            minDate: new Date(),
            beforeShowDay:beforeShowDay,
            defaultDate: +1,
            onClose: function( selectedDate ) {
                $( "#BookForm #to" ).datepicker( "option", "minDate", selectedDate );
            }
        });
        $( "#BookForm #to" ).datepicker({
            defaultDate: "+1w",
            changeMonth: false,
            monthNames: monthNames,
            dayNamesMin: dayNamesMin,
            dateFormat: dateFormat,
            numberOfMonths: 1,
            beforeShowDay:beforeShowDay,
            firstDay: 1,
            onClose: function( selectedDate ) {
                $( "#BookForm #from" ).datepicker( "option", "maxDate", selectedDate );
            }
        });
    });
});


/* ***********************************
* 
*        Init DATA PICKER EN FICHA
*
*********************************** */

$(document).ready(function() {

	$(function() {
    	$( "#datepicker-ficha" ).datepicker({
	    	numberOfMonths: 1,
    	});
	});
});

/* ***********************************
* 
*        Init Sticker lateral
*
*********************************** */


/// INIT Styky formulario lateral
$(document).ready(function() {
	
	function mysticky() {
		
		if ($(window).width() > 991) {
			$("#book-form").stick_in_parent({
				offset_top:10,
				inner_scrolling:true,
			});
		} 
		else if ($(window).width() < 992) {
			$("#book-form").trigger("sticky_kit:detach")
		};
	};
	
	mysticky();
});




/* ***********************************
*        Init VENO LIGHTBOX
*********************************** */

$(document).ready(function(){

    /* default settings */
    $('.venobox').venobox();
    
    /* FILTERS MOBILE */
    $('.venobox-filters-mobile').venobox({
        framewidth: '100%',        // default: ''
        frameheight: '100%',       // default: ''
        border: '0px',             // default: '0'
        bgcolor: '#e7e7e5',         // default: '#fff'
        titleattr: 'Fitrar casas',    // default: 'title'
        numeratio: true,            // default: false
        infinigall: true            // default: false
    });
    
    /* BOOK in mobile */
    $('.venobox-book-mobile').venobox({
        framewidth: '100%',        // default: ''
        frameheight: '100%',       // default: ''
        border: '0px',             // default: '0'
        bgcolor: '#e7e7e5',         // default: '#fff'
       // titleattr: 'Buscar en el mapa',    // default: 'title'
        numeratio: true,            // default: false
        infinigall: true            // default: false
    });
    
    /* MAP SEARCH */
    $('.venobox-search-map').venobox({
        framewidth: '100%',        // default: ''
        frameheight: '1000px',       // default: ''
        border: '0px',             // default: '0'
        bgcolor: '#e7e7e5',         // default: '#fff'
        titleattr: 'Buscar en el mapa',    // default: 'title'
        numeratio: true,            // default: false
        infinigall: true            // default: false
    });
    
     /* COMO RESERVAR */
    $('.venobox-how-to-book').venobox({
        framewidth: '100%',        // default: ''
        frameheight: '70%',       // default: ''
        border: '25px',             // default: '0'
        //bgcolor: '#e7e7e5',         // default: '#fff'
        titleattr: 'Cómo reservar',    // default: 'title'
        numeratio: true,            // default: false
        infinigall: true            // default: false
    });
    
});


/**Init TOOLTIPS */

$(document).ready(function() {
	
	$('#tooltip-House-Type-1').tooltipster({
		animation: 'grow',
		content: $('<div><strong>CASA RURAL INDEPENDIENTE</strong><br>Alquiler íntegro de la casa</div>')
	});
	
	$('#tooltip-House-Type-2').tooltipster({
		animation: 'grow',
		content: $('<div><strong>CASA RURAL INDEPENDIENTE CON SERVICIOS EXTERIORES COMPARTIDOS</strong><br>Las áreas como jardín, piscina, barbacoa son compartidas con otras casas</div>')
	});
	
	$('#tooltip-House-Type-3').tooltipster({
		animation: 'grow',
		content: $('<div><strong>HABITACIONES EN HOTEL RURAL</strong><br>Habitaciones independientes en hotel rural</div>')
	});
});

/** SMOOTH SCROLL  
	BTN smooth scroll. Hay que aplicar al btn la clase .btn-smooth-scroll
*/

$(function() {
	
	$('.btn-smooth-scroll').click(function() {
		
	    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
		    var target = $(this.hash);
		    target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
		    if (target.length) {
				$('html,body').animate({
					scrollTop: target.offset().top
		        }, 1000);
		        
		        return false;
			}
	    }
	});
});

/** Init botones para ocultar las localidades */

$(document).find('.btn-more-card').click(function(){
	$(this).next().toggle();
	$(this).toggle();
	return eventCancel(evt);
});
$('.btn-more-breadcrumb').click(function() {
	$('.location-breadcrumb').slideToggle('fast');
	$(this).toggle();
});
$('.btn-more').click(function() {
	$('.location').slideToggle('fast');
	$(this).toggle();
});

/** Abre links en ventana nueva en desktop */

$(document).ready(function() {
	//$('.link-external').attr('target','_blank');
	
	function linkBlank() {
		if ($(window).width() > 1024) {
			$('.link-external').attr('target','_blank');
		}
		else {
			$('.link-external').attr('target','_self');
		}
	}
	
	linkBlank();
	
	// Detecta el resize para aplicar la función
	$(window).resize(function() {
		linkBlank();
	});
	
});