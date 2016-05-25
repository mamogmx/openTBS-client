<?php
require_once "../init.app.php";
$result = Array("error"=>"0", "fn" => $_POST["action"]);
switch($_POST["action"]){
    case "updateApp":
        $app = $_REQUEST["app"];
        $ext = $_REQUEST["ext"];
        $tab = $_REQUEST["tab"];
        $result["model"] = openTBSApp::getModels($app,$ext);
        $result["data"] = openTBSApp::getData($app);
        $result["tab"] = $tab;
        break;
    case "updateExt":
        $app = $_REQUEST["app"];
        $ext = $_REQUEST["ext"];
        $result["model"] = openTBSApp::getModels($app,$ext);
        break;
    case "loadJson":
        $app = $_REQUEST["app"];
        $dataDir = APPS_DIR.$app.DIRECTORY_SEPARATOR."data".DIRECTORY_SEPARATOR;
        $data = $_REQUEST["file"];
        $dataName = sprintf("%s%s.%s",$dataDir,$data,"json");
        $d = openTBSApp::loadData($dataName);
        $result["data"] = $d;
        $result["filename"] = pathinfo($dataName,PATHINFO_BASENAME);
        break;
    case "loadJsonFile":
        $app = $_REQUEST["app"];
        error_reporting(E_ALL | E_STRICT);
        require(LIB_DIR.'UploadHandler.php');
        $options=Array("upload_dir"=>APPS_DIR.$app.DIRECTORY_SEPARATOR."data".DIRECTORY_SEPARATOR);
        $upload_handler = new UploadHandler($options);
        break;
    case "saveJson":
        $app = $_REQUEST["app"];
        $overwrite = (in_array("overwrite",array_keys($_REQUEST)))?($_REQUEST["overwrite"]):(0);
        $filename = $_REQUEST["filename"];
        $data = $_REQUEST["data"];
        $dataDir = APPS_DIR.$app.DIRECTORY_SEPARATOR."data".DIRECTORY_SEPARATOR;
        $res = openTBSApp::saveData($dataDir.$filename,$data,$overwrite);
        if ($res < 0) {
            $result["error"] = $res;
        }
        break;
    case "createDocument":
        $app = $_REQUEST["app"];
        $ext = $_REQUEST["ext"];
        $data = $_REQUEST["data"];
        $model = $_REQUEST["model"];
        
        $modelDir = APPS_DIR.$app.DIRECTORY_SEPARATOR."modelli".DIRECTORY_SEPARATOR;
        $docDir = DOC_DIR;
        $dataDir = APPS_DIR.$app.DIRECTORY_SEPARATOR."data".DIRECTORY_SEPARATOR;

        $randString = openTBSApp::rndString();
        
        $modelName = sprintf("%s%s.%s",$modelDir,$model,$ext);
        $docName = sprintf("%s%s-%s.%s",$docDir,$randString,$model,$ext);
        $dataName = sprintf("%s%s.%s",$dataDir,$data,"json");
        
        require_once LIB_DIR."tbs_class.php";
        require_once LIB_DIR."tbs_plugin_opentbs.php";
        
        $d = openTBSApp::loadData($dataName);
        if (is_array($d)){
            $TBS = new clsTinyButStrong; // new instance of TBS
            $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
            foreach($d as $key=>$value){
                $TBS->VarRef[$key]=$value;
            }
            $TBS->LoadTemplate($modelName,OPENTBS_ALREADY_UTF8);
            
            foreach($d as $key=>$value){
                
                if(is_array($value)){
                    $TBS->MergeBlock($key, $value);
                }
                else{
                    $TBS->MergeField($key, $value);
                }
            }
            $TBS->Show(OPENTBS_FILE, $docName);
            $result["file"] = sprintf("%s%s-%s.%s",DOCUMENT_URL,$randString,$model,$ext);
            $result["model"] = sprintf("%s.%s",$model,$ext);
        }
        
        else{
            $result["error"] = $d;
        }
        
        
        
        break;
}
header('Content-Type: application/json; charset=utf-8');
print json_encode($result);
?>