<?php
session_start();
if (!empty($_SESSION["username"])) {
    $name = $_SESSION["username"];
    $site 		= $_SESSION["site"];
    $groupe     = $_SESSION["groupe"];
} else {
    session_unset();
    $url = "./index.php";
    header("Location: $url");
}

session_write_close();
include __DIR__ . "/config.php";
include __DIR__ . "/lib/Api.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ .'/vendor/autoload.php';

function envoiMail($sujet,$objet){
    $mail = new PHPMailer(true);
    $mail->setLanguage('fr', '/PHPMailer/language/');
    $mail->IsSMTP(); 
    $mail->SMTPOptions = array(
      'ssl' => array(
      'verify_peer' => false,
      'verify_peer_name' => false,
      'allow_self_signed' => true
      )
    );
    //$mail->SMTPDebug  = 4;  
    $mail->SMTPAuth   = true;  

    $mail->Host       = 'mail.fripesenligne.fr';                     
    $mail->Username   = 'kibocom@fripesenligne.fr';                    
    $mail->Password   = 'dx2sy3gl%`3@';                              
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
    $mail->Port       = 465;


    $mail->SetFrom('informatique@fripesenligne.fr', 'KIBO');
    $mail->Subject    = $sujet;
    $mail->CharSet    = 'UTF-8';
    $mail->Body       = $objet;
    //$mail->AddAddress('winny.devinfo@talys.mg');
    $mail->AddAddress('chefrayon.kibo@kibo.mg');
    $mail->AddCC('JeanPhilippe.Budin@kibo.mg');
    $mail->AddCC('Miora.vente@kibo.mg');
    $mail->AddCC('Lydien.andriamasinoro@kibo.mg');
    $mail->AddCC('informatique@sanifer.mg');
    $mail->AddBCC('winny.devinfo@talys.mg');
    $mail->addReplyTo('informatique@sanifer.mg');
    $mail->isHTML(true);
    if(!$mail->Send()) {
      $return         = "Erreur d'envoi de mail: ".$mail->ErrorInfo;
    } else {
      $return         = 'Mail envoyé avec succès!';
    }
    return $return;
}

$Api 								= new API();
$Api->link 					= $link;
$Api->link2         = $link2;
$Api->url_soap  		= $url_soap;
$Api->login     		= $login;
$Api->password  		= $password;
$Api->codeLang  		= $codeLang;
$Api->poolAlias 		= $poolAlias;
$Api->site  				= $site;
$Api->codeFamille 	= $codeFamille;

$data = $ref = $des = $fam = $fam2 = $fam3 = $cb = $nfourn = $intf = $ref_f = $dat_p = $lot = $emp = $prix_v = $nomencl = $qte = $d = "";

if( isset($_POST["recherche"]) && !empty($_POST["recherche"]) ){
	$recherche 	= $_POST["recherche"];
	$donnee 	= $Api->getDetailArticle($recherche);
	$nomencl 	= $Api->getNomenclatureArticle($recherche);

	if( (is_countable($donnee) && count($donnee) == 1) || strlen($recherche) == 8 || strlen($recherche) == 13){
		if (is_array($donnee) || is_object($donnee)) {
			foreach ($donnee as $value) {
				$lot    = $value["LOT"];
				$emp    = $value["EMPL"].'----'.$value["EMPL_T"];
				$l      = ( isset($lot) && !empty($lot))? '   '.$lot: '';
				if ( $value === reset( $donnee ) ) {
					$data   .='<h5 class="modal-title h5_">'.$value["REF"].'<br />'.$value["DESS"].'</h5>';
					$data   .='<input type="hidden" name="ref" id="ref" value="'.$value["REF"].'----'.$value["DESS"].'">';
				}

				$data   .= '<div class="form-check">
								<input class="form-check-input" type="radio" value="'.$emp.'----'.$lot .'" name="emp" id="emp">
								<label class="form-check-label" for="emp">
								    '.$value["EMPL"].' - '.$value["EMPL_T"].'<b>'.$l.'</b>
								</label>
							</div>';
			}
		}
	}
	else{
		if (is_array($donnee) || is_object($donnee)) {
			foreach ($donnee as $value) {
				$ref 	= $value["REF"];
				$des 	= $value["DESS"];
				$fam 	= $value["FAM"];
				$ref_f 	= $value["REF_F"];

				$data   .= '<tr>
							    <td><a class="rs_" href="#" id="'.$ref.'">'.$ref.'</a></td>
							    <td><a class="rs_" href="#" id="'.$ref.'">'.$des.'</a></td>
							    <td><a class="rs_" href="#" id="'.$ref.'">'.$fam.'</a></td>
							    <td><a class="rs_" href="#" id="'.$ref.'">'.$ref_f.'</a></td>
							</tr>';
			}
		}
	}
	echo $data;
}
else if( isset($_POST["id"]) && !empty($_POST["id"]) ){
	$id 		= $_POST["id"];
	$donnee 	= $Api->getDetailArticle($id);

	foreach ($donnee as $value) {
		$lot    = $value["LOT"];
		$emp    = $value["EMPL"].'----'.$value["EMPL_T"];
		$l      = ( isset($lot) && !empty($lot)) ? '   '.$lot : '';
		if ( $value === reset( $donnee ) ) {
			$data   .='<h5 class="modal-title h5_">'.$value["REF"].'<br />'.$value["DESS"].'</h5>';
			$data   .='<input type="hidden" name="ref" id="ref" value="'.$value["REF"].'----'.$value["DESS"].'">';
		}
		$data   .= '<div class="form-check">
						<input class="form-check-input" type="radio" value="'.$emp.'----'.$lot .'" name="emp" id="emp">
						<label class="form-check-label" for="emp">
						    '.$value["EMPL"].' - '.$value["EMPL_T"].'<b>'.$l.'</b>
						</label>
					</div>';
	}
	echo $data;
}
else if(isset($_POST["qte_sortie"]) && !empty($_POST["qte_sortie"])){
	$exp    = explode('----',$_POST["ref"]);
	$emp    = explode('----',$_POST["emp"]);
	$qte    = $_POST["qte_sortie"];

	$data   .= '<tr class="ligne_">
					<td>'.$exp[0].'</td>
					<td>'.$exp[1].'</td>
					<td>'.$emp[0].' - '.$emp[1].'</td>
					<td>'.$emp[2].'</td>
					<td><input type="number" min="1" id="qte_s" value="'.number_format((float)($qte), 0 , '' ,'').'"></td>
					<td>
						<a class="delete" aria-label="Ne pas visualiser" title="Ne pas visualiser"><i class="fa fa-trash-o supp" aria-hidden="true"></i></a>
					</td>
				</tr>';
	
	echo $data;
}
else if( isset($_POST["add"]) && !empty($_POST["add"]) ){
	$array 		= $_POST["add"];
	$num 		= "";
	$pattern 	= "/[a-zA-Z0-9]+/i";
	$output 	= $Api->soap_API2($array);
	
	if(preg_match_all($pattern, $output, $matches, PREG_PATTERN_ORDER)) {
	  $num = $matches[0][4];
	}

	if(!empty($num)){
		$insert = $Api->InsertSortie($num);
		if($insert){
			$ligne = $Api->ligne_($array);
			$Api->mail($num,$ligne);
			echo $output;
		}
		else echo "Erreur d'insertion de donnée dans la base";
	}
	else echo "Erreur d'insertion de donnée dans X3";
}