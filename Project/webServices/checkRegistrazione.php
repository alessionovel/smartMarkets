<?php
require('db_connection.php');
use PHPMailer\PHPMailer\PHPMailer;
$error = 0;

class Json {

}

$json = new Json();

$risultato;
$messaggio;

if (isset($_REQUEST['email']) && isset($_REQUEST['cognome']) && isset($_REQUEST['nome']) && isset($_REQUEST['password'])) {
  $nome = $_REQUEST['nome'];
  $cognome = $_REQUEST['cognome'];
  $email = $_REQUEST['email'];
  $password = $_REQUEST['password'];

  $stmt = $conn->prepare('SELECT * FROM novelUtente WHERE email = ?');
  $stmt->bind_param('s', $email); // 's' specifies the variable type => 'string'

  $stmt->execute();
  $stmt->store_result();
  $num = $stmt->num_rows;

  if ($num > 0) {
    $risultato = -1;
    $messaggio = 'Email già registrata';
  }else{

    $cryptedPW = password_hash($password, PASSWORD_DEFAULT); //criptazione password hash
    $qu = "INSERT into novelUtente VALUES(?, ?, ?, ?)";
    $stmt = $conn->prepare($qu);

    $stmt->bind_param("ssss", $email, $nome, $cognome, $cryptedPW);
    $stmt->execute();


    require_once 'PHPMailer/PHPMailer.php';
    require_once 'PHPMailer/SMTP.php';
    require_once 'PHPMailer/Exception.php';
    $mail = new PHPMailer(); //link al mailer che permette di usare gmail
    $mail->isSMTP();
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "smart.markets.volta@gmail.com";
    $mail->Password = "AleNovel02";
    $mail->Port = 465;
    $mail->SMTPSecure = "ssl";
    $mail->isHTML(true);
    $mail->setFrom("smart.markets.volta@gmail.com");
    $mail->addAddress($email);

    $mail->Subject = 'Registrazione effettuata!';
    $message = '<html><body>';
    $message .= '<h1 style="color:#e93b81">Benvenuto</h1><br>
    Salve,<b> ' . $nome . ' ' . $cognome . '</b> il suo <b>account</b> è stato registrato correttamente
    <br><br><i>Comincia ad usare il nostro servizio: https://www.appalo.it/5E/GruppoC/smartMarkets/</i>';
    $message .= '</body></html>';
    $mail->Body = $message;

    if($mail->send()){
      $risultato = 0;
      $messaggio = 'Registrazione effettuata e email inviata';
    }else{
      $risultato = 0;
      $messaggio = 'Registrazione effettuata e email non inviata';
    }
  }
} else {
  $risultato = -1;
  $messaggio = 'Errore nel passaggio dei parametri';
}

$json->risultato = $risultato;
$json->messaggio = $messaggio;

echo json_encode($json);
