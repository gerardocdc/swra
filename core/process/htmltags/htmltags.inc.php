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
 * HTML Tags Process plugin library
 *
 * @package		SocialWebResearchAssistant
 * @subpackage  Process
 * @category	HtmlTags
 * @version     1.0
 * @since		Version 1.0
 */


/**
 * -------------------------------------------------------------------
 *  Plugin initialization
 * -------------------------------------------------------------------
 */
	/**
	 * Plugin Definition
	 */
	$id = "htmltags";
	$name = "HTML";
	$description = "Eliminacion de tags de HTML";

	/**
	 * Plugin parameters
	 */
	$parameters = array();

	/**
	 * Plugin instantiation
	 */
	$plugin = array("id"=>$id,"name"=>$name,"description"=>$description,"parameters"=>$parameters);
	array_push($swra_process_plugins,$plugin);


/**
 * -------------------------------------------------------------------
 *  Plugin external libraries initialization
 * -------------------------------------------------------------------
 */


/**
 * -------------------------------------------------------------------
 *  Plugin methods
 * -------------------------------------------------------------------
 */

/**
 * Executes HTML tags process plugin
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param array $parameters_ Array of parameters ["id"=>Id of the research related]
 * @return void
 */
function process_plugin_htmltags_execute($parameters_)
{
	// Parameters
	$origin = $parameters_[id];

	// Raw data fetching
	$data_raw = process_plugin_htmltags_fetch($origin);

	// Data processing
	$data = process_plugin_htmltags_process($data_raw);

	// Saving processed data
	process_plugin_htmltags_save($data,$origin);
}


/**
 * Fetches the raw data from the database
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param int   $origin_    Id of the research related
 * @returm array       Array of raw data
 */
function process_plugin_htmltags_fetch($id_)
{
	global $conection;

	$data_raw = array();

	// Raw data query
	$sql = "SELECT * FROM origin_data_raw_temp WHERE research='$id_'";
	$result = mysql_query($sql, $conection) or die("Error SWRA-PLUGIN-PROCESS-HTMLTAGS-001: Temporary data query ".mysql_error());
	while ($row = mysql_fetch_array($result)) {
		array_push($data_raw,$row);
	}

	return $data_raw;
}


/**
 * Processes the raw data
 * @version     1.0
 * @since       Version 1.0
 *
 * @param array     $data_      Array of raw data
 * @return array                Array of processed data
 */
function process_plugin_htmltags_process($data_)
{
	$result = array();

	for ($i=0; $i<count($data_); $i++)
	{
		$item = $data_[$i];
		$data1 = process_plugin_htmltags_sanitize($item[data1]);
		$data2 = process_plugin_htmltags_sanitize($item[data2]);
		$data3 = process_plugin_htmltags_sanitize($item[data3]);
		$fecha = $item[fecha];
		array_push($result,array("data1"=>"$data1","data2"=>"$data2","data3"=>"$data3","fecha"=>"$fecha"));
	}

	return $result;
}


/**
 * Saves to database the processed data
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param array $data_      Array of processed data
 * @param int   $origin_    Id of the research related
 * @return void
 */
function process_plugin_htmltags_save($data_,$origin_)
{
	global $conection;

	$sql_delete = "DELETE FROM origin_data_raw_temp WHERE research='$origin_'";
	mysql_query($sql_delete,$conection) or die("Error SWRA-PLUGIN-PROCESS-HTMLTAGS-002: Old temporary data delete query ".mysql_error());

	for ($i=0; $i<count($data_); $i++)
	{
		$data_split = $data_[$i];

		$sql_process="INSERT INTO origin_data_raw_temp (research,data1,data2,data3,fecha) VALUES ('$origin_','".sanitizeSQLText($data_split[data1],false)."','".sanitizeSQLText($data_split[data2],false)."','".sanitizeSQLText($data_split[data3],false)."','".$data_split[fecha]."')";
		mysql_query($sql_process,$conection) or die("Error SWRA-PLUGIN-PROCESS-HTMLTAGS-003: Temporary data save query ".mysql_error());
	}

	$sql="UPDATE research SET process_date=CURRENT_TIMESTAMP WHERE id='$origin_';";
	mysql_query($sql,$conection) or die("Error SWRA-PLUGIN-PROCESS-HTMLTAGS-004: Data save update date query ".mysql_error());
}


/**
 * Cleans a text of Html tags
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param string $text_     Text to be cleaned
 * @return string   Sanitized text
 */
function process_plugin_htmltags_sanitize($text_)
{
	$search = array("'<script[^>]*?>.*?</script>'si",	// Javascript
					"'<[\/\!]*?[^<>]*?>'si",			// Html tags
					"'([\r\n])[\s]+'",					// Espacios en blanco
					"'&(quote|#34);'i",					// Html entities
					"'&(amp|#38);'i",
					"'&(lt|#60);'i",
					"'&(gt|#62);'i",
					"'&(nbsp|#160);'i",
					"'&(iexcl|#161);'i",
					"'&(cent|#162);'i",
					"'&(pound|#163);'i",
					"'&(copy|#169);'i"
					);
	$replace = array(	"",
						"",
						"\\1",
						"\"",
						"&",
						"<",
						">",
						" ",
						chr(161),
						chr(162),
						chr(163),
						chr(169));

	$text_clean = preg_replace($search,$replace,$text_);

	// Otra opcion
	//$text_clean = strip_tags($text_);

    return $text_clean;
}