SOCIAL WEB RESEARCH ASSISTANT
(Sistema de apoyo a la investigacion Social en e-Health)
========================================================


Funcionalidades
---------------
La principal funcionalidad del SWRA es la obtencion de datos de plataformas sociales web. Para ello, el SWRA acomete las siguientes funcionalidades:
 - Importa datos de plataformas sociales desde diferentes tipos de fuentes
 - Parsea dichos datos obtenidos y los extrae segmentados
 - Procesa los datos obtenidos, realizando procesos de limpieza y refino
 - Exporta los datos a diferentes formatos


Descripcion
----------
El Sistema de Apoyo a la Investigacion Social en e-Health (Social Web Research Assistant o SWRA) es un software online que nace de la necesidad de facilitar la obtencion de datos sobre e-Health existentes en diferentes plataformas web, a fin de que los investigadores puedan utilizar esos datos obtenidos en analisis cualitativos, cuantitativos y relacionales. Actualmente, la obtencion y tratamiento de dichos datos se realiza de forma manual, siendo esto muy engorroso y consumidora de abundantes recursos materiales, economicos y tiempo.


Arquitectura
------------
El SWRA consiste en una aplicacion web online, accesible desde cualquier ordenador con conexion a Internet, independientemente de cual sea el sistema operativo de dicho ordenador. El codigo fuente esta desarrollado en el lenguaje de programacion PHP, requiriendo de una base de datos MySql. Asimismo, se puede obtener el codigo fuente y ejecutarse en cualquier servidor.

La aplicacion esta desarrollada basada en el modelo de “three tier with an application server”, basandose en la descripcion de arquitecturas de software desarrollado por Philippe Kruchten. La plataforma de software sobre la cual se sustentara el nucleo funcional de la aplicacion sera un compendio de varias tecnologias, herramientas y librerias de terceros, y que formaran un Framework RAD (Rapid Application Development). Dicho framework esta construido sobre una arquitectura de capas, en la que una capa brinda servicios a la capa de nivel superior utilizando los servicios de la capa de nivel inferior. Esta arquitectura de capas se repite a su vez dentro de cada capa siguiendo un patron fractal. La ventaja de este planteamiento es que brinda al desarrollador abstracciones que le permiten trabajar mejor y mas rapido (y asi gozar de una gran ventaja competitiva) pero sin reducir las posibilidades ni la flexibilidad.

La vista logica de la arquitectura de la aplicacion se encuadra perfectamente dentro de las caracteristicas del patron Model View Controller para aplicaciones web, aunque se analiza la aplicacion bajo la perspectiva de Presentation, Business and Persistence.


Plugins
-------
Debido a que en Investigacion Social pueden aparecer nuevos tipos de fuentes, o requerirse de nuevos procesos de filtrado, el SWRA se ha desarrollado previendo y facilitando su expansion. Para ellos, se ha configurado en tres modulos, cada uno de los cuales realiza una de las misiones principales del software (extraer, procesar, exportar) y dentro de cada uno de los modulos se incluyen diferentes plugins:

1) Modulo Extraccion (Input)
Este modulo realiza la obtencion, extraccion y parseo de los datos de las diferentes fuentes. Los diferentes plugins son:
 - RSS por Url: Obtiene los datos de un fichero RSS de noticias sindicadas a partir de su direccion URL. Se guardan los datos de titulo, contenido, descripcion y fecha del RSS.
 - RSS por fichero: Obtiene los datos de un fichero RSS de noticias sindicadas a partir de un fichero. Se guardan los datos de titulo, contenido, descripcion y fecha del RSS.
 - Base de datos: Se obtienen los datos de otra base de datos, pudiendo obtenerse hasta 3 campos de datos de diferentes tablas.

2) Modulo Post-Proceso (Process)
Este modulo realiza el post-proceso de los datos obtenidos, a fin de realizar una limpieza y sanitacion de los mismos. Los diferentes plugins son:
 - HTML Tags: Elimina todos los tags de HTML del texto, dejando intacto el texto dentro de los tags que corresponda a texto
 - HTML links: Elimina solo los tags links de HTML del texto, dejando intacto el texto del link y cualquier otro tag de HTML que existan (formato, posicionamiento, etc.).
 - Acentos: Sustituye los caracteres con los diferentes tipos de tilde por caracteres sin acentuar. Esto es necesario ya que existe software que no codifica correctamente los acentos.
 - Fechas: Realiza la conversion de fechas (dia y hora) de diferentes formatos a un formato unico Unix Epoch

3) Modulo Exportacion (Output)
Este modulo exporta los datos obtenidos y procesados en los dos modulos anteriores a diferentes formatos, a fin de que el investigador pueda usar el formato mas apropiado para realizar la investigacion o bien emplearlo en otro software de analisis. Los diferentes plugins son:
 - Excel: Exporta todos los datos obtenidos a una tabla de Excel.
 - CSV: Exporta todos los datos obtenidos a un fichero de texto plano CSV, donde los campos estan separados por puntos y comas (;) y los registros vienen en lineas.
 - SQL: Exporta todos los datos obtenidos a sentencias SQL, que se pueden emplear para alimentar diferentes tipos de bases de datos.
 - Base de datos: Exporta todos los datos obtenidos a otra base de datos.


Extension
---------
El SWRA consiste en una iniciativa FLOSS (Free/Libre and open source software) o software libre y de codigo abierto, mediante el cual el codigo es accesible por la comunidad de desarrolladores. El codigo es accesible a traves de diferentes forjas existentes en Internet. Dicha comunidad puede utilizar y modificar el codigo para su propio uso. Asimismo, la comunidad puede ampliar el software y desarrollar nuevos plugins, aumentando la funcionalidad del mismo accesible para el resto.

Debido a la propia arquitectura del SWRA, crear un nuevo tipo de plugin por parte de cualquier desarrollador no es complicado, al estar estandarizados las estructuras de variables y metodos del framework a emplear en cada plugin, y debido a que el SWRA reconoce los plugins instalados de forma automatica. Asi por ejemplo, se podrian crear plugins de obtencion de datos para diferentes foros, Twitter, Facebook, etc.


Descripcion
-----------
1) Investigaciones

Al entrar en SWRA se puede elegir entre seguir una investigacion ya realizada o crear una. Aparece el listado de investigaciones anteriormente creadas, pudiendose acceder a las diferentes partes del proceso desde el mismo listado de investigaciones.

En caso de crear una nueva investigacion, se debera indicar el nombre de la misma, una pequeña descripcion (muy util para poder diferenciar investigaciones parecidas) y el tipo de la investigacion, en funcion del plugin input o de obtencion de datos que los datos necesiten (RSS por Url, RSS por fichero y Base de datos).

Se pueden modificar los datos descriptivos de la investigacion en el apartado de editar una investigacion.

Se puede eliminar una investigacion equivocada o que ya no hace falta del SWRA mediante el apartado de eliminacion de una investigacion. Para evitar posibles errores, al eliminar una investigacion lo que hace el sistema del SWRA no es eliminar la investigacion y sus datos, sino impide el acceso a la investigacion, manteniendose almacenados los datos de la investigacion.

2) Extraccion

En funcion del tipo de fuente de datos seleccionada al crear la investigacion, es necesario introducir los parametros necesarios para que el SWRA pueda obtener de forma automatica dichos datos.

En el caso del plugin de obtencion de datos de una fuente RSS por Url, se solicitara que se indique la direccion Url del mismo.

En el caso del plugin de obtencion de datos de una fuente RSS por fichero, se solicitara que se indique el fichero a procesar.

En el caso del plugin de obtencion de datos de una base de datos, se solicitara el nombre del host de la base de datos, el nombre de la base de datos, el usuario de la base de datos que permite el acceso a la misma, la contraseña del usuario y los nombre de las tablas y campos de los que se extraeran los datos.

Una vez introducidos los parametros necesarios para obtener los datos, el SWRA empezara su proceso de obtencion y parseo de los datos. En el caso de que los datos representen una gran cantidad de registros, el SWRA segmenta en varios intervalos su proceso de obtencion de forma automatica, para optimizar los recursos. Al finalizar el proceso de obtencion, se puede proceder al post-proceso de los datos.

3) Post-Proceso

El post-proceso de los datos obtenidos de las fuentes de datos permite al usuario del SWRA realizar la tarea de limpieza, adecuacion y refino de dichos datos a fin de facilitar el posterior trabajo del investigador.

Se debera seleccionar los tipos de post-proceso que se desea aplicar a los datos, pudiendose no seleccionar ningun post-proceso si no es necesario, o bien seleccionar todos los post-procesos que se consideren necesarios. A fin de facilitar el trabajo del usuario, los datos originales nunca se eliminan, almacenandose los datos post-procesados en otro lugar, a fin de disponer siempre de ambos tipos de datos (en bruto y procesados)

4) Exportacion

El proceso de exportacion se puede realizar todas las veces que el usuario de SWRA requiera, mientras que la obtencion y post-proceso de los datos solo puede realizarse una unica vez. Se debera seleccionar el tipo de formato de exportacion de los datos de los disponibles.

En el caso del plugin de exportacion a Excel, se debera definir el nombre del fichero de Excel a generar. Los datos se presentan por filas, y los distintos campos se presentan por columnas, dentro del fichero Excel.

En el caso del plugin de exportacion a CSV, se debera definir el nombre del fichero de CSV a generar. Los datos se presentan por filas, y los distintos campos se presentan separados por el caracter punto y coma (;), dentro del fichero CSV.

En el caso del plugin de exportacion a SQL, se debera definir el nombre del fichero de SQL a generar, el nombre de la base de datos, y los nombre de las tablas y campos en los cuales se almacenaran los datos. Los datos se presentan en sentencias SQL correctamente formateadas segun los parametros de exportacion indicados.

En el caso del plugin de exportacion de datos de una base de datos, se solicitara el nombre del host de la base de datos, el nombre de la base de datos, el usuario de la base de datos que permite el acceso a la misma, la contraseña del usuario y los nombre de las tablas y campos de los que se extraeran los datos.


Copyright
---------
Este software es ofrecido bajo la licencia Creative Commons CC-BY-NC-ND License (http://creativecommons.org/licenses/by-nc-nd/3.0/)
Copyright (c) 2010 Escuela Andaluza de Salud Publica
Copyright (c) 2010 Diaz-Caneja Consultores


Contacto
--------
Jaime Jimenez Pernett          jaime.jimenez.easp@juntadeandalucia.es
Gerardo Colorado Diaz-Caneja   gcdiazcaneja@diaz-caneja-consultores.com

Github: https://github.com/gerardocdc/swra