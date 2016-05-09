<?php

define("BASE_DIR",dirname(__FILE__).DIRECTORY_SEPARATOR);
define("LIB_DIR",BASE_DIR."lib".DIRECTORY_SEPARATOR);
define("APPS_DIR",BASE_DIR."apps".DIRECTORY_SEPARATOR);
define("DOC_DIR",BASE_DIR."documenti".DIRECTORY_SEPARATOR);
define("SERVICES_DIR",dirname($_SERVER['PHP_SELF'])."/services/");
define("DOCUMENT_URL",dirname(dirname($_SERVER['PHP_SELF']))."/documenti/");
require_once LIB_DIR."app.class.php";
$apps = openTBSApp::getApplications();

?>