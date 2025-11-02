<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Peta Wilayah Pendampingan</title>

  <!-- TailwindCSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Leaflet CSS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

  <style>
    #map {
      width: 100%;
      height: 600px;
      border-radius: 12px;
      overflow: hidden;
    }
  </style>
</head>

<body class="bg-gray-50 min-h-screen">
  <!-- Header -->
  <header class="bg-blue-600 text-white py-6 shadow-md">
    <div class="max-w-7xl mx-auto px-6 text-center">
      <h1 class="text-3xl font-bold tracking-wide">🌍 Peta Wilayah Pendampingan</h1>
      <p class="text-blue-100 mt-2">Filter dan lihat data wilayah berdasarkan Kecamatan, Desa, atau Business Assistant</p>
    </div>
  </header>

  <!-- Filter Section -->
  <section class="max-w-7xl mx-auto px-6 mt-10">
    <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col sm:flex-row items-center gap-4 justify-between">
      <div class="flex flex-wrap items-center gap-4 w-full sm:w-auto">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Filter Berdasarkan</label>
          <select id="filterType" class="rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 w-48">
            <option value="">-- Pilih Filter --</option>
            <option value="kecamatan">Kecamatan</option>
            <option value="desa">Desa</option>
            <option value="ba">Business Assistant</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Item</label>
          <select id="filterItem" class="rounded-lg border-gray-300 focus:ring-blue-500 focus:border-blue-500 w-56">
            <option value="">-- Pilih Item --</option>
          </select>
        </div>
      </div>

      <button id="applyFilter"
        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg shadow-md font-semibold transition">
        Tampilkan
      </button>
    </div>
  </section>

  <!-- Map Section -->
  <section class="max-w-7xl mx-auto px-6 mt-10 mb-10">
    <div class="bg-white rounded-2xl shadow-lg p-4">
      <div id="map"></div>
    </div>
  </section>

  <!-- Leaflet JS -->
  <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

  <script>
    // Contoh data JSON (nanti kamu bisa ganti fetch dari API Laravel)
    const districts = [
      { id: 1, name: 'Polewali' },
      { id: 2, name: 'Wonomulyo' },
      { id: 3, name: 'Campalagian' }
    ];

    const assistants = [
      { id: 1, name: 'BA Ahmad' },
      { id: 2, name: 'BA Rani' },
      { id: 3, name: 'BA Fajar' }
    ];

    // Inisialisasi peta
    const map = L.map('map').setView([-3.4, 119.2], 9);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 18,
      attribution: '© OpenStreetMap'
    }).addTo(map);

    let currentLayer = null;

    // Ganti isi dropdown kedua berdasarkan jenis filter
    document.getElementById('filterType').addEventListener('change', function () {
      const type = this.value;
      const filterItem = document.getElementById('filterItem');
      filterItem.innerHTML = '<option value="">-- Pilih Item --</option>';

      let data = [];
      if (type === 'kecamatan') data = districts;
      else if (type === 'ba') data = assistants;

      data.forEach(item => {
        const opt = document.createElement('option');
        opt.value = item.id;
        opt.textContent = item.name;
        filterItem.appendChild(opt);
      });
    });

    // Tombol tampilkan ditekan
    document.getElementById('applyFilter').addEventListener('click', function () {
      const type = document.getElementById('filterType').value;
      const id = document.getElementById('filterItem').value;

      if (!type || !id) {
        alert('Silakan pilih jenis filter dan item terlebih dahulu.');
        return;
      }

      // Ganti bagian ini untuk ambil data dari backend Laravel
      // Contoh endpoint: /map/filter?type=kecamatan&id=1
      fetch(`/map/filter?type=${type}&id=${id}`)
        .then(res => res.json())
        .then(data => {
          if (currentLayer) map.removeLayer(currentLayer);

          currentLayer = L.geoJSON(data, {
            style: {
              color: '#2563eb',
              weight: 2,
              fillOpacity: 0.4
            },
            onEachFeature: (feature, layer) => {
              if (feature.properties?.name) {
                layer.bindPopup(feature.properties.name);
              }
            }
          }).addTo(map);

          if (currentLayer.getLayers().length > 0) {
            map.fitBounds(currentLayer.getBounds());
          }
        })
        .catch(() => alert("Gagal memuat data dari server"));
    });
  </script>
</body>
</html>
