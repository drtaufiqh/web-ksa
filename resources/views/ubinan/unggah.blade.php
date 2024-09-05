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
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            @foreach ($errors->all() as $error)
                                {{ $error }}
                            @endforeach
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {!! session('error') !!}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif


                  <form id="myForm" action="{{ route('ubinan.upload') }}" method="POST" enctype="multipart/form-data">
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

                    <div class="form-group">
                        <label for="tahun">Tahun</label>
                        <select name="tahun" class="form-control" id="tahun">
                            @foreach($years as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Bulan --}}
                    @php
                        // Ambil bulan saat ini dalam format dua digit
                        $currentMonth = date('m');
                    @endphp

                    <div class="form-group">
                        <label for="bulan">Bulan</label>
                        <select class="form-control" id="bulan" name="bulan">
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

                      <div class="form-group">
                        <label for="sampel">Jenis Sampel</label>
                        <select class="form-control" id="sampel" name="sampel">
                          <option value="U">U - Utama</option>
                          <option value="C">C - Cadangan</option>
                        </select>
                      </div>
                      {{-- File --}}
                      <div class="form-group">
                          <label>File upload</label>
                          <input type="file" name="file" class="form-control" accept=".xls,.xlsx,.csv" required>
                          <p style="margin-bottom: 0;font-size: 0.8rem;color: #b9b7b7;">Format penamaan file harus : tahunbulanA_kodekabupaten_jagung.xlsx</p>
                          <p style="margin-bottom: 0;font-size: 0.8rem;color: #b9b7b7;">Contoh : 202110A_3301_jagung.xlsx</p>
                      </div>
                      {{-- Submit --}}
                      <button type="submit" class="btn btn-gradient-primary me-2" style="background: linear-gradient(to right, #696b4c, #b9af49);">Submit</button>

                      {{-- Loading Spinner --}}
                      <div id="loading1" class="text-center" style="display: none;">
                          <div class="spinner-border" role="status">
                              <span class="sr-only">Loading...</span>
                          </div>
                      </div>
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
<script>
    document.getElementById('myForm').addEventListener('submit', function() {
        // Tampilkan spinner loading
        document.getElementById('loading1').style.display = 'block';
    });
</script>
</html>
