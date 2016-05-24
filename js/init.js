var jsonData;
$(document).ready(function(){
    
    var container = document.getElementById("data-json");
    var options = {};
    var jsonData = new JSONEditor(container, options);
    var a = $.gw.openTBS({'applications': applications,'url_server': service_url, 'url_print': print_url,'json_data':jsonData});
});