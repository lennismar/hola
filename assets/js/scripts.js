// JavaScript Document

// Función que comprueba si hay escrito en texto inicial en un input[text]
// Si está escrito, lo borra para que puedas escribir lo que quieras...
/*
function checkForTextFocus(el, defaultText) {
	if (el.value == defaultText){
		el.value = '';
	}
}
*/
// Función que comprueba si hay escrito en texto inicial en un input[text]
// Si está escrito, lo borra para que puedas escribir lo que quieras...
/*
function checkForTextBlur(el, defaultText){
	if (el.value == ''){
		el.value = defaultText;
	}
}
*/
// Funcion que combierte en un array una seleccion de check
function get_array_for_checkboxes_with_name(name) {
    var new_arr = [];
    var nodes = document.getElementsByName(name);
 
    for (var i = 0, n; n = nodes[i]; i++) {
        if (n.checked == true) {
            new_arr.push(n.value);
        }
    }
 
    return new_arr;
}

// Función que carga a través de AJAX el archivo disponibilidad.php, para que calcule la disponibilidad.
/*
function ConsultarDisponibilidad(){
	var datein, dateout, persons, tipo, eid, resultado;
	resultado = document.getElementById('resultado');

	datein = document.getElementById('from').value;
	dateout = document.getElementById('to').value;
	persons = document.getElementById('reserva-persons').value;
	tipo = document.getElementById('reserva-tipo').value;
	eid = document.getElementById('reserva-eid').value;
	  
	ajax=nuevoAjax();
	ajax.open("POST", "disponibilidad.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			resultado.innerHTML = ajax.responseText
		}
	}
	
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("datein="+datein+"&dateout="+dateout+"&persons="+persons+"&tipo="+tipo+"&eid="+eid);	
}
*/      


//IE waits until another event to send the 'change' events on radios and checkboxes
//This bind a trigger for those events on click.
function trig_bind() {
  //unbind old events
  $("input[type='checkbox']").unbind( 'click' )
  $("input[type='radio']").unbind( 'click' )
  //bind the events
  $("input[type='checkbox']").bind( 'click', function() {
    $(this).trigger( 'change' )
  })
  $("input[type='radio']").bind( 'click', function() {
    $(this).trigger( 'change' )
  })
}
function actualizarInformacionReserva(tid, resultado){
	var adultos,ninos,totalPersonas,resultado,totalCasa,minCasa;
	resultado = resultado || 0;

	adultos = $('#adultos').val();
	ninos = $('#ninos').val();
	totalPersonas = parseInt(adultos)+parseInt(ninos);
	totalCasa = $('#fOculto input[name="totalCasa"]').val();
	minCasa = $('#fOculto input[name="minCasa"]').val();
	if(totalPersonas > totalCasa){
		$('.mensaje-error').show();
		$('.seguir').attr('disabled', true);
		$('.mensaje-minpersons').hide();
	}
	else if(totalPersonas < minCasa){
		$('.mensaje-minpersons').show();
		$('.mensaje-error').hide();
	}
	else{
		$('.mensaje-error').hide();
		$('.mensaje-minpersons').hide();
		$('.seguir').attr('disabled', false);
	}
	ajax3=nuevoAjax();
	ajax3.open("POST", "reserva-form.php",true);
	ajax3.onreadystatechange=function() {
		if (ajax3.readyState==4) {
			 
			$('#resultado_reserva').html(ajax3.responseText);

		}
	}
	
	ajax3.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax3.send("totalPersonas="+totalPersonas+"&tid="+tid+"&adultos="+adultos+"&ninos="+ninos+"&resultado="+resultado);

}

function ConsultarDisponibilidad(){
	var datein, dateout, persons, tipo, eid, resultado;
	trig_bind();
	resultado = document.getElementById('resultado');

	datein = document.getElementById('from').value;
	dateout = document.getElementById('to').value;
	persons = document.getElementById('reserva-persons').value;
	rooms = get_array_for_checkboxes_with_name('rooms[]');
	tipo = document.getElementById('reserva-tipo').value;
	eid = document.getElementById('reserva-eid').value;
	pvid = document.getElementById('reserva-pvid').value;
	


	ajax=nuevoAjax();
	ajax.open("POST", "disponibilidad.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			 
			resultado.innerHTML = ajax.responseText;
			if(tipo==2 && datein!= "" && dateout!=""){
				
				bestprice(datein,dateout,eid,persons);
				avisoPersonas(datein,dateout,eid);
			}
			
		}
	}
	
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("datein="+datein+"&dateout="+dateout+"&persons="+persons+"&rooms="+rooms+"&tipo="+tipo+"&eid="+eid+"&pvid="+pvid);

			
}
function avisoPersonas(datein,dateout,eid){
	ajax=nuevoAjax();
	ajax.open("POST", "aviso-fecha.php",true);
	mensaje="";
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			 
			resultado=ajax.responseText;

			partido=resultado.split('/');

			resultado=trim(resultado);
			if(resultado!=''){
				$('.aviso-mensaje').css('display','block');
				$('.de').html(partido[0]);
				$('.a').html(partido[1]);
				$('.noches').html(partido[2]);
				if(partido[3]!=0){
					$('.entrada').html(partido[3]);
				}else{
					$('.no-entrada').hide();
				}
				if(partido[4]!=0){
					$('.salida').html(partido[4]);
				}else{
					$('.no-salida').hide();
				}
				//$('.aviso-mensaje').html(mensaje);
			}
			else{
				$('.aviso-mensaje').hide();
			}
		}
	}
	
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("datein="+datein+"&dateout="+dateout+"&eid="+eid);
}
function bestprice(datein,dateout,eid,persons){
	var total=$('.total').text();
	var array=total.split("€");
	var totalN=parseFloat(array[0]);
	if(isNaN( totalN )){
		totalN=0;
	}
	
	
	ajax2=nuevoAjax();
	ajax2.open("POST", "bestprice.php",true);
	ajax2.onreadystatechange=function() {

		if (ajax2.readyState==4) {
			$("#precio").html(ajax2.responseText);
			if($("#descripcion_tipo_precio").length) {
				$(".text-price").html($("#descripcion_tipo_precio").val());
                $(".mobile-book-text").html($("#descripcion_tipo_precio").val());
            }
			//$(".mobile-book-price span").empty();
			$(".mobile-book-price span[itemprop='price']").html(ajax2.responseText);
		}
	}
	
	ajax2.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax2.send("datein="+datein+"&dateout="+dateout+"&total="+totalN+"&id="+eid+"&persons="+persons);
	
}

// Función que carga a través de AJAX el archivo calculoreserva.php, para que calcule el total de la reserva.
function CalculoReserva(){
	var datein, dateout, tipo, eid, resultado;
	trig_bind();
	resultado = document.getElementById('reserva_calculo');
	
	datein = document.getElementById('from').value;
	dateout = document.getElementById('to').value;
	rooms = get_array_for_checkboxes_with_name('rooms[]');
	tipo = document.getElementById('reserva-tipo').value;
	eid = document.getElementById('reserva-eid').value;
	
  
	ajax=nuevoAjax();
	ajax.open("POST", "calculoreserva.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			
			resultado.innerHTML = ajax.responseText
		}
	}
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	ajax.send("datein="+datein+"&dateout="+dateout+"&rooms="+rooms+"&tipo="+tipo+"&eid="+eid);
}      


// Funcion que inicializa el calendario (datepicker) y no permite que la fecha de entrada sea mayor que la de salida
/*
$(function() {
	
	var dates = $( "#txt-entrada, #txt-sortida").datepicker({
		minDate: new Date(),
		dateFormat: 'dd-mm-yy',
		beforeShow: function(){
               setTimeout(function() { $(".ui-datepicker").css("z-index", 1001);}, 10);
        },
		onSelect: function( selectedDate ) {
			var option = this.id == "txt-entrada" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});
		
	var dates_reserva = $( "#reserva-datein, #reserva-dateout").datepicker({
		minDate: new Date(),
		dateFormat: 'dd-mm-yy',
		beforeShow: function(){
               setTimeout(function() { $(".ui-datepicker").css("z-index", 1001);}, 10);
        },		
		
		onSelect: function( selectedDate ) {
			var option = this.id == "reserva-datein" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates_reserva.not( this ).datepicker( "option", option, date );
			ConsultarDisponibilidad(); return false;
		}
	});
});
*/

function nuevoAjax(){

	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
		}
	}

	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}


