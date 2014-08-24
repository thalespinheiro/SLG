/**
 * @author thales
 */
function abrePagina(pagina)
{
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("conteudo").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET",pagina,true);
xmlhttp.send();
}


$(document).ready(function(){
    $('#origem').change(function(){
        $('#tarefa').load('tarefas.php?node='+$('#origem').val() );
    });
});
