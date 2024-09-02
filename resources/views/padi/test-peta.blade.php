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
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <h1>Filter Data Kabupaten Kota</h1>
    <form id="filterForm">
        @csrf <!-- Token CSRF untuk keamanan -->
        <label for="tahun">Tahun:</label>
        <input id="tahun" name="tahun" required>
        <label for="bulan">Bulan:</label>
        <input id="bulan" name="bulan" required>
        <button type="submit">Tampilkan Data</button>
    </form>

    <!-- Hasil data akan ditampilkan di sini -->
    <div id="result">
        <table>
            <thead>
                <tr>
                    <th>Indeks</th>
                    <th>Subsegmen TK</th>
                </tr>
            </thead>
            <tbody id="dataBody">
                <!-- Data akan ditambahkan di sini oleh JavaScript -->
            </tbody>
        </table>
    </div>

    <script>
        document.getElementById('filterForm').addEventListener('submit', function(event) {
            event.preventDefault();

            const tahun = document.getElementById('tahun').value;
            const bulan = document.getElementById('bulan').value;

            fetch('{{ route('padi.get.data.peta') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    tahun: tahun,
                    bulan: bulan
                })
            })
            .then(response => response.json())
            .then(data => {
                const tableBody = document.getElementById('dataBody');
                tableBody.innerHTML = ''; // Bersihkan tabel sebelum mengisi data baru
                
                data.forEach(row => {
                    const tr = document.createElement('tr');
                    const tdIndeks = document.createElement('td');
                    tdIndeks.textContent = row.indeks;
                    const tdSubsegmen = document.createElement('td');
                    tdSubsegmen.textContent = row.subsegmen_TK;
                    tr.appendChild(tdIndeks);
                    tr.appendChild(tdSubsegmen);
                    tableBody.appendChild(tr);
                });
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>
