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
 * RssUrl Input plugin library
 *
 * @package		SocialWebResearchAssistant
 * @subpackage  Input
 * @category	RssUrl
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
	$id = "rssurl";
	$name = "RSS por Url";
	$description = "Obtencion de datos RSS a traves de una direccion web";

	/**
	 * Plugin parameters
	 */
	$parameters = array();
	$parameter = array("id"=>"url","name"=>"Url","type"=>"text");  array_push($parameters,$parameter);

	/**
	 * Plugin instantiation
	 */
	$plugin = array("id"=>$id,"name"=>$name,"description"=>$description,"parameters"=>$parameters);
	array_push($swra_input_plugins,$plugin);


/**
 * -------------------------------------------------------------------
 *  Plugin external libraries initialization
 * -------------------------------------------------------------------
 */
	/**
	 * Loading of MagPie Rss library
	 */
	require_once LIB_INCLUDE_PATH . DS . 'magpierss-0.72/rss_fetch.inc';
	require_once LIB_INCLUDE_PATH . DS . 'magpierss-0.72/rss_parse.inc';


/**
 * -------------------------------------------------------------------
 *  Plugin methods
 * -------------------------------------------------------------------
 */

/**
 * Executes Rss Url input plugin
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param array $parameters_ Array of parameters ["url"=>Url of the RSS | "id"=>Id of the research related]
 * @return void
 */
function input_plugin_rssurl_execute($parameters_)
{
	// Parameters
	$url = $parameters_[url];
	$origin = $parameters_[id];

	// Text scrapping
	$scrapper_text = input_plugin_rssurl_fetch($url);

	// Text parsing
	$rss = input_plugin_rssurl_parse($scrapper_text);

	// Text trimming
	$rss_trim = input_plugin_rssurl_extract($rss);

	input_plugin_rssurl_save($rss_trim,$origin);
}


/**
 * Obtains the size of the RSS
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param array $parameters_ Array of parameters ["url"=>Url of the RSS | "id"=>Id of the research related]
 * @return integer      Number of items in the RSS
 */
function input_plugin_rssurl_size($parameters_)
{
	// Parameters
	$url = $parameters_[url];

	// Text scrapping
	$scrapper_text = input_plugin_rssurl_fetch($url);

	// Text parsing
	$rss = input_plugin_rssurl_parse($scrapper_text);

	return count($rss->items);
}


/**
 * Fetches through scrapping the RSS url
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param string    $url_    Url of the RSS
 * @return string   Text of the RSS (in XML format)
 */
function input_plugin_rssurl_fetch($url_)
{
	// Text Scrapping
	$scrapper_text = requestHTTP($url_);

	return $scrapper_text;
}


/**
 * Parsing of the RSS text
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param string    $scrapper_text_  Text of the RSS (in XML format)
 * @return MagpieRSS\array  Array of RSS data
 */
function input_plugin_rssurl_parse($scrapper_text_)
{
	$rss = new MagpieRSS($scrapper_text_);
	return $rss;
}


/**
 * Extracts the title, description, content and publication date of an RSS
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param array $data_   Array of RSS data
 * @return array         Array of RSS extracted data (title, description, content, pubdate)
 */
function input_plugin_rssurl_extract($data_)
{
	$result = array();

	foreach ($data_->items as $item)
	{
		$title = sanitizeSQLText($item[title]);
		$description = sanitizeSQLText($item[description]);
		$content = sanitizeSQLText($item[content][encoded]);
		$pubdate = $item[pubdate];
		array_push($result,array("data1"=>"$title","data2"=>"$description","data3"=>"$content","fecha"=>"$pubdate"));
	}

	return $result;
}


/**
 * Saves to database the processed RSS
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param array $data_      Array of RSS extracted data (title, description, content, pubdate)
 * @param int   $origin_    Id of the research related
 * @return void
 */
function input_plugin_rssurl_save($data_,$origin_)
{
	global $conection;

	for ($i=0; $i<count($data_); $i++)
	{
		$data_split = $data_[$i];

		$sql_origen_raw="INSERT INTO origin_data_raw (research,data1,data2,data3,fecha) VALUES ('$origin_','".$data_split[data1]."','".$data_split[data2]."','".$data_split[data3]."','".$data_split[fecha]."')";
		mysql_query($sql_origen_raw,$conection) or die("Error SWRA-PLUGIN-INPUT-RSSURL-001: Data save query ".mysql_error());
	}

	$sql="UPDATE research SET origin_date=CURRENT_TIMESTAMP WHERE id='$origin_';";
	mysql_query($sql,$conection) or die("Error SWRA-PLUGIN-INPUT-RSSURL-002: Data save update date query ".mysql_error());
}