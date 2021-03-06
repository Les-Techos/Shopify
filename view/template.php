<!Doctype HTML>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1" />
    <title>Shop Rtf</title>
    <link href="./bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href=".\assets\style.css">
    <script type="text/javascript" src=".\assets\utils.js"></script>
</head>

<body>
    <?php
    include_once("./view/Header.php");
    ?>
    <div class="container" id="maincontent">
        <div class="row">
            <div class="span4">
                <?php
                if (file_exists('.' . "/view/" . $contents)) {
                    include $contents;
                } else {
                    throw new Exception("File does not exist");
                } ?>
            </div>
        </div>
    </div>

    </div>
    <div class="sticky-bottom">
    <?php
    include_once("./view/Footer.php");
    ?>
    </div>
    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>