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
        @include('components.navbar-jagung')

        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper" style="background: linear-gradient(to right, #f4ffc8, #ddf3ca);">
          <div class="row">
              <div class="col-12 grid-margin stretch-card">
              <div class="card">
                @if (Auth::user()->role == "prov")
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
                                <option value="3">03-Reproduktif Awal</option>
                                <option value="4">04-Reproduktif Akhir</option>
                                <option value="5">05-Panen Hijauan</option>
                                <option value="6">06-Panen Muda</option>
                                <option value="7">07-Panen Pipilan</option>
                                <option value="8">08-Pengolahan Lahan</option>
                                <option value="9">09-Lahan Pertanian Bukan Jagung</option>
                                <option value="10">10-Bukan Lahan Pertanian</option>
                                <option value="11">11-Puso</option>
                            </select>
                        </div>

                      <button id="lihat_peta" type="button" class="btn btn-gradient-primary btn-icon-text" style="padding:0.6rem;background: #a4d17c;margin: 0.5rem;">
                        <i class="fa fa-refresh"></i> Lihat </button>
                    </div>
                    <div id="map" style="height: 70vh;background: #fbf8f8;"></div>
                </div>
                @endif
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
                      <label for="jenis_progres"></label>
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

                    <div class="row">
                        <div class="card-body">
                            <h4 class="judul-chart"> Capaian Validasi </h4>
                            <div class="dropdown-chart">
                                <div class="dropdownpadi">
                                    <select id="jenis_capaian" style="background-color: #a4d17c; border: transparent;color: #FFFFFF;font-weight: bold;">
                                        <option value="subsegmen">Subsegmen</option>
                                        <option value="segmen">Segmen</option>
                                        <option value="evita">Segmen dan Status</option>
                                    </select>
                                </div>
                                <div class="dropdownpadi">
                                    <select id="wilayah_capaian" style="background-color: #a4d17c; border: transparent;color: #FFFFFF;font-weight: bold;">
                                        <option value="3399">Pilih Wilayah</option><option value="3300">Jawa Tengah</option><option value="3301">3301 - Cilacap</option><option value="3302">3302 - Banyumas</option><option value="3303">3303 - Purbalingga</option><option value="3304">3304 - Banjarnegara</option><option value="3305">3305 - Kebumen</option><option value="3306">3306 - Purworejo</option><option value="3307">3307 - Wonosobo</option><option value="3308">3308 - Magelang</option><option value="3309">3309 - Boyolali</option><option value="3310">3310 - Klaten</option><option value="3311">3311 - Sukoharjo</option><option value="3312">3312 - Wonogiri</option><option value="3313">3313 - Karanganyar</option><option value="3314">3314 - Sragen</option><option value="3315">3315 - Grobogan</option><option value="3316">3316 - Blora</option><option value="3317">3317 - Rembang</option><option value="3318">3318 - Pati</option><option value="3319">3319 - Kudus</option><option value="3320">3320 - Jepara</option><option value="3321">3321 - Demak</option><option value="3322">3322 - Semarang</option><option value="3323">3323 - Temanggung</option><option value="3324">3324 - Kendal</option><option value="3325">3325 - Batang</option><option value="3326">3326 - Pekalongan</option><option value="3327">3327 - Pemalang</option><option value="3328">3328 - Tegal</option><option value="3329">3329 - Brebes</option><option value="3371">3371 - Kota Magelang</option><option value="3372">3372 - Kota Surakarta</option><option value="3373">3373 - Kota Salatiga</option><option value="3374">3374 - Kota Semarang</option><option value="3375">3375 - Kota Pekalongan</option><option value="3376">3376 - Kota Tegal</option></select>
                                    </select>
                                </div>
                                <button type="button" id="lihat_capaian" class="btn btn-gradient-primary btn-icon-text" style="padding:0.6rem;background: #a4d17c;margin: 0.5rem;">
                                <i class="fa fa-refresh"></i> Lihat </button>
                            </div>
                        <div id="capaian" class="col-lg-6 grid-margin stretch-card">
                            <div class="card">
                                <h4 class="card-title">Bulan Terakhir</h4>
                                <div class="doughnutjs-wrapper d-flex justify-content-center">
                                    <canvas id="pieChart" style="height: 200px; display: block; box-sizing: border-box; width: 200px;" ></canvas>
                                </div>
                            </div>
                            <div class="card">
                                <h4 class="card-title">Tahun Berjalan</h4>
                                <div class="doughnutjs-wrapper d-flex justify-content-center">
                                    <canvas id="pieChart2" style="height: 200px; display: block; box-sizing: border-box; width: 200px;"></canvas>
                                </div>
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
               d == 0  ? '#92C98C' :
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
               d > 100 ? '#043015' :
               d > 80 ? '#00441b' :
               d > 60 ? '#006d2c' :
               d > 40 ? '#3fa65b' :
               d > 20 ? '#7ad692' :
               d >= 1 ? '#bee6b9' :
               d == 0  ? '#ddefdb' :
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
        map.attributionControl.removeAttribution('Konsistensi Data Jagung')
        map.attributionControl.removeAttribution('Sebaran Data Jagung')

        if ($('#petaSelect').val() == "konsistensi"){
            map.attributionControl.addAttribution('Konsistensi Data Jagung')
        } else {
            map.attributionControl.addAttribution('Sebaran Data Jagung')
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
                    '<i style="background:#ddefdb"></i> 0 <br/>' +
                    '<i style="background:#bee6b9"></i> 1 - 20 <br/>' +
                    '<i style="background:#7ad692"></i> 21 - 40 <br/>' +
                    '<i style="background:#3fa65b"></i> 41 - 60 <br/>' +
                    '<i style="background:#006d2c"></i> 61 - 80 <br/>' +
                    '<i style="background:#00441b"></i> 81 - 100 <br/>' +
                    '<i style="background:#043015"></i> 100 + <br/>';
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
        $('#capaian').hide();
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
                url_post = '/jagung-get-data-peta-sebaran'; // URL untuk Sebaran Fase Amatan
            } else if (petaSelect == 'konsistensi') {
                url_post = '/jagung-get-data-peta'; // URL untuk Konsistensi Perwilayah
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
                url: '/jagung-get-data-progres',
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

<script>
    // Ambil konteks chart
    const cty = document.getElementById('pieChart').getContext('2d');
    const ctz = document.getElementById('pieChart2').getContext('2d');

    // Inisialisasi chart dengan data kosong
    let pieChart = new Chart(cty, {
        type: 'pie',
        data: {
            labels: [],
            datasets: [{
                label: 'Data Konsistensi',
                data: [],
                backgroundColor: [
                    '#92C98C',
                    'rgba(255, 205, 86, 0.6)',
                    '#ED7D79'
                ],
                borderColor: [
                    '#92C98C',
                    'rgba(255, 205, 86, 0.6)',
                    '#ED7D79'
                ],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            weight: 'bold'
                        },
                        color: '#000'
                    }
                }
            }
        }
    });

    let pieChart2 = new Chart(ctz, {
        type: 'pie',
        data: {
            labels: [],
            datasets: [{
                label: 'Data Konsistensi',
                data: [],
                backgroundColor: [
                    '#92C98C',
                    'rgba(255, 205, 86, 0.6)',
                    '#ED7D79'
                ],
                borderColor: [
                    '#92C98C',
                    'rgba(255, 205, 86, 0.6)',
                    '#ED7D79'
                ],
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: {
                            weight: 'bold'
                        },
                        color: '#000'
                    }
                }
            }
        }
    });

    // Event listener untuk tombol
    document.getElementById('lihat_capaian').addEventListener('click', function() {
        $('#capaian').show();
        const jenisCapaian = document.getElementById('jenis_capaian').value;
        const wilayahCapaian = document.getElementById('wilayah_capaian').value;

        // Lakukan permintaan AJAX
        fetch(`/jagung-get-data-capaian?jenis_capaian=${jenisCapaian}&wilayah_capaian=${wilayahCapaian}`)
            .then(response => response.json())
            .then(data => {
                // Misalnya data dari server adalah { chart1: { labels: [...], data: [...] }, chart2: { labels: [...], data: [...] } }
                const chartData1 = data.chart1;
                const chartData2 = data.chart2;

                // Update pieChart
                pieChart.data.labels = chartData1.labels;
                pieChart.data.datasets[0].data = chartData1.data;
                pieChart.update();

                // Update pieChart2
                pieChart2.data.labels = chartData2.labels;
                pieChart2.data.datasets[0].data = chartData2.data;
                pieChart2.update();
            })
            .catch(error => console.error('Error:', error));
    });

</script>
