<?php require_once 'template_header.inc.php'; ?>

    <div id="wrapper">
        <h3>Investigacion</h3>

<?php
// Research data
$research = research_getById($_GET[id]);
?>

	<h4><?php print $research[name]; ?></h4>

	<h5>0) Investigaci&oacute;n</h5>

	<div class="research-info">
		<span class="title">Nombre:</span>
		<?php print $research[name]; ?>
	</div>

	<div class="research-info">
		<span class="title">Descripci&oacute;n:</span>
		<?php print $research[description]; ?>
	</div>

	<div class="research-info">
		<span class="title">Fuente de datos:</span>
		<?php
		for ($i=0; $i<count($swra_input_plugins); $i++)
		{
			$swra_input_plugin = $swra_input_plugins[$i];
			if ($swra_input_plugin[id] == $research[origin_type])
			{
				print "$swra_input_plugin[name] <em>($swra_input_plugin[description])</em>\n";
			}
		}
		?>
	</div>

	<div class="research-info">
		<span class="title">Tama&ntilde;o:</span>
		<?php print $research[size]; ?>
	</div>


	<?php
	if ($research[status]=="3")
	{

		print "<h5>3) Post-proceso de los datos</h5>";

		print "<form name=\"forminput\" method=\"post\" action=\"research_process.php?id=$_GET[id]&process=done\">";

		print "<div class=\"field\">";
		print "<label>Tipos de post-proceso:</label>";
		for ($i=0; $i<count($swra_process_plugins); $i++)
		{
			$swra_process_plugin = $swra_process_plugins[$i];
			print "<span><input type=\"checkbox\" name=\"process[]\" value=\"$swra_process_plugin[id]\" />$swra_process_plugin[name] <em>($swra_process_plugin[description])</em></span><br />";
		}
		print "</div>";

		print "<div class=\"field\">";
		print "<input type=\"submit\" value=\"Modificar\">";
		print "</div>";

		print "</form>";

	} else if ($research[status]=="4") {

		print "<h5>3) Post-proceso de los datos</h5>";

		$research_process_types = json_decode($research[process_type],true);
		print "<div class=\"research-info\">";
		if (count($research_process_types[process])==0)
		{
			print "<p>Ningun post-proceso</p>";
		} else {
			print "<label>Procesos</label>:";
			print "<ul>";
			for ($i=0; $i<count($research_process_types[process]); $i++)
			{
				for ($j=0; $j<count($swra_process_plugins); $j++)
				{
					if ($swra_process_plugins[$j][id]==$research_process_types[process][$i])
					{
						print "<li>".$swra_process_plugins[$j][name]."</li>";
					}
				}
			}
			print "</ul>";
		}
		print "</div>";

		print "<div class=\"research-info\">";
			print "<p>Pendiente de post-procesar los datos</p>";
		print "</div>";

		print "<div class=\"research-info\">";
			print "<a href=\"research_process_job.php?id=$research[id]\">Procesar datos</a>";
		print "</div>";

	} else {
		print "<meta http-equiv=refresh content=3;url=research_show.php?id=$_GET[id]>";
	}
	?>

	<?php
	if ($_GET[process]=="done")
	{
		if (!empty($_POST)) {
			// Obteniendo los datos de los parametros en un array
			$process_parameters_json = json_encode($_POST);

			if (count($process_parameters_json!=0))
			{
				// Consulta para guardar la investigacion
				research_updateParametersProcess($_GET[id],$process_parameters_json);
			}
		}
		research_updateStatus($_GET[id],'POSTPROCESS');
		print "<meta http-equiv=refresh content=3;url=research_process_job.php?id=$_GET[id]>";
	}
	?>

    </div>

    <div class="buttons">
        <div class="left">
            <a href="research_list.php">Volver</a>
        </div>
    </div>

<?php require_once 'template_footer.inc.php'; ?>