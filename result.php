<?php
session_start();
if (!empty($_SESSION["username"])) {
    $name = $_SESSION["username"];
} else {
    session_unset();
    $url = "./index.php";
    header("Location: $url");
}

session_write_close();
include __DIR__ . "/config.php";
include __DIR__ . "/lib/Api.php";

$Api = new API();
$Api->link 	= $link;
$Api->url_soap  = $url_soap;
$Api->login     = $login;
$Api->password  = $password;
$Api->codeLang  = $codeLang;
$Api->poolAlias = $poolAlias;

$data = $ref = $des = $fam = $fam2 = $fam3 = $cb = $nfourn = $intf = $ref_f = $dat_p = $lot = $emp = $prix_v = $nomencl = $qte = $d = "";

if( isset($_POST["recherche"]) && !empty($_POST["recherche"]) ){
	$recherche 	= $_POST["recherche"];
	$donnee 	= $Api->getDetailArticle($recherche);
	$nomencl 	= $Api->getNomenclatureArticle($recherche);

	if( (is_countable($donnee) && count($donnee) == 1) || $nomencl == 1 || strlen($recherche) == 8){
		if (is_array($donnee) || is_object($donnee)) {
			foreach ($donnee as $value) {
				$ref 	= $value["REF"];
				$des 	= $value["DESS"];
				$fam 	= $value["FAM"];
				$fam2 	= $value["FAM2"];
				$fam3 	= $value["FAM3"];
				$cb  	= $value["CB"];
				$nfourn = $value["FOURN"];
				$intf 	= $value["FOURNN"];
				$ref_f 	= $value["REF_F"];
				$dat_p  = $value["DAT_P"];
				$lot    = $value["LOT"];
				$emp    = $value["EMPL"].' - '.$value["EMPL_T"];
				$s 		= $value["QTE"];

			$data   .= '<tr class="ligne_">
							<td>'.$ref.'</td>
							<td>'.$des.'</td>
							<td>'.$fam.'</td>
							<td>'.$fam2.'</td>
							<td>'.$fam3.'</td>
							<td>'.$ref_f.'</td>
							<td>'.$emp.'</td>
							<td>'.$lot.'</td>
							<td>'.$dat_p.'</td>
							<td align="right" class="S1">'.number_format((float)($s), 2 , ',' ,' ').'</td>
							<td>
								<a class="edit" aria-label="Modifier" title="Modifier"><i class="fa fa-pencil-square-o edit_" aria-hidden="true"></i></a>
								<a class="delete" aria-label="Ne pas visualiser" title="Ne pas visualiser"><i class="fa fa-trash-o supp" aria-hidden="true"></i></a>
							</td>
						</tr>';
			}
		}
	}
	else{
		if (is_array($donnee) || is_object($donnee)) {
			foreach ($donnee as $value) {
				$ref 	= $value["REF"];
				$des 	= $value["DESS"];
				$fam 	= $value["FAM"];
				$cb  	= $value["CB"];
				$num_f 	= $value["FOURN"];
				$int_f 	= $value["FOURNN"];
				$ref_f 	= $value["REF_F"];
				$prix_v	= $value["PV_TTC"];

				$data   .= '<tr>
							    <td><a class="r_" href="#" id="'.$ref.'">'.$ref.'</a></td>
							    <td><a class="r_" href="#" id="'.$ref.'">'.$des.'</a></td>
							    <td><a class="r_" href="#" id="'.$ref.'">'.$fam.'</a></td>
							    <td><a class="r_" href="#" id="'.$ref.'">'.$ref_f.'</a></td>
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
		$ref 	= $value["REF"];
		$des 	= $value["DESS"];
		$fam 	= $value["FAM"];
		$fam2 	= $value["FAM2"];
		$fam3 	= $value["FAM3"];
		$cb  	= $value["CB"];
		$nfourn = $value["FOURN"];
		$intf 	= $value["FOURNN"];
		$ref_f 	= $value["REF_F"];
		$dat_p  = $value["DAT_P"];
		$lot    = $value["LOT"];
		$emp    = $value["EMPL"].' - '.$value["EMPL_T"];
		$s 		= $value["QTE"];

		$data   .= '<tr class="ligne_">
						    <td>'.$ref.'</td>
						    <td>'.$des.'</td>
						    <td>'.$fam.'</td>
						    <td>'.$fam2.'</td>
						    <td>'.$fam3.'</td>
						    <td>'.$ref_f.'</td>
						    <td>'.$emp.'</td>
						    <td>'.$lot.'</td>
						    <td>'.$dat_p.'</td>
						    <td align="right" class="S1">'.number_format((float)($s), 2 , ',' ,' ').'</td>
						    <td>
						    	<a class="edit" aria-label="Modifier" title="Modifier"><i class="fa fa-pencil-square-o edit_" aria-hidden="true"></i></a>
						    	<!--<a class="delete" aria-label="Ne pas visualiser" title="Ne pas visualiser"><i class="fa fa-trash-o supp" aria-hidden="true"></i></a>-->
						    </td>
						</tr>';
	}
	echo $data;
}
if(isset($_POST["ref"]) && !empty($_POST["ref"])){
	$ref    = $_POST["ref"];
	$emp    = $_POST["emp"];
	$lot    = $_POST["lot"];
	$qte    = $_POST["qte"];
	$d  	= date_create($_POST["date_"]);
	$dat_p  = date_format($d, 'Ymd');
	
	$ws	 	= $Api->soap_API($ref,$emp,$lot,$qte,$dat_p);
	echo $ws;
}