<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Overzicht Allergenen</title>
</head>
<body>

    <h1>Overzicht Allergenen</h1>

    <p>
        <strong>Naam Product:</strong>
        {{ $product->Naam }}
    </p>

    <p>
        <strong>Barcode:</strong>
        {{ $product->Barcode }}
    </p>

    @if ($allergenen->isEmpty())

        <p>
            In dit product zitten geen stoffen die een allergische reactie kunnen veroorzaken
        </p>

        <script>
            setTimeout(function () {
                window.location.href = "{{ route('magazijn.index') }}";
            }, 4000);
        </script>

    @else

        <table border="1">
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>Omschrijving</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($allergenen as $allergeen)
                    <tr>
                        <td>{{ $allergeen->Naam }}</td>
                        <td>{{ $allergeen->Omschrijving }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @endif

</body>
</html>
