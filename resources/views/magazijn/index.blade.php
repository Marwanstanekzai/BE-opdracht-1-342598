<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Overzicht Magazijn Jamin</title>
</head>
<body>

    <h1>Overzicht Magazijn Jamin</h1>

    <table border="1">
        <thead>
            <tr>
                <th>Barcode</th>
                <th>Naam</th>
                <th>Verpakkingseenheid</th>
                <th>Aantal aanwezig</th>
                <th>Allergenen Info</th>
                <th>Leverantie Info</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($producten as $product)
                <tr>
                    <td>{{ $product->Barcode }}</td>
                    <td>{{ $product->Naam }}</td>
                    <td>{{ $product->magazijn->VerpakkingsEenheid ?? '-' }}</td>
                    <td>{{ $product->magazijn->AantalAanwezig ?? '-' }}</td>
                    <td>
    <a href="{{ route('allergeen.show', $product->Id) }}">❌</a>
</td>
                    <td>
    <a href="{{ route('levering.show', $product->Id) }}">❓</a>
</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
