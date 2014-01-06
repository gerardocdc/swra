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
 * Date and time format library
 *
 * @package		SocialWebResearchAssistant
 * @subpackage  Common
 * @category	Number
 * @version     1.0
 * @since		Version 1.0
 */


/**
 * Formats a number with selected decimal numbers
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param  float    $numero_                Number to format
 * @param  integer  $cifrassignificativa_   Decimal numbers to show
 * @return float    Formatted number
 */
function format_number($numero_,$cifrasignificativa_)
{
	$numfinal="";
	$longitud=strlen($numero_);
	if ($longitud<$cifrasignificativa_) {
		$numeroceros=$cifrasignificativa_-$longitud;
		for ($i=1;$i<=($numeroceros);$i++) {
			$numfinal=$numfinal."0";
		}
		$numfinal=$numfinal.$numero_;
	}

	if ($longitud>=$cifrasignificativa_) {
		$numfinal=$numero_;
	}

	return $numfinal;
}