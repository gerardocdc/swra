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
 * @category	Accents
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
	$id = "accents";
	$name = "Acentos";
	$description = "Sustitucion de acentos por su caracter sin acentuar";

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
 * Executes Accents process plugin
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param array $parameters_ Array of parameters ["id"=>Id of the research related]
 * @return void
 */
function process_plugin_accents_execute($parameters_)
{
	// Parameters
	$origin = $parameters_[id];

	// Raw data fetching
	$data_raw = process_plugin_accents_fetch($origin);

	// Data processing
	$data = process_plugin_accents_process($data_raw);

	// Saving processed data
	process_plugin_accents_save($data,$origin);
}


/**
 * Fetches the raw data from the database
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param int   $id_    Id of the research related
 * @returm array       Array of raw data
 */
function process_plugin_accents_fetch($id_)
{
	global $conection;

	$data_raw = array();

	// Raw data query
	$sql = "SELECT * FROM origin_data_raw_temp WHERE research='$id_'";
	$result = mysql_query($sql, $conection) or die("Error SWRA-PLUGIN-PROCESS-ACCENT-001: Temporary data query ".mysql_error());
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
function process_plugin_accents_process($data_)
{
	$result = array();

	for ($i=0; $i<count($data_); $i++)
	{
		$item = $data_[$i];
		$data1 = process_plugin_accents_sanitize($item[data1]);
		$data2 = process_plugin_accents_sanitize($item[data2]);
		$data3 = process_plugin_accents_sanitize($item[data3]);
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
function process_plugin_accents_save($data_,$origin_)
{
	global $conection;

	$sql_delete = "DELETE FROM origin_data_raw_temp WHERE research='$origin_'";
	mysql_query($sql_delete,$conection) or die("Error SWRA-PLUGIN-PROCESS-ACCENT-002: Old temporary data delete query ".mysql_error());

	for ($i=0; $i<count($data_); $i++)
	{
		$data_split = $data_[$i];

		$sql_process="INSERT INTO origin_data_raw_temp (research,data1,data2,data3,fecha) VALUES ('$origin_','".sanitizeSQLText($data_split[data1],false)."','".sanitizeSQLText($data_split[data2],false)."','".sanitizeSQLText($data_split[data3],false)."','".$data_split[fecha]."')";
		mysql_query($sql_process,$conection) or die("Error SWRA-PLUGIN-PROCESS-ACCENT-003: Temporary data save query ".mysql_error());
	}

	$sql="UPDATE research SET process_date=CURRENT_TIMESTAMP WHERE id='$origin_';";
	mysql_query($sql,$conection) or die("Error SWRA-PLUGIN-PROCESS-ACCENT-004: Data save update date query ".mysql_error());
}


/**
 * Cleans a text of accents
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param string $text_     Text to be cleaned
 * @return string   Sanitized text
 */
function process_plugin_accents_sanitize($text_)
{
    // Sanitation of HTML accents
	$text_ = sanitizeSQLText(process_plugin_accents_sanitize_accents_html($text_),false);

	// Sanitation of accents
	$text_ = sanitizeSQLText(process_plugin_accents_sanitize_accents($text_),false);

    return $text_;
}


/**
 * Cleans a text of HTML accents
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param string $text_     Text to be cleaned
 * @return string   Sanitized text
 */
function process_plugin_accents_sanitize_accents_html($text_)
{
	$text_ = str_replace('&aacute;','á',$text_);
    $text_ = str_replace('&eacute;','é',$text_);
    $text_ = str_replace('&iacute;','í',$text_);
    $text_ = str_replace('&oacute;','ó',$text_);
    $text_ = str_replace('&iacute;','ú',$text_);

    $text_ = str_replace('&Aacute;','Á',$text_);
    $text_ = str_replace('&Eacute;','É',$text_);
    $text_ = str_replace('&Iacute;','Í',$text_);
    $text_ = str_replace('&Oacute;','Ó',$text_);
    $text_ = str_replace('&Uacute;','Ú',$text_);

    $text_ = str_replace('&agrave;','à',$text_);
    $text_ = str_replace('&egrave;','è',$text_);
    $text_ = str_replace('&iagrave;','ì',$text_);
    $text_ = str_replace('&oagrave;','ò',$text_);
    $text_ = str_replace('&uagrave;','ù',$text_);

    $text_ = str_replace('&agrave;','À',$text_);
    $text_ = str_replace('&Egrave;','È',$text_);
    $text_ = str_replace('&Igrave;','Ì',$text_);
    $text_ = str_replace('&Ograve;','Ò',$text_);
    $text_ = str_replace('&Ugrave;','Ù',$text_);

    $text_ = str_replace('&acirc;','â',$text_);
    $text_ = str_replace('&ecirc;','ê',$text_);
    $text_ = str_replace('&icirc;','î',$text_);
    $text_ = str_replace('&ocirc;','ô',$text_);
    $text_ = str_replace('&ucirc;','û',$text_);

    $text_ = str_replace('&Acirc;','Â',$text_);
    $text_ = str_replace('&Ecirc;','Ê',$text_);
    $text_ = str_replace('&Icirc;','Î',$text_);
    $text_ = str_replace('&Ocirc;','Ô',$text_);
    $text_ = str_replace('&Ucirc;','Û',$text_);

	return $text_;
}


/**
 * Cleans a text of accents characters
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param string $text_     Text to be cleaned
 * @return string   Sanitized text
 */
function process_plugin_accents_sanitize_accents($text_)
{
	$text_ = str_replace('á','a',$text_);
    $text_ = str_replace('é','e',$text_);
    $text_ = str_replace('í','i',$text_);
    $text_ = str_replace('ó','o',$text_);
    $text_ = str_replace('ú','u',$text_);

    $text_ = str_replace('Á','A',$text_);
    $text_ = str_replace('É','E',$text_);
    $text_ = str_replace('Í','I',$text_);
    $text_ = str_replace('Ó','O',$text_);
    $text_ = str_replace('Ú','U',$text_);

    $text_ = str_replace('à','a',$text_);
    $text_ = str_replace('è','e',$text_);
    $text_ = str_replace('ì','i',$text_);
    $text_ = str_replace('ò','o',$text_);
    $text_ = str_replace('ù','u',$text_);

    $text_ = str_replace('À','A',$text_);
    $text_ = str_replace('È','E',$text_);
    $text_ = str_replace('Ì','I',$text_);
    $text_ = str_replace('Ò','O',$text_);
    $text_ = str_replace('Ù','U',$text_);

    $text_ = str_replace('â','a',$text_);
    $text_ = str_replace('ê','e',$text_);
    $text_ = str_replace('î','i',$text_);
    $text_ = str_replace('ô','o',$text_);
    $text_ = str_replace('û','u',$text_);

    $text_ = str_replace('Â','A',$text_);
    $text_ = str_replace('Ê','E',$text_);
    $text_ = str_replace('Î','I',$text_);
    $text_ = str_replace('Ô','O',$text_);
    $text_ = str_replace('Û','U',$text_);

	return $text_;
}