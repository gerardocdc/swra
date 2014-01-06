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
 * Database Output plugin library
 *
 * @package		SocialWebResearchAssistant
 * @subpackage  Output
 * @category	SQL
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
	$id = "sql";
	$name = "SQL";
	$description = "Exportacion de datos al formato SQL";

	/**
	 * Plugin parameters
	 */
	$parameters = array();
	$parameter = array("id"=>"filename","name"=>"Nombre del fichero","type"=>"text");  array_push($parameters,$parameter);
	$parameter = array("id"=>"dbname","name"=>"Base de datos","type"=>"text");  array_push($parameters,$parameter);
	$parameter = array("id"=>"table","name"=>"Tabla","type"=>"text");  array_push($parameters,$parameter);
	$parameter = array("id"=>"column1","name"=>"Columna 1","type"=>"text");  array_push($parameters,$parameter);
	$parameter = array("id"=>"column2","name"=>"Columna 2","type"=>"text");  array_push($parameters,$parameter);
	$parameter = array("id"=>"column3","name"=>"Columna 3","type"=>"text");  array_push($parameters,$parameter);
	$parameter = array("id"=>"column4","name"=>"Columna 4","type"=>"text");  array_push($parameters,$parameter);

	/**
	 * Plugin instantiation
	 */
	$plugin = array("id"=>$id,"name"=>$name,"description"=>$description,"parameters"=>$parameters);
	array_push($swra_output_plugins,$plugin);


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
 * Executes Sql output plugin
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param array $parameters_ Array of parameters ["origin"=>Id of the research related | "filename"=>Name of the filename to export]
 * @return void
 */
function output_plugin_sql_execute($parameters_)
{
	// Parameters
	$origin = $parameters_[id];
	$filename = $parameters_[filename];

	header("Content-type: text/plain");
	header("Content-Disposition: attachment; filename=".basename($filename));

	// Data fetching
	$data_raw = output_plugin_sql_fetch($origin);

	// Data processing
	$data = output_plugin_sql_extract($data_raw);

	// Data processing
	$text = output_plugin_sql_process($data,$parameters_);

	print $text;

	flush();
}


/**
 * Fetches the data from the database
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param int   $origin_    Id of the research related
 * @returm array       Array of data
 */
function output_plugin_sql_fetch($id_)
{
	global $conection;

	$data_raw = array();

	// Raw data query
	$sql = "SELECT * FROM origin_data WHERE research='$id_'";
	$result = mysql_query($sql, $conection) or die("Error SWRA-PLUGIN-OUTPUT-SQL-001: Data query ".mysql_error());
	while ($row = mysql_fetch_array($result)) {
		array_push($data_raw,$row);
	}

	return $data_raw;
}


/**
 * Extracts the data of the database records
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param array $data_   Array of DDBB data ["data1"=>Column name for data set 1 | "data2"=>Column name for data set 2 | "data3"=>Column name for data set 3 | "fecha"=>Column name for date]
 * @return array         Array of DDBB extracted data (title, description, content, pubdate)
 */
function output_plugin_sql_extract($data_)
{
	$result = array();

	for ($i=0; $i<count($data_); $i++)
	{
		$item = $data_[$i];
		$title = sanitizeSQLText($item[data1]);
		$description = sanitizeSQLText($item[data2]);
		$content = sanitizeSQLText($item[data3]);
		$pubdate = $item[fecha];
		array_push($result,array("data1"=>"$title","data2"=>"$description","data3"=>"$content","fecha"=>"$pubdate"));
	}

	return $result;
}


/**
 * Process the data of the database records to SQL syntax sentences
 *
 * @version     1.0
 * @since       Version 1.0
 *
 * @param array $data_   Array of DDBB data ["data1"=>Column name for data set 1 | "data2"=>Column name for data set 2 | "data3"=>Column name for data set 3 | "fecha"=>Column name for date]
 * @return string   Sql syntax sentences
 */
function output_plugin_sql_process($data_,$parameters_)
{
	// Parameters
	$dbname = $parameters_[dbname];
	$table = $parameters_[table];
	$column1 = $parameters_[column1];
	$column2 = $parameters_[column2];
	$column3 = $parameters_[column3];
	$column4 = $parameters_[column4];

	// SQL sentences
	$text = "";

	for ($i=0; $i<count($data_); $i++)
	{
		$data_split = $data_[$i];

		$text.="INSERT INTO $dbname.$table ($column1,$column2,$column3,$column4) VALUES ('".$data_split[data1]."','".$data_split[data2]."','".$data_split[data3]."','".$data_split[fecha]."')\n";
	}

	return $text;
}