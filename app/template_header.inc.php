<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
    /**
     * Loading configuration file
     */
	require_once dirname(__FILE__) . '/config/config.inc.php';

	/**
	 * Loading Framework Core
	 */
	require_once CORE_INCLUDE_PATH . DS . 'SocialWebResearchAssistant.php';

	/**
	 * Conection with Database
	 */
	$conection = conection_open();
	?>

	<title>Social Web Research Assistant</title>

	<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon" />
	<link rel="icon" href="images/favicon.ico" type="image/x-icon" />

	<link rel="stylesheet" type="text/css" media="all" href="css/styles.css" />

	<meta http-equiv="Content-Type" content="text/html;charset=ISO-8859-1" />
</head>
<body>

    <div id="header">
        <h1><a href="./research_list.php">Social Web <span>Research Assistant</span></a></h1>
        <h2>Escuela Andaluza de Salud Publica (EASP)</h2>
    </div>