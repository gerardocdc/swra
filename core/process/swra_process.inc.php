<?php
/**
 * Comunidades Virtuales de Salud
 * Social Web Research Assistant
 *
 * Grupo Internet y Salud
 * Escuela Andaluza de Salud Publica
 *
 * @author		Gerardo Colorado Diaz-Caneja <gcdiazcaneja@diaz-caneja-consultores.com>
 * @author      Jaime Jimenez Pernett <jaime.jimenez.easp@juntadeandalucia.es>
 * @link		http://www.diaz-caneja-consultores.com
 * @link        http://campus.easp.es/internetysalud/
 * @link        http://www.easp.es
 * @copyright	Copyright (c) 2010 Diaz-Caneja Consultores
 * @copyright	Copyright (c) 2010 Escuela Andaluza de Salud Publica
 * @license		Creative Commons CC-BY-NC-ND License (http://creativecommons.org/licenses/by-nc-nd/3.0/)
 * @package		SocialWebResearchAssistant
 * @version     1.0
 * @filesource
 */


/**
 * Input plugins libraries
 *
 * @package		SocialWebResearchAssistant
 * @subpackage  Process
 * @category	Init
 * @version     1.0
 * @since		Version 1.0
 */


/**
 * Loading of process plugins
 */
	/**
	 * Html Sanitation Process Plugin
	 */
	require_once CORE_PROCESS_INCLUDE_PATH . DS . 'htmltags/htmltags.inc.php';
	/**
	 * Links Sanitation Process Plugin
	 */
	require_once CORE_PROCESS_INCLUDE_PATH . DS . 'htmllinks/htmllinks.inc.php';
	/**
	 * Accents Process Plugin
	 */
	require_once CORE_PROCESS_INCLUDE_PATH . DS . 'accents/accents.inc.php';


/**
 * Returns the process plugin corresponding to the selected type
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param string    $type_    Id of the plugin to be fetched
 * @return array    Array of the plugin selected
 */
function swra_process_plugins_fetcher($type_)
{
	global $swra_process_plugins;

	$swra_process_plugin = array();

	for ($i=0; $i<count($swra_process_plugins); $i++)
	{
		$temp = $swra_process_plugins[$i];
		if ($temp[id]==$type_) { $swra_process_plugin = $temp; }
	}

	return $swra_process_plugin;
}


/**
 * Executes the selected process plugin
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param string    $type         Id of the plugin to be executed
 * @param array     $parameters   Array of the parameters needed for the plugin to be executed
 * @return void
 */
function swra_process_plugins_execute($type,$parameters_)
{
	switch($type)
	{
		case "htmltags":    process_plugin_htmltags_execute($parameters_);  break;
		case "htmllinks":   process_plugin_htmllinks_execute($parameters_); break;
		case "accents":     process_plugin_accents_execute($parameters_);   break;
	}
}


/**
 * Prepares the database for the processing of raw data
 *
 * @version     1.0
 * @since       Version 1.0
 *
 * @param array     $parameters   Array of the parameters needed for the plugin to be executed
 * @return void
 */
function swra_process_plugins_prepare($parameters_)
{
	// Parameters
	$origin = $parameters_[id];

	global $conection;

	// Temp data query
	$sql = "SELECT * FROM origin_data_raw WHERE research='$origin'";
	$result = mysql_query($sql, $conection) or die("Error SWRA-PLUGIN-PROCESS-001: Raw data query ".mysql_error());
	while ($row = mysql_fetch_array($result)) {
		$sql_temp = "INSERT INTO origin_data_raw_temp (research,data1,data2,data3,fecha) VALUES ('$origin','".sanitizeSQLText($row[data1],false)."','".sanitizeSQLText($row[data2],false)."','".sanitizeSQLText($row[data3],false)."','".$row[fecha]."')";
		mysql_query($sql_temp,$conection) or die("Error SWRA-PLUGIN-PROCESS-002: Copying raw data to temporary table query ".mysql_error());
	}
}


/**
 * Releases the database of the temporary items from the processing of raw data
 *
 * @version     1.0
 * @since       Version 1.0
 *
 * @param array     $parameters   Array of the parameters needed for the plugin to be executed
 * @return void
 */
function swra_process_plugins_release($parameters_)
{
	// Parameters
	$origin = $parameters_[id];

	global $conection;

	// Temp data query
	$sql_temp = "SELECT * FROM origin_data_raw_temp WHERE research='$origin'";
	$result_temp = mysql_query($sql_temp, $conection) or die("Error SWRA-PLUGIN-PROCESS-003: Temporary data query ".mysql_error());
	while ($row_temp = mysql_fetch_array($result_temp)) {
		$sql = "INSERT INTO origin_data (research,data1,data2,data3,fecha) VALUES ('$origin','".sanitizeSQLText($row_temp[data1],false)."','".sanitizeSQLText($row_temp[data2],false)."','".sanitizeSQLText($row_temp[data3],false)."','".$row_temp[fecha]."')";
		mysql_query($sql,$conection) or die("Error SWRA-PLUGIN-PROCESS-004: Copying temporary data to fianl table query ".mysql_error());
	}

	$sql_delete = "DELETE FROM origin_data_raw_temp WHERE research='$origin'";
	mysql_query($sql_delete,$conection) or die("Error SWRA-PLUGIN-PROCESS-005: Deleting temporary data query ".mysql_error());
}
?>