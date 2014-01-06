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
 * Common Framework libraries
 *
 * @package		SocialWebResearchAssistant
 * @subpackage  Common
 * @category	Init
 * @version     1.0
 * @since		Version 1.0
 */


/**
 * Loading of database conection library
 */
require_once CORE_COMMON_INCLUDE_PATH . DS . 'db/conection.inc.php';

/**
 * Loading of date and time format library
 */
require_once CORE_COMMON_INCLUDE_PATH . DS .  'format/datetime.inc.php';

/**
 * Loading of number format library
 */
require_once CORE_COMMON_INCLUDE_PATH . DS .  'format/number.inc.php';

/**
 * Loading of scrapping library
 */
require_once CORE_COMMON_INCLUDE_PATH . DS . 'scrapping/scapping.inc.php';