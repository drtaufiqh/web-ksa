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
            <div class="form-group">
                <label for="bulan">Bulan</label>
                <select class="form-control" id="bulan" >
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
                <input type="file" name="file" class="form-control" required>
            </div>
            {{-- Submit --}}
            <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
        </form>
    </div>
</body>
</html>