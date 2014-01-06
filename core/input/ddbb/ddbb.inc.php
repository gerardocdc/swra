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
 * Database Input plugin library
 *
 * @package		SocialWebResearchAssistant
 * @subpackage  Input
 * @category	DDBB
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
	$id = "ddbb";
	$name = "Base de datos";
	$description = "Obtencion de datos desde una base de datos externa";

	/**
	 * Plugin parameters
	 */
	$parameters = array();
	$parameter = array("id"=>"host","name"=>"Host","type"=>"text");  array_push($parameters,$parameter);
	$parameter = array("id"=>"dbname","name"=>"Base de datos","type"=>"text");  array_push($parameters,$parameter);
	$parameter = array("id"=>"username","name"=>"Usuario","type"=>"text");  array_push($parameters,$parameter);
	$parameter = array("id"=>"userpassword","name"=>"Contraseña","type"=>"text");  array_push($parameters,$parameter);
	$parameter = array("id"=>"table","name"=>"Tabla","type"=>"text");  array_push($parameters,$parameter);
	$parameter = array("id"=>"column1","name"=>"Columna 1","type"=>"text");  array_push($parameters,$parameter);
	$parameter = array("id"=>"column2","name"=>"Columna 2","type"=>"text");  array_push($parameters,$parameter);
	$parameter = array("id"=>"column3","name"=>"Columna 3","type"=>"text");  array_push($parameters,$parameter);
	$parameter = array("id"=>"column4","name"=>"Columna 4","type"=>"text");  array_push($parameters,$parameter);

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
 * -------------------------------------------------------------------
 *  Plugin methods
 * -------------------------------------------------------------------
 */

/**
 * Executes DDBB input plugin
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param array $parameters_ Array of parameters ["id"=>Id of the research related | "host"=>Host of the database | "dbname"=>Database name | "username"=>Database username | "userpassword"=>Database user password | "table"=>Table name for data set | "column1"=>Column name for data set 1 | "column2"=>Column name for data set 2 | "column3"=>Column name for data set 3 | "column4"=>Column name for data set 4]
 * @return void
 */
function input_plugin_ddbb_execute($parameters_)
{
	// Parameters
	$parameters_ddbb = $parameters_;
	$origin = $parameters_[id];

	// Text fetching
	$text_ddbb = input_plugin_ddbb_fetch($parameters_ddbb);

	// Text trimming
	$text_trim = input_plugin_ddbb_extract($text_ddbb);

	input_plugin_ddbb_save($text_trim,$origin);
}


/**
 * Obtains the size of the database records
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param array $parameters_ Array of parameters ["host"=>Host of the database | "dbname"=>Database name | "username"=>Database username | "userpassword"=>Database user password | "table"=>Table name for data set]

 * @return int      Number of items in the RSS
 */
function input_plugin_ddbb_size($parameters_)
{
	// Conection with Database
	$conection_ddbb = conection_create($parameters_[host], $parameters_[username], $parameters_[userpassword], $parameters_[dbname]);

	// Count query
	$sql = "SELECT * FROM $parameters_[table]";
	$result = mysql_query($sql, $conection_ddbb) or die("Error SWRA-PLUGIN-INPUT-DDBB-001: Data count query ".mysql_error());
	$rows_number = mysql_num_rows($result);

	return $rows_number;
}


/**
 * Fetches the database records
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param array $parameters_ Array of parameters ["id"=>Id of the research related | "host"=>Host of the database | "dbname"=>Database name | "username"=>Database username | "userpassword"=>Database user password | "table"=>Table name for data set | "column1"=>Column name for data set 1 | "column2"=>Column name for data set 2 | "column3"=>Column name for data set 3 | "column4"=>Column name for data set 4]
 * @return array    Array of DDBB data ["column1"=>Column name for data set 1 | "column2"=>Column name for data set 2 | "column3"=>Column name for data set 3]
 */
function input_plugin_ddbb_fetch($parameters_)
{
	$data = array();

	// Conection with Database
	$conection_ddbb = conection_create($parameters_[host], $parameters_[username], $parameters_[userpassword], $parameters_[dbname]);

	// Query
	$sql = "SELECT $parameters_[column1] AS column1, $parameters_[column2] AS column2, $parameters_[column3] AS column3 FROM $parameters_[table]";
	$result = mysql_query($sql, $conection_ddbb) or die("Error SWRA-PLUGIN-INPUT-DDBB-002: Data fetch query ".mysql_error());
	while ($row = mysql_fetch_array($result))
	{
		array_push($data,$row);
	}

	return $data;
}


/**
 * Extracts the data of the database records
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param array $data_   Array of DDBB data ["column1"=>Column name for data set 1 | "column2"=>Column name for data set 2 | "column3"=>Column name for data set 3]
 * @return array         Array of DDBB extracted data (title, description, content, pubdate)
 */
function input_plugin_ddbb_extract($data_)
{
	$result = array();

	for ($i=0; $i<count($data_); $i++)
	{
		$item = $data_[$i];
		$title = sanitizeSQLText($item[column1]);
		$description = sanitizeSQLText($item[column2]);
		$content = sanitizeSQLText($item[column3]);
		$pubdate = sanitizeSQLText($item[column4]);
		array_push($result,array("data1"=>"$title","data2"=>"$description","data3"=>"$content","fecha"=>"$pubdate"));
	}

	return $result;
}


/**
 * Saves to database the processed database records
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param array $data_      Array of DDBB extracted data (title, description, content, pubdate)
 * @param int   $origin_    Id of the research related
 * @return void
 */
function input_plugin_ddbb_save($data_,$origin_)
{
	global $conection;

	for ($i=0; $i<count($data_); $i++)
	{
		$data_split = $data_[$i];

		$sql_origen_raw="INSERT INTO origin_data_raw (research,data1,data2,data3,fecha) VALUES ('$origin_','".sanitizeSQLText($data_split[data1],false)."','".sanitizeSQLText($data_split[data2],false)."','".sanitizeSQLText($data_split[data3],false)."','".$data_split[fecha]."')";
		mysql_query($sql_origen_raw,$conection) or die("Error SWRA-PLUGIN-INPUT-DDBB-003: Data save query ".mysql_error());
	}
}