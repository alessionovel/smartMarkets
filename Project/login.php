<?php
session_start();
if (isset($_SESSION['email'])) {
  header("location:index.php");
}
?>
<!doctype html>

<html lang="it">
<head>
  <meta charset="utf-8">
  <link rel="icon" type="image/png" href="images/icon.png" />

  <title>Login</title>
  <meta name="description" content="The HTML5 Herald">
  <meta name="author" content="SitePoint">
  <link rel="stylesheet" href="css/style.css">

</head>

<body>

  <h2>Bentornato nel tuo servizio di SmartMarkets! <img src="images/icon.png" width="30px"> </h2>
  <div class="container" id="container">
    <div class="form-container sign-up-container">
  		<form id="registrazione" method="post">
  			<h1>Registrati</h1>
  			<span>Inserisci i tuoi dati</span>
  			<input id="nome" type="text" placeholder="Nome" />
        <input id="cognome" type="text" placeholder="Cognome" />
  			<input id="emailReg" type="email" placeholder="Email" />
  			<input id="passwordReg" type="password" placeholder="Password" />
        <div style="color:#FF8C00;margin-bottom:10px" id="registrazione-check" class="output-check"></div>
  			<button type="submit">Registrati</button>
  		</form>
  	</div>
    <div class="form-container sign-in-container">
      <form id="login" method="post" data-bitwarden-watching="1">
        <h1>Login</h1>
        <span>Inserisci le tue credenziali</span>
        <input id="email" type="email" placeholder="Email">
        <input id="password" type="password" placeholder="Password">
        <div> Visualizza password<input style="display:inline" type="checkbox" id="check"></div>
        <div style="color:#FF8C00;margin-bottom:10px" id="login-check" class="output-check"></div>
        <button type="submit">Accedi</button>
        <p id="easterEgg" onclick="easterEgg()">Hai dimenticato la password?</p>
      </form>
    </div>
    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left">
  				<h1>Bentornato!</h1>
  				<p>Accedi con le tue credenziali</p>
  				<button class="ghost" id="signIn">Login</button>
  			</div>
        <div class="overlay-panel overlay-right">
          <h1>Non hai un account?</h1>
          <p>Registrati per poter accedere al servizio</p>
          <button class="ghost" id="signUp">Registrati</button>
        </div>
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
  <script>
    $(document).ready(function() {
      $('#check').click(function() {
        if (document.getElementById('check').checked) {
          $('#password').get(0).type = 'text';
        } else {
          $('#password').get(0).type = 'password';
        }
      });
    });
  </script>
  <script src="script/script.js"></script>
</body>
</html>
