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
 * Output plugins libraries
 *
 * @package		SocialWebResearchAssistant
 * @subpackage  Output
 * @category	Init
 * @version     1.0
 * @since		Version 1.0
 */


/**
 * Loading of output plugins
 */
	/**
	 *  Excel Output Plugin
	 */
	require_once CORE_OUTPUT_INCLUDE_PATH . DS . 'excel/excel.inc.php';
	/**
	 * Csv Output Plugin
	 */
	require_once CORE_OUTPUT_INCLUDE_PATH . DS . 'csv/csv.inc.php';
	/**
	 * SQL Output Plugin
	 */
	require_once CORE_OUTPUT_INCLUDE_PATH . DS . 'sql/sql.inc.php';
	/**
	 * Database Output Plugin
	 */
	require_once CORE_OUTPUT_INCLUDE_PATH . DS . 'ddbb/ddbb.inc.php';


/**
 * Returns the ouput plugin corresponding to the selected type
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param string    $type_    Id of the plugin to be fetched
 * @return array    Array of the plugin selected
 */
function swra_output_plugins_fetcher($type_)
{
	global $swra_output_plugins;

	$swra_output_plugin = array();

	for ($i=0; $i<count($swra_output_plugins); $i++)
	{
		$temp = $swra_output_plugins[$i];
		if ($temp[id]==$type_) { $swra_output_plugin = $temp; }
	}

	return $swra_output_plugin;
}


/**
 * Executes the selected output plugin
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param string    $type         Id of the plugin to be executed
 * @param array     $parameters   Array of the parameters needed for the plugin to be executed
 * @return void
 */
function swra_output_plugins_execute($type,$parameters)
{
	switch($type)
	{
		case "excel":       output_plugin_excel_execute($parameters);   break;
		case "csv":         output_plugin_csv_execute($parameters);     break;
		case "sql":         output_plugin_sql_execute($parameters);     break;
		case "ddbb":        output_plugin_ddbb_execute($parameters);    break;
	}
}