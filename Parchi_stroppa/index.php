<?php
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Parchi d'Italia</title>
        <link rel="stylesheet" type="text/css" href="style.css" />

</head>
<body>
    <h1 class="titolo">Parchi d'Italia</h1>
    <form method="GET" action="index.php">
    <select class="box"  name="nome_parco">
        <option> Seleziona un parco: </option>
    <?php

    $ip='127.0.0.1';
    $username='root';
    $pwd='';
    $database='parchi';
    $connection= new mysqli($ip, $username, $pwd, $database);
    if($connection->connect_error){
        die('C\'è stato un erroe: ' . $connection->connect_error);
    }
    $sql= 'SELECT nome FROM parco';
    $result=$connection->query($sql);
    if($result->num_rows>0){
        while($row=$result->fetch_assoc()){
            echo '<option value="'. $row['nome'] . '">'. $row['nome'].'</option>';
        }
    }

    ?>
    </select>
        <input class="btn" type="submit"/>
</form>
<form method="GET" >
        <select class="box"  name="species_id">
        <option> Seleziona una specie: </option>
           <?php
        if (isset($_REQUEST['nome_parco'])) {
         $_SESSION['park'] = $_REQUEST['nome_parco'];    
        $ip = '127.0.0.1';
        $username = 'root';
        $pwd = '';
        $database = 'parchi';            
        $connection = new mysqli($ip, $username, $pwd, $database);
        $sql = 'SELECT DISTINCT specie FROM animale WHERE parco="' . $_REQUEST['nome_parco'] . '"';
        $result = $connection->query($sql);
        if ($result->num_rows > 0) {
         while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['specie'] .'">' . $row['specie'] . '</option>';
             }
               }  
             }
            ?> 
            </select>
            <input class="btn" type="submit"/>
        </form>
        <?php

if ( isset( $_REQUEST["species_id"])){
    $ip = '127.0.0.1';
    $username = 'root';
    $pwd = '';
    $database = 'parchi';
    $connection = new mysqli($ip, $username, $pwd, $database);
    $sql = 'SELECT data_nascita FROM animale where specie="' . $_REQUEST['species_id'] . '" AND parco ="' . $_SESSION['park'] .  '"';
    $result = $connection->query($sql);

if ($result->num_rows > 0) {
    $eta_speci=0;
    $n_speci=0;
    while ($row = $result->fetch_assoc()) {
$data_nascita = new DateTime( $row['data_nascita']); 
$data_oggi = new DateTime('00:00:00'); 
$diff = $data_oggi->diff($data_nascita);
$diff=$diff->format('%y');
$eta_speci=$eta_speci+$diff;
$n_speci++;
    }
    $media=$eta_speci/$n_speci;
    echo "Al " . $_SESSION['park'] . " l'età media della specie " . $_REQUEST['species_id']. " è di: <br>";
    echo $media." anni <br>";
    echo "Ed il numero di esemplari è: ";
    echo $n_speci;
    }
}
?>
</body>
</html>