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

	swra_output_plugins_execute($_GET[output],$_POST);
?>