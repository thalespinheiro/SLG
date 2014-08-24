var x=document.getElementById("geolocation");
var pos;
function getLocation()
  {
  if (navigator.geolocation)
    {
      navigator.geolocation.getCurrentPosition(showPositionGlobe);
    }
  else{x.innerHTML="Geolocation is not supported by this browser.";}
  }
function showPosition(position)
  {
  x.innerHTML="Latitude: " + position.coords.latitude +
  "<br>Longitude: " + position.coords.longitude;
  }
function showPositionGlobe(position)
{
var latlon=position.coords.latitude+","+position.coords.longitude;

var img_url="http://maps.googleapis.com/maps/api/staticmap?center="
+latlon+"&zoom=14&size=400x300&sensor=false";

x.innerHTML="Sua localização: <img src='"+img_url+"'>";
}

getLocation();
