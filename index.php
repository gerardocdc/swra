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
 * Landing page and domain redirection
 *
 * @package		SocialWebResearchAssistant
 * @subpackege  Common
 * @category	Landing
 * @version     1.0
 * @since		Version 1.0
 */


/**
 * -------------------------------------------------------------------
 *  App Path Constants
 * -------------------------------------------------------------------
 */
	/**
	 * Directory separator
	 */
	define('DS', DIRECTORY_SEPARATOR);

	/**
	 * Root directory path
	 */
	define('ROOT', dirname(__FILE__));

	/**
	 * Application folder name
	 */
	define('APP_FOLDER_NAME', 'app');

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
 * Redirection to dashboard
 */
header("Location: " . APP_FOLDER_NAME . DS . "index.php");