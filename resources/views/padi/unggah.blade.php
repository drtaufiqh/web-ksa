<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unggah Excel</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h2>Unggah File Excel Padi Amatan</h2>

        @if (session('success'))
            <div class="alert alert-success" style="color: green;">
                {{ session('success') }}
            </div>
        @endif

        <!-- Menampilkan pesan error -->
        @if($errors->any())
        <div class="alert alert-danger" style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger" style="color: red;">
                {!! session('error') !!}
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
</body>
<script>
    document.getElementById('myForm').addEventListener('submit', function() {
        // Tampilkan spinner loading
        document.getElementById('loading1').style.display = 'block';
    });
</script>
</html>