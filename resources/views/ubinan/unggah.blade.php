<!DOCTYPE html>
<lang="en">
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
              <h3 class="page-title"> Unggah Data Ubinan </h3>
            </div>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                <div class="form-group">
                  <form  id="myForm">
                    <label for="exampleInput2">Tahun</label>
                        <select type="text" class="form-control" id="exampleInput2">
                          <option value="0">2020</option>
                          <option value="1">2021</option>
                          <option value="2">2022</option>
                          <option value="3">2023</option>
                        </select> 
                </div>
                      <div class="form-group">
                        <label for="exampleInpu3">Bulan</label>
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
                      <div class="form-group">
                        <label for="exampleInpu3">Jenis Sample</label>
                        <select class="form-control" id="exampleInput3" >
                          <option value="01">U - Utama</option>
                          <option value="02">C - Cadangan</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label>File upload</label>
                        <input type="file" name="img[]" class="file-upload-default">
                        <div class="input-group col-xs-12">
                          <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload File">
                          <span class="input-group-append">
                            <button class="file-upload-browse btn btn-gradient-primary py-3" style="background: linear-gradient(to right,#696b4c, #b9af49);" type="button">Upload</button>
                          </span>
                        </div>
                        <p style="margin-bottom: 0;font-size: 0.8rem;color: #b9b7b7;">Format penamaan file harus : tahunbulanA_kodekabupaten_jagung.xlsx</p>
                        <p style="margin-bottom: 0;font-size: 0.8rem;color: #b9b7b7;">Contoh : 202110A_3301_jagung.xlsx</p>
                      </div>
                      <button type="submit" class="btn btn-gradient-unggah me-2"style="background: linear-gradient(to right, #696b4c, #b9af49);">Submit</button> 
                    </form>
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
</body>
</html>
  </body>
</html>