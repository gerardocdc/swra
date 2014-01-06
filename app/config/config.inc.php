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
 * Configuration
 *
 * @package		SocialWebResearchAssistant
 * @subpackage  Common
 * @category	Config
 * @version     1.0
 * @since		Version 1.0
 */


// ---------------------------------------------------------------------
// APPLICATION CONFIGURABLE SETTINGS (START).  EDIT BELOW THIS LINE
// ---------------------------------------------------------------------

/**
 * Environment
 */
$config["APP_ENVIRONMENT"] = 'DEVELOPMENT';		// PRODUCTION, DEVELOPMENT, TEST


/**
 * Databases
 */
	/**
	 * Production Database
	 */
	$config["DATABASE"]["PRODUCTION"]["TYPE"] = 'MYSQL';		    // Database type
	$config["DATABASE"]["PRODUCTION"]["HOST"] = 'host.domain.com';  // Database host
	$config["DATABASE"]["PRODUCTION"]["DBNAME"] = 'ddbbname';	    // Database name
	$config["DATABASE"]["PRODUCTION"]["USER"] = 'ddbbuser';	        // Database username
	$config["DATABASE"]["PRODUCTION"]["PASSWORD"] = 'ddbbpassword'; // Database user password

	/**
	 * Development Database
	 */
	$config["DATABASE"]["DEVELOPMENT"]["TYPE"] = 'MYSQL';		    // Database type
	$config["DATABASE"]["DEVELOPMENT"]["HOST"] = 'localhost';	    // Database host
	$config["DATABASE"]["DEVELOPMENT"]["DBNAME"] = 'swra';	        // Database name
	$config["DATABASE"]["DEVELOPMENT"]["USER"] = 'swra';	        // Database username
	$config["DATABASE"]["DEVELOPMENT"]["PASSWORD"] = 'swra';	    // Database user password

	/**
	 * Test Database
	 */
	$config["DATABASE"]["TEST"]["TYPE"] = 'MYSQL';		            // Database type
	$config["DATABASE"]["TEST"]["HOST"] = 'host.domain.com';	    // Database host
	$config["DATABASE"]["TEST"]["DBNAME"] = 'ddbbnametest';	        // Database name
	$config["DATABASE"]["TEST"]["USER"] = 'ddbbusertest';	        // Database username
	$config["DATABASE"]["TEST"]["PASSWORD"] = 'ddbbpasswordtest';   // Database user password

// ---------------------------------------------------------------------
// APPLICATION CONFIGURABLE SETTINGS (END).  DO NOT EDIT BELOW THIS LINE
// ---------------------------------------------------------------------


/**
 *  Main Path Constants
 */
	/**
	 * Directory separator
	 */
	define('DS', DIRECTORY_SEPARATOR);

	/**
	 * Root directory path
	 */
	define('ROOT', dirname(dirname(dirname(__FILE__))));

	/**
	 * Framework folder name
	 */
	define('CORE_FOLDER_NAME', 'core');

	/**
	 * Application folder name
	 */
	define('APP_FOLDER_NAME', 'app');

	/**
	 * Libraries folder name
	 */
	define('LIB_FOLDER_NAME','lib');

	/**
	 * Framework path
	 */
	if (!is_dir(ROOT . DS . CORE_FOLDER_NAME))
	{
		exit('ERROR: Framework core not found in the path configured');
	} else {
		define('CORE_INCLUDE_PATH', ROOT . DS . CORE_FOLDER_NAME);
	}

	/**
	 * Application path
	 */
	if (!is_dir(ROOT . DS . APP_FOLDER_NAME))
	{
		exit('ERROR: Application not found in the path configured');
	} else {
		define('APP_INCLUDE_PATH', ROOT . DS . APP_FOLDER_NAME);
	}

	/**
	 * Library path
	 */
	if (!is_dir(ROOT . DS . LIB_FOLDER_NAME))
	{
		exit('ERROR: Libraries not found in the path configured');
	} else {
		define('LIB_INCLUDE_PATH', ROOT . DS . LIB_FOLDER_NAME);
	}


/**
 * Pagination
 */
$config["PAGINATION"]["MAX_ELEMENTS"] = 10;