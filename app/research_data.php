<?php require_once 'template_header.inc.php'; ?>

    <div id="wrapper">
	    <h3>Investigaciones</h3>

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
// Number of records per page to show
$datas_show = $config["PAGINATION"]["MAX_ELEMENTS"];

// Size query
$datas_total = data_count($_GET[id],$_GET[type]);

// Rearranging paging parameters
if ($_GET[page] == "") {
    $page_current = 1;
    $datas_start = 0;
} else {
    $page_current = $_GET[page];
    $datas_start = $datas_show * ($page_current - 1);
}

// Total number of pages
$page_total = ceil($datas_total / $datas_show);

// Rearranging paging parameters
if ($page_current > $page_total) {
    $page_current = $page_total;
}
if ($page_current < 1) {
    $page_current = 1;
}

if ($datas_total == 0) {
	print "<table id=\"box-table\" summary=\"Datos\">\n";
	print "		<thead>\n";
	print "		</thead>\n";
	print "		<tbody>\n";
	print "			<tr>\n";
	print "         <td>No existen datos</td>\n";
	print "			<tr>\n";
	print "		</tbody>\n";
	print "</table>\n";
} else {
	// Data items
	$datas_all = data_getAll($_GET[id],$_GET[type],$datas_start,$datas_show);

	foreach ($datas_all as $data)
	{
		print "<table id=\"box-table\" summary=\"Datos\">\n";
		print "		<thead>\n";
		print "		</thead>\n";
		print "		<tbody>\n";
		print "         <tr><th scope=\"row\" class=\"box-table-td-medium\">Datos 1</th><td class=\"box-table-td-xxlarge\">$data[data1]</td></tr>\n";
		print "         <tr><th scope=\"row\" class=\"box-table-td-medium\">Datos 2</th><td class=\"box-table-td-xxlarge\">$data[data2]</td></tr>\n";
		print "         <tr><th scope=\"row\" class=\"box-table-td-medium\">Datos 3</th><td class=\"box-table-td-xxlarge\">$data[data3]</td></tr>\n";
		print "         <tr><th scope=\"row\" class=\"box-table-td-medium\">Fecha</th><td>$data[fecha]</td></tr>\n";
		print "		</tbody>\n";
		print "</table>\n";
	}
}

if ($page_total != 1)
{
	print "<div id=\"box-table-pagination\">\n";

	// Previous page
	if ($page_current > 1) {
		print "<a href=\"research_data.php?id=$_GET[id]&page=".($page_current - 1)."\">Prev</a>\n";
	} else {
		print "<span class=\"disabled\">Prev</span>\n";
	}
	// Pages links
	for ($i = 1; $i <= $page_total; $i++) {
		if ($i == $page_current) {
			print "<span class=\"active\">$i</span>\n";
		} else {
			print "<a href=\"research_data.php?id=$_GET[id]&page=$i\">$i</a>\n";
		}
	}
	// Next page
	if ($page_current < $page_total) {
		print "<a href=\"research_data.php?id=$_GET[id]&page=".($page_current + 1)."\">Next</a>\n";
	} else {
		print "<span class=\"disabled\">Next</span>\n";
	}

	print "</div>\n";
}
?>

    </div>

	<div class="buttons">
		<div class="left">
			<a href="research_list.php">Volver</a>
		</div>
	</div>

<?php require_once 'template_footer.inc.php'; ?>