function getLoc(location)
{
    document.getElementById("latitude").value = location.latlng.lat;
    document.getElementById("longitude").value = location.latlng.lng;
}

var map = L.map("uni_map").setView([28.602653443870356, -81.20001698975429], 16);

var marker1 = L.marker([28.601720028286387, -81.20040256091856]).addTo(map).on('click', getLoc);
var marker2 = L.marker([28.599782391875614, -81.20200047811245]).addTo(map).on('click', getLoc);
var marker3 = L.marker([28.60042293324504, -81.20148549399389]).addTo(map).on('click', getLoc);

var marker4 = L.marker([29.64747289727294, -82.35445858329476]).addTo(map).on('click', getLoc);
var marker5 = L.marker([29.64043713776004, -82.36449646745443]).addTo(map).on('click', getLoc);


L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 18
}).addTo(map);