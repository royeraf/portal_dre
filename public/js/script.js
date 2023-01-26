var link = "http://127.0.0.1:8000";
$(".eliminar").click(function (){
    var url=$(this).attr("href");
    if(window.confirm("ESTA SEGURO DE ELIMINAR?")==true){
        window.location.href = url;
    }
    return false;
});
$(".showpopup").click(function (){
    var idpopup=$(this).attr("href");
	$.get(link+"/popup/show/"+idpopup,function(data){
        $('#popupcontent').html(data);
        $('#modalpopup').modal('show');
   });
   return false;
});