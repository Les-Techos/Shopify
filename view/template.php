<!Doctype HTML>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
    <title>Shop Rtf</title>
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href=".\assets\style.css">
</head>

<body>
    <?php
    include_once("./view/Header.php");
    ?>
    <div class="container">
        <div class="row">
            <div class="span4">
                <?php 
                if (file_exists( $_SERVER['DOCUMENT_ROOT']."/view/".$contents)) {
                    include $contents;
                } else {
                    throw new Exception("File does not exist");
                } ?>
            </div>
        </div>
    </div>

    </div>
    <?php
    include_once("./view/Footer.php");
    ?>
    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>