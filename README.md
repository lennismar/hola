

## Historial de Cambios
----
### Al 28-Dic-2016 Por [JP Guevara](mailto:chorew@gmail.com)
* Se agregaron dos metodos a init.js para habilitar los rangos de fechas mostrados en casa-rural.php
* Se agrego archivo de consulta json api/getReservatios.php, el cual entrega un arreglo de las reservaciones para la casa indicada.
* En el archivo casa-rural.php se agrego la llamada a getReservatios.php 
* Se agrego libreria [lodash](https://lodash.com/docs/4.17.2#find) para facilitar las busquedas en arreglos de js.

### Al 16-Nov-2016 Por [JP Guevara](mailto:chorew@gmail.com)

* Se agrego minificacion a travez de grunt
* Se agrego seccion de *Descripcion de reserva inmediatas* en el index.php. 
	Para modificar la seccion hay que revisar el archivo includes/secciones-index/desc-reservas-inmediatas.php
	Para cambiar el texto revisa el archivo de laguages/*.php 
	con las variables DESCRIPCION_RESERVA_INMEDIATA
* Se cambio en el index.php la seccion "Casas que te van a gustar" el titulo
	*CASAS_QUE_TE_VAN_GUSTAR* por *Planes que te van a gustar*
* en la maqueta en el index.php, se muestra la seccion con titulo "Planes que te van a gustar"
	Esta seccion no existe en el codigo. Hay que ponerla?
* se movio el codigo del index.php para la seccion de 'mejores-zonas-cataluña' a su archivo.
	includes/secciones-index/mejores-zonas-cataluña.php
* se comento el codigo de 'mejores-zonas-cataluña' en el archivo index.php. ya que no existe en el template.
* se arreglo el codigo de las tabs en la seccion de casas destacadas.
* se agrego valoracion y numero de comentarios en la tarjeta de resultados de busqueda.
* Se agregaron variables en los archivos de idiomas

## Grunt ## 
----

Se utilizo grunt para minificar y asi generar el archivo unico de js 'somrurals.min.js'
con la mayoria de los scripts js, en un futuro se puede obtimizar y separar en 2 archivos o como se necesite.

Hay que ejecutar el comando 'grunt' cada vez que se haga cambios en el archivo init.js

Para instalar grunt se requiere nodejs y npm

ya con npm instalado, ejecutar los comandos:
```
#para instalar todo lo requerido por el proyecto
npm install
#para instalar grunt
npm install -g grunt 
npm install -g grunt-cli 
```
