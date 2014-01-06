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
 * Database conections library
 *
 * @package		SocialWebResearchAssistant
 * @subpackage  Common
 * @category	DDBB Conection
 * @version     1.0
 * @since		Version 1.0
 */


/**
 * Opens a conection with the Database defined in configuration
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param  string   $environment_   Environment (PRODUCTION = production, DEVELOPMENT = development, TEST = test)
 * @return object   Conection with Database
 */
function conection_open($environment_ = '')
{
    // Configuration data
    global $config;

    // Environment
    if($environment_ == '')
    {
        $app_environment = $config["APP_ENVIRONMENT"];
    }

    // Database conection data
    $dbhost = $config["DATABASE"][$app_environment]["HOST"];        // Database host
    $dbuser = $config["DATABASE"][$app_environment]["USER"];		// Database username
    $dbpassword = $config["DATABASE"][$app_environment]["PASSWORD"];// Database user password
    $dbname = $config["DATABASE"][$app_environment]["DBNAME"];      // Database name

    // Conection creation
    if(!$conection = mysql_connect($dbhost, $dbuser, $dbpassword))
    {
		return false;
    }

    // Selection of database
    $dbselected = mysql_select_db($dbname, $conection);
    if(!$dbselected)
    {
		return false;
    }

    // Conection encoding parameters
    # Set character_set_results
    mysql_query("SET character_set_results=utf8", $conection);
    # Set character_set_client
    mysql_query("SET character_set_client=utf8", $conection);
    # Set character_set_connection
    mysql_query("SET character_set_connection=utf8", $conection);

    return $conection;
}


/**
 * Opens a conection with a Database
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param  string   $host_   Environment (PRODUCTION = production, DEVELOPMENT = development, TEST = test)
 * @return object   Conection with Database
 */
function conection_create($host_, $user_, $password_, $name_)
{

    // Database conection data
    $dbhost = $host_;           // Database host
    $dbuser = $user_;		    // Database username
    $dbpassword = $password_;   // Database user password
    $dbname = $name_;           // Database name

    // Conection creation
    if(!$conection = mysql_connect($dbhost, $dbuser, $dbpassword))
    {
		return false;
    }

    // Selection of database
    $dbselected = mysql_select_db($dbname, $conection);
    if(!$dbselected)
    {
		return false;
    }

    // Conection encoding parameters
    # Set character_set_results
    mysql_query("SET character_set_results=utf8", $conection);
    # Set character_set_client
    mysql_query("SET character_set_client=utf8", $conection);
    # Set character_set_connection
    mysql_query("SET character_set_connection=utf8", $conection);

    return $conection;
}


/**
 * Closes a Database conection
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param  object   $conection_ Database conection
 * @return  void
 */
function conection_close($conection_)
{
	// Database closing
	mysql_close($conection_);
}