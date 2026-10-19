<div class="w-full max-w-4xl bg-slate-900 rounded-xl shadow-md p-6">
    <h1 class="text-2xl font-bold text-zinc-100 mb-4 text-center">
        Кафедра ігрових та інтелектуальних систем
    </h1>

    <!-- Map -->
    <div id="map" class="w-full h-[500px] rounded-lg border border-gray-300 z-0"></div>
</div>

<!-- Map initialization -->
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // Coordinates of the map center
        const startCoords = [50.447033, 30.456741];

        // 1. Initialize the map in the element with id="map"
        const map = L.map('map').setView(startCoords, 15);

        // 2. Adding an OpenStreetMap tile layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors'
        }).addTo(map);

        // 3. Add a marker (optional)
        const marker = L.marker(startCoords).addTo(map);
        marker.bindPopup("<b>Привіт!</b><br>Ми знаходимося тут!").openPopup();
    });
</script>