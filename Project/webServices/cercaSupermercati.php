<?php

require_once('db_connection.php');

if (isset($_REQUEST['email']) && isset($_REQUEST['provincia']) && isset($_REQUEST['cerca'])){
  $email = $_REQUEST['email'];
  class Json {

  }


  class Supermercato {

  }
  $json = new Json();
  $i = 0;

  $query = "SELECT idUtenteBackOffice, nome, indirizzo, provincia, latitudine, longitudine FROM `novelSupermercato`  WHERE novelSupermercato.nome LIKE '%".$_REQUEST['cerca']."%' AND novelSupermercato.provincia = '".$_REQUEST['provincia']."'";
  $rec = mysqli_query($conn, $query) or die($query . "<br>" . mysqli_error($conn));
  $num = mysqli_num_rows($rec);
  if ($num == 0) {
    $json->risultato = -2;
    $json->messaggio = 'Nessun supermercato trovato';
  } else {

    while ($array = mysqli_fetch_array($rec)) {
      $supermercato[$i] = new Supermercato();

      $supermercato[$i]->nome = $array['nome'];

      $supermercato[$i]->idUtenteBackOffice = $array['idUtenteBackOffice'];

      $supermercato[$i]->indirizzo = $array['indirizzo'];

      $supermercato[$i]->provincia = $array['provincia'];

      $supermercato[$i]->lat = $array['latitudine'];

      $supermercato[$i]->lon = $array['longitudine'];



      $query = "SELECT * FROM `novelValutazione` WHERE novelValutazione.idUtenteBackOffice = '".$array['idUtenteBackOffice']."' AND novelValutazione.emailUtente = '".$_REQUEST['email']."'";
      $rec2 = mysqli_query($conn, $query) or die($query . "<br>" . mysqli_error($conn));
      $num2 = mysqli_num_rows($rec2);
      if($num2 == 0){
        $supermercato[$i]->valutazione = null;
      } else {
      while ($array2 = mysqli_fetch_array($rec2)) {
        $supermercato[$i]->valutazione = $array2['voto'];
      }
    }
      $i++;
    }
    $json->supermercati = $supermercato;
    $json->risultato = 0;
    $json->messaggio = 'Supermercati trovati correttamente';

  }

}else{
  $json->risultato = -1;
  $json->messaggio = 'Errore nel passaggio dei parametri';
}

echo json_encode($json);
