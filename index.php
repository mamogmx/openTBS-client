<?php
require_once "init.app.php";
$urlService = SERVICES_DIR."xServer.php";
$urlPrint = SERVICES_DIR."xCreateDocument.php";
$appsJson = json_encode($apps);
$modelsJson = json_encode($tree);
$initScript =<<<EOT
        <script>
            var service_url = '$urlService';
            var print_url = '$urlPrint';
            var applications = $appsJson;
            var models = $modelsJson;
            
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
        <link href="css/bootstrap-treeview.css" rel="stylesheet">
        <link href="css/jsoneditor.css" rel="stylesheet">
        <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
        <link rel="stylesheet" href="css/jquery.fileupload.css">
        <link rel="stylesheet" href="css/jquery.fileupload-ui.css">
        <!-- CSS adjustments for browsers with JavaScript disabled -->
        <noscript><link rel="stylesheet" href="css/jquery.fileupload-noscript.css"></noscript>
        <noscript><link rel="stylesheet" href="css/jquery.fileupload-ui-noscript.css"></noscript>
        <link rel="stylesheet" href="css/style.css">
        
<?php
print $initScript;

?>
        
  </head>
    </head>
    <body>
        <div>
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#result-div" data-toggle="tab">Applicazione</a></li>
                <li role="presentation"><a href="#model-div" data-toggle="tab">Gestione dei Modelli</a></li>
                <li role="presentation"><a href="#data-div" data-toggle="tab">Gestione dei File Dati</a></li>
                <li role="presentation"><a href="#app-div" data-toggle="tab">Gestione delle Applicazioni</a></li>
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
                
            <!-- GESTIONE DEI FILE E DELLE CARTELLE DELLE APPLICAZIONI -->                
                
                <div id="model-div" role="tabpanel" class="tab-pane">
                    <h1>Gestione dei Modelli di Stampa</h1>
                    <div class="container-fluid" style="width:90%;margin-top:50px;">
                        <div class="row">

                            <div class="col-md-8">
                                <div id="tree-model" style="height:400px;width:100%;">
                            
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row vertical-row">
                                    <div class="col-md-12">
                                        <label for="data-fileupload">File Dati</label>
                                        <span class="btn btn-success fileinput-button pull-right">
                                            <i class="glyphicon glyphicon-plus"></i>
                                            <span>Seleziona un file ....</span>
                                            <!-- The file input field used as target for the file upload widget -->
                                            <input id="fileupload"" type="file" name="files[]" multiple>
                                        </span>
                                        <!--<input type="file" id=" name="files[]" class="pull-right" data-plugin="" />-->
                                    </div>
                                </div>
                                <div class="row vertical-row">
                                    <div class="col-md-12">
                                        <div id="progress" class="progress">
                                            <div class="progress-bar progress-bar-success"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row vertical-row">
                                    <div class="col-md-12">
                                        <!-- The container for the uploaded files -->
                                        <div id="files" class="files"></div>
                                    </div>
                                </div>
                                <div class="row vertical-row">
                                    <div class="col-md-12">
                                        
                                        <button id="loadFileModelBtn" type="button" class="btn btn-default">
                                            <span class="glyphicon glyphicon-save" aria-hidden="true" ></span><span style="margin-left:10px;">Carica File Dati</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="data-div" role="tabpanel" class="tab-pane">
                    <div class="container-fluid" style="width:90%;margin-top:50px;">
                        <div class="row">
                            <div class="col-md-8">
                                <div id="data-json" style="height:400px;width:100%;">
                            
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div id="data-apps">
                                    <div class="row vertical-row">
                                        <div class="col-md-12">
                                            <label for="data-app">Applicazione</label>
                                            <select id="data-app" class="pull-right" data-plugin="">
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row vertical-row">
                                        <div class="col-md-12">
                                            <label for="data-data">File Dati</label>
                                            <select id="data-data" class="pull-right" data-plugin="">
                                            
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row vertical-row">
                                        <div class="col-md-12">
                                            <label for="data-filename">Nome File</label>
                                            <input type="text" id="data-filename" class="pull-right" data-plugin="" />
                                        </div>
                                    </div>
                                    <div class="row vertical-row">
                                        <div class="col-md-12">
                                            <label for="data-fileupload">File Dati</label>
                                            <span class="btn btn-success fileinput-button pull-right">
                                                <i class="glyphicon glyphicon-plus"></i>
                                                <span>Seleziona un file ....</span>
                                                <!-- The file input field used as target for the file upload widget -->
                                                <input id="fileupload"" type="file" name="files[]" multiple>
                                            </span>
                                            <!--<input type="file" id=" name="files[]" class="pull-right" data-plugin="" />-->
                                        </div>
                                    </div>
                                    <div class="row vertical-row">
                                        <div class="col-md-12">
                                            <div id="progress" class="progress">
                                                <div class="progress-bar progress-bar-success"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row vertical-row">
                                        <div class="col-md-12">
                                            <!-- The container for the uploaded files -->
                                            <div id="files" class="files"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="row vertical-row">
                                        <div class="col-md-12">
                                            <button id="loadDataBtn" type="button" class="btn btn-default">
                                                <span class="glyphicon glyphicon-refresh" aria-hidden="true" ></span><span style="margin-left:10px;">Carica Dati</span>
                                            </button>
                                            <button id="saveDataBtn" type="button" class="btn btn-default">
                                                <span class="glyphicon glyphicon-save" aria-hidden="true" ></span><span style="margin-left:10px;">Salva Dati</span>
                                            </button>
                                            <button id="loadFileDataBtn" type="button" class="btn btn-default">
                                                <span class="glyphicon glyphicon-save" aria-hidden="true" ></span><span style="margin-left:10px;">Carica File Dati</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="responseDataDiv">
                        
                    </div>
                    <div id="data-list">
                        
                    </div>
                </div>
                <div id="app-div" role="tabpanel" class="tab-pane">
                    <h1>Gestione Applicazioni</h1>
                </div>
            </div>
        </div>
        
        <script src="js/jquery.js"></script>
        <script src="js/jquery-ui.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/bootstrap-treeview.js"></script>
        <script src="js/jsoneditor.js"></script>
        <script src="js/opentbs.plugin.js"></script>
        <script src="js/jquery.iframe-transport.js"></script>
        <!-- The basic File Upload plugin -->
        <script src="js/jquery.fileupload.js"></script>

        
        <script src="js/init.js"></script>
        
    </body> 
</html>