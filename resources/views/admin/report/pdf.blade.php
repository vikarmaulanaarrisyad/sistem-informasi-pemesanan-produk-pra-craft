<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Transaksi</title>

    <link rel="stylesheet" href="{{ public_path('/Templates/dist/css/adminlte.min.css') }}">

    <style>
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: right;
            font-size: 15px;
            color: rgb(61, 61, 61);
        }
    </style>
</head>

<body>

    <h4 class="text-center">Laporan Transaksi</h4>
    <p class="text-center">
        Tanggal {{ tanggal_indonesia($start) }}
        s/d
        Tanggal {{ tanggal_indonesia($end) }}
    </p>

    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Produk</th>
                <th>Stok</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>

        </thead>
        <tbody>
            @foreach ($data as $key=> $row)
                <tr>
                    <td>{{ $row['DT_RowIndex'] }}</td>
                    <td>{{ $row['tanggal'] }}</td>
                    <td>{{ $row['product'] }}</td>
                    <td class="text-center">{{ $row['stok'] }}</td>
                    <td class="text-center">{{ $row['qty'] }}</td>
                    <td class="text-right">{{ $row['harga'] }}</td>
                    <td class="text-right">{{ $row['subtotal'] }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="6" class="text-right pr-3 text-bold">TOTAL :</td>
                <td class="text-right text-bold">{{ $data[$key]['total'] }}</td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        Cetak pada tanggal {{ date('Y-m-d H:i:s') }}
    </div>
</body>

</html>
