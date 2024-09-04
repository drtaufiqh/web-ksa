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
              <h3 class="page-title">Amatan Potensial</h3>
            </div>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  <form class="forms-sample">
                      <div class="form-group row" style="margin-bottom: 0;">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Tahun Amatan</label>
                        <div class="col-sm-9">
                          <select type="text" class="form-control" id="exampleInput2">
                            <option value="0">2020</option>
                            <option value="1">2021</option>
                            <option value="2">2022</option>
                            <option value="3">2023</option>
                          </select> 
                        </div>
                      </div>
                      <div class="form-group row" style="margin-bottom: 0;">
                        <label for="exampleInputEmail2" class="col-sm-3 col-form-label">Bulan Amatan</label>
                        <div class="col-sm-9">
                          <select class="form-control" id="exampleInput3" >
                            <option value="01">01 - Januari</option>
                            <option value="02">02 - Februari</option>
                            <option value="03">03 - Maret</option>
                            <option value="04">04 - April</option>
                            <option value="05">05 - Mei</option>
                            <option value="06">06 - Juni</option>
                            <option value="07">07 - Juli</option>
                            <option value="08">08 - Agustus</option>
                            <option value="09">09 - September</option>
                            <option value="10">10 - Oktober</option>
                            <option value="11">11 - November</option>
                            <option value="12">12 - Desember</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row" style="margin-bottom: 0;">
                        <label for="exampleInputMobile" class="col-sm-3 col-form-label">Tahun Sample</label>
                        <div class="col-sm-9">
                          <select type="text" class="form-control" id="exampleInput2">
                            <option value="0">2020</option>
                            <option value="1">2021</option>
                            <option value="2">2022</option>
                            <option value="3">2023</option>
                          </select> 
                        </div>
                      </div>
                      <div class="form-group row" style="margin-bottom: 0;">
                        <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Bulan Sample</label>
                        <div class="col-sm-9">
                        <select class="form-control" id="exampleInput3" >
                          <option value="01">01 - Januari</option>
                          <option value="02">02 - Februari</option>
                          <option value="03">03 - Maret</option>
                          <option value="04">04 - April</option>
                          <option value="05">05 - Mei</option>
                          <option value="06">06 - Juni</option>
                          <option value="07">07 - Juli</option>
                          <option value="08">08 - Agustus</option>
                          <option value="09">09 - September</option>
                          <option value="10">10 - Oktober</option>
                          <option value="11">11 - November</option>
                          <option value="12">12 - Desember</option>
                        </select>
                        </div>
                      </div>
                      <button type="button" class="btn btn-gradient-primary btn-icon-text" style="padding:0.5rem;background: #a18c4a;margin-bottom: 1rem;">
                        <i class="fa fa-refresh"></i> Lihat </button></td>
                    </form>
                    <table id="padiamatan-table" class="table table-striped" style="border: 1px solid #ebedf2;">
                      <thead>
                        <tr>
                          <th> Kode Segmen </th>
                          <th> Subsegmen </th>
                          <th> Nilai Amatan </th>
                          <th> Kelurahan </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>3301261826</td>
                          <td>C1</td>
                          <td>3</td>
                          <td>Gajah Mungkur</td>
                        </tr>
                        <tr>
                          <td>3301261826</td>
                          <td>C1</td>
                          <td>3</td>
                          <td>Gajah Mungkur</td>
                        </tr>
                        <tr>
                          <td>3301261826</td>
                          <td>C1</td>
                          <td>3</td>
                          <td>Gajah Mungkur</td>
                        </tr>
                        <tr>
                          <td>3301261826</td>
                          <td>C1</td>
                          <td>3</td>
                          <td>Gajah Mungkur</td>
                        </tr>
                        <tr>
                          <td>3301261826</td>
                          <td>C1</td>
                          <td>3</td>
                          <td>Gajah Mungkur</td>
                        </tr>
                      </tbody>
                    </table>
                    <button type="button" class="btn btn-gradient-primary btn-icon-text"style="background: linear-gradient(to right, #696b4c, #b9af49);">
                    <i class="fa fa-download"></i> Unduh </button>
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