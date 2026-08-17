var link = "https://drehuanuco.gob.pe";
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
$(".copiar-link").click(function (e){
    e.preventDefault();
    var $boton = $(this);
    var texto = $boton.data("link");
    var copiado = function(){
        var $icono = $boton.find("i");
        var claseOriginal = $icono.attr("class");
        $icono.attr("class", "fas fa-check text-success");
        setTimeout(function(){ $icono.attr("class", claseOriginal); }, 1500);
    };
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(texto).then(copiado);
    } else {
        var $temp = $("<textarea>").val(texto).css({position:"fixed", opacity:0}).appendTo("body").select();
        document.execCommand("copy");
        $temp.remove();
        copiado();
    }
    return false;
});
