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
          <div class="content-wrapper" style="background: linear-gradient(to right, #f1edc1, #dbe4be);">
            <div class="page-header" style="background-color: #5e5741">
              <h3 class="page-title">Lacak </h3>
            </div>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <form id="formulir-awal">
                    @csrf
                        <div class="form-group row" id="tahun_g" style="margin-bottom: 0;">
                          <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Tahun Amatan</label>
                          <div class="col-sm-9">
                            <select type="text" class="form-control" id="tahun_i">
                                <?php for($tahun=date('Y'); $tahun>=2021; $tahun--){
                                    echo '<option value="'.$tahun.'">'.$tahun.'</option>';
                                } ?>
                            </select>
                          </div>
                        </div>

                        <div class="form-group row" id="bulan_g" style="margin-bottom: 0;">
                            <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Bulan Amatan</label>
                            <div class="col-sm-9">
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
                            <label for="exampleInputMobile" class="col-sm-3 col-form-label">Tahun Sample</label>
                            <div class="col-sm-9">
                              <select type="text" class="form-control" id="tahunsampel_i">
                                <?php for($tahun=date('Y'); $tahun>=2021; $tahun--){
                                    echo '<option value="'.$tahun.'">'.$tahun.'</option>';
                                } ?>
                              </select>
                            </div>
                        </div>


                        <div class="form-group row" id="bulansampel_g" style="margin-bottom: 0;">
                            <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Bulan Sample</label>
                            <div class="col-sm-9">
                            <select class="form-control" id="bulansampel_i" >
                                <option value="1" <?php if(date("m")<3) echo "selected";?>>Jan - Feb</option>
                                <option value="3" <?php if(date("m")>=3 && date("m")<5) echo "selected";?>>Mar - Apr</option>
                                <option value="5" <?php if(date("m")>=5 && date("m")<7) echo "selected";?>>Mei - Jun</option>
                                <option value="7" <?php if(date("m")>=7 && date("m")<9) echo "selected";?>>Jul - Ags</option>
                                <option value="9" <?php if(date("m")>=9 && date("m")<11) echo "selected";?>>Sep - Okt</option>
                                <option value="11" <?php if(date("m")>=11) echo "selected";?>>Nov - Des</option>
                                <option value="">- - -</option>
                                <option value="21">[Jan - Apr]</option>
                                <option value="22">[Mei - Ags]</option>
                                <option value="23">[Sep - Des]</option>
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

                    <button id="tambah_btn" type="button" class="btn btn-gradient-primary btn-icon-text" onclick="proses()" style="padding:0.5rem;background: #a18c4a;">
                        <i class="fa fa-refresh"></i> Lihat </button>

                    <div id="hasilValidasi"></div>
                  <form class="forms-sample">

                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                            <div class="modal-header" id="headerModal">
                                <h5 class="modal-title" id="judulModal"></h5>
                                <button id="close_btn" type="button" class="close" aria-label="Close" onclick="cancel()">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div id="isiModal">
                                    <div id="formContainer"></div>
                                    <div id="pesanContainer"></div>
                                </div>
                            </div>
                            <div class="modal-footer"></div>
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
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        var base_url = '/';
        var level = '{{ Auth::user()->role }}';
        var opsi = '5';
        var wilayah = '{{ Auth::user()->kode }}';
        var tmp_segmen = '';
        var tmp_sub = '';
        var tmp_nik = '';
        var tmp_nama = '';
        var tmp_alamat = '';
        var tmp_hp = '';
    </script>
<script>
    // moment.locale('id');
    $(document).ready( function () {
        $('#loading1').hide();
    });
    var formKosong =
        '<form id="formulir">'+
            '<div class="form-inline" id="segmen_g">'+
                '<label style="width:25%">Segmen</label>'+
                '<input type="text" class="form-control" id="segmen_i" style="width:75%">'+
            '</div>'+
            '<div class="form-inline" id="subsegmen_g">'+
                '<label style="width:25%">Subsegmen</label>'+
                '<input type="text" class="form-control" id="subsegmen_i" style="width:75%">'+
            '</div>'+
            '<div class="form-inline" id="nama_g">'+
                '<label style="width:25%">Nama</label>'+
                '<input type="text" class="form-control" id="nama_i" style="width:75%">'+
            '</div>'+
            '<div class="form-inline" id="nik_g">'+
                '<label style="width:25%">NIK</label>'+
                '<input type="text" class="form-control" id="nik_i" style="width:75%">'+
            '</div>'+
            '<div class="form-inline" id="alamat_g">'+
                '<label style="width:25%">Alamat</label>'+
                '<input type="text" class="form-control" id="alamat_i" style="width:75%">'+
            '</div>'+
            '<div class="form-inline" id="hp_g">'+
                '<label style="width:25%">No HP</label>'+
                '<input type="text" class="form-control" id="hp_i" style="width:75%">'+
            '</div>'+
        '</form>';

    var pesanKosong =
        '<div id="tombolModal" style="text-align:center">'+
            '<img id="image" src="'+base_url+'assets/img/farmer.png" style="height:100px;margin-bottom:5px">'+
            '<p id="pesan">Data Petani belum ada</p>'+
            '<button id="tambah_btn" class="btn btn-sm btn-primary" onclick="tambah()">Tambah</button>'+
        '</div>';

    var formAda =
        '<table id="tablePetani" class="table table-borderless">'+
            '<tr>'+
                '<td>Segmen</td>'+
                '<td id="a"></td>'+
            '</tr>'+
            '<tr>'+
                '<td>Subsegmen</td>'+
                '<td id="b"></td>'+
            '</tr>'+
            '<tr>'+
                '<td>Nama</td>'+
                '<td id="c"></td>'+
            '</tr>'+
            '<tr>'+
                '<td>NIK</td>'+
                '<td id="d"></td>'+
            '</tr>'+
            '<tr>'+
                '<td>Alamat</td>'+
                '<td id="e"></td>'+
            '</tr>'+
            '<tr>'+
                '<td>HP</td>'+
                '<td id="f"></td>'+
            '</tr>'+
        '</table>';

    var pesanAda =
        '<div id="tombolModal" style="text-align:center">'+
            '<div id="pesan" style="text-align:center"></div>'+
            '<button type="button" id="ubah_btn" class="btn btn-gradient-primary btn-icon-text" style="padding:0.5rem;background: #87c351;" onclick="ubah()">Ubah</button>'+
            '<button type="button" id="hapus_btn" class="btn btn-gradient-primary btn-icon-text" style="padding:0.5rem;background: #ff5050;" onclick="hapus()">Hapus</button>'+
        '</div>';

    function unduh(){
        $("#tabelHasil").table2excel({
            name: "lacak",
            filename: $('#tahun_i').val()+$('#bulan_i').val()+wilayah+'_ubinan',//do not include extension
            fileext:".xls", // file extension
            preserveColors:true
        });
    }

    function infoPetani(segmen,sub){
        tmp_segmen = segmen;
        tmp_sub = sub;
        $.getJSON(base_url+'ubinan/petani/getBySubsegmen/'+segmen+'/'+sub,function(data,status){
            $('#judulModal').html('Petani');
            if(data['status']){
                tmp_nama = data['data'][0]['nama'];
                tmp_nik = data['data'][0]['nik'];
                tmp_alamat = data['data'][0]['alamat'];
                tmp_hp = data['data'][0]['hp'];
                $('#formContainer').html(formAda);
                $('#pesanContainer').html(pesanAda);
                $('#a').html(': '+tmp_segmen);
                $('#b').html(': '+tmp_sub);
                $('#c').html(': '+tmp_nama);
                $('#d').html(': '+tmp_nik);
                $('#e').html(': '+tmp_alamat);
                $('#f').html(': '+tmp_hp);
            } else {
                $('#pesanContainer').html(pesanKosong);
            }
            // Tampilkan modal
            $('#editModal').modal({backdrop:'static', keyboard:false});
            $('#editModal').on('hidden.bs.modal', function () {
                $('.modal-backdrop').remove();  // Hapus backdrop yang mungkin tertinggal
                $('body').removeClass('modal-open');  // Pastikan class modal-open dihapus dari body
            });
            $('#editModal').on('show.bs.modal', function () {
                $('.modal-backdrop').remove();  // Bersihkan backdrop sebelum membuka modal lagi
            });
            $('#editModal').on('hide.bs.modal', function (e) {
                if (e.target !== this) {  // Pastikan hanya modal yang dapat ditutup secara eksplisit
                    e.preventDefault();
                }
            });
        });
    }

    function tambah(){
        $('#formContainer').html(formKosong);
        $('#segmen_i').val(tmp_segmen);
        $('#subsegmen_i').val(tmp_sub);
        $('#pesanContainer').html(
            '<div id="tombolModal" style="text-align:center">'+
                '<div id="pesan" style="text-align:center"></div>'+
                '<button type="button" id="submit_btn" type="submit" class="btn btn-gradient-primary btn-icon-text" style="background: linear-gradient(to right, #696b4c, #b9af49);margin-bottom: 1rem;" onclick="submitData()">Submit</button>'+
            '</div>'
        );
    }
    function ubah(){
        $('#formContainer').html(formKosong);
        $('#segmen_i').val(tmp_segmen);
        $('#subsegmen_i').val(tmp_sub);
        $('#nik_i').val(tmp_nik);
        $('#nama_i').val(tmp_nama);
        $('#alamat_i').val(tmp_alamat);
        $('#hp_i').val(tmp_hp);
        $('#pesanContainer').html(
            '<div id="tombolModal" style="text-align:center">'+
                '<div id="pesan" style="text-align:center"></div>'+
                '<button type="button" id="submit_btn"type="submit" class="btn btn-gradient-primary btn-icon-text" style="background: linear-gradient(to right, #696b4c, #b9af49);margin-bottom: 1rem;" onclick="submitData()">Submit</button>'+
            '</div>'
        );
    }

    function hapus(){
        var id = '';
        var data = {kode_segmen: tmp_segmen, subsegmen: tmp_sub, id: id};
            $.ajax({
                type : "post",
                url  : base_url+'ubinan/petani/deletePetani',
                data : data,
                success : function(data) {
                    let d = JSON.parse(data);
                    console.log(d);
                    $('#formContainer').html('');
                    $('#pesanContainer').html(pesanKosong);
                    $('#pesan').html(
                        '<h5 style="color:green">'+d.message+'</h5>'
                    );
                }
            });
    }

    function submitData(){
        var error = 0;
        var pesan = '';
        tmp_nik = $('#nik_i').val();
        tmp_nama = $('#nama_i').val();
        tmp_alamat = $('#alamat_i').val();
        tmp_hp = $('#hp_i').val();

        if(tmp_alamat.length < 10){
            error = 1;
            pesan = 'Alamat minimal 10 karakter';
        }
        if(tmp_nama.length < 3){
            error = 1;
            pesan = 'Nama minimal 3 karakter';
        }
        if(error == 0){
            var data = {kode_segmen: tmp_segmen, subsegmen: tmp_sub, nik: tmp_nik, nama: tmp_nama, alamat: tmp_alamat, hp: tmp_hp};
            $.ajax({
                type : "post",
                url  : base_url+'ubinan/petani/insertPetani',
                data : data,
                success : function(data) {
                    let d = JSON.parse(data);
                    $('#formContainer').html(formAda);
                    $('#pesanContainer').html(pesanAda);
                    $('#a').html(': '+tmp_segmen);
                    $('#b').html(': '+tmp_sub);
                    $('#c').html(': '+tmp_nama);
                    $('#d').html(': '+tmp_nik);
                    $('#e').html(': '+tmp_alamat);
                    $('#f').html(': '+tmp_hp);
                    $('#pesan').html(
                        '<h5 style="color:green">'+d.message+'</h5>'
                    );
                }
            });
        } else {
            $('#pesan').html('<h5 style="color:red">Warning: '+pesan+'</h5>');
        }
    }

    function proses(){
        $('#loading1').show();
        var error = 0;
        var pesan = '';
        var tahun = $('#tahun_i').val();
        var bulan = $('#bulan_i').val();
        var bulansampel = $('#bulansampel_i').val();
        var tahunsampel = $('#tahunsampel_i').val();
        var tabul = tahun+''+bulan;

        console.log(tahun);
        console.log(bulan);
        console.log(tahunsampel);
        console.log(bulansampel);
        console.log(tabul);
        if(error == 1){
            $('#pesan').html('<h5 style="color:red">'+pesan+'</h5>');
        } else {
            $('#pesan').html('');
            var data = {tabul: tabul, bulansampel: bulansampel, tahunsampel: tahunsampel};
            console.log('masuk else');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type : "post",
                url  : base_url+'ubinan-lacak-proses',
                data : data,
                success : function(data) {
                    $('#loading1').hide();
                    let d = JSON.parse(data);
                    // tmp_data = d.sampel;
                    if(d.status){
                        $('#hasilValidasi').html(
                            '<table class="table table-bordered table-sm" style="margin-top:5px">'+
                                '<thead class="thead-light">'+
                                    '<tr>'+
                                        '<th style="text-align:center">Keterangan</th>'+
                                        '<th style="text-align:center">Fase</th>'+
                                        '<th style="text-align:center">Subsegmen Utama</th>'+
                                        '<th style="text-align:center">Subsegmen Cadangan</th>'+
                                    '</tr>'+
                                '</thead>'+
                                '<tbody>'+
                                    '<tr>'+
                                        '<td>Available</td>'+
                                        '<td>2-Vegetatif Akhir <br> 3-Generatif</td>'+
                                        '<td><b>'+d.count[0]+'</b></td>'+
                                        '<td><b>'+d.count[3]+'</b></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                        '<td>Unavailable</td>'+
                                        '<td>4-Panen</td>'+
                                        '<td><b>'+d.count[1]+'</b></td>'+
                                        '<td><b>'+d.count[4]+'</b></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                        '<td>Non-eligible</td>'+
                                        '<td>Fase lainnya</td>'+
                                        '<td><b>'+d.count[2]+'</b></td>'+
                                        '<td><b>'+d.count[5]+'</b></td>'+
                                    '</tr>'+
                                '</tbody>'+
                            '</table>'+
                            '<div style="overflow-x:scroll">'+
                                '<table id="tabelHasil" class="display compact">'+
                                    '<thead>'+
                                        '<tr>'+
                                            '<th>Kode Segmen</th>'+
                                            '<th>Subsegmen</th>'+
                                            '<th>Nilai Amatan</th>'+
                                            '<th>NKS</th>'+
                                            '<th>Strata</th>'+
                                            '<th>Bulan</th>'+
                                            '<th>Jenis Sampel</th>'+
                                            '<th>Keterangan</th>'+
                                            '<th style="display:none">PCS</th>'+
                                            '<th style="display:none">PMS</th>'+
                                            '<th>Petani</th>'+
                                        '</tr>'+
                                    '</thead>'+
                                    '<tbody id="bodyTable"></tbody>'+
                                '</table>'+
                            '</div>'
                        );
                        for(x in d.sampel){
                            $('#bodyTable').append(
                                '<tr>'+
                                    '<td>'+d.sampel[x]['kode_segmen']+'</td>'+
                                    '<td>'+d.sampel[x]['subsegmen']+'</td>'+
                                    '<td style="background-color:'+d.sampel[x]['color']+'">'+d.sampel[x]['amatan']+'</td>'+
                                    '<td>'+d.sampel[x]['nks']+'</td>'+
                                    '<td>'+d.sampel[x]['strata']+'</td>'+
                                    '<td>'+d.sampel[x]['bln']+'</td>'+
                                    '<td>'+d.sampel[x]['jenis_sampel']+'</td>'+
                                    '<td style="background-color:'+d.sampel[x]['color']+'">'+d.sampel[x]['keterangan']+'</td>'+
                                    '<td style="display:none">'+d.sampel[x]['pcs']+'</td>'+
                                    '<td style="display:none">'+d.sampel[x]['pms']+'</td>'+
                                    '<td onclick="infoPetani('+d.sampel[x]['kode_segmen']+',\''+d.sampel[x]['subsegmen']+'\')">' +
                                        '<button type="button" class="btn btn-gradient-primary btn-icon-text" style="padding:0.2rem;background: #87c351;" data-toggle="modal" data-target="#editModal" data-backdrop="static" data-keyboard="false">' +
                                            '<i class="fa fa-edit"></i> Edit' +
                                        '</button>'+
                                    '</td>'+
                                '</tr>'
                            )
                        }
                        $('#tabelHasil').DataTable({
                            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
                        });
                    } else {
                        $('#hasilValidasi').html('<h4>'+d.message+'</h4>');
                    }
                }
            });
        }
    }

    function cancel(){
        tmp_segmen = '';
        tmp_sub = '';
        tmp_nik = '';
        tmp_nama = '';
        tmp_alamat = '';
        tmp_hp = '';
        $('#formContainer').html('');
        $('#pesanContainer').html('');
        $('#editModal').hide();
        $('#editModal').modal('hide');
        $('.modal-backdrop').remove();  // Hapus elemen backdrop
        $('#editModal').on('hidden.bs.modal', function () {
            $('.modal-backdrop').remove();  // Hapus backdrop yang mungkin tertinggal
            $('body').removeClass('modal-open');  // Pastikan class modal-open dihapus dari body
        });
        $('#editModal').on('show.bs.modal', function () {
            $('.modal-backdrop').remove();  // Bersihkan backdrop sebelum membuka modal lagi
        });
        $('#editModal').on('hide.bs.modal', function (e) {
            if (e.target !== this) {  // Pastikan hanya modal yang dapat ditutup secara eksplisit
                e.preventDefault();
            }
        });
    }
</script>
  </body>
</html>
