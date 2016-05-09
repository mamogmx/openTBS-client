<?php
class openTBSApp{
    static function getApplications(){
        $result = Array();
        foreach(glob(APPS_DIR."*",GLOB_ONLYDIR) as $d) $result[]=pathinfo($d,PATHINFO_FILENAME);
        return $result;
    }
    static function getModels($app,$ext="docx"){
        $result = Array();
        $dir = APPS_DIR.$app.DIRECTORY_SEPARATOR."modelli".DIRECTORY_SEPARATOR;
        foreach(glob($dir."*.".$ext) as $d) $result[]=pathinfo($d,PATHINFO_FILENAME);
        return $result;
    }
    static function getData($app){
        $result = Array();
        $dir = APPS_DIR.$app.DIRECTORY_SEPARATOR."data".DIRECTORY_SEPARATOR;
        foreach(glob($dir."*.json") as $d) $result[]=pathinfo($d,PATHINFO_FILENAME);
        return $result;
    }
    
    static function loadData($filename){
        if (!file_exists($filename)) return -1;
        $f = fopen($filename,'r');
        $text = fread($f,filesize($filename));
        fclose($f);
        $data = json_decode($text,TRUE);
        if ($data === NULL || $data === 'FALSE') {
            switch (json_last_error()) {
                case JSON_ERROR_NONE:
                    return 'No errors';
                break;
                case JSON_ERROR_DEPTH:
                    return 'Maximum stack depth exceeded';
                break;
                case JSON_ERROR_STATE_MISMATCH:
                    return 'Underflow or the modes mismatch';
                break;
                case JSON_ERROR_CTRL_CHAR:
                    return 'Unexpected control character found';
                break;
                case JSON_ERROR_SYNTAX:
                    return 'Syntax error, malformed JSON';
                break;
                case JSON_ERROR_UTF8:
                    return 'Malformed UTF-8 characters, possibly incorrectly encoded';
                break;
                default:
                    return 'Unknown error';
                break;
            }
        }
        
        return $data;
    }
    
    static function rndString($length = 10,$onlyNumbers=1) {
        $characters = ($onlyNumbers==1)?('0123456789'):('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

?>