<?php require_once 'template_header.inc.php'; ?>

    <div id="wrapper">
	    <h3>Investigaciones</h3>

<?php
// Number of records per page to show
$records_show = $config["PAGINATION"]["MAX_ELEMENTS"];

// Size query
$research_total = research_count();

// Rearranging paging parameters
if ($_GET[page] == "") {
    $page_current = 1;
    $records_start = 0;
} else {
    $page_current = $_GET[page];
    $records_start = $records_show * ($page_current - 1);
}

// Total number of pages
$page_total = ceil($research_total / $records_show);

// Rearranging paging parameters
if ($page_current > $page_total) {
    $page_current = $page_total;
}
if ($page_current < 1) {
    $page_current = 1;
}

print "<table id=\"box-table\" summary=\"Investigaciones\">\n";
print "		<thead>\n";
print "         <tr>\n";
print "             <th scope=\"col\">Fecha</th>\n";
print "             <th scope=\"col\" class=\"box-table-td-large\">Investigacion</th>\n";
print "             <th scope=\"col\" class=\"box-table-td-large\"></th>\n";
print "             <th scope=\"col\" class=\"box-table-td-medium\"></th>\n";
print "         </tr>\n";
print "		</thead>\n";
print "		<tbody>\n";

if ($research_total == 0) {
	print "<tr>\n";
	print "<td></td>\n";
	print "<td>No existen investigaciones</td>\n";
	print "<td></td>\n";
	print "<td></td>\n";
	print "</tr>\n";
} else {
	// Researches
	$research_all = research_getAll($records_start,$records_show);

	foreach ($research_all as $research)
	{
		print "<tr>\n";
		print "<td><a href=\"research_show.php?id=$research[id]\">".date_mysql_to_simple($research[date_creation])."</a></td>\n";
		print "<td><a href=\"research_show.php?id=$research[id]\">$research[name]</a></td>\n";
		print "<td>
				<a href=\"research_show.php?id=$research[id]\">Mostrar</a> -
				<a href=\"research_input.php?id=$research[id]\">Input</a> -
				<a href=\"research_process.php?id=$research[id]\">Proceso</a> -";
		if ($research[status]=="5") { $type="NORMAL"; } else { $type="RAW"; }
		print " <a href=\"research_data.php?id=$research[id]&type=$type\">Datos</a> -";
		print " <a href=\"research_output.php?id=$research[id]\">Output</a>
			   </td>\n";
		print "<td>
				<a href=\"research_edit.php?id=$research[id]\">Editar</a> -
				<a href=\"research_del.php?id=$research[id]\">Eliminar</a>
			   </td>\n";
		print "</tr>\n";
	}
}

print "		</tbody>\n";
print "</table>\n";

if ($page_total != 1)
{
	print "<div id=\"box-table-pagination\">\n";

	// Previous page
	if ($page_current > 1) {
		print "<a href=\"research_list.php?page=".($page_current - 1)."\">Prev</a>\n";
	} else {
		print "<span class=\"disabled\">Prev</span>\n";
	}
	// Pages links
	for ($i = 1; $i <= $page_total; $i++) {
		if ($i == $page_current) {
			print "<span class=\"active\">$i</span>\n";
		} else {
			print "<a href=\"research_list.php?page=$i\">$i</a>\n";
		}
	}
	// Next page
	if ($page_current < $page_total) {
		print "<a href=\"research_list.php?page=".($page_current + 1)."\">Next</a>\n";
	} else {
		print "<span class=\"disabled\">Next</span>\n";
	}

	print "</div>\n";
}
?>

	    <div class="buttons">
			<a href="research_add.php">Crear Investigacion</a>
	    </div>
    </div>

<?php require_once 'template_footer.inc.php'; ?>