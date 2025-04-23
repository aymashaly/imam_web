<?php  // Moodle configuration file

unset($CFG);
global $CFG;
$CFG = new stdClass();

$CFG->dbtype    = 'mysqli';
$CFG->dblibrary = 'native';
$CFG->dbhost    = '13.39.95.238';
$CFG->dbname    = 'tofaha_i';
$CFG->dbuser    = 'tofaha';
$CFG->dbpass    = 'aA@981031';
$CFG->prefix    = 'mdl_';
$CFG->dboptions = array (
  'dbpersist' => 0,
  'dbport' => '3306',
  'dbsocket' => '',
  'dbcollation' => 'utf8mb4_general_ci',
);
@error_reporting(E_ALL );
@ini_set('display_errors', '1');
$CFG->debug = (E_ALL);
$CFG->debugdisplay = true;
$CFG->wwwroot   = 'http://imam.themistlabs.com';
$CFG->dataroot  = '/var/www/imam_moodledata';
$CFG->admin     = 'admin';
$CFG->disableupgradewarning = true;
$CFG->directorypermissions = 0777;

require_once(__DIR__ . '/lib/setup.php');

// There is no php closing tag in this file,
// it is intentional because it prevents trailing whitespace problems!
