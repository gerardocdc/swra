<?php require_once 'template_header.inc.php'; ?>

    <div id="wrapper">
        <h3>Investigacion</h3>

<?php
// Research data
$research = research_getById($_GET[id]);
?>

    <h4><?php print $research[name]; ?></h4>

	<h5>3) Post-proceso de los datos</h5>

<?php
switch ($research[status])
{
case 0: // Definicion
	print "<meta http-equiv=refresh content=0;url=research_input.php?id=$_GET[id]>";

	break;
case 1: // Pendiente
	print "<meta http-equiv=refresh content=0;url=research_input.php?id=$_GET[id]>";

	break;
case 2: // Proceso
	print "<meta http-equiv=refresh content=3;url=research_show.php?id=$_GET[id]>";

	break;
case 3:	// Obtenido
	print "<meta http-equiv=refresh content=3;url=research_process.php?id=$_GET[id]>";

	break;
case 4:	// Post-Proceso
	print "<div class=\"research-info\">";
		print "<p>Procesando los datos ...</p>";
	print "</div>";

	$swra_process_parameters = json_decode($research[process_type],true);

	$parameters = array("id"=>$research[id]);

	swra_process_plugins_prepare($parameters);

	for ($i=0; $i<count($swra_process_parameters[process]); $i++)
	{
		swra_process_plugins_execute($swra_process_parameters[process][$i],$parameters);
	}

	swra_process_plugins_release($parameters);

	// Actualizamos el estado
	research_updateStatus($_GET[id],'END');

	print "<meta http-equiv=refresh content=3;url=research_output.php?id=$_GET[id]>";

	break;
case 5:	// Terminado
	print "<meta http-equiv=refresh content=3;url=research_output.php?id=$_GET[id]>";

	break;
}
?>

    </div>

<?php require_once 'template_footer.inc.php'; ?>