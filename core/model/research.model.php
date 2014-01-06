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
 * @category	Research
 * @version     1.0
 * @since		Version 1.0
 */
 

/**
 * Obtains the total number of available researches
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @return  int     Total number of available researches
 */
function research_count()
{
	global $conection;

	// Size query
	$querytotal = "SELECT DISTINCT count(*) FROM research WHERE erased='0'";
	$total = mysql_fetch_row(mysql_query($querytotal, $conection)) or die("Error SWRA-MODEL-RESEARCH-001: Research query - Count ".mysql_error());

	return $total[0];
}


/**
 * Obtains all available researches
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param int   $start_     Initial record to obtain
 * @param int   $show_      Number of records to show
 * @return array    Array of all researches data
 */
function research_getAll($start_ = 0, $show_ = 10)
{
	global $conection;

	$research_all = array();

	// Research query
	$sql = "SELECT * FROM research WHERE erased='0' ORDER BY name LIMIT $start_,$show_";
	$result = mysql_query($sql, $conection) or die("Error SWRA-MODEL-RESEARCH-002: Research query ".mysql_error());
	while ($row = mysql_fetch_array($result)) {
		array_push($research_all,$row);
	}

	return $research_all;
}


/**
 * Obtains the research by its Id
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param int   $id_    Id of the research to obtain
 * @return array    Array of the research data
 */
function research_getById($id_)
{
	global $conection;

	// Research data
	$sql = "SELECT * FROM research WHERE id='$id_'";
	$result=mysql_query($sql,$conection) or die("Error SWRA-MODEL-RESEARCH-003: Research query by Id ".mysql_error());
	$row=mysql_fetch_array($result);

	return $row;
}


/**
 * Adds a new research
 *
 * @version     1.0
 * @since       Version 1.0
 *
 * @param array $data_  Array of the research data
 * @return integer  Id of the research added
 */
function research_add($data_)
{
	global $conection;

	// Research save query
	$sql = "INSERT INTO research (name,description,date_creation,origin_type) VALUES ('$data_[name]','$data_[description]',CURRENT_TIMESTAMP,'$data_[origin]')";
	mysql_query($sql,$conection) or die("Error SWRA-MODEL-RESEARCH-004: New research query ".mysql_error());
	$id = mysql_insert_id();

	return $id;
}


/**
 * Updates the data of a research
 *
 * @version     1.0
 * @since       Version 1.0
 *
 * @param int   $id_    Id of the research to obtain
 * @param array $data_  Array of the research data
 * @retun void
 */
function research_update($id_,$data_)
{
	global $conection;

	// Research update query
	$sql = "UPDATE research SET name='$data_[name]',description='$data_[description]',date_update=CURRENT_TIMESTAMP WHERE id='$id_';";
	mysql_query($sql,$conection) or die("Error SWRA-MODEL-RESEARCH-005: Edit research query ".mysql_error());
}


/**
 * Deletes a research
 *
 * @version     1.0
 * @since       Version 1.0
 *
 * @param int   $id_    Id of the research to delete
 * @retun void
 */
function research_delete($id_)
{
	global $conection;

	// Research delete query
	$sql = "UPDATE research SET erased='1',date_update=CURRENT_TIMESTAMP WHERE id='$id_';";
	mysql_query($sql,$conection) or die("Error SWRA-MODEL-RESEARCH-006: Delete research query ".mysql_error());
}


/**
 * Updates the status of a research
 *
 * @version     1.0
 * @since       Version 1.0
 *
 * @param int   $id_    Id of the research to obtain
 * @param   string  $status_    Status to be updated [DEFINITION=>Definicion | PENDING=>Pending | PROCESS=>En proceso | OBTAINED=>Obtained | POSTPROCESS=>Post-processing | END=>End]
 * @return void
 */
function research_updateStatus($id_,$status_)
{
	// Status
	$status_array = array("DEFINITION","PENDING","PROCESS","OBTAINED","POSTPROCESS","END");
	$status_key = array_search($status_,$status_array,true);

	global $conection;

	$sql="UPDATE research SET status='$status_key',date_update=CURRENT_TIMESTAMP WHERE id='$id_'";
	mysql_query($sql,$conection) or die("Error SWRA-MODEL-RESEARCH-007: Research status update query ".mysql_error());
}


/**
 * Updates the size of the origin of data of the research
 *
 * @version     1.0
 * @since       Version 1.0
 *
 * @param int   $id_    Id of the research to obtain
 * @param int   $size_  Number of items in the data
 * @return void
 */
function research_updateSize($id_,$size_)
{
	global $conection;

	$sql="UPDATE research SET size='$size_',date_update=CURRENT_TIMESTAMP WHERE id='$id_';";
	mysql_query($sql,$conection) or die("Error SWRA-MODEL-RESEARCH-008: Size update query ".mysql_error());
}


/**
 * Updates the parameters of the origin of data of the research
 *
 * @version     1.0
 * @since       Version 1.0
 *
 * @param int   $id_    Id of the research to obtain
 * @param string    $parameters_    Parameters of the origin of the data of the research
 * @return void
 */
function research_updateParametersOrigin($id_,$parameters_)
{
	global $conection;

	$sql="UPDATE research SET origin_parameters='$parameters_',date_update=CURRENT_TIMESTAMP WHERE id='$id_';";
	mysql_query($sql,$conection) or die("Error SWRA-MODEL-RESEARCH-009: Input parameters update query ".mysql_error());
}


/**
 * Updates the parameters of the process of data of the research
 *
 * @version     1.0
 * @since       Version 1.0
 *
 * @param int   $id_    Id of the research to obtain
 * @param string    $parameters_    Parameters of the process of the data of the research
 * @return void
 */
function research_updateParametersProcess($id_,$parameters_)
{
	global $conection;

	$sql="UPDATE research SET process_type='$parameters_',date_update=CURRENT_TIMESTAMP WHERE id='$id_';";
	mysql_query($sql,$conection) or die("Error SWRA-MODEL-RESEARCH-010: Input parameters update query ".mysql_error());
}