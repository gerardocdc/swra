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
if ($research[status]=="5")
{
	print "<h5>5) Exportacion de datos</h5>";

	if (empty($_POST))
	{
		print "<form name=\"formoutput\" method=\"post\" action=\"research_output.php?id=$_GET[id]\">";

		print "<div class=\"field\">";
		print "<label>Tipos de exportacion:</label>";
		for ($i=0; $i<count($swra_output_plugins); $i++)
		{
			$swra_output_plugin = $swra_output_plugins[$i];
			print "<span><input type=\"radio\" name=\"output\" value=\"$swra_output_plugin[id]\" />$swra_output_plugin[name] <em>($swra_output_plugin[description])</em></span><br />\n";
		}
		print "</div>";

		print "<div class=\"field\">";
		print "<input type=\"submit\" value=\"Seleccionar\">";
		print "</div>";

		print "</form>";

	} else {

		$swra_output_plugin = swra_output_plugins_fetcher($_POST[output]);
		$swra_output_plugin_parameters = $swra_output_plugin[parameters];

		print "<div class=\"field\">";
		print "<label>Tipo de exportacion:</label>";
		print "$swra_output_plugin[name] <em>($swra_output_plugin[description])</em>\n";
		print "</div>";

		print "<form name=\"formoutput\" method=\"post\" action=\"research_output_job.php?id=$_GET[id]&output=$_POST[output]\" id=\"formoutput\" >";
		print "<input type=\"hidden\" name=\"id\" value=\"$_GET[id]\" />";

		print "<script src=\"js/jquery/1.7.1/jquery.min.js\" type=\"text/javascript\"></script>";
		print "<script src=\"js/jqueryvalidate/jquery.validate.min.js\" type=\"text/javascript\"></script>";
		print "<link rel=\"stylesheet\" href=\"js/jqueryvalidate/jquery.validate.css\" type=\"text/css\" media=\"all\" />";

		$form_validation_jquery_rules = "";
		$form_validation_jquery_messages = "";

		for ($i=0; $i<count($swra_output_plugin_parameters); $i++)
		{
			$swra_output_plugin_parameter = $swra_output_plugin_parameters[$i];
			print "<div class=\"field\">";
			print "<label>$swra_output_plugin_parameter[name]:</label>";
				$value=$swra_output_parameters[$swra_output_plugin_parameter[id]];
				print "<input type=\"text\" name=\"$swra_output_plugin_parameter[id]\" value=\"$value\" />";
			print "</div>";
			$form_validation_jquery_rules .= $swra_output_plugin_parameter[id] .'"required",';
			$form_validation_jquery_messages .= $swra_output_plugin_parameter[id] .'"Introduzca $swra_input_plugin_parameter[name]",';
		}
		print "<div class=\"field\">";
		print "<input type=\"submit\" value=\"Generar\">";
		print "</div>";

		$form_validation_jquery_rules = substr($form_validation_jquery_rules,0,strlen($form_validation_jquery_rules)-1);
		$form_validation_jquery_messages = substr($form_validation_jquery_messages,0,strlen($form_validation_jquery_messages)-1);

		print "<script type=\"text/javascript\">";
		print "    $(document).ready(function() {";
		print "	    $(\"#formoutput\").validate({";
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

	}

} else {
	print "<meta http-equiv=refresh content=3;url=research_show.php?id=$_GET[id]>";
}
?>

<?php

?>

    </div>

    <div class="buttons">
        <div class="left">
            <a href="research_list.php">Volver</a>
        </div>
    </div>

<?php require_once 'template_footer.inc.php'; ?>