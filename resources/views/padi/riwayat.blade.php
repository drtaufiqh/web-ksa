<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Padi Amatan</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
    <div class="container mt-5">
        <h2>Data Padi Amatan</h2>

        <!-- Dropdown untuk memilih kab/kota -->
        <div class="form-group">
            <label for="kabkota-select">Pilih Kab/Kota:</label>
            <select id="kabkota-select" class="form-control">
                <option value="all">Seluruh Kab/Kota</option>
                @foreach ($allKabKota as $item)
                    <option value="{{ substr($item, 0,4) }}">{{ $item }}</option>
                @endforeach
            </select>
        </div>

        <!-- Tabel data -->
        <table id="datatable" class="display">
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
                        <button class="btn btn-info btn-sm view-btn" data-id="{{ $row->kode_kabkota }}">Lihat</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

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
                    table.column(0).visible(true); // Tampilkan kolom Kab/Kota
                } else {
                    // Filter berdasarkan kab/kota yang dipilih
                    table.columns(0).search(selectedValue).draw();
                    table.column(0).visible(false); // Sembunyikan kolom Kab/Kota
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
