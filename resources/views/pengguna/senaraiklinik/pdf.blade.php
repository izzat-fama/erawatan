<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Tuntutan</title>

    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: solid 1px black;
            padding: 10px;
        }
        th {
            background-color: #4CAF50;
            color: #FFFFFF;
        }
    </style>
</head>
<body>

    <section>
        <div>
            LOGO
        </div>
        <div>ADDRESS</div>
        <hr>
    </section>

    <section>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>TARIKH RAWATAN</th>
                    <th>NAMA PESAKIT</th>
                    <th>NAMA KLINIK</th>
                    <th>AMAUN</th>
                    <th>STATUS BAYARAN</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($senarai_tuntutan as $tuntutan)
                <tr>
                    <td>{{ $tuntutan->id }}</td>
                    <td>{{ $tuntutan->ertuntutantarikhrawat }}</td>
                    <td>{{ $tuntutan->individu->individunama ?? null }}</td>
                    <td>{{ $tuntutan->entiti->entitinama ?? null }}</td>
                    <td>{{ $tuntutan->ertuntutanamaun }}</td>
                    <td>{{ $tuntutan->statusAkhir->refStatus->status ?? null }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
    </section>
        <hr>
        <div>
            Copyright &copy; FAMA. All Rights Reserved.
        </div>
    <section>

    </section>
    
</body>
</html>