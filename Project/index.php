<?php
session_start();
ob_start();
if (!isset($_SESSION['email'])){
  header("location:login.php");
}
?>

<!doctype html>

<html lang="it">
<head>
  <meta charset="utf-8">
  <link rel="icon" type="image/png" href="images/icon.png" />
  <title>Home</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12/dist/vue.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/dayjs/1.10.4/dayjs.min.js"></script>
  <link rel="stylesheet" href="css/styleHome.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body id="body">

  <nav>
  <a onclick="home()"><i class="fa fa-home"></i></a>
  <a onclick="ricerca()"><i class="fa fa-search"></i></a>
  <a onclick="lista()"><i class="fa fa-shopping-cart"></i></a>
  <a onclick="valuta()"><i class="fa fa-star"></i></a>
  <a href="logout.php"><i class="fa fa-sign-out"></i></a>
  </nav>


<div id="container" class="container">

</div>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script>
$(document).ready(function() {
  $.ajax({
    url: 'home.php',
    success: function(data) {
        $("#container").html(data);
        document.getElementById('body').style.background="#b6c9f0";
    },
    error: function(jXHR, textStatus, errorThrown) {
      alert(errorThrown + "Errore nella chiamata della pagina");
    }
  });
});

function home(){
  $.ajax({
    url: 'home.php',
    success: function(data) {
        $("#container").html(data);
    },
    error: function(jXHR, textStatus, errorThrown) {
      alert(errorThrown + "Errore nella chiamata della pagina");
    }
  });
}

function ricerca(){
  $.ajax({
    url: 'ricerca.php',
    success: function(data) {
        $("#container").html(data);
    },
    error: function(jXHR, textStatus, errorThrown) {
      alert(errorThrown + "Errore nella chiamata della pagina");
    }
  });
}

function lista(){
  $.ajax({
    url: 'lista.php',
    success: function(data) {
        $("#container").html(data);
    },
    error: function(jXHR, textStatus, errorThrown) {
      alert(errorThrown + "Errore nella chiamata della pagina");
    }
  });
}

function valuta(){
  $.ajax({
    url: 'valuta.php',
    success: function(data) {
        $("#container").html(data);
    },
    error: function(jXHR, textStatus, errorThrown) {
      alert(errorThrown + "Errore nella chiamata della pagina");
    }
  });
}

</script>
</body>
</html>
