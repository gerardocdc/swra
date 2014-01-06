<?php require_once 'template_header.inc.php'; ?>

    <div id="wrapper">
        <h3>Crear Investigacion</h3>

<?php
if (empty($_POST)) {
?>

<form name="formadd" method="post" action="research_add.php" id="researchForm">

    <script src="js/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

	<script src="js/jqueryvalidate/jquery.validate.min.js" type="text/javascript"></script>
	<link rel="stylesheet" href="js/jqueryvalidate/jquery.validate.css" type="text/css" media="all" />

    <script type="text/javascript">
		$(document).ready(function() {
			$("#researchForm").validate({
				rules: {
					name: "required",
					origin: "required"
				},
				messages: {
					name: "Introduzca un nombre",
					origin: "Introduzca una fuente de datos"
				}
			});
		});
	</script>

    <div class="field">
        <label>Nombre:</label>
        <input type="text" name="name" class="large" />
    </div>

    <div class="field">
        <label>Descripcion:</label>
	    <textarea name="description" wrap="hard" class="large"></textarea>
    </div>

	<div class="field">
	    <label>Fuente de datos:</label>
		<?php
		for ($i=0; $i<count($swra_input_plugins); $i++)
		{
			$swra_input_plugin = $swra_input_plugins[$i];
			print "<span><input type=\"radio\" name=\"origin\" value=\"$swra_input_plugin[id]\" />$swra_input_plugin[name] <em>($swra_input_plugin[description])</em></span><br />\n";
		}
		?>
	</div>

    <div class="field">
        <input type="submit" value="Guardar">
    </div>
    
</form>

<?php
} else {
// Research save query
$id = research_add($_POST);

print "<meta http-equiv=refresh content=0;url=research_input.php?id=$id>";
}
?>

    </div>

    <div class="buttons">
        <div class="left">
            <a href="research_list.php">Volver</a>
        </div>
    </div>

<?php require_once 'template_footer.inc.php'; ?>