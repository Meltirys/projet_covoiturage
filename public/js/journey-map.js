const mapContainer = document.getElementById('map');
if (mapContainer && mapContainer.dataset.geojson) {
    const map = L.map('map').setView([46.5, 2.5], 6);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    const layer = L.geoJSON(JSON.parse(mapContainer.dataset.geojson)).addTo(map);
    map.fitBounds(layer.getBounds());
}
