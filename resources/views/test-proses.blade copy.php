<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Proses</title>
</head>
<body>
    <h1>Test Proses Function</h1>
    <form action="{{ route('test.proses') }}" method="POST">
        @csrf
        <label for="wil">Wil:</label>
        <input type="text" id="wil" name="wil"><br><br>

        <label for="tabul0">Tabul 0:</label>
        <input type="text" id="tabul0" name="tabul0"><br><br>

        <label for="tabul1">Tabul 1:</label>
        <input type="text" id="tabul1" name="tabul1"><br><br>

        <label for="output">Output:</label>
        <select id="output" name="output">
            <option value="array">Array</option>
            <option value="json">JSON</option>
        </select><br><br>

        <button type="submit">Proses</button>
    </form>

    @if(session('message'))
        <h2>Result:</h2>
        <pre>{{ session('message') }}</pre>
    @endif
</body>
</html>