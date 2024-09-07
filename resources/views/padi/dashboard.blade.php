<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PAK TANI</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/assets/vendors/font-awesome/css/font-awesome.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="/assets/vendors/select2/select2.min.css">
    <link rel="stylesheet" href="/assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Map Js -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Layout styles -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="/assets/img/logo.png" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
  <body>
    <div class="container-scroller">
        <!-- resources/views/home.blade.php -->
        @include('components.navbar-padi')

        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
              <div class="card">
                  <div class="card-body">
                    <div class="dropdownpadi" style="color: #3b5740;background-color: #def4ca;">
                        <label>Peta</label>
                        <select id="petaSelect" style="background-color: #def4ca; border: transparent;color: #3b5740;font-weight: bold;">
                            <option value="sebaran">Sebaran Fase Amatan</option>
                            <option value="konsistensi">Konsistensi Perwilayah (subsegmen)</option>
                        </select>
                    </div>
                    <div class="dropdown-chart">
                        <div class="dropdownpadi">
                            {{-- Tahun --}}
                            @php
                                $years = [];
                                $currentYear = old('tahun_peta', $currentYear ?? 2030); // Gunakan nilai lama jika tersedia
                                $minYear = $minYear ?? 2020; // Menyediakan tahun default jika tidak ada dari database

                                // Generate array tahun dari tahun sekarang ke tahun terkecil
                                for ($year = $currentYear; $year >= $minYear; $year--) {
                                    $years[] = $year;
                                }
                            @endphp
                            <label for="tahun_peta">Tahun</label>
                            <select id="tahun_peta" name="tahun_peta" style="background-color: #a4d17c; border: transparent;color: #FFFFFF;font-weight: bold;">
                                @foreach($years as $year)
                                    <option value="{{ $year }}" {{ $currentYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="dropdownpadi">
                            {{-- Bulan --}}
                            @php
                                $currentMonth = old('bulan_peta', date('m')); // Gunakan nilai lama jika tersedia
                            @endphp
                            <label for="bulan_peta">Bulan</label>
                            <select id="bulan_peta" name="bulan_peta" style="background-color: #a4d17c; border: transparent;color: #FFFFFF;font-weight: bold;">
                                <option value="01" {{ $currentMonth == '01' ? 'selected' : '' }}>01 - Januari</option>
                                <option value="02" {{ $currentMonth == '02' ? 'selected' : '' }}>02 - Februari</option>
                                <option value="03" {{ $currentMonth == '03' ? 'selected' : '' }}>03 - Maret</option>
                                <option value="04" {{ $currentMonth == '04' ? 'selected' : '' }}>04 - April</option>
                                <option value="05" {{ $currentMonth == '05' ? 'selected' : '' }}>05 - Mei</option>
                                <option value="06" {{ $currentMonth == '06' ? 'selected' : '' }}>06 - Juni</option>
                                <option value="07" {{ $currentMonth == '07' ? 'selected' : '' }}>07 - Juli</option>
                                <option value="08" {{ $currentMonth == '08' ? 'selected' : '' }}>08 - Agustus</option>
                                <option value="09" {{ $currentMonth == '09' ? 'selected' : '' }}>09 - September</option>
                                <option value="10" {{ $currentMonth == '10' ? 'selected' : '' }}>10 - Oktober</option>
                                <option value="11" {{ $currentMonth == '11' ? 'selected' : '' }}>11 - November</option>
                                <option value="12" {{ $currentMonth == '12' ? 'selected' : '' }}>12 - Desember</option>
                            </select>
                        </div>

                        <div class="dropdownpadi" id="faseAmatan">
                            <label for="fase">Fase Amatan</label>
                            <select id="fase" name="fase" style="background-color: #a4d17c; border: transparent;color: #FFFFFF;font-weight: bold;">
                                <option value="1">01-Vegetatif Awal</option>
                                <option value="2">02-Vegetatif Akhir</option>
                                <option value="3">03-Generatif</option>
                                <option value="4">04-Panen</option>
                                <option value="5">05-Persiapan Lahan</option>
                                <option value="6">06-Puso</option>
                                <option value="7">07-Lahan Pertanian Bukan Padi</option>
                                <option value="8">08-Bukan Lahan Pertanian</option>
                                <option value="12">12-Tidak Bisa Diamati</option>
                            </select>
                        </div>

                      <button id="lihat_peta" type="button" class="btn btn-gradient-primary btn-icon-text" style="padding:0.6rem;background: #a4d17c;margin: 0.5rem;">
                        <i class="fa fa-refresh"></i> Lihat </button>
                    </div>
                    <div id="map" style="height: 70vh;background: #fbf8f8;"></div>
                </div>
                  <div class="card-body">
                    <h4 class="judul-chart"> Progres Tiap Wilayah</h4>
                    <div class="dropdown-chart">
                    <div class="dropdownpadi">
                        {{-- Tahun --}}
                        @php
                            $years = [];
                            $currentYear = old('tahun_progres', $currentYear ?? 2030); // Gunakan nilai lama jika tersedia
                            $minYear = $minYear ?? 2020; // Menyediakan tahun default jika tidak ada dari database

                            // Generate array tahun dari tahun sekarang ke tahun terkecil
                            for ($year = $currentYear; $year >= $minYear; $year--) {
                                $years[] = $year;
                            }
                        @endphp
                        <label for="tahun_progres">Tahun</label>
                        <select id="tahun_progres" name="tahun_progres" style="background-color: #a4d17c; border: transparent;color: #FFFFFF;font-weight: bold;">
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ $currentYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="dropdownpadi">
                        {{-- Bulan --}}
                        @php
                            $currentMonth = old('bulan_progres', date('m')); // Gunakan nilai lama jika tersedia
                        @endphp
                        <label for="bulan_progres">Bulan</label>
                        <select id="bulan_progres" name="bulan_progres" style="background-color: #a4d17c; border: transparent;color: #FFFFFF;font-weight: bold;">
                            <option value="01" {{ $currentMonth == '01' ? 'selected' : '' }}>01 - Januari</option>
                            <option value="02" {{ $currentMonth == '02' ? 'selected' : '' }}>02 - Februari</option>
                            <option value="03" {{ $currentMonth == '03' ? 'selected' : '' }}>03 - Maret</option>
                            <option value="04" {{ $currentMonth == '04' ? 'selected' : '' }}>04 - April</option>
                            <option value="05" {{ $currentMonth == '05' ? 'selected' : '' }}>05 - Mei</option>
                            <option value="06" {{ $currentMonth == '06' ? 'selected' : '' }}>06 - Juni</option>
                            <option value="07" {{ $currentMonth == '07' ? 'selected' : '' }}>07 - Juli</option>
                            <option value="08" {{ $currentMonth == '08' ? 'selected' : '' }}>08 - Agustus</option>
                            <option value="09" {{ $currentMonth == '09' ? 'selected' : '' }}>09 - September</option>
                            <option value="10" {{ $currentMonth == '10' ? 'selected' : '' }}>10 - Oktober</option>
                            <option value="11" {{ $currentMonth == '11' ? 'selected' : '' }}>11 - November</option>
                            <option value="12" {{ $currentMonth == '12' ? 'selected' : '' }}>12 - Desember</option>
                        </select>
                    </div>
                    <div class="dropdownpadi">
                        {{-- Jenis --}}
                        @php
                            $currentMonth = old('jenis_progres', 'subsegmen'); // Gunakan nilai lama jika tersedia
                        @endphp
                      <label for="jenis_progres">Segmen</label>
                          <select id="jenis_progres" name="jenis_progres" style="background-color: #a4d17c; border: transparent;color: #FFFFFF;font-weight: bold;">
                            <option value="subsegmen">Subsegmen</option>
                            <option value="segmen">Segmen</option>
                            <option value="evita">Segmen dan Status</option>
                          </select>
                    </div>
                    <button id="lihat_progres" type="button" class="btn btn-gradient-primary btn-icon-text" style="padding:0.6rem;background: #a4d17c;margin: 0.5rem;">
                        <i class="fa fa-refresh"></i> Lihat </button>
                    </div>
                    <div>
                    <div class="row">
                        <div id="chartContainer" class="chartBox">
                            <canvas id="Chart" style="display: initial; box-sizing: border-box; height: 105vh; width: 800px;font-weight: bold;"></canvas>
                      </div>
                    </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
          @include('components.footer')
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="/assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="/assets/vendors/select2/select2.min.js"></script>
    <script src="/assets/vendors/typeahead.js/typeahead.bundle.min.js"></script>
    <script src="/assets/vendors/chart.js/chart.umd.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="/assets/js/off-canvas.js"></script>
    <script src="/assets/js/misc.js"></script>
    <script src="/assets/js/settings.js"></script>
    <script src="/assets/js/chart.js"></script>
    <script src="/assets/js/todolist.js"></script>
    <script src="/assets/js/jquery.cookie.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="/assets/js/file-upload.js"></script>
    <script src="/assets/js/typeahead.js"></script>
    <script src="/assets/js/select2.js"></script>
    <!-- End custom js for this page -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  </body>
</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var petaSelect = document.getElementById('petaSelect');
        var faseAmatan = document.getElementById('faseAmatan');

        // Fungsi untuk menampilkan/menyembunyikan faseAmatan
        function toggleFaseAmatan() {
            if (petaSelect.value === 'konsistensi') {
                faseAmatan.style.display = 'none';
            } else {
                faseAmatan.style.display = 'block';
            }
        }

        // Jalankan fungsi saat elemen dropdown berubah
        petaSelect.addEventListener('change', toggleFaseAmatan);

        // Jalankan fungsi saat halaman dimuat
        toggleFaseAmatan();
    });
</script>

<!-- Make sure you put this AFTER Leaflet's CSS -->
<script type="text/javascript" src="assets/js/data/jateng.js"></script>
<script type="text/javascript">
    geodata.features.forEach(function(feature) {
        feature.properties.KONSISTEN_P = 'Tidak ada data';
    });

    var map = L.map('map').setView([-7.150975, 110.1402594], 8);

    var LayerKita = L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox.streets',
        accessToken: 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw'
    });
    map.addLayer(LayerKita);

    function getJudul(){
        if($('#petaSelect').val() == "konsistensi"){
            return 'Peta Konsistensi'
        } else {
            return 'Peta Sebaran Fase Amatan'
        }
    }

    // Control that shows state info on hover
    var info = L.control();

    info.onAdd = function(map) {
        this._div = L.DomUtil.create('div', 'info');
        this.update();
        return this._div;
    };

    info.update = function(props) {
        this._div.innerHTML = '<h4>' + getJudul() + '</h4>' + (props ?
            '<b>' + props.KABKOT + '</b><br />' + props.KONSISTEN_P + getSatuan() :
            'Dekatkan mouse untuk melihat');
    };

    info.addTo(map);

    function getColor(d) {
        return d == 'Tidak ada data' ? '#666666' :
               d > 50 ? '#850D0C' :
               d > 40 ? '#B41C17' :
               d > 30 ? '#CE2C29' :
               d > 20 ? '#ED7D79' :
               d > 10 ? '#EE978D' :
               d >= 1 ? '#F5C4B6' :
               d = 1  ? '#92C98C' :
                        '#666666';
    }

    function style(feature) {
        return {
            weight: 2,
            opacity: 1,
            color: 'white',
            dashArray: '3',
            fillOpacity: 0.7,
            fillColor: getColor(feature.properties.KONSISTEN_P)
        };
    }

    function getColorSebaran(d) {
        return d == 'Tidak ada data' ? '#666666' :
               d > 100 ? '#a67b5b' :
               d > 80 ? '#af9559' :
               d > 60 ? '#d0c49a' :
               d > 40 ? '#b3b78f' :
               d > 20 ? '#6e9775' :
               d >= 1 ? '#407154' :
               d = 1  ? '#104730' :
                        '#666666';
    }

    function styleSebaran(feature) {
        return {
            weight: 2,
            opacity: 1,
            color: 'white',
            dashArray: '3',
            fillOpacity: 0.7,
            fillColor: getColorSebaran(feature.properties.KONSISTEN_P)
        };
    }

    function highlightFeature(e) {
        var layer = e.target;

        layer.setStyle({
            weight: 5,
            color: '#666',
            dashArray: '',
            fillOpacity: 0.7
        });

        if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
            layer.bringToFront();
        }

        info.update(layer.feature.properties);
    }

    var geojson;

    function resetHighlight(e) {
        geojson.resetStyle(e.target);
        info.update();
    }

    function zoomToFeature(e) {
        map.fitBounds(e.target.getBounds());
    }

    function getSatuan(){
        if($('#petaSelect').val() == "konsistensi"){
            return ' subsegmen inkonsisten'
        } else {
            return ' subsegmen'
        }
    }

    function onEachFeature(feature, layer) {
        layer.on({
            mouseover: highlightFeature,
            mouseout: resetHighlight,
            click: function(e) {
                zoomToFeature(e);
                L.popup()
                    .setLatLng(e.latlng)
                    .setContent('<b>' + feature.properties.KABKOT + '</b><br />' + feature.properties.KONSISTEN_P + getSatuan())
                    .openOn(map);
            }
        });
    }

    geojson = L.geoJson(geodata, {
        style: style,
        onEachFeature: onEachFeature
    }).addTo(map);

    function addAttribution(){
        map.attributionControl.removeAttribution('Konsistensi Data Padi')
        map.attributionControl.removeAttribution('Sebaran Data Padi')

        if ($('#petaSelect').val() == "konsistensi"){
            map.attributionControl.addAttribution('Konsistensi Data Padi')
        } else {
            map.attributionControl.addAttribution('Sebaran Data Padi')
        }
    }

    // Simpan referensi legend di luar fungsi, sehingga bisa diakses nanti untuk dihapus
    var legend;

    function addLegend() {
        // Jika legend sudah ada, hapus terlebih dahulu
        if (legend) {
            map.removeControl(legend);
        }

        // Buat legend baru
        legend = L.control({position: 'bottomleft'});
        legend.onAdd = function (map) {
            var div = L.DomUtil.create('div', 'info legend'),
                grades = [0, 10, 20, 30, 40, 50],
                labels = [];

            if ($('#petaSelect').val() == "konsistensi"){
                // Tambahkan isi legend sesuai dengan kebutuhan Anda
                div.innerHTML =
                '<i style="background:#92C98C"></i> 0 <br/>'+
                '<i style="background:#F5C4B6"></i> 1 - 10 <br/>'+
                '<i style="background:#EE978D"></i> 11 - 20 <br/>'+
                '<i style="background:#ED7D79"></i> 21 - 30 <br/>'+
                '<i style="background:#CE2C29"></i> 31 - 40 <br/>'+
                '<i style="background:#B41C17"></i> 41 - 50 <br/>'+
                '<i style="background:#850D0C"></i> 50+ <br/>';
            } else {
                // Tambahkan isi legend sesuai dengan kebutuhan Anda
                div.innerHTML =
                    '<i style="background:#a67b5b"></i> 0 <br/>' +
                    '<i style="background:#af9559"></i> 1 - 20 <br/>' +
                    '<i style="background:#d0c49a"></i> 21 - 40 <br/>' +
                    '<i style="background:#b3b78f"></i> 41 - 60 <br/>' +
                    '<i style="background:#6e9775"></i> 61 - 80 <br/>' +
                    '<i style="background:#407154"></i> 81 - 100 <br/>' +
                    '<i style="background:#104730"></i> 100 + <br/>';
            }

            return div;
        };

        // Tambahkan legend baru ke peta
        legend.addTo(map);
    }

</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#map').hide();
        $('#Chart').hide();
        $('#lihat_peta').click(function() {
            $('#map').show();
            // Ambil nilai dari dropdown
            var tahun = $('#tahun_peta').val();
            var bulan = $('#bulan_peta').val();
            var fase = $('#fase').val();
            var petaSelect = $("#petaSelect").val();

            // Variabel untuk URL endpoint yang berbeda berdasarkan tipe peta
            let url_post;

            // Cek pilihan di dropdown petaSelect
            if (petaSelect == 'sebaran') {
                url_post = '/padi-get-data-peta-sebaran'; // URL untuk Sebaran Fase Amatan
            } else if (petaSelect == 'konsistensi') {
                url_post = '/padi-get-data-peta'; // URL untuk Konsistensi Perwilayah
            }
            console.log(url_post);

            $.ajax({
                url: url_post,
                type: 'POST',
                data: {
                    tahun_peta: tahun,
                    bulan_peta: bulan,
                    fase: fase,
                    geodata: JSON.stringify(geodata),
                    _token: $('meta[name="csrf-token"]').attr('content') // Menambahkan CSRF token untuk Laravel
                },
                dataType: 'json',
                success: function(response) {
                    // Simpan respons JSON ke variabel geodata
                    var geodata = response;

                    console.log(geodata.features[0].properties);

                    // Hapus layer geojson yang ada jika ada
                    map.eachLayer(function(layer) {
                        if (layer instanceof L.GeoJSON) {
                            map.removeLayer(layer);
                        }
                    });

                    // Cek pilihan di dropdown petaSelect
                    if (petaSelect == 'sebaran') {
                        // Tambahkan layer geojson baru
                        geojson = L.geoJson(geodata, {
                            style: styleSebaran,
                            onEachFeature: onEachFeature
                        }).addTo(map);
                    } else if (petaSelect == 'konsistensi') {
                        // Tambahkan layer geojson baru
                        geojson = L.geoJson(geodata, {
                            style: style,
                            onEachFeature: onEachFeature
                        }).addTo(map);
                    }

                    addAttribution();
                    addLegend();
                },
                error: function(xhr, status, error) {
                    console.error('Terjadi kesalahan: ', error);
                }
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    let myChart;

    $(document).ready(function() {
        $('#lihat_progres').click(function() {
            $('#Chart').show();
            // Ambil nilai dari dropdown
            var tahun = $('#tahun_progres').val();
            var bulan = $('#bulan_progres').val();
            var jenis = $('#jenis_progres').val();
            console.log(jenis);

            $.ajax({
                url: '/padi-get-data-progres',
                type: 'POST',
                data: {
                    tahun: tahun,
                    bulan: bulan,
                    jenis: jenis,
                    _token: $('meta[name="csrf-token"]').attr('content') // Menambahkan CSRF token untuk Laravel
                },
                dataType: 'json',
                success: function(response) {
                    console.log('Labels:', response.labels);
                    console.log('Raw Data:', response.rawData);

                    if (!Array.isArray(response.labels) || !Array.isArray(response.rawData)) {
                        console.error('Format data tidak sesuai.');
                        return;
                    }
                    // Hapus canvas lama
                    $('#Chart').remove();
                    // Tambahkan canvas baru
                    $('#chartContainer').append('<canvas id="Chart" style="display: initial; box-sizing: border-box; height: 105vh; width: 800px;font-weight: bold;"></canvas>');

                    // Debugging untuk memastikan canvas ditambahkan
                    console.log($('#chartContainer').html());
                    console.log(document.getElementById('Chart')); // Pastikan ini tidak bernilai null

                    var labels = response.labels;
                    var rawData = response.rawData;

                    // Verifikasi bahwa rawData adalah array yang berisi array
                    if (!rawData.every(Array.isArray)) {
                        console.error('rawData harus berupa array yang berisi array.');
                        return;
                    }

                    // Convert rawData into percentages
                    var data = rawData.map((dataSet) => {
                        const total = dataSet.reduce((sum, value) => sum + value, 0);
                        return dataSet.map((value) => (value / total) * 100);
                    });

                    let datasets = [];
                    let jenis = $('#jenis_progres').val();
                    // Periksa jenis
                    if (jenis === 'segmen') {
                        datasets.push(
                            {
                                axis: 'y',
                                label: 'Konsisten',
                                data: data.map(d => d[0]),
                                rawData: rawData.map(d => d[0]),
                                backgroundColor: '#92C98C',
                                borderColor: '#92C98C',
                                borderWidth: 1
                            },
                            {
                                axis: 'y',
                                label: 'Inkonsisten',
                                data: data.map(d => d[1]),
                                rawData: rawData.map(d => d[1]),
                                backgroundColor: '#ED7D79',
                                borderColor: '#ED7D79',
                                borderWidth: 1
                            }
                        );
                    } else if (jenis === 'evita') {
                        datasets.push(
                            {
                                axis: 'y',
                                label: 'Approved',
                                data: data.map(d => d[0]),
                                rawData: rawData.map(d => d[0]),
                                backgroundColor: '#92C98C',
                                borderColor: '#92C98C',
                                borderWidth: 1
                            },
                            {
                                axis: 'y',
                                label: 'Rejected',
                                data: data.map(d => d[1]),
                                rawData: rawData.map(d => d[1]),
                                backgroundColor: '#ED7D79',
                                borderColor: '#ED7D79',
                                borderWidth: 1
                            }
                        );
                    } else {
                        datasets.push(
                            {
                                axis: 'y',
                                label: 'Konsisten',
                                data: data.map(d => d[0]),
                                rawData: rawData.map(d => d[0]),
                                backgroundColor: '#92C98C',
                                borderColor: '#92C98C',
                                borderWidth: 1
                            },
                            {
                                axis: 'y',
                                label: 'Warning',
                                data: data.map(d => d[1]),
                                rawData: rawData.map(d => d[1]),
                                backgroundColor: 'rgba(255, 205, 86, 0.6)',
                                borderColor: 'rgba(255, 205, 86, 0.6)',
                                borderWidth: 1
                            },
                            {
                                axis: 'y',
                                label: 'Inkonsisten',
                                data: data.map(d => d[2]),
                                rawData: rawData.map(d => d[2]),
                                backgroundColor: '#ED7D79',
                                borderColor: '#ED7D79',
                                borderWidth: 1
                            }
                        );
                    }

                    const chartData = {
                        labels: labels,
                        datasets: datasets
                    };

                    // Hapus chart yang lama jika ada
                    if (myChart instanceof Chart) {
                        myChart.destroy();
                    }

                    // Buat chart baru
                    const canvas = document.getElementById('Chart');
                    const ctx = canvas.getContext('2d');
                    myChart = new Chart(ctx, {
                        type: 'bar',
                        data: chartData,
                        options: {
                            indexAxis: 'y',
                            scales: {
                                x: {
                                    beginAtZero: true,
                                    min: 0, // Set minimum value of x-axis
                                    max: 100, // Set maximum value of x-axis
                                    stacked: true,
                                    ticks: {
                                        callback: function(value) {
                                            return value + '%';
                                        },
                                        font: {
                                            weight: 'bold',
                                            color: '#000'
                                        },
                                        color: '#000'
                                    }
                                },
                                y: {
                                    stacked: true,
                                    ticks: {
                                        font: {
                                            weight: 'bold',
                                            color: '#000'
                                        },
                                        color: '#000'
                                    }
                                }
                            },
                            elements: {
                                bar: {
                                    barThickness: 20, // Atur ketebalan bar
                                    categoryPercentage: 0.8, // Kurangi ini untuk jarak antar bar lebih kecil
                                }
                            },
                            plugins: {
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            const dataset = tooltipItem.dataset;
                                            const rawValue = dataset.rawData[tooltipItem.dataIndex];
                                            const percentage = tooltipItem.raw.toFixed(2) + '%';
                                            return [
                                                dataset.label + ': ' + percentage,
                                                'Nilai: ' + rawValue
                                            ];
                                        }
                                    }
                                },
                                legend: {
                                    labels: {
                                        font: {
                                            weight: 'bold',
                                            color: '#000'
                                        },
                                        color: '#000'
                                    }
                                }
                            }
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Terjadi kesalahan: ', error);
                }
            });
        });
    });
</script>
