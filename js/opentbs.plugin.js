$.widget("gw.openTBS",{
    options: {
        'application_bookmark': 'app',
        'datafile_bookmark': 'data',
        'extension_bookmark': 'ext',
        'model_bookmark': 'model',
        'load_app_bookmark': 'data-app',
        'load_data_bookmark': 'data-data',
        'print': 'printBtn',
        'loadData': 'loadDataBtn',
        'loadDataFile': 'loadDataFileBtn',
        'saveData': 'saveDataBtn',
        'response': 'responseDiv',
        'responseData': 'responseDataDiv',
        'applications': [],
        'url_server': '',
        'url_print': '',
        'json_data': null
    },
    self : this,
    _create: function() {
        this.application = $("#"+this.options["application_bookmark"]);
        this.datafile = $("#"+this.options["datafile_bookmark"]);
        this.extension = $("#"+this.options["extension_bookmark"]);
        this.model = $("#"+this.options["model_bookmark"]);
        this.print = $("#"+this.options["print"]);
        this.response = $("#"+this.options["response"]);
        
        this.loadapplication = $("#"+this.options["load_app_bookmark"]);
        this.loaddatafile = $("#"+this.options["load_data_bookmark"]);
        this.loadDataBtn = $("#"+this.options["loadData"]);
        this.loadDataFileBtn = $("#"+this.options["loadDataFile"]);
        this.saveDataBtn = $("#"+this.options["saveData"]);
        
        this.json_data = this.options["json_data"];
        
        var html = '<option value="" selected>Seleziona un\'applicazione</option>';
        $.each(this.options.applications,function(k,v){
           html+='<option value="' + v + '">'+ v + '</option>';
        });
        $(this.application).html(html);
        $(this.loadapplication).html(html);
        this._update();
        return this;
    },

    _update: function() {
        var self = this;
        $(this.application).unbind("change")
        $(this.application).bind("change",function(){
            self.updateApp($(self.application).val(),$(self.extension).val(),'print');
        });
        /*$(this.datafile).unbind("change")
        $(this.datafile).bind("change",function(){
            alert(this.id);
        });*/
        $(this.extension).unbind("change")
        $(this.extension).bind("change",function(){
            self.updateExt($(self.application).val(),$(self.extension).val());
        });
        $(this.print).unbind("click")
        $(this.print).bind("click",function(event){
            self.createDocument($(self.application).val(),$(self.datafile).val(),$(self.extension).val(),$(self.model).val());
        });
        $(this.loadapplication).unbind("change")
        $(this.loadapplication).bind("change",function(){
            self.updateApp($(self.loadapplication).val(),null,'data');
        });
        $(this.loadDataBtn).unbind("click")
        $(this.loadDataBtn).bind("click",function(event){
            self.loadJson($(self.loadapplication).val(),$(self.loaddatafile).val());
        });
        $(this.loadDataFileBtn).unbind("click")
        $(this.loadDataFileBtn).bind("click",function(event){
            self.loadFileJson($(self.application).val());
        });
        $(this.saveDataBtn).unbind("click")
        $(this.saveDataBtn).bind("click",function(event){
            self.saveJson($(self.loadapplication).val(),$(self.loaddatafile).val());
        });
        console.log(this.loadData);
    },
    updateApp: function(app,ext,tab){
        var self = this;
        $.ajax(this.options.url_server,{
            'data':{
                'app': app,
                'ext': ext,
                'tab': tab,
                'action': 'updateApp'
            },
            'method': 'POST',
            success: self.responseApp.bind(self)
        });
    },
    updateExt: function(app,ext,tab){
        var self = this;
        $.ajax(this.options.url_server,{
            'data':{
                'app': app,
                'ext': ext,
                'tab': tab,
                'action': 'updateExt'
            },
            'method': 'POST',
            success: self.responseApp.bind(self)
        });
    },
    createDocument: function(app,data,ext,model){
        var self = this;
        $(self.response).html('');
        $.ajax(this.options.url_server,{
            'data':{
                'app': app,
                'ext': ext,
                'data': data,
                'model': model,
                'action': 'createDocument'
            },
            'method': 'POST',
            success: self.responseApp.bind(self)
        });
    },
    loadJson: function(app,filename){
        var self = this;
        $(self.responseData).html('');
        $.ajax(this.options.url_server,{
            'data':{
                'app': app,
                'file': filename,
                'action': 'loadJson'
            },
            'method': 'POST',
            success: self.responseApp.bind(self)
        });
    },
    loadJsonFile: function(){
        
    },
    saveJson: function(app,filename){
        
    },
    
    responseApp: function(data,textStatus,jqXHR){
        var self = this;
        switch (data["fn"]) {
            case "updateApp":
                if(data["model"].length == 0){
                    var html = '<option value="">Nessun modello trovato</option>';
                }
                else{
                    var html = '';
                    $.each(data["model"],function(k,v){
                        html += '<option value="' + v + '">' + v + '</option>';
                    });
                }
                if (data["tab"]=='print'){
                    $(self.model).html(html);
                }
                if(data["data"].length == 0){
                    var html= '<option value="">Nessun file dati trovato</option>';
                }
                else{
                    var html = '';
                    $.each(data["data"],function(k,v){
                        html += '<option value="' + v + '">' + v + '</option>';
                    });
                    
                }
                if (data["tab"]=="print"){
                    $(self.datafile).html(html);
                }
                else if (data["tab"]=='data') {
                    $(self.loaddatafile).html(html);
                }
                break;
            case "updateExt":
                if(data["model"].length == 0){
                    var html = '<option value="">Nessun modello trovato</option>';
                }
                else{
                    var html = '';
                    $.each(data["model"],function(k,v){
                        html += '<option value="' + v + '">' + v + '</option>';
                    });
                }
                $(self.model).html(html);
                break;
            case "createDocument":
                if (data["error"]==0) {
                     var d = new Date();
                    var html = '<a target="_new" href="' + data["file"] + '"> Ore ' + d.toLocaleTimeString() + '. E\' stato generato il documento a partire dal modello ' + data['model'] + '</a>';
                }
                else{
                    var html = data["error"];
                }
                $(self.response).html(html);
                break;
            case "loadJson":
                if (data["error"]==0) {
                    self.json_data.set(data["data"]);
                }
                else{
                    var html = data["error"];
                }
                $(self.responseData).html(html);
            default:
                console.log(data);
                break;
        }
    }
    
});