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

	<?php
	if ($research[status]=="0")
	{
		print "<h5>1) Par&aacute;metros de la Fuente de datos ($swra_input_plugin[description])</h5>";

		$swra_input_parameters = json_decode($research[origin_parameters],true);
		$swra_input_plugin = swra_input_plugins_fetcher($research[origin_type]);
		$swra_input_plugin_parameters = $swra_input_plugin[parameters];

		print "<form name=\"forminput\" method=\"post\" action=\"research_input.php?id=$_GET[id]\">";

		print "<script src=\"js/jquery/1.7.1/jquery.min.js\" type=\"text/javascript\"></script>";
		print "<script src=\"js/jqueryvalidate/jquery.validate.min.js\" type=\"text/javascript\"></script>";
		print "<link rel=\"stylesheet\" href=\"js/jqueryvalidate/jquery.validate.css\" type=\"text/css\" media=\"all\" />";

		$form_validation_jquery_rules = "";
		$form_validation_jquery_messages = "";

		for ($i=0; $i<count($swra_input_plugin_parameters); $i++)
		{
			$swra_input_plugin_parameter = $swra_input_plugin_parameters[$i];
			print "<div class=\"field\">";
			print "<label>$swra_input_plugin_parameter[name]:</label>";
				$value=$swra_input_parameters[$swra_input_plugin_parameter[id]];
				print "<input type=\"text\" name=\"$swra_input_plugin_parameter[id]\" value=\"$value\" />";
			print "</div>";
			$form_validation_jquery_rules .= $swra_input_plugin_parameter[id] .'"required",';
			$form_validation_jquery_messages .= $swra_input_plugin_parameter[id] .'"Introduzca $swra_input_plugin_parameter[name]",';
		}
		print "<div class=\"field\">";
		print "<input type=\"submit\" value=\"Modificar\">";
		print "</div>";

		$form_validation_jquery_rules = substr($form_validation_jquery_rules,0,strlen($form_validation_jquery_rules)-1);
		$form_validation_jquery_messages = substr($form_validation_jquery_messages,0,strlen($form_validation_jquery_messages)-1);

		print "<script type=\"text/javascript\">";
		print "    $(document).ready(function() {";
		print "	    $(\"#forminput\").validate({";
		print "		    rules: {";
		print "			    $form_validation_jquery_rules";
		print "		    },";
		print "		    messages: {";
		print "			    $form_validation_jquery_messages";
		print "		    }";
		print "	    });";
		print "    });";
		print "</script>";

		print "</form>";

	} else if ($research[status]=="1") {

		print "<h5>1) Par&aacute;metros de la Fuente de datos ($swra_input_plugin[description])</h5>";

		for ($i=0; $i<count($swra_input_plugin_parameters); $i++)
		{
			$swra_input_plugin_parameter = $swra_input_plugin_parameters[$i];
			print "<div class=\"field\">";
			print "<label>$swra_input_plugin_parameter[name]:</label>";
				print $swra_input_parameters[$swra_input_plugin_parameter[id]];
			print "</div>";
		}

		print "<div class=\"field\">";
		print "<p>Pendiente de obtener los datos</p>";
		print "</div>";

	} else {
		print "<meta http-equiv=refresh content=3;url=research_show.php?id=$_GET[id]>";
    }
	?>

	<?php
	if (!empty($_POST)) {
		// Obteniendo los datos de los parametros en un array
		$origin_parameters_json = json_encode($_POST);

		// Consulta para guardar la investigacion
	    research_updateParametersOrigin($_GET[id],$origin_parameters_json);

		// Validacion de que todos los parametros estan completos
		$validation_complete = true;
		for ($i=0; $i<count($origin_parameters_json); $i++)
		{
			if (empty($origin_parameters_json[$i])) { $validation_complete = false; }
		}
		// Cambia de estado de la investigacion
		if ($validation_complete && $research[status]=="0")
		{
			research_updateStatus($_GET[id],'PENDING');

			print "<meta http-equiv=refresh content=3;url=research_input_job.php?id=$_GET[id]>";
		}
	}
	?>

    </div>

    <div class="buttons">
        <div class="left">
            <a href="research_list.php">Volver</a>
        </div>
    </div>

<?php require_once 'template_footer.inc.php'; ?>