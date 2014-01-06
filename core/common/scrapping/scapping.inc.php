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
 * Scrapping library
 *
 * @package		SocialWebResearchAssistant
 * @subpackage  Common
 * @category	Scrapping
 * @version     1.0
 * @since		Version 1.0
 */


/**
 * Obtains the contents of an Url using cUrl
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param  string   $path_      Url of the web for scrapping
 * @param  string   $cookie_    Cookie needed for scrapping the web
 * @return string   Scrapped text from the Url
 */
function requestHTTP($path_, $cookie_= ''){

    $curl_handle_ = curl_init();
    $curl_timeout_ = 10; // 0 for no timeout

    // cURL of the web
    if (empty($cookie_)) {
		curl_setopt ($curl_handle_, CURLOPT_URL, $path_);
		curl_setopt ($curl_handle_, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($curl_handle_, CURLOPT_CONNECTTIMEOUT, $curl_timeout_);
		curl_setopt ($curl_handle_, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.9) Gecko/20071025 Firefox/2.0.0.9');
    } else {
		curl_setopt ($curl_handle_, CURLOPT_URL, $path_);
		curl_setopt ($curl_handle_, CURLOPT_RETURNTRANSFER, true);
		curl_setopt ($curl_handle_, CURLOPT_COOKIESESSION, false);
		curl_setopt ($curl_handle_, CURLOPT_CONNECTTIMEOUT, $curl_timeout_);
		curl_setopt ($curl_handle_, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.9) Gecko/20071025 Firefox/2.0.0.9');
		curl_setopt ($curl_handle_, CURLOPT_COOKIE, $cookie_);
		curl_setopt ($curl_handle_, CURLOPT_REFERER, $path_);
		curl_setopt ($curl_handle_, CURLOPT_HEADER, false);
    }

    $curl_buffer_ = curl_exec($curl_handle_);
    curl_close($curl_handle_);

    return $curl_buffer_;
}


/**
 * Obtains the contents of a file
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param  string   $path_      Path and name of the file
 * @return string   Scrapped text from the file
 */
function requestFile($path_)
{
	$content = file_get_contents($path_);

    return $content;
}


/**
 * Cleans a text of characters which causes problems in SQL injection
 *
 * @version     1.0
 * @since		Version 1.0
 *
 * @param  string   $text_      Text to be cleaned
 * @param  boolean  $encode_    Encoding to UTF-8 (true=encodes | false=no encoding done)
 * @return string   Sanitized text
 */
function sanitizeSQLText($text_, $encode_ = true) {

    // Cleaning of quotes, double quotes and hyphens
    $text_ = str_replace("'","''",$text_);
    $text_ = str_replace("’","''",$text_);
    $text_ = str_replace('""','"',$text_);
    $text_ = str_replace('"','""',$text_);

    /*
    // Sanitation of HTML accents
    $text_ = str_replace('&aacute;','á',$text_);
    $text_ = str_replace('&eacute;','é',$text_);
    $text_ = str_replace('&iacute;','í',$text_);
    $text_ = str_replace('&oacute;','ó',$text_);
    $text_ = str_replace('&iacute;','ú',$text_);

    $text_ = str_replace('&Aacute;','Á',$text_);
    $text_ = str_replace('&Eacute;','É',$text_);
    $text_ = str_replace('&Iacute;','Í',$text_);
    $text_ = str_replace('&Oacute;','Ó',$text_);
    $text_ = str_replace('&Uacute;','Ú',$text_);

    $text_ = str_replace('&agrave;','à',$text_);
    $text_ = str_replace('&egrave;','è',$text_);
    $text_ = str_replace('&iagrave;','ì',$text_);
    $text_ = str_replace('&oagrave;','ò',$text_);
    $text_ = str_replace('&uagrave;','ù',$text_);

    $text_ = str_replace('&agrave;','À',$text_);
    $text_ = str_replace('&Egrave;','È',$text_);
    $text_ = str_replace('&Igrave;','Ì',$text_);
    $text_ = str_replace('&Ograve;','Ò',$text_);
    $text_ = str_replace('&Ugrave;','Ù',$text_);

    $text_ = str_replace('&acirc;','â',$text_);
    $text_ = str_replace('&ecirc;','ê',$text_);
    $text_ = str_replace('&icirc;','î',$text_);
    $text_ = str_replace('&ocirc;','ô',$text_);
    $text_ = str_replace('&ucirc;','û',$text_);

    $text_ = str_replace('&Acirc;','Â',$text_);
    $text_ = str_replace('&Ecirc;','Ê',$text_);
    $text_ = str_replace('&Icirc;','Î',$text_);
    $text_ = str_replace('&Ocirc;','Ô',$text_);
    $text_ = str_replace('&Ucirc;','Û',$text_);
    */

    // UTF-8 encoding
    if ($encode_) { $text_ = utf8_encode($text_); }

    return $text_;
}