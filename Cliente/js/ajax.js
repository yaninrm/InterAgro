function objetoAjax(){
    var xmlhttp=false;
    try{
        xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
    }catch (e){
        try{
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }catch (E){
            xmlhttp = false;
        }
    }
    
    if (!xmlhttp && typeof XMLHttpRequest!='undefined'){
        xmlhttp = new XMLHttpRequest();
    }
    return xmlhttp;
}


function carga_act(){
    divResultado  = document.getElementById('principal');//div donde se cargara
    selectAnyoActividad = document.getElementById('selectAnyoActividad').value;//valor del Año
    ajax = objetoAjax();
    ajax.open("POST", "actividades.php", true);
    
    ajax.onreadystatechange = function(){
        if (ajax.readyState==4){
            divResultado.innerHTML = ajax.responseText
        }
    }
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
    ajax.send("selectAnyoActividad="+selectAnyoActividad)
}  