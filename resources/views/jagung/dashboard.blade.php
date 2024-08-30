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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <!-- Layout styles -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="/assets/img/logo.png" />
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
                  <div class="card-body">
                    <h4 class="judul-chart"> Peta Konsistensi Perwilayah (Subsegmen)</h4>
                    <div class="dropdown-chart">
                      <div class="dropdown">
                        <button class="btn btn-gradient-success dropdown-toggle" type="button" id="dropdownMenuOutlineButton5" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Tahun </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton5">
                          <h6 class="dropdown-header">Tahun</h6>
                          <a class="dropdown-item" id="tahun" href="#">2024</a>
                          <a class="dropdown-item" id="tahun" href="#">2023</a>
                          <a class="dropdown-item" id="tahun" href="#">2022</a>
                          <a class="dropdown-item" id="tahun" href="#">2021</a>
                          <a class="dropdown-item" id="tahun" href="#">2020</a>
                        </div>
                      </div>
                      <div class="dropdown">
                      <button class="btn btn-gradient-success dropdown-toggle" type="button" id="dropdownMenuOutlineButton6" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Bulan </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton5">
                          <h6 class="dropdown-header">Bulan</h6>
                          <a class="dropdown-item" id="bulan" href="#">01 - Januari</a>
                          <a class="dropdown-item" id="bulan" href="#">02 - Februari</a>
                          <a class="dropdown-item" id="bulan" href="#">03 - Maret</a>
                          <a class="dropdown-item" id="bulan" href="#">04 - April</a>
                          <a class="dropdown-item" id="bulan" href="#">05 - Mei</a>
                          <a class="dropdown-item" id="bulan" href="#">06 - Juni</a>
                          <a class="dropdown-item" id="bulan" href="#">07 - Juli</a>
                          <a class="dropdown-item" id="bulan" href="#">08 - Agustus</a>
                          <a class="dropdown-item" id="bulan" href="#">09 - September</a>
                          <a class="dropdown-item" id="bulan" href="#">10 - Oktober</a>
                          <a class="dropdown-item" id="bulan" href="#">11 - November</a>
                          <a class="dropdown-item" id="bulan" href="#">12 - Desember</a>
                        </div>
                      </div>
                    </div>
                    <div id="map"></div>
                  </div>
                  <div class="card-body">
                    <h4 class="judul-chart"> Progres Tiap Wilayah</h4>
                    <div class="dropdown-chart">
                      <div class="dropdown">
                        <button class="btn btn-gradient-success dropdown-toggle" type="button" id="dropdownMenuOutlineButton8" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Tahun </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton8">
                          <h6 class="dropdown-header">Tahun</h6>
                          <a class="dropdown-item" id="tahun" href="#">2024</a>
                          <a class="dropdown-item" id="tahun" href="#">2023</a>
                          <a class="dropdown-item" id="tahun" href="#">2022</a>
                          <a class="dropdown-item" id="tahun" href="#">2021</a>
                          <a class="dropdown-item" id="tahun" href="#">2020</a>
                        </div>
                      </div>
                      <div class="dropdown">
                      <button class="btn btn-gradient-success dropdown-toggle" type="button" id="dropdownMenuOutlineButton9" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Bulan </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton9">
                          <h6 class="dropdown-header">Bulan</h6>
                          <a class="dropdown-item" id="bulan" href="#">01 - Januari</a>
                          <a class="dropdown-item" id="bulan" href="#">02 - Februari</a>
                          <a class="dropdown-item" id="bulan" href="#">03 - Maret</a>
                          <a class="dropdown-item" id="bulan" href="#">04 - April</a>
                          <a class="dropdown-item" id="bulan" href="#">05 - Mei</a>
                          <a class="dropdown-item" id="bulan" href="#">06 - Juni</a>
                          <a class="dropdown-item" id="bulan" href="#">07 - Juli</a>
                          <a class="dropdown-item" id="bulan" href="#">08 - Agustus</a>
                          <a class="dropdown-item" id="bulan" href="#">09 - September</a>
                          <a class="dropdown-item" id="bulan" href="#">10 - Oktober</a>
                          <a class="dropdown-item" id="bulan" href="#">11 - November</a>
                          <a class="dropdown-item" id="bulan" href="#">12 - Desember</a>
                        </div>
                      </div>
                      <div class="dropdown">
                        <button class="btn btn-gradient-success dropdown-toggle" type="button" id="dropdownMenuOutlineButton7" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Segmen </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton7">
                          <a class="dropdown-item" id="segmen" href="#">Subegmen</a>
                          <a class="dropdown-item" id="segmen" href="#">Segmen</a>
                          <a class="dropdown-item" id="segmen" href="#">Segmen dan Status</a>
                        </div>
                      </div>
                    </div>
                    <div>
                    <div class="row">
                      <div class="col-lg-6 grid-margin stretch-card">
                        <div class="card">
                          <div class="card-body">
                            <h4 class="card-title">Kabupaten Kota</h4>
                            <canvas id="lineChart" style="height: 292px; display: block; box-sizing: border-box; width: 585px;" width="1170" height="585"></canvas>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-6 grid-margin stretch-card">
                        <div class="card">
                          <div class="card-body">
                            <h4 class="card-title">Provinsi</h4>
                            <canvas id="barChart" style="height: 292px; display: block; box-sizing: border-box; width: 585px;" width="1170" height="585"></canvas>
                          </div>
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
    <script src="/assets/js/dropdown.js"></script>
    <!-- End custom js for this page -->
  </body>
</html>

<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="/assets/js/data/line.js"></script>
<script src="/assets/js/data/point.js"></script>
<script src="/assets/js/data/polygon.js"></script>
<script src="/assets/js/data/nepaldata.js"></script>
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
<script src="/assets/js/data/usstates.js"></script>
<script>

/*===================================================
                      OSM  LAYER               
===================================================*/

    var map = L.map('map').setView([-7.30324,110.00441], 8);
var osm = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
});
osm.addTo(map);

/*===================================================
                      MARKER               
===================================================*/

var singleMarker = L.marker([-7.30324,110.00441]);
singleMarker.addTo(map);
var popup = singleMarker.bindPopup('Jawa Tengah')
popup.addTo(map);

/*===================================================
                     TILE LAYER               
===================================================*/

var CartoDB_DarkMatter = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
subdomains: 'abcd',
	maxZoom: 19
});
CartoDB_DarkMatter.addTo(map);

// Google Map Layer

googleStreets = L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}',{
    maxZoom: 20,
    subdomains:['mt0','mt1','mt2','mt3']
 });
 googleStreets.addTo(map);

 // Satelite Layer
googleSat = L.tileLayer('http://{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}',{
   maxZoom: 20,
   subdomains:['mt0','mt1','mt2','mt3']
 });
googleSat.addTo(map);

var Stamen_Watercolor = L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/watercolor/{z}/{x}/{y}.{ext}', {
 attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a> &mdash; Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
subdomains: 'abcd',
minZoom: 1,
maxZoom: 16,
ext: 'jpg'
});
Stamen_Watercolor.addTo(map);


/*===================================================
                      GEOJSON               
===================================================*/

var linedata = L.geoJSON(lineJSON).addTo(map);
var pointdata = L.geoJSON(pointJSON).addTo(map);
var nepalData = L.geoJSON(nepaldataa).addTo(map);
var polygondata = L.geoJSON(polygonJSON,{
    onEachFeature: function(feature,layer){
        layer.bindPopup('<b>This is a </b>' + feature.properties.name)
    },
    style:{
        fillColor: 'red',
        fillOpacity:1,
        color: 'green'
    }
}).addTo(map);

/*===================================================
                      LAYER CONTROL               
===================================================*/

var baseLayers = {
    "Satellite":googleSat,
    "Google Map":googleStreets,
    "Water Color":Stamen_Watercolor,
    "OpenStreetMap": osm,
};

var overlays = {
    "Marker": singleMarker,
    "PointData":pointdata,
    "LineData":linedata,
    "PolygonData":polygondata
};

L.control.layers(baseLayers, overlays).addTo(map);


/*===================================================
                      SEARCH BUTTON               
===================================================*/

L.Control.geocoder().addTo(map);


/*===================================================
                      Choropleth Map               
===================================================*/

L.geoJSON(statesData).addTo(map);


function getColor(d) {
    return d > 1000 ? '#800026' :
           d > 500  ? '#BD0026' :
           d > 200  ? '#E31A1C' :
           d > 100  ? '#FC4E2A' :
           d > 50   ? '#FD8D3C' :
           d > 20   ? '#FEB24C' :
           d > 10   ? '#FED976' :
                      '#FFEDA0';
}

function style(feature) {
    return {
        fillColor: getColor(feature.properties.density),
        weight: 2,
        opacity: 1,
        color: 'white',
        dashArray: '3',
        fillOpacity: 0.7
    };
}

L.geoJson(statesData, {style: style}).addTo(map);

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

function resetHighlight(e) {
    geojson.resetStyle(e.target);
    info.update();
}

var geojson;
// ... our listeners
geojson = L.geoJson(statesData);

function zoomToFeature(e) {
    map.fitBounds(e.target.getBounds());
}

function onEachFeature(feature, layer) {
    layer.on({
        mouseover: highlightFeature,
        mouseout: resetHighlight,
        click: zoomToFeature
    });
}

geojson = L.geoJson(statesData, {
    style: style,
    onEachFeature: onEachFeature
}).addTo(map);

var info = L.control();

info.onAdd = function (map) {
    this._div = L.DomUtil.create('div', 'info'); // create a div with a class "info"
    this.update();
    return this._div;
};

// method that we will use to update the control based on feature properties passed
info.update = function (props) {
    this._div.innerHTML = '<h4>US Population Density</h4>' +  (props ?
        '<b>' + props.name + '</b><br />' + props.density + ' people / mi<sup>2</sup>'
        : 'Hover over a state');
};

info.addTo(map);

var legend = L.control({position: 'bottomright'});

legend.onAdd = function (map) {

    var div = L.DomUtil.create('div', 'info legend'),
        grades = [0, 10, 20, 50, 100, 200, 500, 1000],
        labels = [];

    // loop through our density intervals and generate a label with a colored square for each interval
    for (var i = 0; i < grades.length; i++) {
        div.innerHTML +=
            '<i style="background:' + getColor(grades[i] + 1) + '"></i> ' +
            grades[i] + (grades[i + 1] ? '&ndash;' + grades[i + 1] + '<br>' : '+');
    }

    return div;
};

legend.addTo(map);


</script>