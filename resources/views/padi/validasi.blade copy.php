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
        @include('components.navbar-padi')

        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Validasi Amatan </h3>
            </div>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                <div class="card-body">
                <form id="myForm" action="{{ route('padi_validasi_post') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Tahun --}}
                @php
                    $years = [];
                    $currentYear = old('tahun', $currentYear ?? Carbon::now()->year); // Gunakan nilai lama jika tersedia
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
                            <option value="{{ $year }}" {{ ($selected_tahun ? $selected_tahun : $currentYear) == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Bulan --}}
                @php
                    $currentMonth = old('bulan', date('m')); // Gunakan nilai lama jika tersedia
                @endphp
                <div class="form-group">
                    <label for="bulan">Bulan</label>
                    <select class="form-control" id="bulan" name="bulan">
                        <option value="01" {{ ($selected_bulan ? $selected_bulan : $currentMonth) == '01' ? 'selected' : '' }}>01 - Januari</option>
                        <option value="02" {{ ($selected_bulan ? $selected_bulan : $currentMonth) == '02' ? 'selected' : '' }}>02 - Februari</option>
                        <option value="03" {{ ($selected_bulan ? $selected_bulan : $currentMonth) == '03' ? 'selected' : '' }}>03 - Maret</option>
                        <option value="04" {{ ($selected_bulan ? $selected_bulan : $currentMonth) == '04' ? 'selected' : '' }}>04 - April</option>
                        <option value="05" {{ ($selected_bulan ? $selected_bulan : $currentMonth) == '05' ? 'selected' : '' }}>05 - Mei</option>
                        <option value="06" {{ ($selected_bulan ? $selected_bulan : $currentMonth) == '06' ? 'selected' : '' }}>06 - Juni</option>
                        <option value="07" {{ ($selected_bulan ? $selected_bulan : $currentMonth) == '07' ? 'selected' : '' }}>07 - Juli</option>
                        <option value="08" {{ ($selected_bulan ? $selected_bulan : $currentMonth) == '08' ? 'selected' : '' }}>08 - Agustus</option>
                        <option value="09" {{ ($selected_bulan ? $selected_bulan : $currentMonth) == '09' ? 'selected' : '' }}>09 - September</option>
                        <option value="10" {{ ($selected_bulan ? $selected_bulan : $currentMonth) == '10' ? 'selected' : '' }}>10 - Oktober</option>
                        <option value="11" {{ ($selected_bulan ? $selected_bulan : $currentMonth) == '11' ? 'selected' : '' }}>11 - November</option>
                        <option value="12" {{ ($selected_bulan ? $selected_bulan : $currentMonth) == '12' ? 'selected' : '' }}>12 - Desember</option>
                    </select>
                </div>
                
                {{-- Dropdown untuk memilih kab/kota --}}
                <div class="form-group">
                    <label for="kabkota-select">Wilayah Amatan</label>
                    <select id="kabkota-select" class="form-control" name="wil">
                        <option value="3399" {{ ($selected_wil) == '3399' ? 'selected' : '' }}>Pilih Wilayah</option>
                        <option value="33" {{ ($selected_wil) == '33' ? 'selected' : '' }}>Jawa Tengah</option>
                        @foreach ($allKabKota as $item)
                            <option value="{{ substr($item, 0,4) }}" {{ ($selected_wil) == substr($item, 0,4) ? 'selected' : '' }}>{{ $item }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-gradient-primary btn-icon-text" style="padding:0.5rem;background: #87c351;margin-bottom:2rem">
                        <i class="fa fa-refresh"></i> Lihat </button></td>
                </form>

                @if ($hasil['status'])
                    @php
                        $isi_tabel = $hasil['data1']
                    @endphp 
                @else
                    @php
                        $isi_tabel = []
                    @endphp 
                    <h6 class="alert" style="color: red"><b>{{ $hasil['message'] }}</b></h6>
                @endif
                <table id="padiamatan-table" class="table table-bordered" style="border-bottom-color: #ebedf2;">
                    <thead>
                        <tr>
                            <th> Kode </th>
                            <th> A1 </th>
                            <th> A2 </th>
                            <th> A3 </th>
                            <th> B1 </th>
                            <th> B2 </th>
                            <th> B3 </th>
                            <th> C1 </th>
                            <th> C2 </th>
                            <th> C3 </th>
                            <th> Status </th>
                            <th> Segmen & Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($isi_tabel as $data)
                        <tr>
                            <td> {{ $data['kode_segmen'] }} </td>
                            <td style="background-color:{{ $data['warnaa1'] }}"> {{ $data['hasila1'] }} </td>
                            <td style="background-color:{{ $data['warnaa2'] }}"> {{ $data['hasila2'] }} </td>
                            <td style="background-color:{{ $data['warnaa3'] }}"> {{ $data['hasila3'] }} </td>
                            <td style="background-color:{{ $data['warnab1'] }}"> {{ $data['hasilb1'] }} </td>
                            <td style="background-color:{{ $data['warnab2'] }}"> {{ $data['hasilb2'] }} </td>
                            <td style="background-color:{{ $data['warnab3'] }}"> {{ $data['hasilb3'] }} </td>
                            <td style="background-color:{{ $data['warnac1'] }}"> {{ $data['hasilc1'] }} </td>
                            <td style="background-color:{{ $data['warnac2'] }}"> {{ $data['hasilc2'] }} </td>
                            <td style="background-color:{{ $data['warnac3'] }}"> {{ $data['hasilc3'] }} </td>
                            <td>
                            @if($data['status'] == 'Approved')
                                <label class="badge badge-danger">{{ $data['status'] }}</label>
                            @else
                                <label class="badge badge-info">{{ $data['status'] }}</label>
                            @endif
                            </td>
                            <td>
                            @if($data['evita'] == 'APPROVED')
                                <label class="badge badge-warning">{{ $data['evita'] }}</label>
                            @else
                                <label class="badge badge-info">{{ $data['evita'] }}</label>
                            @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table> 
                
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