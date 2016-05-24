<?php
require_once "init.app.php";
$urlService = SERVICES_DIR."xServer.php";
$urlPrint = SERVICES_DIR."xCreateDocument.php";
$appsJson = json_encode($apps); 
$initScript =<<<EOT
        <script>
            var service_url = '$urlService';
            var print_url = '$urlPrint';
            var applications = $appsJson;
        </script>
EOT;
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Client OpenTBS to test documents MailMerge</title>
    
        <!-- Bootstrap -->
        <link href="css/jquery-ui.min.css" rel="stylesheet">
        <link href="css/bootstrap.min.css" rel="stylesheet">
         <link href="css/jsoneditor.css" rel="stylesheet">
        <script src="js/jquery.js"></script>
        <script src="js/jquery-ui.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jsoneditor.js"></script>
        <script src="js/opentbs.plugin.js"></script>
        
<?php
print $initScript;

?>
        <script src="js/init.js"></script>
  </head>
    </head>
    <body>
        <div>
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#result-div" data-toggle="tab">Applicazione</a></li>
                <li role="presentation"><a href="#model-div" data-toggle="tab">Gestione dei Modelli</a></li>
                <li role="presentation"><a href="#data-div" data-toggle="tab">Gestione dei File Dati</a></li>
            </ul>
            <div class="tab-content">
                <div id="result-div" role="tabpanel" class="tab-pane active">
                    <div class="container-fluid" style="width:90%;margin-top:50px;">
                        <div class="row">
                            <div class="col-md-3">
                                <label for="app">Applicazione</label>
                                <select id="app" data-plugin="">
                                    
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="data">File Dati</label>
                                <select id="data" data-plugin="">
                                    
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="ext">Tipo Modello</label>
                                <select id="ext" data-plugin="">
                                    <option value="docx" selected>File Word</option>
                                    <option value="odt">File OpenOffice</option>
                                </select>                    
                            </div>
                            <div class="col-md-3">
                                <label for="model">Modello</label>
                                <select id="model" data-plugin="">
                                    
                                </select>                    
                            </div>
                        </div>
                        <div class="row" style="margin-top:50px;">
                            <div class="col-md-3">
                                <button id="printBtn" type="button" class="btn btn-default">
                                    <span class="glyphicon glyphicon-print" aria-hidden="true" ></span><span style="margin-left:10px;">Stampa Modello</span>
                                </button>
                            </div>
                            <div class="col-md-9">
                                <div id = "responseDiv"></div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div id="model-div" role="tabpanel" class="tab-pane">
                    <h1>ALFA</h1>
                </div>
                 <div id="data-div" role="tabpanel" class="tab-pane">
                    <div id="data-json" style="height:400px;width:100%;">
                        
                    </div>
                    <div id="data-apps">
                        <div class="container-fluid" style="width:100%;margin-top:50px;">
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="data-app">Applicazione</label>
                                    <select id="data-app" data-plugin="">
                                        
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="data-data">File Dati</label>
                                    <select id="data-data" data-plugin="">
                                        
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <button id="loadDataBtn" type="button" class="btn btn-default">
                                        <span class="glyphicon glyphicon-refresh" aria-hidden="true" ></span><span style="margin-left:10px;">Carica Dati</span>
                                    </button>
                                    <button id="saveDataBtn" type="button" class="btn btn-default disabled">
                                        <span class="glyphicon glyphicon-save" aria-hidden="true" ></span><span style="margin-left:10px;">Salva Dati</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="responseDataDiv">
                        
                    </div>
                    <div id="data-list">
                        
                    </div>
                </div>
            </div>
        </div>
    </body> 
</html>