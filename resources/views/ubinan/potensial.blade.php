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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="/assets/img/logo.png" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
  <body>
    <div class="container-scroller">
        <!-- resources/views/home.blade.php -->
        @include('components.navbar-ubin')

        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper" style="background: linear-gradient(to right, #f3efe7, #fff8e9);">
            <div class="page-header" style="background-color: #5e5741">
              <h3 class="page-title">Amatan Potensial</h3>
            </div>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <form id="formulir">
                    @csrf
                        {{-- Tahun --}}
                        @php
                            $years = [];
                            $currentYear = $currentYear ?? Carbon::now()->year; // Menggunakan tahun sekarang jika tidak ada
                            $minYear = $minYear ?? 2020; // Menyediakan tahun default jika tidak ada dari database

                            // Generate array tahun dari tahun sekarang ke tahun terkecil
                            for ($year = $currentYear; $year >= $minYear; $year--) {
                                $years[] = $year;
                            }
                        @endphp

                        <div class="form-group row" id="tahun_g" style="margin-bottom: 0;">
                            <label for="tahun_i" class="col-sm-3 col-form-label">Tahun Amatan</label>
                            <div class="col-sm">
                                <select type="text" class="form-control" id="tahun_i">
                                    @foreach($years as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row" id="bulan_g" style="margin-bottom: 0;">
                            <label for="bulan_i" class="col-sm-3 col-form-label">Bulan Amatan</label>
                            <div class="col-sm">
                                <select class="form-control" id="bulan_i">
                                    <option value="01" <?php if(date("m")=="01") echo "selected";?>>01 - Januari</option>
                                    <option value="02" <?php if(date("m")=="02") echo "selected";?>>02 - Februari</option>
                                    <option value="03" <?php if(date("m")=="03") echo "selected";?>>03 - Maret</option>
                                    <option value="04" <?php if(date("m")=="04") echo "selected";?>>04 - April</option>
                                    <option value="05" <?php if(date("m")=="05") echo "selected";?>>05 - Mei</option>
                                    <option value="06" <?php if(date("m")=="06") echo "selected";?>>06 - Juni</option>
                                    <option value="07" <?php if(date("m")=="07") echo "selected";?>>07 - Juli</option>
                                    <option value="08" <?php if(date("m")=="08") echo "selected";?>>08 - Agustus</option>
                                    <option value="09" <?php if(date("m")=="09") echo "selected";?>>09 - September</option>
                                    <option value="10" <?php if(date("m")=="10") echo "selected";?>>10 - Oktober</option>
                                    <option value="11" <?php if(date("m")=="11") echo "selected";?>>11 - November</option>
                                    <option value="12" <?php if(date("m")=="12") echo "selected";?>>12 - Desember</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row" id="tahunsampel_g" style="margin-bottom: 0;">
                            <label for="tahunsampel_i" class="col-sm-3 col-form-label">Tahun Sampel</label>
                            <div class="col-sm">
                                <select type="text" class="form-control" id="tahunsampel_i">
                                    @foreach($years as $year)
                                        <option value="{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row" id="bulansampel_g" style="margin-bottom: 0;">
                            <label for="bulansampel_i" class="col-sm-3 col-form-label">Bulan sampel</label>
                            <div class="col-sm">
                                <select class="form-control" id="bulansampel_i">
                                    <option value="1" <?php if(date("m")<3) echo "selected";?>>Jan - Feb</option>
                                    <option value="3" <?php if(date("m")>=3 && date("m")<5) echo "selected";?>>Mar - Apr</option>
                                    <option value="5" <?php if(date("m")>=5 && date("m")<7) echo "selected";?>>Mei - Jun</option>
                                    <option value="7" <?php if(date("m")>=7 && date("m")<9) echo "selected";?>>Jul - Ags</option>
                                    <option value="9" <?php if(date("m")>=9 && date("m")<11) echo "selected";?>>Sep - Okt</option>
                                    <option value="11" <?php if(date("m")>=11) echo "selected";?>>Nov - Des</option>
                                </select>
                            </div>
                        </div>
                    </form>
                    <div id="pesan1"></div>
                    <div id="loading1" class="text-center">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    <button id="tambah_btn" type="button" type="button" class="btn btn-gradient-primary btn-icon-text" style="padding:0.5rem;background: #a18c4a;margin-bottom: 1rem;" onclick="proses()">
                        <i class="fa fa-refresh"></i> Lihat </button>
                    <div id="hasilValidasi"></div>
                  </div>
                </div>
              </div>
            </div>


            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                    <div class="modal-header" id="headerModal">
                        <h5 class="modal-title" id="judulModal">Keterangan</h5>
                        <button id="close_btn" type="button" class="close" aria-label="Close" onclick="cancel()">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="isiModal"></div>
                    </div>
                    <div class="modal-footer"></div>
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
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="/assets/js/off-canvas.js"></script>
    <script src="/assets/js/misc.js"></script>
    <script src="/assets/js/settings.js"></script>
    <script src="/assets/js/todolist.js"></script>
    <script src="/assets/js/jquery.cookie.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="/assets/js/file-upload.js"></script>
    <script src="/assets/js/typeahead.js"></script>
    <script src="/assets/js/select2.js"></script>
    <!-- End custom js for this page -->

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
    var base_url = '/';
    var level = '{{ Auth::user()->role }}';
    var opsi = '5';
    var wilayah = '{{ Auth::user()->kode }}'
</script>
<script>
    // moment.locale('id');
    $(document).ready( function () {
        $('#loading1').hide();
    });

    function unduh(){
        if(opsi<2){
            var txt = 'bppt';
        } else {
            var txt = 'pro';
        }
        $("#tabelHasil").table2excel({
            name: "potensial",
            filename: $('#tahun_i').val()+$('#bulan_i').val()+wilayah+'_potensial',//do not include extension
            fileext:".xls", // file extension
            preserveColors:true
        });
    }

    function proses(){
        $('#loading1').show();
        var error = 0;
        var pesan = '';
        var tahun = $('#tahun_i').val();
        var bulan = $('#bulan_i').val();
        var bulansampel = $('#bulansampel_i').val();
        var tahunsampel = $('#tahunsampel_i').val();
        var tabul = tahun+bulan;

        if(error == 1){
            $('#pesan').html('<h5 style="color:red">'+pesan+'</h5>');
        } else {
            $('#pesan').html('');
            var data = {tabul: tabul, bulansampel: bulansampel, tahunsampel: tahunsampel};
            console.log(data);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type : "post",
                url  : base_url+'ubinan/lacak/cadangan',
                data : data,
                success : function(data) {
                    $('#loading1').hide();
                    let d = JSON.parse(data);
                    if(d.status){
                        $('#hasilValidasi').html(
                            // '<h5>Konsisten = '+d.count[0]+' subsegmen | '+d.count[3]+' segmen</h5>'+
                            // '<h5>Inkonsisten = '+d.count[1]+' subsegmen | '+d.count[4]+' segmen</h5>'+
                            // '<p>Keterangan: data sebelah kiri (BPPT) vs data sebelah kanan (Pro)</p>'+
                            '<div style="overflow-x:scroll">'+
                                '<table id="tabelHasil" class="table table-striped" style="border: 1px solid #ebedf2;">'+
                                    '<thead>'+
                                        '<tr>'+
                                            '<th>Kode Segmen</th>'+
                                            '<th>Subsegmen</th>'+
                                            '<th>Nilai Amatan</th>'+
                                            // '<th>Kelurahan</th>'+
                                        '</tr>'+
                                    '</thead>'+
                                    '<tbody id="bodyTable"></tbody>'+
                                '</table>'+
                            '</div>'
                        );
                        for(x in d.segmen){
                            $('#bodyTable').append(
                                '<tr>'+
                                    '<td>'+d.segmen[x]['kode_segmen']+'</td>'+
                                    '<td>'+d.segmen[x]['subsegmen']+'</td>'+
                                    '<td>'+d.segmen[x]['amatan']+'</td>'+
                                    // '<td>'+d.segmen[x]['kel']+'</td>'+
                                '</tr>'
                            )
                        }
                        $('#tabelHasil').DataTable({
                            "pageLength": 10, // Jumlah default baris per halaman
                            "lengthMenu": [[5,10,25,50,100,-1],[5, 10, 25, 50, 100, 'All']], // Opsi jumlah baris per halaman
                            "order": [[ 0, "asc" ]], // Urutkan berdasarkan kolom pertama secara ascending
                            "compact": true,
                            dom: 'lfrtpB',
                            buttons: [
                                {
                                    extend: 'excel',
                                    text: '<i class="fa fa-download"></i> Unduh ',
                                    className: "btn btn-gradient-primary btn-icon-text mt-1",
                                    title: function() {
                                        var tahun = $('#tahun_i').val();
                                        var bulan = $('#bulan_i').val();
                                        var tahunsampel = $('#tahunsampel_i').val();
                                        var bulansampel = $('#bulansampel_i option:selected').text();
                                        var kabkota = '{{ Auth::user()->kode }}';
                                        return 'Padi Potensial Ubinan ' + bulansampel + ' ' + tahunsampel + ' ' + kabkota + ' Berdasarkan Amatan ' + bulan + ' ' + tahun;
                                    },
                                    filename: function() {
                                        var tahun = $('#tahun_i').val();
                                        var bulan = $('#bulan_i').val();
                                        var tahunsampel = $('#tahunsampel_i').val();
                                        var bulansampel = $('#bulansampel_i option:selected').text();
                                        var kabkota = '{{ Auth::user()->kode }}';
                                        return 'Padi Potensial Ubinan ' + bulansampel + ' ' + tahunsampel + ' ' + kabkota + ' Berdasarkan Amatan ' + bulan + ' ' + tahun;
                                    },
                                    init: function(api, node, config) {
                                        $(node).css({
                                            'background': 'linear-gradient(to right, #696b4c, #b9af49)',
                                        });
                                    }
                                },
                                {
                                    extend: 'copy',
                                    text: '<i class="fa fa-copy"></i> Salin ',
                                    className: "btn btn-gradient-primary btn-icon-text mt-1",
                                    title: function() {
                                        var tahun = $('#tahun_i').val();
                                        var bulan = $('#bulan_i').val();
                                        var tahunsampel = $('#tahunsampel_i').val();
                                        var bulansampel = $('#bulansampel_i option:selected').text();
                                        var kabkota = '{{ Auth::user()->kode }}';
                                        return 'Padi Potensial Ubinan ' + bulansampel + ' ' + tahunsampel + ' ' + kabkota + ' Berdasarkan Amatan ' + bulan + ' ' + tahun;
                                    },
                                    init: function(api, node, config) {
                                        $(node).css({
                                            'background': 'linear-gradient(to right, #696b4c, #b9af49)',
                                        });
                                    }
                                }
                            ],
                        });
                    } else {
                        $('#hasilValidasi').html('<h4>'+d.message+'</h4>');
                    }
                }
            });
        }
    }

    function cancel(){
        $('#isiModal').html('');
        $('#exampleModal').modal('hide');
    }
</script>
<!-- DataTables Buttons JS -->
<script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>
  </body>
</html>
