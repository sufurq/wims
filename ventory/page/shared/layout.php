<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge, chrome=1.0, safari">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/img/logo/yt_final1.png" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/sweetalert2.min.css">
    <link rel="stylesheet" href="../assets/css/loader.css">
    <?php echo (isset($styles)) ? $styles : "" ?>
    <title>
        <?php echo (isset($title)) ? "Youth Reconnect | " . $title : "" ?>
    </title>
</head>

<body>
    <?php ob_start() ?>

    <div class="loader" id="loadingModal">
        <div class="dot dot-1"></div>
        <div class="dot dot-2"></div>
        <div class="dot dot-3"></div>
        <div class="dot dot-4"></div>
        <div class="dot dot-5"></div>
    </div>

    <?php $loader = ob_get_clean() ?>

    <?php echo (!isset($load)) ? $loader : "" ?>
    <?php echo (isset($navbar)) ? $navbar : "" ?>

    <?php echo isset($content) ? $content : ''; ?>

    <!-- JS -->
    <script src="../assets/js/jquery-3.7.1.slim.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/sweetalert2.all.min.js"></script>
    <script src="../assets/js/loader.js"></script>


    <?php if (isset($_SESSION["m"])) : ?>
        <?php
        $m = $_SESSION["m"];
        $i = strlen($m) - 1;
        ?>
        <?php if ($m[$i] != "!") : ?>
            <?php $m = $m . "!" ?>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: '<?php echo $m ?>',
                    confirmButtonColor: '#5DB075',
                    timer: 2000
                });
            </script>
        <?php else : ?>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: '<?php echo $m ?>',
                    confirmButtonColor: '#d33',
                    timer: 2000
                });
            </script>
        <?php endif; ?>
        <?php unset($_SESSION["m"]) ?>
    <?php endif; ?>

    <?php echo (isset($scripts)) ? $scripts : "" ?>
</body>

</html>