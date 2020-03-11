# SOM RURALS  #

Diseño y front-end por Alberto del Río www.delirios.es

## Actualizaciones ##

### VERSION 1.3 (30/01/2017) ###

* Cambiados las fichas de resultados de búsqueda. Cambios importantes

* Cambiada ficha de casa. Cambios importantes.

### VERSION 1.2 (04/03/2016) ###

* Modificada landing page. Puesto el buscador en la parte superior como test durante un mes para reducir el rebote.

* Ficha de producto. Incluido video youtube responsive.

* Ficha recurso. Solucionado problema de alineación con el texto

* Home. Incluida clase para corregir alineación vertical.

### VERSION 1.1 (09/10/2015) ### 

* Carga de Javascript
	* Para Aligerar la carga, se han dejado los scripts básicos cargando en la parte superior: jquery, modernizr.
	
	* El script init.js se ha compilado dentro de script.min.js, y se ha puesto a cargar an el pie, antes de la etiqueta /body
	
	* Quitado el javascript tabs.js e inyectado en el html, ya que es pequeño y solo aplica en la home, para aligerar carga de scripts externos
	
	* Carga de script de google maps https://maps.googleapis.com/maps/api/js?v=3.exp solo en el cuerpo de las páginas que lo usan, para ayudar a aligerar la carga de scripts.
	
	* EL resto de scripts que actualmente se usan: scripst.js y BookingCalendar.js deben ponerse a cargar también en el footer. EVITAR la carga de estos scripts (especialmente BookingCalendar.js cuando en las páginas que no sean necesarias.). Intentar minificarlos para que la ejecución sea más rápida.
	
* CSS. Reorganizado los archivos SASS dentro de una carpeta del mismo nombre (aunque esta no hay que publicarla)
	
* HEAD: Limpiada la cabecera de scripts comentados.

* HEAD: Etiquetas metadatos OG. Quitadas. Si no se van a completar, mejor quitarlas.

* Cabecera solo con el logo. Para las páginas de checkout. includes/header-clean.php

* index.php Añadidas las propuestas de valor.

* index.php script de las tabs metido en el html para aligerar (ya que sólo se usa ahí).

* includes/mainsearch.php Retocado el buscador principal para que ajuste perfectamente y que el botón de buscar destaque más. En el html se ha insertado el botón submit dentro de la capa anterior.

* Etiqueta INSTANT BOOKING. En includes/instant-booking.php

* Busqueda.php 

	* Añadido en los filtros el filtro de casa con reserva.
	
	* IMPORTANTE: Optimizada la carga de los filtros. Estos se cargan de la propia capa id"filters-mobile" mediante una ventana modal, en lugar de otro include de filtros como hacía antes.
	
	* Mobile: Barra inferior de "Mostrar filtros". Incluido código para trackear en analytics.
	
* ficha.php

	* Ajustes en las columnas y css para el correcto funcionamiento de la columna fija en parte de la derecha en desktop. El código de inicialización del stiky se ha eliminado del html, ya que ahora se inicializa desde scripst.min y solo aplica cuando este es desktop
	* IMPORTANTE: MOBILE.
	
		* Cambiado el color de la barra inferior de llamada a la acción a negro para que destaque mejor.
		
		* El botón de reservar ahora llama a la caja de reserva como ventana modal, en lugar de hacer un scroll como hacía antes (al igual que en los filtros). De esta manera mejoramos notablemente la experiencia de usuario. En este mismo botón se ha incluido un código de evento para analytics.
		
		
* Paginas de CheckOut. Cambiado el header a uno sin menú para evitar las distracciones/escapatoria del usuario
		
* CheckOut Instant Booking

	* checkout-instant-booking-1.php
	
	* checkout-instant-booking-2.php
	
	* checkout-instant-booking-3.php

* CheckOut Pago con tarjeta (desde casa normal)

	* emails/12.2.2.Email-DisponibilidadReserva-Tarjeta.html

	* checkout-tarjeta-1.php

* Pagina de error en el checkout checkout-error.php

* Pagina de información sobre la reserva info-reserva.php
	

### VERSION 1.0 ###

## CSS's ##

* Realizadas en SASS y compiladas posteriormente.
* Componentes modulares. Separado el layout, grid, tipografias, por hojas.
* Las variables de configuración se encuentran en _default.scss
* EL CSS se compila en main.min.css
* En vendors se encuentran los estilos de componenetes externos, como select2, datepicker..

## COMPONENTES JS ##

El archivo init.js contienen inicializaciones de elementos como calendarios, tooltips, etc..

* SELECT2
	Permite las busquedas dentro de los select.
	http://ivaynberg.github.io/select2/
	

* JQUERY UI Datepicker
	Selector de fechas.
	http://jqueryui.com/datepicker/
	
* STICKY-KIT
	Fija la capa al hacer scroll. Usado para fijar el book-form en la ficha de producto, y para el submenú en la ficha de Recurso turístico.
	https://github.com/leafo/sticky-kit

* FOTORAMA
	Carrusel de fotos con thumbnail en la ficha de producto y recursos turísticos.
	http://fotorama.io/
	
* OWL-CAROULSEL
	Carrusel usdo para para mejorar la experiencia en listados. Hace que las columnas de 3 y 4 elementos se conviertan en carruseles en dispositivos moviles. Inicializado en Init.js.
	http://www.owlcarousel.owlgraphic.com/
	
* TOOLTIPSTER
	Tooltips customizables. Necesita ser inicializada previamente para meter el contenido. Esto se encuentra en init.js
	http://iamceege.github.io/tooltipster/

* JQUERY VALIDATION
	Valida los formularios
	http://jqueryvalidation.org
	
* VENOBOX
	Ventanas modales.
	http://lab.veno.it/venobox/

* TABS
	Pestañas cuyo link es un achor dentro de la página. Para dispositivos móbiles transforma las tablas en un desplegable para el facil uso del usuario.
	
* Background cycle
	Inserta un ciclo de imágnees en el background. Usado en la home, landing.
	http://www.jqueryscript.net/slideshow/Simple-jQuery-Background-Image-Slideshow-with-Fade-Transitions-Background-Cycle.html

* SMOOTH SCROLL
	Para aplicarse debe añadir al anchorlink la clase "btn-smooth-scroll".

## USO DE MICRODATOS ##

* Microdatos de schema.org para incluidos. Principalmente en ficha de producto y breadcrumbs
	https://www.google.com/webmasters/tools/richsnippets?q=http%3A%2F%2Fwww.delirios.es%2Fclients%2Fsomrurals%2Fficha.php
	Las fichas de casa están tageadas como PRODUCTO itemtype="http://schema.org/Product"
	
* Microdatos Open Graph incluidos en el head
