<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Function Proses</title>
</head>
<body>
    <h1>Test Function Proses</h1>

    <form action="{{ route('run.proses') }}" method="POST">
        @csrf
        <label for="tabul0">Tabul 0:</label>
        <input type="text" name="tabul0" id="tabul0" required>
        <br>
        <label for="tabul1">Tabul 1:</label>
        <input type="text" name="tabul1" id="tabul1" required>
        <br><br>
        <button type="submit">Run Proses</button>
    </form>

    @if(isset($result))
        <h2>Result:</h2>
        <pre>{{ print_r($result) }}</pre>
    @endif
</body>
</html>