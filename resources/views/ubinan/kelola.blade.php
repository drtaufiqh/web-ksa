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
              <button type="button" class="btn btn-gradient-primary btn-icon-text"style="background: linear-gradient(to right, #696b4c, #b9af49)" data-toggle="modal" data-target="#editModal">
              <i class="fa fa-plus-circle"></i> Tambah Data </button>
            </div>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <table id="padiamatan-table" class="table table-striped" style="border: 1px solid #ebedf2;">
                      <thead>
                        <tr>
                          <th> Segmen </th>
                          <th> Subsegmen</th>
                          <th> Nama </th>
                          <th> No Telpon </th>
                          <th> Alamat </th>
                          <th> Aksi </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>33682618</td>
                          <td>C1</td>
                          <td>Azmi Zulfani</td>
                          <td>082926318277</td>
                          <td>PudakPayung Banyumanik Semarang</td>
                          <td>
                            <button type="button" class="btn btn-gradient-primary btn-icon-text" style="padding:0.5rem;background: #87c351;"data-toggle="modal" data-target="#editModal">
                            <i class="fa fa-edit"></i> Edit </button>
                            <button type="button" class="btn btn-gradient-primary btn-icon-text" style="padding:0.5rem;background: #ff5050;">
                            <i class="fa fa-trash-o"></i> Hapus </button>
                          </td>
                        </tr>
                        <tr>
                          <td>33682618</td>
                          <td>C1</td>
                          <td>Azmi Zulfani</td>
                          <td>082926318277</td>
                          <td>PudakPayung Banyumanik Semarang</td>
                          <td>
                            <button type="button" class="btn btn-gradient-primary btn-icon-text" style="padding:0.5rem;background: #87c351;"data-toggle="modal" data-target="#editModal">
                            <i class="fa fa-edit"></i> Edit </button>
                            <button type="button" class="btn btn-gradient-primary btn-icon-text" style="padding:0.5rem;background: #ff5050;">
                            <i class="fa fa-trash-o"></i> Hapus </button>
                          </td>
                        </tr>
                        <tr>
                          <td>33682618</td>
                          <td>C1</td>
                          <td>Azmi Zulfani</td>
                          <td>082926318277</td>
                          <td>PudakPayung Banyumanik Semarang</td>
                          <td>
                            <button type="button" class="btn btn-gradient-primary btn-icon-text" style="padding:0.5rem;background: #87c351;"data-toggle="modal" data-target="#editModal">
                            <i class="fa fa-edit"></i> Edit </button>
                            <button type="button" class="btn btn-gradient-primary btn-icon-text" style="padding:0.5rem;background: #ff5050;">
                            <i class="fa fa-trash-o"></i> Hapus </button>
                          </td>
                        </tr>
                        <tr>
                          <td>33682618</td>
                          <td>C1</td>
                          <td>Azmi Zulfani</td>
                          <td>082926318277</td>
                          <td>PudakPayung Banyumanik Semarang</td>
                          <td>
                            <button type="button" class="btn btn-gradient-primary btn-icon-text" style="padding:0.5rem;background: #87c351;"data-toggle="modal" data-target="#editModal">
                            <i class="fa fa-edit"></i> Edit </button>
                            <button type="button" class="btn btn-gradient-primary btn-icon-text" style="padding:0.5rem;background: #ff5050;">
                            <i class="fa fa-trash-o"></i> Hapus </button>
                          </td>
                        </tr>
                        <tr>
                          <td>33682618</td>
                          <td>C1</td>
                          <td>Azmi Zulfani</td>
                          <td>082926318277</td>
                          <td>PudakPayung Banyumanik Semarang</td>
                          <td>
                            <button type="button" class="btn btn-gradient-primary btn-icon-text" style="padding:0.5rem;background: #87c351;"data-toggle="modal" data-target="#editModal">
                            <i class="fa fa-edit"></i> Edit </button>
                            <button type="button" class="btn btn-gradient-primary btn-icon-text" style="padding:0.5rem;background: #ff5050;">
                            <i class="fa fa-trash-o"></i> Hapus </button>
                          </td>
                        </tr>
                        <tr>
                          <td>33682618</td>
                          <td>C1</td>
                          <td>Azmi Zulfani</td>
                          <td>082926318277</td>
                          <td>PudakPayung Banyumanik Semarang</td>
                          <td>
                          <button type="button" class="btn btn-gradient-primary btn-icon-text" style="padding:0.5rem;background: #87c351;"data-toggle="modal" data-target="#editModal">
                            <i class="fa fa-edit"></i> Edit </button>
                          <button type="button" class="btn btn-gradient-primary btn-icon-text" style="padding:0.5rem;background: #ff5050;">
                            <i class="fa fa-trash-o"></i> Hapus </button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <button type="button" class="btn btn-gradient-primary btn-icon-text"style="background: linear-gradient(to right, #696b4c, #b9af49)">
                    <i class="fa fa-download"></i> Unduh </button>
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
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