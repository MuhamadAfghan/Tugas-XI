<?php
session_start();

if (!isset($_SESSION['history']) && !empty($_SESSION['history'])) {
    header('Location: bahanbakar.php?message=Data tidak valid');
}

if (isset($_GET['action']) && $_GET['action'] == 'delete-all') {
    $_SESSION['history'] = [];
    // header('Location: history.php?message=Berhasil menghapus semua history transaksi');
    header('Location: history.php');
}

if ((isset($_GET['action']) && $_GET['action'] == 'delete')) {
    if (isset($_GET['index']) && in_array($_GET['index'], array_keys($_SESSION['history']))) {
        $index = $_GET['index'];
        unset($_SESSION['history'][$index]);
        header('Location: history.php');
    } else {
        header('Location: history.php?message=Data tidak valid');
    }
}

rsort($_SESSION['history']);
// echo '<pre>';
// var_dump($_SESSION['history']);
// echo '</pre>';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src='https://cdn.tailwindcss.com'></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body class="h-screen">
    <main class="flex  justify-center h-full">
        <div class=" bg-white h-full  p-8 rounded-lg shadow-lg w-full max-w-2xl">
            <div>
                <div class="text-center mb-6">
                    <img src="shell-logo.png" alt="Shell Logo" class="mx-auto w-20 h-20 animate-bounce">
                    <h2 class="mt-3 text-2xl font-bold">Shell Bahan Bakar</h2>
                </div>
                <h2 class="text-xl font-bold mb-5">History Transaksi</h2>


            </div>

            <div class="overflow-y-auto scroll-y h-[60%]">
                <?php if (empty($_SESSION['history'])) : ?>
                <div class="bg-zinc-50 p-5 rounded-lg mb-5">
                    <h2 class="text-xl font-bold">Shell Bahan Bakar</h2>
                    <p>Belum ada riwayat transaksi</p>
                </div>
                <?php else : ?>
                <?php foreach ($_SESSION['history'] as $key => $item) : ?>
                <div class="bg-zinc-50 p-5 rounded-lg mb-5">
                    <!-- <div class="flex justify-between">
                    <h2 class="text-xl font-bold"></h2>
                    <span><?= $item['order_at'] ?></span>
                </div> -->
                    <div class="flex justify-between">
                        <strong class="">Jenis Bahan Bakar</strong>
                        <strong><?= $item['bahanbakar'] ?></strong>
                    </div>
                    <div class="my-5">
                        <div class="flex justify-between">
                            <p>Jumlah Liter</p>
                            <strong><?= $item['jumlah'] ?>L</strong>
                        </div>
                        <div class="flex justify-between">
                            <p>Harga Per Liter</p>
                            <p>Rp. <?= $item['hargaPerLiter'] ?></p>
                        </div>
                        <div class="flex justify-between">
                            <p>Total PPN</p>
                            <p>Rp. <?= $item['totalPpn'] ?></p>
                        </div>
                        <div class="flex justify-between">
                            <p>Total Harga</p>
                            <p>Rp. <?= $item['totalHarga'] ?></p>
                        </div>
                        <div class="flex justify-between">
                            <p>Tanggal transaksi</p>
                            <span><?= $item['order_at'] ?></span>
                        </div>
                    </div>

                    <div class="mt-5 w-fit ms-auto">
                        <a href="history.php?action=delete&index=<?= $key ?>">
                            <button
                                class="btn ms-auto btn-secondary shiny w-fit bg-red-600 text-white py-2 px-3 rounded-md hover:bg-red-700">
                                Hapus
                            </button>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="mt-10 flex justify-between">
                <a href="bahanbakar.php">
                    <button
                        class="btn btn-secondary shiny w-fit bg-gray-800 text-white py-2 px-3 rounded-md hover:bg-gray-700">Kembali
                        ke beranda
                    </button>
                </a>
                <a href="history.php?action=delete-all">
                    <button
                        class="btn btn-secondary shiny w-fit bg-red-600 text-white py-2 px-3 rounded-md hover:bg-red-700">
                        Hapus Semua
                    </button>
                </a>
            </div>


        </div>
    </main>

    <?php if (isset($_GET['message']) && $_GET['message'] == 'Data tidak valid') : ?>
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Data tidak valid!',
    }).then(function() {
        window.location = "history.php";
    });
    </script>
    <?php endif; ?>

    <script src="shiny.js">
    </script>
</body>

</html>