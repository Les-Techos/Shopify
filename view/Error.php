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

<style>
        h5 {
  position: relative;
  animation-name: bouge;
  animation-duration: 4s;
  animation-iteration-count: infinite;
  animation-direction: alternate-reverse;  
}

@keyframes bouge {
  0%   {color: #ff0000; left:0px; }
  25%  { color: #00ff00; left:25px; }
  50%  { color: #0000ff; left:50px;  }
  75%  { color: #ff00ff; left:75px; }
  100% { color: #1a1a1a; left:100px; }
}
    </style>
<div class="container-fluid" style="text-align: center;">
    <img src="./assets/image/404.png" style=" display: block; margin-left: auto; margin-right: auto; width: 50%;">
    <h5> On cherche la panne pour vous fournir le meilleur service possible </h5>
    <h6> erreur : <?=$controllerData?></h6>
</div>
<div class="row">
    <div  class="d-grid gap-2 col-6 mx-auto">
        <a href="./" type="button" class="btn btn-outline-info btn-lg">Retour page principale</a>
    </div>
</div>
</body>

</html>