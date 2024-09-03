<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Filter Data Berjalan</title>
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
    <h1>Filter Data Berjalan</h1>
    <form id="filterForm">
        @csrf <!-- Token CSRF untuk keamanan -->
        <label for="kabkota">Kab/Kota:</label>
        <input id="kabkota" name="kabkota" type="number" required>
        <label for="jenis">Jenis:</label>
        <select id="jenis" name="jenis" required>
            <option value="subsegmen">Subsegmen</option>
            <option value="segmen">Segmen</option>
            <option value="evita">Evita</option>
        </select>
        <button type="submit">Tampilkan Data</button>
    </form>

    <!-- Hasil data akan ditampilkan di sini -->
    <div id="result">
        <table>
            <thead>
                <tr>
                    <!-- Kolom dinamis tergantung pada 'jenis' -->
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

            const kabkota = document.getElementById('kabkota').value;
            const jenis = document.getElementById('jenis').value;

            fetch('{{ route('jagung.get.data.berjalan') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    kabkota: kabkota,
                    jenis: jenis
                })
            })
            .then(response => response.json())
            .then(data => {
                // console.log(data);
                const tableBody = document.getElementById('dataBody');
                const tableHead = document.querySelector('thead tr');
                tableBody.innerHTML = ''; // Bersihkan tabel sebelum mengisi data baru
                tableHead.innerHTML = ''; // Bersihkan header tabel

                // Menentukan header tabel berdasarkan jenis
                const headers = ['Indeks'];
                if (jenis === 'subsegmen') {
                    headers.push('Subsegmen K', 'Subsegmen TK', 'Subsegmen W');
                } else if (jenis === 'segmen') {
                    headers.push('Segmen K', 'Segmen TK');
                } else {
                    headers.push('Evita A', 'Evita R');
                }

                headers.forEach(header => {
                    const th = document.createElement('th');
                    th.textContent = header;
                    tableHead.appendChild(th);
                });

                function transformHeader(header) {
                    // Pisahkan bagian sebelum dan setelah underscore
                    const parts = header.split(' ');

                    // Ubah bagian sebelum underscore menjadi huruf kecil
                    const beforeUnderscore = parts[0].toLowerCase();
                    const afterUnderscore = parts.slice(1).join('_'); // Gabungkan kembali bagian setelah underscore

                    // Gabungkan bagian sebelum dan setelah underscore
                    return beforeUnderscore + (afterUnderscore ? '_' + afterUnderscore : '');
                }

                // Menambahkan data ke tabel
                data.forEach(row => {
                    const tr = document.createElement('tr');
                    headers.forEach(header => {
                        const td = document.createElement('td');
                        td.textContent = row[transformHeader(header)];
                        // console.log(transformHeader(header));
                        tr.appendChild(td);
                    });
                    tableBody.appendChild(tr);
                });
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>
