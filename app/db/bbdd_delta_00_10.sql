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
 * Database schema delta from version 0.0 to 1.0
 * Usage: mysql -u root -p < bbdd_delta_00_10.sql
 *
 * @package		SocialWebResearchAssistant
 * @subpackage  Common
 * @category	DataBase Deltas
 * @version     1.0
 * @since		Version 1.0
 */


--
-- Table `research` structure
--
CREATE TABLE research (
	`id` int(11) NOT NULL auto_increment,
	`name` mediumtext NOT NULL COMMENT 'Name',
	`description` mediumtext NOT NULL COMMENT 'Description',
	`status` enum ('0','1','2','3','4','5') default '0' COMMENT 'Status: 0=Definition, 1=Pending, 2=Process, 3=Obtained, 4=Post-Process, 5=End',
	`erased` enum ('0','1') default '0' COMMENT 'Deleted: 0=Active, 1=Deleted',
	`date_creation` datetime NOT NULL COMMENT 'Date of creation',
	`date_update` datetime NOT NULL COMMENT 'Date of update',
	`origin_type` mediumtext NOT NULL COMMENT 'Data source type',
	`origin_parameters` mediumtext NOT NULL COMMENT 'Data source parameters',
	`origin_date` datetime NOT NULL COMMENT 'Date of data source fetching',
	`size` int(11) COMMENT 'Size of data source',
	`process_type` mediumtext NOT NULL COMMENT 'Type of process',
	`process_date` datetime NOT NULL COMMENT 'Date of processing',
	PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Research';

--
-- Table `origin_data_raw` structure
--
CREATE TABLE origin_data_raw (
	`research` int(11) NOT NULL COMMENT 'Research',
	`data1` longtext COMMENT 'Data 1',
	`data2` longtext COMMENT 'Data 2',
	`data3` longtext COMMENT 'Data 3',
	`fecha` longtext COMMENT 'Date'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Raw data';

--
-- Table `origin_data_raw_temp` structure
--
CREATE TABLE origin_data_raw_temp (
	`research` int(11) NOT NULL COMMENT 'Research',
	`data1` longtext COMMENT 'Data 1',
	`data2` longtext COMMENT 'Data 2',
	`data3` longtext COMMENT 'Data 3',
	`fecha` longtext COMMENT 'Date'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Temporary data';

--
-- Table `research_data` structure
--
CREATE TABLE origin_data (
	`research` int(11) NOT NULL COMMENT 'Research',
	`data1` longtext COMMENT 'Data 1',
	`data2` longtext COMMENT 'Data 2',
	`data3` longtext COMMENT 'Data 3',
	`fecha` longtext COMMENT 'Date'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Data';