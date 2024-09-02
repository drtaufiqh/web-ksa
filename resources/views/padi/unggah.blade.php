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
        @include('components.navbar-padi')

        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Unggah Data Amatan </h3>
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

                    <form id="myForm" action="{{ route('padiamatan.upload') }}" method="POST" enctype="multipart/form-data">
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

                        {{-- pilih --}}
                        <div class="form-group">
                            <label for="kolom">Kolom yang akan diupload (Pemrosesan data membutuhkan waktu 1 menit/bulan)</label>
                            <select class="form-control" id="kolom" name="kolom">
                                <option value="n" selected> bulan terpilih saja (n) - [1 Menit]</option>
                                <option value="n-1"> dengan 1 bulan sebelumnya (n, n-1) - [2 Menit]</option>
                                <option value="n-2"> dengan 2 bulan sebelumnya (n, n-1, n-2) - [3 Menit]</option>
                                <option value="n-3"> dengan 3 bulan sebelumnya (n, n-1, n-2, n-3) - [4 Menit]</option>
                            </select>
                        </div>
                        
                        {{-- File --}}
                        <div class="form-group">
                            <label>File upload</label>
                            {{-- <input type="file" name="img[]" class="file-upload-default">
                            <div class="input-group col-xs-12">
                            <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload File">
                            <span class="input-group-append">
                                <button class="file-upload-browse btn btn-gradient-primary py-3" type="button">Upload</button>
                            </span>
                            </div> --}}
                            <input type="file" name="file" class="form-control" accept=".xls,.xlsx,.csv" required>
                        </div>
                        {{-- Submit --}}
                        <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                        
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
</body>
<script>
    document.getElementById('myForm').addEventListener('submit', function() {
        // Tampilkan spinner loading
        document.getElementById('loading1').style.display = 'block';
    });
</script>
</html>