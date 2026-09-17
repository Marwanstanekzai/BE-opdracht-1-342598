<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Levering Informatie</title>
</head>
<body>

    <h1>Levering Informatie</h1>

    @if ($product->Naam === 'Winegums')

        <p>
            Er is van dit product op dit moment geen voorraad aanwezig, de verwachte eerstvolgende levering is: 30-04-2023
        </p>

        <script>
            setTimeout(function () {
                window.location.href = "{{ route('magazijn.index') }}";
            }, 4000);
        </script>

    @else

        <p>
            <strong>Naam leverancier:</strong>
            {{ $leveringen->first()->leverancier->Naam ?? '-' }}
        </p>

        <p>
            <strong>Contactpersoon leverancier:</strong>
            {{ $leveringen->first()->leverancier->ContactPersoon ?? '-' }}
        </p>

        <p>
            <strong>Leveranciernummer:</strong>
            {{ $leveringen->first()->leverancier->LeverancierNummer ?? '-' }}
        </p>

        <p>
            <strong>Mobiel:</strong>
            {{ $leveringen->first()->leverancier->Mobiel ?? '-' }}
        </p>

        <table border="1">
            <thead>
                <tr>
                    <th>Naam Product</th>
                    <th>Datum laatste levering</th>
                    <th>Aantal</th>
                    <th>Eerstvolgende levering</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($leveringen as $levering)
                    <tr>
                        <td>{{ $product->Naam }}</td>
                        <td>{{ $levering->DatumLevering }}</td>
                        <td>{{ $levering->Aantal }}</td>
                        <td>{{ $levering->DatumEerstVolgendeLevering ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    @endif

</body>
</html>
