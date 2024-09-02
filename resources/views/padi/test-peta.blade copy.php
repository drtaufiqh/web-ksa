<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filter Data Kabupaten Kota</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Filter Data Kabupaten Kota</h1>
    <form action="{{ route('padi.get.data.peta') }}" method="POST">
        @csrf <!-- Token CSRF untuk keamanan -->
        <label for="tahun">Tahun:</label>
        <input id="tahun" name="tahun" required>
        <label for="bulan">Bulan:</label>
        <input id="bulan" name="bulan" required>
        <button type="submit">Tampilkan Data</button>
    </form>

    <!-- Hasil data akan ditampilkan di halaman hasil -->
    @if(isset($data))
        <div id="result">
            <table>
                <thead>
                    <tr>
                        <th>Kabupaten/Kota</th>
                        <th>Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $row)
                        <tr>
                            <td>{{ $row->indeks }}</td>
                            <td>{{ $row->subsegmen_TK }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</body>
</html>