<?php require_once 'template_header.inc.php'; ?>

    <div id="wrapper">
        <h3>Investigacion</h3>

<?php
// Research data
$research = research_getById($_GET[id]);
?>

    <h4><?php print $research[name]; ?></h4>

<?php
switch ($research[status])
{
case 0: // Definicion
	print "<meta http-equiv=refresh content=0;url=research_input.php?id=$_GET[id]>";

	break;
case 1: // Pendiente
	// Parametros
	$swra_input_parameters = json_decode($research[origin_parameters],true);

	// Obtenemos el tamaño de los datos
	$data_size = swra_input_plugins_execute_size($research[origin_type],$swra_input_parameters);
	research_updateSize($_GET[id],$data_size);

	// Actualizamos el estado
	research_updateStatus($_GET[id],'PROCESS');

   	print "<meta http-equiv=refresh content=3;url=research_input_job.php?id=$_GET[id]>";

	break;
case 2: // Proceso
	print "<div class=\"research-info\">";
		print "<p>Obteniendo los datos ...</p>";
	print "</div>";

	// Parametros
	$swra_input_parameters = json_decode($research[origin_parameters],true);
	$swra_input_parameters["id"] = $_GET[id];

	// Proceso
	swra_input_plugins_execute($research[origin_type],$swra_input_parameters);

	// Actualizamos el estado
	research_updateStatus($_GET[id],'OBTAINED');

	print "<meta http-equiv=refresh content=3;url=research_process.php?id=$_GET[id]>";

	break;
case 3:	// Obtenido
	print "<meta http-equiv=refresh content=3;url=research_process.php?id=$_GET[id]>";

	break;
case 4:	// Post-Proceso
	print "<meta http-equiv=refresh content=3;url=research_process_job.php?id=$_GET[id]>";

	break;
case 5:	// Terminado
	print "<meta http-equiv=refresh content=3;url=research_output.php?id=$_GET[id]>";

	break;
}
?>

    </div>

<?php require_once 'template_footer.inc.php'; ?>