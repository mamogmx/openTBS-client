$.widget("gw.openTBS",{
    options: {
        'application_bookmark': 'app',
        'datafile_bookmark': 'data',
        'extension_bookmark': 'ext',
        'model_bookmark': 'model',
        'print': 'printBtn',
        'response': 'responseDiv',
        'applications': [],
        'url_server': '',
        'url_print': ''
    },
    self : this,
    _create: function() {
        this.application = $("#"+this.options["application_bookmark"]);
        this.datafile = $("#"+this.options["datafile_bookmark"]);
        this.extension = $("#"+this.options["extension_bookmark"]);
        this.model = $("#"+this.options["model_bookmark"]);
        this.print = $("#"+this.options["print"]);
        this.response = $("#"+this.options["response"]);
        var html = '<option value="" selected>Seleziona un\'applicazione</option>';
        $.each(this.options.applications,function(k,v){
           html+='<option value="' + v + '">'+ v + '</option>';
        });
        $(this.application).html(html);
        
        this._update();
        return this;
    },

    _update: function() {
        var self = this;
        $(this.application).unbind("change")
        $(this.application).bind("change",function(){
            self.updateApp($(self.application).val(),$(self.extension).val());
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
        
    },
    updateApp: function(app,ext){
        var self = this;
        $.ajax(this.options.url_server,{
            'data':{
                'app': app,
                'ext': ext,
                'action': 'updateApp'
            },
            'method': 'POST',
            success: self.responseApp.bind(self)
        });
    },
    updateExt: function(app,ext){
        var self = this;
        $.ajax(this.options.url_server,{
            'data':{
                'app': app,
                'ext': ext,
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
                $(self.model).html(html);
                if(data["data"].length == 0){
                    var html= '<option value="">Nessun file dati trovato</option>';
                }
                else{
                    var html = '';
                    $.each(data["data"],function(k,v){
                        html += '<option value="' + v + '">' + v + '</option>';
                    });
                    
                }
                $(self.datafile).html(html);
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
            default:
                console.log(data);
                break;
        }
    }
    
});