<?php require_once 'template_header.inc.php'; ?>

    <div id="wrapper">
        <h3>Eliminar Investigacion</h3>

<?php
if (empty($_POST)) {
// Research data
$research = research_getById($_GET[id]);
?>

<form name="formdel" method="post" action="research_del.php?id=<?php print $_GET[id]; ?>" id="researchForm">
<input type="hidden" name="id" value="<?php print $_GET[id]; ?>" />
    <div class="field">
	    <p>La investigacion <strong><?php print $research[name]; ?></strong> de fecha <b><?php print date_mysql_to_simple($research[date_creation]); ?></b> va a ser eliminada. &iquest;Est&aacute; seguro?</p>
	</div>

    <div class="field">
        <input type="submit" value="Eliminar">
    </div>
    
</form>

<?php
} else {
// Research delete query
research_delete($_GET[id]);

print "<meta http-equiv=refresh content=0;url=research_list.php>";
}
?>

    </div>

    <div class="buttons">
        <div class="left">
            <a href="research_list.php">Volver</a>
        </div>
    </div>

<?php require_once 'template_footer.inc.php'; ?>