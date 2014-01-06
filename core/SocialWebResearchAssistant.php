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
 * System initialization and loading of base classes and libraries
 *
 * @package		SocialWebResearchAssistant
 * @subpackage  SocialWebResearchAssistant
 * @category	Init
 * @version     1.0
 * @since		Version 1.0
 */


/**
 * Version
 */
$config["APP_VERSION"] = "1.0";


/*
 * Error Reporting
 */
switch ($config[APP_ENVIRONMENT])
{
	case 'PRODUCTION':
	    error_reporting(0); break;
    case 'DEVELOPMENT':
        error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);break;
    case 'TEST':
    default:
        exit('Application environment is not set correctly.');
}


/**
 * -------------------------------------------------------------------
 *  Core Path Constants
 * -------------------------------------------------------------------
 */
	/**
	 * Framework Common libraries folder name
	 */
	define('CORE_COMMON_FOLDER_NAME', 'common');

	/**
	 * Framework Model libraries folder name
	 */
	define('CORE_MODEL_FOLDER_NAME', 'model');

	/**
	 * Framework Input libraries folder name
	 */
	define('CORE_INPUT_FOLDER_NAME', 'input');

	/**
	 * Framework Process libraries folder name
	 */
	define('CORE_PROCESS_FOLDER_NAME', 'process');

	/**
	 * Framework Output libraries folder name
	 */
	define('CORE_OUTPUT_FOLDER_NAME', 'output');

	/**
	 * Framework Common libraries path
	 */
	if (!is_dir(CORE_INCLUDE_PATH . DS . CORE_COMMON_FOLDER_NAME))
	{
		exit('ERROR: Framework core common libraries not found in the path configured');
	} else {
		define('CORE_COMMON_INCLUDE_PATH',CORE_INCLUDE_PATH . DS . CORE_COMMON_FOLDER_NAME);
	}

	/**
	 * Framework Model libraries path
	 */
	if (!is_dir(CORE_INCLUDE_PATH . DS . CORE_MODEL_FOLDER_NAME))
	{
		exit('ERROR: Framework core model libraries not found in the path configured');
	} else {
		define('CORE_MODEL_INCLUDE_PATH',CORE_INCLUDE_PATH . DS . CORE_MODEL_FOLDER_NAME);
	}

	/**
	 * Framework Input libraries path
	 */
	if (!is_dir(CORE_INCLUDE_PATH . DS . CORE_INPUT_FOLDER_NAME))
	{
		exit('ERROR: Framework core input libraries not found in the path configured');
	} else {
		define('CORE_INPUT_INCLUDE_PATH',CORE_INCLUDE_PATH . DS . CORE_INPUT_FOLDER_NAME);
	}

	/**
	 * Framework Process libraries path
	 */
	if (!is_dir(CORE_INCLUDE_PATH . DS . CORE_PROCESS_FOLDER_NAME))
	{
		exit('ERROR: Framework core process libraries not found in the path configured');
	} else {
		define('CORE_PROCESS_INCLUDE_PATH',CORE_INCLUDE_PATH . DS . CORE_PROCESS_FOLDER_NAME);
	}

	/**
	 * Framework Output libraries path
	 */
	if (!is_dir(CORE_INCLUDE_PATH . DS . CORE_OUTPUT_FOLDER_NAME))
	{
		exit('ERROR: Framework core output libraries not found in the path configured');
	} else {
		define('CORE_OUTPUT_INCLUDE_PATH',CORE_INCLUDE_PATH . DS . CORE_OUTPUT_FOLDER_NAME);
	}


/**
 * Instantiate plugins
 */
// Input plugins
$swra_input_plugins = array();
// Process plugins
$swra_process_plugins = array();
// Output plugins
$swra_output_plugins = array();


/**
 * Loading common libraries
 */
require_once CORE_COMMON_INCLUDE_PATH .DS . 'swra_common.inc.php';

/**
 * Loading model libraries
 */
require_once CORE_MODEL_INCLUDE_PATH .DS . 'swra_model.inc.php';

/**
 * Loading input plugins libraries
 */
require_once CORE_INPUT_INCLUDE_PATH .DS . 'swra_input.inc.php';

/**
 * Loading process plugins libraries
 */
require_once CORE_PROCESS_INCLUDE_PATH .DS . 'swra_process.inc.php';

/**
 * Loading output plugins libraries
 */
require_once CORE_OUTPUT_INCLUDE_PATH .DS . 'swra_output.inc.php';