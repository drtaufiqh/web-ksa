<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>PAK TANI</title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- DataTables Buttons CSS -->
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css"> --}}
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
    <style>
        td.feedback-cell {
            white-space: normal !important;
            word-wrap: break-word;
            max-width: 400px; /* Atur lebar maksimum untuk mengontrol wrapping */
        }

        /* Gunakan nowrap untuk kolom lain agar tidak melebar secara berlebihan */
        .text-nowrap {
            white-space: nowrap;
        }
    </style>
  </head>
  <body>
    <div class="container-scroller">
        <!-- resources/views/home.blade.php -->
        @include('components.navbar-jagung')

        <!-- partial -->
        <div class="main-panel">
        <div class="content-wrapper" style="background: linear-gradient(to right, #f4ffc8, #ddf3ca);">
            <div class="page-header" style="background-color: #3b5740">
              <h3 class="page-title"> Validasi Amatan </h3>
            </div>
            <div class="row">
              <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                        {{-- Loading Spinner --}}
                        <div id="loading" class="text-center" style="display: none;">
                            <div class="spinner-border" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    <form class="forms-sample">
                        {{-- Tahun --}}
                        @php
                            $years = [];
                            $currentYear = old('tahun', $currentYear ?? 2030); // Gunakan nilai lama jika tersedia
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

                        @if (Auth::user()->role == 'prov')
                        <!-- Dropdown untuk memilih kab/kota -->
                        <div class="form-group">
                            <label for="kabkota-select">Wilayah Amatan</label>
                            <select id="kabkota-select" class="form-control">
                                <option value="-">Pilih Kab/Kota</option>
                                <option value="3300">Seluruh Kab/Kota</option>
                                @foreach ($allKabKota as $item)
                                    <option value="{{ substr($item, 0,4) }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <!-- Tombol Lihat -->
                        <button type="button" id="lihat-btn" class="btn btn-gradient-primary btn-icon-text"style="padding:0.5rem;background: #87c351;margin-bottom:2rem">
                            <i class="fa fa-refresh"></i> Lihat </button>
                    </form>
                    <!-- Tabel data -->
                    <table id="datatable" class="display table table-striped" style="border: 1px solid #ebedf2;">
                        <thead>
                            <tr>
                                <th>Kode Segmen</th>
                                <th>A1</th>
                                <th>A2</th>
                                <th>B1</th>
                                <th>B2</th>
                                <th> Status </th>
                                <th> Segmen & Status</th>
                                <th>Feedback</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Data akan dimuat melalui AJAX -->
                        </tbody>
                    </table>

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
    <!-- Bootstrap JS -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        var isprov = false;
        @if (Auth::user()->role == 'prov')
            isprov = true;
        @endif
    </script>
    <script>
    $(document).ready(function () {
        // Initialize DataTable
        var table = $('#datatable').DataTable({
            "pageLength": 10,
            "lengthMenu": [5, 10, 20, 50],
            "compact": true,
            dom: 'lfrtpB',  // Tambahkan 'lfrtpB' untuk menampilkan tombol
            // buttons: [
            //     'copy', 'csv', 'excel', 'pdf', 'print'
            // ],
            buttons: [
                {
                    extend: 'excel',
                    text: '<i class="fa fa-download"></i> Unduh ',
                    className: "btn btn-gradient-primary btn-icon-text mt-1",
                    title: function() {
                        var tahun = $('#tahun').val();
                        var bulan = $('#bulan').val();
                        var kabkota = '{{ Auth::user()->kode }}';
                        if (isprov) {
                            kabkota = $('#kabkota-select').val();
                        }
                        return 'Validasi Amatan Jagung ' + kabkota + ' - ' + bulan + '/' + tahun;
                    },
                    filename: function() {
                        var tahun = $('#tahun').val();
                        var bulan = $('#bulan').val();
                        var kabkota = '{{ Auth::user()->kode }}';
                        if (isprov) {
                            kabkota = $('#kabkota-select').val();
                        }
                        return 'Validasi Amatan Jagung ' + kabkota + ' ' + bulan + ' ' + tahun;
                    },
                    init: function(api, node, config) {
                        $(node).css({
                            'background': 'linear-gradient(to right, #3b7d46, #659f3b)',
                        });
                    }
                },
                {
                    extend: 'copy',
                    text: '<i class="fa fa-copy"></i> Salin ',
                    className: "btn btn-gradient-primary btn-icon-text mt-1",
                    title: function() {
                        var tahun = $('#tahun').val();
                        var bulan = $('#bulan').val();
                        var kabkota = '{{ Auth::user()->kode }}';
                        if (isprov) {
                            kabkota = $('#kabkota-select').val();
                        }
                        return 'Validasi Amatan Jagung ' + kabkota + ' ' + bulan + ' ' + tahun;
                    },
                    init: function(api, node, config) {
                        $(node).css({
                            'background': 'linear-gradient(to right, #3b7d46, #659f3b)',
                        });
                    }
                }
            ],
            "ajax": null, // Disable initial AJAX call
            "columns": [
                { "data": "kode_segmen" },
                // { "data": "hasil_a1" },
                // { "data": "hasil_a2" },
                // { "data": "hasil_b1" },
                // { "data": "hasil_b2" },
                {
                    "data": null, // Kolom ini akan menampilkan hasil_a1 dengan tooltip feedback fb_a1
                    "render": function (data, type, row) {
                        return '<div data-toggle="tooltip" data-placement="top" title="(n=' + row.a1 + ') , (n-1=' + row.a1_sblm + ')">'
                            + row.hasil_a1 + '</div>';
                    }
                },
                {
                    "data": null, // Kolom ini akan menampilkan hasil_a2 dengan tooltip feedback fb_a2
                    "render": function (data, type, row) {
                        return '<div data-toggle="tooltip" data-placement="top" title="(n=' + row.a2 + ') , (n-1=' + row.a2_sblm + ')">'
                            + row.hasil_a2 + '</div>';
                    }
                },
                {
                    "data": null, // Kolom ini akan menampilkan hasil_b1 dengan tooltip feedback fb_b1
                    "render": function (data, type, row) {
                        return '<div data-toggle="tooltip" data-placement="top" title="(n=' + row.b1 + ') , (n-1=' + row.b1_sblm + ')">'
                            + row.hasil_b1 + '</div>';
                    }
                },
                {
                    "data": null, // Kolom ini akan menampilkan hasil_b2 dengan tooltip feedback fb_b2
                    "render": function (data, type, row) {
                        return '<div data-toggle="tooltip" data-placement="top" title="(n=' + row.b2 + ') , (n-1=' + row.b2_sblm + ')">'
                            + row.hasil_b2 + '</div>';
                    }
                },
                { "data": "status" },
                { "data": "evita" },
                { "data": "feedback", "className": "feedback-cell" } // Tambahkan class di kolom feedback
            ],
            "createdRow": function (row, data, dataIndex) {
                // Array dengan kolom hasil
                var hasilColumns = ['hasil_a1', 'hasil_a2', 'hasil_b1', 'hasil_b2'];

                // Loop melalui kolom hasil dan cek nilainya
                hasilColumns.forEach(function (col, index) {
                    var cellValue = data[col];
                    var cell = $('td', row).eq(index + 1); // offset by 3 because columns 0-2 are not hasil_*
                    if (cellValue === 'K') {
                        cell.css('background-color', '#abe96c').css('color', 'white');
                    } else if (cellValue === 'TK') {
                        cell.css('background-color', '#ff5050').css('color', 'white');
                    } else if (cellValue === 'W') {
                        cell.css('background-color', '#ffc37c').css('color', 'black');
                    }
                });

                // Kolom status logic
                var status = data['status'];
                var statusCell = $('td', row).eq(5);
                if (status === 'SUDAH LENGKAP') {
                    statusCell.html('<label class="badge badge-danger">' + status + '</label>');
                } else {
                    statusCell.html('<label class="badge badge-info">' + status + '</label>');
                }

                // Kolom evita logic
                var evita = data['evita'];
                var evitaCell = $('td', row).eq(6);
                if (evita === 'APPROVED') {
                    evitaCell.html('<label class="badge badge-warning">' + evita + '</label>');
                } else if (evita === 'REJECTED') {
                    evitaCell.html('<label class="badge badge-info">' + evita + '</label>');
                }else {
                    evitaCell.html('<label class="badge badge-info">Data bulan sebelumnya tidak tersedia</label>');
                }


                $('#datatable').on('draw.dt', function () {
                    $('[data-toggle="tooltip"]').tooltip(); // Inisialisasi tooltip setelah DataTable dirender ulang
                });
            }
        });

        // Event listener untuk tombol "Lihat"
        $('#lihat-btn').on('click', function () {
            $('#loading').show();

            // Ambil nilai dari form
            var tahun = $('#tahun').val();
            var bulan = $('#bulan').val();
            var kabkota = '{{ Auth::user()->kode }}';
            if (isprov) {
                kabkota = $('#kabkota-select').val();
            }

            // Lakukan AJAX request untuk mendapatkan data
            $.ajax({
                url: '/get-filtered-data',
                method: 'GET',
                data: {
                    tahun: tahun,
                    bulan: bulan,
                    kabkota: kabkota
                },
                success: function (data) {
                    $('#loading').hide();
                    // Clear table sebelum menambahkan data baru
                    table.clear();

                    // Tambah data baru ke dalam tabel
                    table.rows.add(data).draw();
                },
                error:function (){
                    $('#loading').hide();
                }
            });
        });
    });

    </script>
    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>
  </body>
</html>
