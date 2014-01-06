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

	<h5>1) Par&aacute;metros de la Fuente de datos (<?php print $swra_input_plugin[description]; ?>)</h5>

		<?php
		if ($research[status]=="0")
        {
	        print "<div class=\"research-info\">";
	        print "<p>Pendiente de definir los parametros de la fuente de datos</p>";
	        print "<div class=buttons><a href=\"research_input.php?id=$research[id]\">Definir parametros</a></div>";
	        print "</div>";
		} else {
			$research_input_parameters = json_decode($research[origin_parameters],true);
			$research_input_plugin = swra_input_plugins_fetcher($research[origin_type]);
			$research_input_plugin_parameters = $research_input_plugin[parameters];

			for ($i=0; $i<count($research_input_plugin_parameters); $i++)
			{
				$research_input_plugin_parameter = $research_input_plugin_parameters[$i];
				print "<div class=\"research-info\">";
				print "<span class=\"title\">$research_input_plugin_parameter[name]</span>: ";
				print $research_input_parameters[$research_input_plugin_parameter[id]];
				print "</div>";
			}
	    }
	    ?>

	<h5>2) Fuente de datos</h5>

		<?php
		if ($research[status]=="0")
        {
	        print "<div class=\"research-info\">";
	        print "<p>Pendiente de definir los parametros de la fuente de datos</p>";
	        print "<div class=buttons><a href=\"research_input.php?id=$research[id]\">Definir parametros</a></div>";
	        print "</div>";
        } else if ($research[status]=="1") {
		    print "<div class=\"research-info\">";
		    print "<p>Pendiente de obtener los datos</p>";
		    print "</div>";
        } else if ($research[status]=="2") {
			print "<div class=\"research-info\">";
			print "<p>Obteniendo datos</p>";
			print "<span class=\"title\">Tama&ntilde;o</span>: $research[size]";
			print "</div>";
		} else {
			print "<div class=\"research-info\">";
			print "<span class=\"title\">Tama&ntilde;o</span>: $research[size]";
			print "</div>";

			print "<div class=\"research-info\">";
			print "<a href=\"research_data.php?id=$research[id]&type=RAW\">Ver datos</a>";
			print "</div>";
		}
		?>

	<h5>3) Post-proceso de los datos</h5>

		<?php
		if ($research[status]=="0" || $research[status]=="1" || $research[status]=="2")
        {
	        print "<div class=\"research-info\">";
	        print "<p>Pendiente de obtener los datos</p>";
	        print "</div>";
        } else if ($research[status]=="3") {
		    print "<div class=\"research-info\">";
		    print "<a href=\"research_process.php?id=$research[id]\">Definir post-proceso</a>";
		    print "</div>";
	    } else if ($research[status]=="4") {
			print "<div class=\"research-info\">";
			print "<p>Post-procesando datos</p>";
			print "<span class=\"title\">Tama&ntilde;o</span>: $research[size]";
			print "</div>";
        }

	    if ($research[status]=="4" || $research[status]=="5")
	    {
			print "<div class=\"research-info\">";
	        $research_process_types = json_decode($research[process_type],true);
		    if (count($research_process_types[process])==0)
	        {
			    print "<p>Ningun post-proceso</p>";
	        } else {
			    print "<span class=\"title\">Procesos</span>:";
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
	    }
	    ?>

	<h5>4) Datos procesados</h5>

		<?php
		if ($research[status]=="0" || $research[status]=="1" || $research[status]=="2" || $research[status]=="3" || $research[status]=="4")
		{
			print "<div class=\"research-info\">";
			print "<p>Sin datos post-procesados</p>";
			print "</div>";
		} else if ($research[status]=="5") {
			print "<div class=\"research-info\">";
			print "<a href=\"research_data.php?id=$research[id]&type=process\">Ver datos</a>";
	        print "</div>";
			print "<div class=\"research-info\" style=\"clear:both;\">";
			print "<a href=\"research_output.php?id=$research[id]\">Exportar</a>";
			print "</div>";
	    }
	    ?>

    </div>

    <div class="buttons">
        <div class="left">
            <a href="research_list.php">Volver</a>
        </div>
    </div>

<?php require_once 'template_footer.inc.php'; ?>