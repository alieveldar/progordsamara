var map, cntr={lat:53.237270, lng:50.202714}; $(document).ready(function() { if ($("#idots").size()>0) { initmapgoogle(); }});
function initmapgoogle() { map=new google.maps.Map(document.getElementById('yamap'),{ center:cntr, scrollwheel:true, disableDefaultUI: true, zoom:12 }); getMarkers(); }
function attachMark(mkr) { mkr.addListener('click', function(e) { document.location="/places/view/"+mkr.getTitle(); }); }
function getMarkers() { var cors, marker=new Array(), pos, dotas=($("#idots").val()).split(";"); 
for (var i=0; i<(dotas.length-1); i++) { cors=dotas[i].split(","); id=(cors[0]-0); pos={ lat: (cors[1]-0), lng: (cors[2]-0) }; 
marker[i]=new google.maps.Marker({ position:pos, map:map, title:""+id+"", icon:'/modules/page_mods/dotmap.png' }); attachMark(marker[i]);	}}
function singleDot(gps) { $(document).ready(function() { var cors=gps.split(","); cntr={ lat: (cors[0]-0), lng: (cors[1]-0) }; 
map=new google.maps.Map(document.getElementById('yamap'),{ center:cntr, scrollwheel:true, disableDefaultUI: true, zoom:16 }); 
var marker=new google.maps.Marker({ position:cntr, map:map, icon:'/modules/page_mods/dotmap.png' });});}