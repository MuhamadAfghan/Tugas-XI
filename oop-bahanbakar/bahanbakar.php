<?php session_start() ?>

<!doctype html>
<html lang="en">

<head>
    <title>Shell Bahan Bakar</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="shortcut icon" href="shell-logo.png" type="image/x-icon">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>


    <style>
    body {
        background-color: #f8f9fa;
    }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-gray-100">
    <main class="flex  justify-center min-h-screen">
        <div class=" bg-white h-fit mt-12 p-8 rounded-lg shadow-lg w-full max-w-2xl">
            <div class="text-center mb-6">
                <img src="shell-logo.png" alt="Shell Logo" class="mx-auto w-20 h-20 animate-bounce">
                <h2 class="mt-3 text-2xl font-bold">Shell Bahan Bakar</h2>
            </div>

            <form action="result.php" method="post" class="space-y-4">
                <div class="form-group">
                    <label for="bahanbakar" class="block font-semibold">Jenis Bahan Bakar</label>
                    <select name="bahanbakar" id="bahanbakar"
                        class="form-select mt-1 block w-full p-2 border border-gray-300 rounded-md" required>
                        <option selected disabled hidden>-- Pilih Bahan Bakar --</option>
                        <option value="Super">Shell Super</option>
                        <option value="VPower">Shell V-Power</option>
                        <option value="VPowerDiesel">Shell V-Power Diesel</option>
                        <option value="VPowerNitro">Shell V-Power Nitro</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="bahanbakar" class="block font-semibold">Jumlah Liter </label>
                    <input type="number" name="jumlah" id="bahanbakar"
                        class="form-control mt-1 block w-full p-2 border border-gray-300 rounded-md" required min="1">
                </div>
                <a href="history.php" class="inline-block my-5 text-blue-500">History transaksi</a>
                <button type="submit" name="submit"
                    class="btn btn-secondary shiny w-full bg-gray-800 text-white py-2 rounded-md hover:bg-gray-700">Beli</button>
            </form>
        </div>
    </main>

    <?php if (isset($_GET['message']) && $_GET['message'] == 'Data tidak valid') : ?>
    <script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Data tidak valid!',
    }).then(function() {
        window.location = "bahanbakar.php";
    });
    </script>
    <?php endif; ?>

    <script src="shiny.js">
    </script>
</body>

</html>