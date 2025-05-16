<!DOCTYPE html>
<html>

<head>
    <title>Track Shipment</title>
</head>

<body>
    <h1>Track Your Shipment</h1>
    <form method="POST" action="{{ route('track') }}">
        @csrf
        <label for="barcode">Barcode:</label>
        <input type="text" name="barcode" id="barcode" required>
        <button type="submit">Track</button>
    </form>

    @if (session('trackingData'))
        <h2>Tracking Results</h2>
        <pre>{{ session('trackingData') }}</pre>
    @elseif (session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif
</body>

</html>
