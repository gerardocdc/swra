<?php require_once 'template_header.inc.php'; ?>

    <div id="wrapper">
        <h3>Modificar Investigacion</h3>

<?php
if (empty($_POST)) {
// Research data
$research = research_getById($_GET[id]);
?>

<form name="formedit" method="post" action="research_edit.php?id=<?php print $_GET[id]; ?>" id="researchForm">

    <script src="js/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

	<script src="js/jqueryvalidate/jquery.validate.min.js" type="text/javascript"></script>
	<link rel="stylesheet" href="js/jqueryvalidate/jquery.validate.css" type="text/css" media="all" />

    <script type="text/javascript">
		$(document).ready(function() {
			$("#researchForm").validate({
				rules: {
					name: "required"
				},
				messages: {
					name: "Introduzca un nombre"
				}
			});
		});
	</script>

    <div class="field">
        <label>Nombre:</label>
        <input type="text" name="name" class="large" value="<?php print $research[name]; ?>" />
    </div>

    <div class="field">
        <label>Descripcion:</label>
	    <textarea name="description" wrap="hard" class="large"><?php print $research[description]; ?></textarea>
    </div>

	<div class="field">
	    <label>Fuente de datos:</label>
		<?php
		for ($i=0; $i<count($swra_input_plugins); $i++)
		{
			$swra_input_plugin = $swra_input_plugins[$i];
			if ($swra_input_plugin[id] == $research[origin_type])
			{
				print "<span>$swra_input_plugin[name] <em>($swra_input_plugin[description])</em></span>\n";
			}
		}
		?>
	</div>

    <div class="field">
        <input type="submit" value="Modificar">
    </div>

</form>

<?php
} else {
// Research update query
research_update($_GET[id],$_POST);

print "<meta http-equiv=refresh content=0;url=research_input.php?id=$_GET[id]>";
}
?>

    </div>

    <div class="buttons">
        <div class="left">
            <a href="research_list.php">Volver</a>
        </div>
    </div>

<?php require_once 'template_footer.inc.php'; ?>