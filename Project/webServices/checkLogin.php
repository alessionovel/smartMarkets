<?php
session_start();

require_once('db_connection.php');

class Json {

}

$json = new Json();

$risultato;
$messaggio;

if (isset($_REQUEST['email']) && isset($_REQUEST['password'])) {
  $email = $_REQUEST['email'];
  $password = $_REQUEST['password'];

  $query = "SELECT email, nome, cognome, password FROM novelUtente WHERE email = ?";

  $stmt = $conn->prepare($query);
  $stmt->bind_param('s', $email); // 's' specifies the variable type => 'string'
  $stmt->execute();
  $stmt->bind_result($email, $nome, $cognome, $passwordInDB);
  $stmt->store_result();
  $num = $stmt->num_rows;

  if ($num == 1) {
    while ($stmt->fetch()) {
      if (password_verify($password, $passwordInDB)) {        //verifica se la password cryptata nel database associata all'email è uguale alla passord cryptata inserita al momento del login
        $risultato = 0;
        $messaggio = 'Login effettuato correttamente';
        $_SESSION['email']=$email;
        $_SESSION['nome']=$nome;
        $_SESSION['cognome']=$cognome;
      }
      else {
        $risultato = -1;
        $messaggio = 'Password errata';
      }
    }
  } else {
    $risultato = -2;
    $messaggio = 'Account inesistente';
  }
} else {
  $risultato = -3;
  $messaggio = 'Errore nel passaggio dei parametri';
}
$json->risultato = $risultato;
$json->messaggio = $messaggio;

echo json_encode($json);
