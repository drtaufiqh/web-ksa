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
              <h3 class="page-title"> Database Petani</h3>
              <button type="button" id="tambah_btn" class="btn btn-gradient-primary btn-icon-text" onclick="tambah()" style="background: linear-gradient(to right, #696b4c, #b9af49)"  data-toggle="modal" data-target="#editModal"  data-backdrop="static" data-keyboard="false">
              <i class="fa fa-plus-circle"></i> Tambah Data </button>
            </div>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div id="hasil"></div>
                    </div>
{{--
                    <!-- Modal for Edit Form -->
                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel">Data Petani</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <form id="editForm">
                              <div class="form-group">
                                <label for="segmen">Kode Segmen</label>
                                <input type="text" class="form-control" id="segmen" value="3301261826" readonly>
                              </div>
                              <div class="form-group">
                                <label for="subsegmen">Subsegmen</label>
                                <input type="text" class="form-control" id="subsegmen" value="C1">
                              </div>
                              <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control" id="nama" placeholder="Masukkan nama">
                              </div>
                              <div class="form-group">
                                <label for="nik">NIK</label>
                                <input type="text" class="form-control" id="nik" placeholder="Masukkan NIK">
                              </div>
                              <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control" id="alamat" rows="2" placeholder="Masukkan alamat"></textarea>
                              </div>
                              <div class="form-group">
                                <label for="noHp">No. HP</label>
                                <input type="text" class="form-control" id="noHp" placeholder="Masukkan No. HP">
                              </div>
                              <button type="submit" class="btn btn-gradient-primary btn-icon-text" style="background: linear-gradient(to right, #696b4c, #b9af49);margin-bottom: 1rem;">Submit</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div> --}}

                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                            <div class="modal-header" id="headerModal">
                                <h5 class="modal-title" id="judulModal">Petani</h5>
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
        var wilayah = '{{ Auth::user()->kode }}';
        var tmp_data = [];
        var tmp_segmen = '';
        var flag = 0;
    </script>

    <script>
        $(document).ready( function () {
            getPetani();
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
            '</div>';

        function unduh(){
            $("#tabelRaw").table2excel({
                name: "petani",
                filename: 'master_petani',//do not include extension
                fileext:".xls", // file extension
                preserveColors:true
            });
        }

        function tambah(){
            $('#formContainer').html(formKosong);
            $('#pesanContainer').html(
                '<div id="tombolModal" style="text-align:center">'+
                    '<div id="pesan" style="text-align:center"></div>'+
                    '<button id="submit_btn"type="submit" class="btn btn-gradient-primary btn-icon-text" style="background: linear-gradient(to right, #696b4c, #b9af49);margin-bottom: 1rem;" onclick="submitData()">Submit</button>'+
                '</div>'
            );
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
        }

        function ubah(y){
            $('#formContainer').html(formKosong);
            $('#segmen_i').val(tmp_data[y]['kode_segmen']);
            $('#subsegmen_i').val(tmp_data[y]['subsegmen']);
            $('#nik_i').val(tmp_data[y]['nik']);
            $('#nama_i').val(tmp_data[y]['nama']);
            $('#alamat_i').val(tmp_data[y]['alamat']);
            $('#hp_i').val(tmp_data[y]['hp']);
            $('#pesanContainer').html(
                '<div id="tombolModal" style="text-align:center">'+
                    '<div id="pesan" style="text-align:center"></div>'+
                    '<button id="submit_btn"type="submit" class="btn btn-gradient-primary btn-icon-text" style="background: linear-gradient(to right, #696b4c, #b9af49);margin-bottom: 1rem;" onclick="submitData()">Submit</button>'+
                '</div>'
            );
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
        }

        function hapus(y){
            var id = tmp_data[y]['id'];
            var data = {kode_segmen: '', subsegmen: '', id: id};
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type : "post",
                    url  : base_url+'ubinan/petani/deletePetani',
                    data : data,
                    success : function(data) {
                        let d = JSON.parse(data);
                        $('#pesanContainer').html(
                            '<h5 style="color:green">'+d.message+'</h5>'
                        );
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
                        flag = 1;
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText); // Log error response
                    }
                });
        }

        function submitData(){
            var error = 0;
            var pesan = '';
            var tmp_segmen = $('#segmen_i').val();
            var tmp_sub = $('#subsegmen_i').val();
            var tmp_nik = $('#nik_i').val();
            var tmp_nama = $('#nama_i').val();
            var tmp_alamat = $('#alamat_i').val();
            var tmp_hp = $('#hp_i').val();

            if(tmp_segmen.length != 9){
                error = 1;
                pesan = 'Kode Segmen harus 9 digit';
            } else {
                if(wilayah != '3300'){
                    if(tmp_segmen.substr(0,4) != wilayah) {
                        error = 1;
                        pesan = 'Tidak bisa menginput data petani wilayah sebelah';
                    }
                }
            }
            if(tmp_sub.length != 2){
                error = 1;
                pesan = 'Kode subsegmen harus 2 karakter';
            }
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
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type : "post",
                    url  : base_url+'ubinan/petani/insertPetani',
                    data : data,
                    success : function(data) {
                        let d = JSON.parse(data);
                        flag = 1;
                        $('#formContainer').html('');
                        $('#submit_btn').hide();
                        $('#pesanContainer').html(
                            '<h5 style="color:green">'+d.message+'</h5>'
                        );
                    }
                });
            } else {
                $('#pesan').html('<h5 style="color:red">Warning: '+pesan+'</h5>');
            }
        }

        function getPetani(){
            $.getJSON(base_url+'ubinan/petani/getAll',function(data,status){
                if(data['status']){
                    tmp_data = data['data'];
                    $('#hasil').html(
                        '<table id="tabelRaw" class="display compact">'+
                            '<thead>'+
                                '<tr>'+
                                    '<th>Segmen</th>'+
                                    '<th>Subsegmen</th>'+
                                    '<th style="display:none">NIK</th>'+
                                    '<th>Nama</th>'+
                                    '<th>HP</th>'+
                                    '<th>Alamat</th>'+
                                    '<th>Aksi</th>'+
                                '</tr>'+
                            '</thead>'+
                            '<tbody id="bodyRaw"></tbody>'+
                        '</table>'
                    );
                    for(y in data['data']){
                        $('#bodyRaw').append(
                            '<tr>'+
                                '<td>'+data['data'][y]['kode_segmen']+'</td>'+
                                '<td>'+data['data'][y]['subsegmen']+'</td>'+
                                '<td style="display:none">'+data['data'][y]['nik']+'</td>'+
                                '<td>'+data['data'][y]['nama']+'</td>'+
                                '<td>'+data['data'][y]['hp']+'</td>'+
                                '<td>'+data['data'][y]['alamat']+'</td>'+
                                '<td>'+
                                    '<button id="ubah_btn" type="button" class="btn btn-gradient-primary btn-icon-text" style="padding:0.5rem;background: #87c351;" onclick="ubah('+y+')"  data-toggle="modal" data-target="#editModal"  data-backdrop="static" data-keyboard="false"><i class="fa fa-edit"></i> Edit </button>'+
                                    '<button id="hapus_btn" type="button" class="btn btn-gradient-primary btn-icon-text" style="padding:0.5rem;background: #ff5050;" onclick="hapus('+y+')"  data-toggle="modal" data-target="#editModal"  data-backdrop="static" data-keyboard="false"><i class="fa fa-trash-o"></i> Hapus </button>'+
                                '</td>'+
                            '</tr>'
                        );
                    }

                    $('#tabelRaw').DataTable({
                        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
                    });
                } else {
                    $('#hasil').html(pesanKosong);
                }
            });
        }

        function cancel(){
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
            if(flag==1) location.reload();
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#padiamatan-table').DataTable({
                "pageLength": 10, // Jumlah default baris per halaman
                "lengthMenu": [5, 10, 25, 50, 100], // Opsi jumlah baris per halaman
                "order": [[ 0, "asc" ]], // Urutkan berdasarkan kolom pertama secara ascending
            });
        });
    </script>
  </body>
</html>
