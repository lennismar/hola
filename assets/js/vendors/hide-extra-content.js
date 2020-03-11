
//// MUESTRA O NO EL CONTENIDO OCULTO
	
$(document).ready(function() {
	
    $(document).find('.btn-expand-extra-content').click(function(){

      //Expand or collapse this panel
      $(this).next().slideToggle('fast');

      //Hide the other panels
      //$(".filter-content").not($(this).next()).slideUp('fast');

    });
});