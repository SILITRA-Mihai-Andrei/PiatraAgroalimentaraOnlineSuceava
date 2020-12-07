<?php

require_once('variables.php');
require_once('strings.php');

session_start();

if(isset($_SESSION[STR_ID_DB]) and isset($_SESSION[STR_USER_DB]) and isset($_SESSION[STR_EMAIL_DB])){
    echo $_SESSION[STR_ID_DB];
    echo $_SESSION[STR_USER_DB];
    echo $_SESSION[STR_EMAIL_DB];
}
else{
    header( "Location: $login_page_server");
}


/*
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "id: " . $row["id"]. " - NumeComplet: " . $row["NumeComplet"]. " - from " . $row["Localitate"]. "<br>"
        . $row["Adresa"]. "<br>"
        . $row["Telefon"]. "<br>";
    if($row["Depozit"] == NULL)
        echo "Fara depozit.";
    else
        echo "Adresa depozitului: ". $row["Depozit"];
    echo "<br>";    
  }
} else {
  echo "0 results";
}

echo "<div class='container'>
    <div class='row-fluid'>";
    foreach ( $result as $row) :
        echo "<div class='col-sm-4'>
            <div class='card-columns-fluid'>
                <div class='card  bg-light' style = 'width: 22rem; ' >

                    <div class='card-body'>
                        <h5 class='card-title'><b>" . $row["id"]." ".$row["NumeComplet"] . "</b></h5>"
                        . "<p class='card-text'><b>" . $row["Localitate"] . "</b></p>"
                        . "<p class='card-text'>" . $row["Adresa"] . "</p>"
                        . "<p class='card-text'>" . $row["Telefon"] . "</p>"
                        . "<a href='#' class='btn btn-secondary'>Full Details</a>"
                    . "</div>

                </div>
            </div>
        </div>";
    endforeach;
    echo "</div>
</div>";
*/

?>