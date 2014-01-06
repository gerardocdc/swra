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
 * Research model library
 *
 * @package		SocialWebResearchAssistant
 * @subpackage  Model
 * @category	Data
 * @version     1.0
 * @since		Version 1.0
 */
 

/**
 * Obtains the total number of available data items of a research
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param int   $id_    Id of the research to obtain
 * @param string    $type_  Tipo de datos mostrar (RAW= iniciales | NORMAL= procesados]
 * @return  int     Total number of available data items
 */
function data_count($id_, $type_ = "NORMAL")
{
	global $conection;

	// Size query
	switch ($type_)
	{
		case "RAW":
			$querytotal = "SELECT DISTINCT count(*) FROM origin_data_raw WHERE research='$id_'";
			break;
		case "NORMAL":
		default:
			$querytotal = "SELECT DISTINCT count(*) FROM origin_data WHERE research='$id_'";
			break;
	}
	$total = mysql_fetch_row(mysql_query($querytotal, $conection)) or die("Error SWRA-MODEL-RESEARCH-001: Research query - Count ".mysql_error());

	return $total[0];
}


/**
 * Obtains all available data items of a research
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param int   $id_    Id of the research to obtain
 * @param string    $type_  Tipo de datos mostrar (RAW= iniciales | NORMAL= procesados]
 * @param int   $start_     Initial record to obtain
 * @param int   $show_      Number of records to show
 * @return array    Array of all data items
 */
function data_getAll($id_, $type_ = "NORMAL", $start_ = 0, $show_ = 10)
{
	global $conection;

	$data_all = array();

	// Research query
	switch ($type_)
	{
		case "RAW":
			$sql = "SELECT * FROM origin_data_raw WHERE research='$id_' ORDER BY data1,data2,data3 LIMIT $start_,$show_";
			break;
		case "NORMAL":
		default:
			$sql = "SELECT * FROM origin_data WHERE research='$id_' ORDER BY data1,data2,data3 LIMIT $start_,$show_";
			break;
	}

	$result = mysql_query($sql, $conection) or die("Error SWRA-MODEL-RESEARCH-002: Research query ".mysql_error());
	while ($row = mysql_fetch_array($result)) {
		array_push($data_all,$row);
	}

	return $data_all;
}