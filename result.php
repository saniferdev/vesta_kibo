<?php
session_start();
if (!empty($_SESSION["username"])) {
    $username 	= $_SESSION["username"];
    $site 		= $_SESSION["site"];
    $groupe     = $_SESSION["groupe"];
} else {
    session_unset();
    header("Location: index.php");
}
session_write_close();

if (!function_exists('str_contains')) {
    function str_contains(string $haystack, string $needle): bool
    {
        return '' === $needle || false !== strpos($haystack, $needle);
    }
}

require __DIR__ . "/config.php";
require __DIR__ . "/lib/Api.php";

$dossier = "uploads/";
$Api = new API();
$Api->link  = $link;
$Api->link2 = $link2;
$Api->site  = $site;
$Api->user  = $username;


if(isset($_FILES["file"])){
   $msg = $Api->upload_csv($_FILES["file"]);
   echo $msg;
   if(str_contains($msg, 'success')) {
        $fileName = basename($_FILES["file"]["name"]);
        $rep      = $dossier.$fileName;
        $data     = $Api->csv_to_array($rep);

        $nEntete   = $data[0][1];
        $nsite     = $data[0][2];
        $nLigne    = $data[1][1];
        $insEntete = $Api->InsertEntete($nEntete,$nLigne,$nsite,$username);

        if($nEntete == $insEntete){
            //echo "<div class='alert alert-success'>Entete inseré: <b>".$nEntete."</b></div>";
            $session  = array_slice($data, 2);
            $insLigne = $Api->InsertLigne($nLigne,$nsite,$username,$session);
            if($nLigne == $insLigne){
                //echo "<div class='alert alert-success'>Session Ligne inserée: <b>".$nLigne."</b></div>";
                $detail = $Api->getDetailInv($insEntete);
                echo $detail;
            }
            
        }
        else{
            $n = $Api->getInv($nEntete);
            if($n[0]["nEntete"] == $nEntete){
                echo "<div class='alert alert-warning'><b>N° ".$nEntete." Inventaire déjà existant dans la base!!</b></div>";
            }
            else{
                echo "<div class='alert alert-warning'><b>Erreur d'insertion des données dans la base!!</b></div>";
            }
        }

   }
}
else if( isset($_POST["nLigne"]) && !empty($_POST["nLigne"]) ){
    $num = $_POST["nLigne"];
    $ref = $_POST["ref"];
    $qte = $_POST["qte"];
    $ajoutLigne = $Api->addLigneInv($num,$ref,$qte);
    echo $ajoutLigne;

}
else if( isset($_POST["VnLigne"]) && !empty($_POST["VnLigne"]) ){
    $num  = $_POST["VnLigne"];
    $data = $_POST["result"];
    $envoi =  $Api->traitementInv($num,$data);
    echo $envoi;

}
else if( isset($_POST["InvNum"]) && !empty($_POST["InvNum"]) ){
    $num  = $_POST["InvNum"];
    $detail = $Api->getDetailInv($num);
    if($detail == ""){
        echo "<div class='alert alert-warning'><b>N° ".$num." Inventaire inexistant dans la base!!</b></div>";
    }
    else{
        echo $detail;
    }
}