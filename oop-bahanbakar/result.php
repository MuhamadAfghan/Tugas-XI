<?php

session_start();

if (!isset($_SESSION['history'])) {
    $_SESSION['history'] = [];
}

class Shell
{
    protected static $ppn = 0.1,
        $Super = '15420',
        $VPower = '16130',
        $VPowerDiesel = '18310',
        $VPowerNitro = '16510',
        $result = '',
        $hargaPerLiter = '',
        $totalPpn = '';

    public function __construct($bahanbakar, $jumlah)
    {
        switch ($bahanbakar) {
            case 'Super':
                self::$hargaPerLiter = self::$Super;
                self::$totalPpn = self::$Super * $jumlah * self::$ppn;
                self::$result = (self::$Super * $jumlah) + self::$totalPpn;
                break;
            case 'VPower':
                self::$hargaPerLiter = self::$VPower;
                self::$totalPpn = self::$VPower * $jumlah * self::$ppn;
                self::$result = (self::$VPower * $jumlah) + self::$totalPpn;
                break;
            case 'VPowerDiesel':
                self::$hargaPerLiter = self::$VPowerDiesel;
                self::$totalPpn = self::$VPowerDiesel * $jumlah * self::$ppn;
                self::$result = (self::$VPowerDiesel * $jumlah) + self::$totalPpn;
                break;
            case 'VPowerNitro':
                self::$hargaPerLiter = self::$VPowerNitro;
                self::$totalPpn = self::$VPowerNitro * $jumlah * self::$ppn;
                self::$result = (self::$VPowerNitro * $jumlah) + self::$totalPpn;
                break;
            default:
                self::$result = 'data tidak ditemukan';
                break;
        }
    }
}

class Beli extends Shell
{
    public static $output = '',
        $totalPpn = '',
        $result = '',
        $hargaPerLiter = '',
        $bahanbakar = '',
        $jumlah = '';


    public function __construct($bahanbakar, $jumlah)
    {
        parent::__construct($bahanbakar, $jumlah);

        self::$totalPpn = number_format(parent::$totalPpn, 0, ',', '.');
        self::$result = number_format(parent::$result, 0, ',', '.');
        self::$hargaPerLiter = number_format(parent::$hargaPerLiter, 0, ',', '.');
        self::$bahanbakar = $bahanbakar;
        self::$jumlah = number_format($jumlah, 0, ',', '.');


        self::$output =
            "Anda membeli bahan bakar minyak tipe <b>Shell $bahanbakar</b>
            dengan jumlah <b>$jumlah liter</b> harga per liter: <b>Rp." . static::$hargaPerLiter . "</b>
            untuk total yang harus dibayarkan: <b>Rp." . static::$result . "</b><br>
            PPN (10%): <b>Rp." . self::$totalPpn . "</b>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bahanbakarValidation = ['Super', 'VPower', 'VPowerDiesel', 'VPowerNitro'];
    if (
        (isset($_POST['bahanbakar']) && in_array($_POST['bahanbakar'], $bahanbakarValidation))
        &&
        (isset($_POST['jumlah']) && $_POST['jumlah'] > 0)
    ) {
        $bahanbakar = $_POST['bahanbakar'];
        $jumlah = $_POST['jumlah'];
        new Beli($bahanbakar, $jumlah);

        $_SESSION['history'][] = [
            // 'id' => uniqid(),
            'bahanbakar' => 'Shell ' . $bahanbakar,
            'jumlah' => Beli::$jumlah,
            'hargaPerLiter' => Beli::$hargaPerLiter,
            'totalPpn' => Beli::$totalPpn,
            'totalHarga' => Beli::$result,
            'order_at' => (new DateTime('now', new DateTimeZone('Asia/Jakarta')))->format('Y-m-d H:i'),
        ];
    } else {
        header('Location: bahanbakar.php?message=Data tidak valid');
        exit;
    }
} else {
    header('Location: bahanbakar.php?message=Data tidak valid');
    exit;
}

?>

<!doctype html>
<html lang="en">

<head>
    <title>Shell Bahan Bakar - Hasil</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="shortcut icon" href="shell-logo.png" type="image/x-icon">

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body class="bg-gray-100">
    <div class="container max-w-2xl  mx-auto mt-12 p-8 bg-white rounded-lg shadow-lg">
        <div class="text-center mb-6">
            <img src="shell-logo.png" alt="Shell Logo" class="mx-auto w-20 h-20 animate-bounce">
            <h2 class="mt-3 text-2xl font-bold">Shell Bahan Bakar</h2>
        </div>

        <?php if (Beli::$output != '') : ?>

            <div class="border border-yellow-500 p-6 rounded-lg bg-yellow-100">
                <!-- <h5 class="text-lg font-bold mb-4">---- BUKTI TRANSAKSI ----</h5> -->
                <!-- <p><?= Beli::$output ?></p> -->
                <table id="table-export-pdf" class="w-full text-lg mx-auto" cellpadding='5'>
                    <tr align="center">
                        <th colspan="3" class="text-xl">BUKTI TRANSAKSI</th>
                    </tr>
                    <tr>
                        <td>Jenis Bahan Bakar</td>
                        <td>:</td>
                        <td>Shell <?= $bahanbakar ?></td>
                    </tr>
                    <tr>
                        <td>Jumlah Liter</td>
                        <td>:</td>
                        <td><?= Beli::$jumlah ?> Liter</td>
                    </tr>
                    <tr>
                        <td>Harga per Liter</td>
                        <td>:</td>
                        <td>Rp. <?= Beli::$hargaPerLiter ?></td>
                    </tr>
                    <tr>
                        <td>Total Harga</td>
                        <td>:</td>
                        <td>Rp. <?= Beli::$result ?></td>
                    </tr>
                    <tr>
                        <td>PPN (10%)</td>
                        <td>:</td>
                        <td>Rp. <?= Beli::$totalPpn ?></td>
                    </tr>
                </table>

                <div class="flex gap-2 items-center mt-5">
                    <button type="button" onclick="toPDF()"
                        class="bg-blue-500 hidden-print  inline-block shiny text-white py-2 px-4 rounded hover:bg-blue-700">Cetak
                        PDF</button>
                    <!-- <a href="history.php" class="">
                    <div class="bg-gray-800 block hidden-print  text-white  shiny rounded hover:bg-gray-700">
                        Lihat history transaksi
                    </div>
                </a> -->

                </div>



                <script>
                    Swal.fire({
                        title: 'Success',
                        text: 'Terima kasih telah membeli bahan bakar di Shell',
                        icon: 'success',
                        confirmButtonText: 'Lihat bukti transaksi'
                    })
                </script>
            </div>

        <?php endif; ?>

        <a href="history.php" class="inline-block hidden-print my-5 text-blue-500">History transaksi</a>
        <div class="text-center ">

            <a href="bahanbakar.php"
                class="bg-gray-800 inline-block hidden-print  text-white w-full shiny py-2 px-4 rounded hover:bg-gray-700">Kembali</a>
        </div>
    </div>

    <script>
        function toPDF() {
            window.print()
        }
    </script>


    <script src="shiny.js">
    </script>
</body>

</html>