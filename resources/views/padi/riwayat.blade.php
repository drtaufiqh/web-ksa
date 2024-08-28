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
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        /* Style untuk modal pop-up */
        .modal-dialog {
            max-width: 800px;
        }
    </style>
</head>
<body>
    <div class="container-scroller">
        <!-- resources/views/home.blade.php -->
        @include('components.navbar-padi')

        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Riwayat </h3>
            </div>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <form class="forms-sample" style="display:flex">
                        <!-- Dropdown untuk memilih kab/kota -->
                            <label for="kabkota-select" style="margin-bottom:2rem">Wilayah Amatan</label>
                            <select id="kabkota-select" class="form-control">
                                <option value="all">Seluruh Kab/Kota</option>
                                @foreach ($allKabKota as $item)
                                    <option value="{{ substr($item, 0,4) }}">{{ $item }}</option>
                                @endforeach
                            </select>
                    </form>
                    <!-- Tabel data -->
                    <table id="datatable" class="display table table-striped" style="border: 1px solid #ebedf2;">
                        <thead>
                            <tr>
                                <th>Kab/Kota</th>
                                <th>Tahun</th>
                                <th>Bulan</th>
                                <th>Baris</th>
                                <th>Last Update</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $row)
                            <tr data-kode="{{ $row->kode_kabkota }}">
                                <td>{{ $row->kab_kota }}</td>
                                <td>{{ $row->tahun }}</td>
                                <td>{{ $row->bulan }}</td>
                                <td>{{ $row->baris }}</td>
                                <td>{{ $row->last_update }}</td>
                                <td>
                                    <button class="btn btn-gradient-primary btn-icon-text" data-id="{{ $row->kode_kabkota }}" style="padding:0.5rem;background: #87c351;">
                                        <i class="fa fa-edit"></i> Lihat
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Modal untuk menampilkan tabel detail -->
                    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="detailModalLabel">Detail Data</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Tabel detail -->
                                    <table id="tabel-popup" class="table table-bordered table-sm">
                                        <thead>
                                            <tr>
                                                <th>Kode Segmen</th>
                                                <th>A1</th>
                                                <th>A2</th>
                                                <th>A3</th>
                                                <th>B1</th>
                                                <th>B2</th>
                                                <th>B3</th>
                                                <th>C1</th>
                                                <th>C2</th>
                                                <th>C3</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Baris detail akan diisi dengan JavaScript -->
                                        </tbody>
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="btn btn-gradient-primary btn-icon-text">
                    <i class="fa fa-download"></i> Unduh </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2023 <a href="https://www.bootstrapdash.com/" target="_blank">BootstrapDash</a>. All rights reserved.</span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i></span>
            </div>
          </footer>
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
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            // Initialize main DataTable
            var table = $('#datatable').DataTable({
                "pageLength": 10,
                "lengthMenu": [5, 10, 20, 50],
                "compact": true
            });

            // DataTable instance for modal
            var popupTable = $('#tabel-popup').DataTable({
                "paging": true, // Pastikan pagination diaktifkan
                "pageLength": 10,
                "lengthMenu": [5, 10, 20, 50],
                "bDestroy": true, // Allow re-initialization
                "searching": true,
                "info": true
            });

            $('#kabkota-select').on('change', function () {
                var selectedValue = $(this).val();

                if (selectedValue === 'all') {
                    // Tampilkan semua baris dan kolom
                    table.columns().search('').draw();
                    // table.column(0).visible(true); // Tampilkan kolom Kab/Kota
                } else {
                    // Filter berdasarkan kab/kota yang dipilih
                    table.columns(0).search(selectedValue).draw();
                    // table.column(0).visible(false); // Sembunyikan kolom Kab/Kota
                }
            });

            // Aksi tombol lihat
            $('#datatable').on('click', '.view-btn', function () {
                var id = $(this).data('id');
                // Lakukan AJAX atau ambil data detail berdasarkan ID
                $.ajax({
                    url: '/padi_detail/' + id, // Ganti dengan URL yang sesuai untuk mengambil data detail
                    method: 'GET',
                    success: function (response) {
                        // Kosongkan tabel popup
                        popupTable.clear().draw();
                        
                        // Tambahkan baris detail ke tabel popup
                        var rows = '';
                        response.data.forEach(function (item) {
                            rows += '<tr>' +
                                '<td>' + item.kode_segmen + '</td>' +
                                '<td>' + item.a1 + '</td>' +
                                '<td>' + item.a2 + '</td>' +
                                '<td>' + item.a3 + '</td>' +
                                '<td>' + item.b1 + '</td>' +
                                '<td>' + item.b2 + '</td>' +
                                '<td>' + item.b3 + '</td>' +
                                '<td>' + item.c1 + '</td>' +
                                '<td>' + item.c2 + '</td>' +
                                '<td>' + item.c3 + '</td>' +
                            '</tr>';
                        });
                        popupTable.rows.add($(rows)).draw();
                        
                        // Tampilkan modal
                        $('#detailModal').modal('show');
                    }
                });
            });
        });
    </script>
  </body>
</html>