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
 * @subpackage  Input
 * @category	Init
 * @version     1.0
 * @since		Version 1.0
 */


/**
 * Loading of input plugins
 */
	/**
	 *  RSS Url Input Plugin
	 */
	require_once CORE_INPUT_INCLUDE_PATH . DS . 'rssurl/rssurl.inc.php';
	/**
	 * RSS File Input Plugin
	 */
	require_once CORE_INPUT_INCLUDE_PATH . DS . 'rssfile/rssfile.inc.php';
	/**
	 * Database Input Plugin
	 */
	require_once CORE_INPUT_INCLUDE_PATH . DS . 'ddbb/ddbb.inc.php';


/**
 * Returns the input plugin corresponding to the selected type
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param string    $type_    Id of the plugin to be fetched
 * @return array    Array of the plugin selected
 */
function swra_input_plugins_fetcher($type_)
{
	global $swra_input_plugins;

	$swra_input_plugin = array();

	for ($i=0; $i<count($swra_input_plugins); $i++)
	{
		$temp = $swra_input_plugins[$i];
		if ($temp[id]==$type_) { $swra_input_plugin = $temp; }
	}

	return $swra_input_plugin;
}


/**
 * Executes the selected input plugin
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param string    $type         Id of the plugin to be executed
 * @param array     $parameters   Array of the parameters needed for the plugin to be executed
 * @return void
 */
function swra_input_plugins_execute($type,$parameters)
{
	switch($type)
	{
		case "rssurl":      input_plugin_rssurl_execute($parameters);   break;
		case "rssfile":     input_plugin_rssfile_execute($parameters);  break;
		case "ddbb":        input_plugin_ddbb_execute($parameters);     break;
	}
}


/**
 * Obtains the size of the data
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param string    $type         Id of the plugin to be executed
 * @param array     $parameters   Array of the parameters needed for the plugin to be executed
 * @return integer      Number of items in the data
 */
function swra_input_plugins_execute_size($type,$parameters)
{
	switch($type)
	{
		case "rssurl":      $data_size = input_plugin_rssurl_size($parameters);   break;
		case "rssfile":     $data_size = input_plugin_rssfile_size($parameters);  break;
		case "ddbb":        $data_size = input_plugin_ddbb_size($parameters);     break;
	}

	return $data_size;
}