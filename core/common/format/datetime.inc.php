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
 * @category	DateTime
 * @version     1.0
 * @since		Version 1.0
 */


/**
 * Converts date from MySql format aaaa-mm-dd to format dd/mm/aaaa
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param  string   $fecm_  Date in MySql format aaaa-mm-dd
 * @return string           Date in format dd/mm/aaa
 */
function date_mysql_to_simple($fecm_)
{
	$fecm_ = ltrim($fecm_);
	$fecm_ = rtrim($fecm_);
	if ($fecm_=="0000-00-00") { return; }
	$fecp = "";
	$fecp = substr($fecm_,8,2)."/".substr($fecm_,5,2)."/".substr($fecm_,0,4);
	return $fecp;
}


/**
 * Converts date from format dd/mm/aaaa to MySql format aaaa-mm-dd
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param  string   $fecp_  Date in format dd/mm/aaa
 * @return string           Date in MySql format aaaa-mm-dd
 */
function date_simple_to_mysql($fecp_)
{
	$fecp_ = ltrim($fecp_);
	$fecp_ = rtrim($fecp_);
	$posbarradiames=strpos($fecp_,'/');
	$posbarramesano=strpos($fecp_,'/',$posbarradiames+1);
	$fecm = "";
	$fecmd=format_number(substr($fecp_,0,$posbarradiames),2);
	$fecmm=format_number(substr($fecp_,$posbarradiames+1,$posbarramesano-($posbarradiames+1)),2);
	$fecma=substr($fecp_,$posbarramesano+1,4);
	$fecm=$fecma."-".$fecmm."-".$fecmd;
	return $fecm;
}


/**
 * Converts time from MySql format hh:mm:ss to format hh:mm
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param  string   $horam_  Hour in MySql format hh:mm:ss
 * @return string            Hour in format hh:mm
 */
function time_mysql_to_simple($horam_)
{
	$horam_ = ltrim($horam_);
	$horam_ = rtrim($horam_);
	if ($horam_=="00:00:00") { return; }
	$horap = "";
	$horap = substr($horam_,0,2).":".substr($horam_,3,2);
	return $horap;
}


/**
 * Converts time from format hh:mm to MySql format hh:mm:ss
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param  string   $horap_ Hour in format hh:mm
 * @return string           Hour in MySql format hh:mm:ss
 */
function time_simple_to_mysql($horap_)
{
	$horap_ = ltrim($horap_);
	$horap_ = rtrim($horap_);
	$pospuntoshoraminuto=strpos($horap_,':');
	$horam = "";
	$horamh=format_number(substr($horap_,0,$pospuntoshoraminuto),2);
	$horamm=format_number(substr($horap_,$pospuntoshoraminuto+1,strlen($horap_)-($pospuntoshoraminuto+1)),2);
	$horams="00";
	$horam=$horamh.":".$horamm.":".$horams;
	return $horam;
}