<?php

Class API{

    public $link;
    public $link2;
    public $site;
    public $user;

    public function getInv($num){
        $queryParams    = $data = array();
        $queryOptions   = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $query          = " SELECT 
                                *
                            FROM 
                                invEntete invE
                                INNER JOIN invSession invL ON invL.nLigne = invE.nLigne
                            WHERE
                                invE.site = '".$this->site."'
                                AND (invE.nEntete = '".$num."' OR invE.nLigne = '".$num."')
                            ORDER BY
                                invL.ligne ASC ";

        $resultat       = sqlsrv_query($this->link2, $query, $queryParams, $queryOptions);
        if ($resultat == FALSE) {
            var_dump(sqlsrv_errors());
            return false;
        } elseif (sqlsrv_num_rows($resultat) == 0) {
            return false;
        } else {
            while($row = sqlsrv_fetch_array($resultat, SQLSRV_FETCH_ASSOC)){
                $data[] = $row;
            }
        }
        return $data;
    }

    public function getInvE($num){
        $queryParams    = $data = array();
        $queryOptions   = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $query          = " SELECT 
                                'E' AS 'A'
                                ,[nEntete] AS 'B'
                                ,[site] AS 'C'
                                ,'' AS D
                                ,'' AS E
                                ,'' AS G
                                ,'' AS H
                                ,'' AS I
                                ,'' AS J
                                ,'' AS K
                                ,'' AS L
                                ,'' AS M
                                ,'' AS N
                            FROM 
                                invEntete 
                            WHERE
                                nLigne = '".$num."' ";

        $resultat       = sqlsrv_query($this->link2, $query, $queryParams, $queryOptions);
        if ($resultat == FALSE) {
            var_dump(sqlsrv_errors());
            return false;
        } elseif (sqlsrv_num_rows($resultat) == 0) {
            return false;
        } else {
            while($row = sqlsrv_fetch_array($resultat, SQLSRV_FETCH_ASSOC)){
                $data[] = $row;
            }
            return $data;
        }        
    }
    public function getInvL($num){
        $queryParams    = $data = array();
        $queryOptions   = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $query          = " SELECT 
                                'L' AS 'A'
                                ,[nLigne] AS 'B'
                                ,'' AS C
                                ,'' AS D
                                ,'' AS E
                                ,'' AS G
                                ,'' AS H
                                ,'' AS I
                                ,'' AS J
                                ,'' AS K
                                ,'' AS L
                                ,'' AS M
                                ,'' AS N
                            FROM 
                                invEntete 
                            WHERE
                                nLigne = '".$num."' ";

        $resultat       = sqlsrv_query($this->link2, $query, $queryParams, $queryOptions);
        if ($resultat == FALSE) {
            var_dump(sqlsrv_errors());
            return false;
        } elseif (sqlsrv_num_rows($resultat) == 0) {
            return false;
        } else {
            while($row = sqlsrv_fetch_array($resultat, SQLSRV_FETCH_ASSOC)){
                $data[] = $row;
            }
            return $data;
        }        
    }

    public function getSession($num){
        $queryParams    = $data = array();
        $queryOptions   = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $query          = " SELECT 
                                'S' AS 'A'
                                ,[ligne] AS 'B'
                                ,CONVERT(NUMERIC(28,0),[qte]) AS 'C'
                                ,CONVERT(NUMERIC(28,0),[qty]) AS 'D'
                                ,[val_qte] AS 'E'
                                ,[reference] AS 'G'
                                ,[designation] AS 'H'      
                                ,[unite] AS 'I'
                                ,[coef] AS 'J'
                                ,[lot] AS 'K'
                                ,[emplacement] AS 'L'
                                ,[sta_st] AS 'M'
                                ,ISNULL([dlvdate],'') AS 'N'
                            FROM 
                               invSession invL
                            WHERE
                                nLigne = '".$num."'
                            ORDER BY
                                ligne ASC ";

        $resultat       = sqlsrv_query($this->link2, $query, $queryParams, $queryOptions);
        if ($resultat == FALSE) {
            var_dump(sqlsrv_errors());
            return false;
        } elseif (sqlsrv_num_rows($resultat) == 0) {
            return false;
        } else {
            while($row = sqlsrv_fetch_array($resultat, SQLSRV_FETCH_ASSOC)){
                if($row["B"]==0){
                    $row["B"] = "";
                }
                $data[] = $row;
            }
            return $data;
        }
        
    }

    public function getInvEmp($num){
        $queryParams    = array();
        $queryOptions   = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $query          = " SELECT 
                                TOP 1 emplacement
                            FROM 
                                invSession invL
                            WHERE
                                invL.site = '".$this->site."'
                                AND invL.nLigne = '".$num."' ";

        $resultat       = sqlsrv_query($this->link2, $query, $queryParams, $queryOptions);
        if ($resultat == FALSE) {
            var_dump(sqlsrv_errors());
            return false;
        } elseif (sqlsrv_num_rows($resultat) == 0) {
            return false;
        } else {
            $row  = sqlsrv_fetch_array($resultat, SQLSRV_FETCH_ASSOC);
            return $row['emplacement'];
        }
    }

    public function getArticleX3($num){
        $queryParams    = $data = array();
        $queryOptions   = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $query          = " SELECT * FROM [ZITMMASTER] WHERE ITMREF_0 = '".$num."' OR YBPSEAN_0 = '".$num."' ";
        $resultat       = sqlsrv_query($this->link, $query, $queryParams, $queryOptions);
        if ($resultat == FALSE) {
            var_dump(sqlsrv_errors());
            return false;
        } else {
            while($row = sqlsrv_fetch_array($resultat, SQLSRV_FETCH_ASSOC)){
                $data[] = $row;
            }
        }
        return $data;
    }

    public function traitementInv($num,$data){
        $msg = "";
        if (is_array($data) || is_object($data)) {
            foreach ($data as $key=>$qte) {
                $update = $insert = "";
                $exp = explode("&&&&&&",$key);
                $ln  = $exp[0];
                $ref = $exp[1];
                if(trim($ln) == ""){
                    $insert = $this->InsertLigneNouveau($num,$ref,$qte);
                    if($insert == $num)
                        $msg .= $ref.": Insertion effectuée avec succès!!";
                    else    
                        $msg .= $ref.": ".$insert;
                }
                else{
                    $update = $this->updateInv($num,$ref,$qte);
                    if($update == $num)
                        $msg .= $ref.": Mise à jour effectuée avec succès!!";
                    else    
                        $msg .= $ref.": ".$update;
                }
            }
        }
        return $msg;
    }

    public function addLigneInv($num,$ref,$qte){
        $donnee = $this->getArticleX3($ref);
        $emp    = $this->getInvEmp($num);
        $table  = '<tr id="session" class="table-success bold">';
            $table .= '<td></td>';
            $table .= '<td><input type ="number" value="'.$qte.'"></td>';
            $table .= '<td>'.$donnee[0]['YBPSEAN_0'].'</td>';
            $table .= '<td>'.$donnee[0]['ITMREF_0'].'</td>';
            $table .= '<td>'.$donnee[0]['ITMDES1_0'].'</td>';
            $table .= '<td>'.$donnee[0]['STU_0'].'</td>';
            $table .= '<td>XXX</td>';
            $table .= '<td>'.$emp.'</td>';
            $table .= '<td><a class="delete" aria-label="Supprimer" title="Supprimer"><i class="fa fa-trash-o supp" aria-hidden="true"></i></a></td>';
        $table .= '</tr>';
        return $table;
    }

    public function getDetailInv($num){
        $donnee = $this->getInv($num);
        $table  = "";
        if (is_array($donnee) || is_object($donnee)) {
            $table .= "<h3 class='text-titre'>Détail de l'inventaire</h3>";
            $table .= '<table class="table detail table-borderless">';
            $table .= '<tr class="bg-warning">';
                $table .= '<td>'.$donnee[0]['nEntete'].'</td>';
                $table .= '<td>'.$donnee[0]['site'].'</td>';
                $table .= '<td></td>';
                $table .= '<td></td>';
                $table .= '<td></td>';
                $table .= '<td></td>';
                $table .= '<td></td>';
                $table .= '<td></td>';
                $table .= '<td></td>';
            $table .= '</tr>';
            $table .= '<tr>';
                $table .= '<td><span class="jaune nLigne">'.$donnee[0]['nLigne'].'</span></td>';
                $table .= '<td><input id="recherche_" class="form-control" placeholder="Référence, Codebarre"></td>';
                $table .= '<td><input type="number" id="qte_" class="form-control"></td>';
                $table .= '<td><button type="button" class="btn btn-primary ajouter">Ajouter</button></td>';
                $table .= '<td></td>';
                $table .= '<td></td>';
                $table .= '<td></td>';
                $table .= '<td></td>';
                $table .= '<td></td>';
            $table .= '</tr>';
            foreach($donnee as $val){
                $table .= '<tr id="session">';
                    $table .= '<td>'.$val['ligne'].'</td>';
                    $table .= '<td><input type ="number" value="'.number_format($val['qte'], 0, '.', '').'"></td>';
                    $table .= '<td>'.$val['codebarre'].'</td>';
                    $table .= '<td>'.$val['reference'].'</td>';
                    $table .= '<td>'.$val['designation'].'</td>';
                    $table .= '<td>'.$val['unite'].'</td>';
                    $table .= '<td>'.$val['lot'].'</td>';
                    $table .= '<td>'.$val['emplacement'].'</td>';
                    $table .= '<td><a class="delete" aria-label="Supprimer" title="Supprimer"><i class="fa fa-trash-o supp" aria-hidden="true"></i></a></td>';
                $table .= '</tr>';
            }
            $table .= '</table>';
            $table .= '<button type="button" class="btn btn-primary valider">EXPORTER</button>';
        }
        return $table;
    }

    public function updateInv($nLigne,$ref,$qte){
        $val_qte = ($qte > 0) ? '1' : '2';
        $query = "UPDATE 
                    [dbo].[invSession] 
                    SET [qte] = '".$qte."',
                        [qty] = '".$qte."',
                        [val_qte] = '".$val_qte."',
                        [date_modification] = GETDATE()
                    WHERE
                        [nLigne] = '".$nLigne."'
                        AND [reference] = '".$ref."'; ";

        if(sqlsrv_query($this->link2, $query)) return $nLigne;
    }

    public function InsertEntete($nEntete,$nLigne,$nSite,$utilisateur){
        $query = "INSERT INTO [dbo].[invEntete]
                    ([nEntete]
                    ,[nLigne]
                    ,[site]
                    ,[utilisateur]
                    ,[statut])
                 VALUES 
                 ('".$nEntete."','".$nLigne."','".$nSite."','".$utilisateur."','0')";

        if(sqlsrv_query($this->link2, $query)) return $nEntete;
    }

    public function InsertLigne($nLigne,$nSite,$utilisateur,$array){
        $m   = $val = $cb = "";
        $end = end($array);
        if (is_array($array) || is_object($array)) {
            foreach ($array as $value) {
                $cb = $this->getArticleX3($value[5]);
                $val_qte = ($value[2] > 0) ? '1' : '2';
                if($value == $end){
                    $m = ";";
                }
                else{
                    $m = ",";
                }
                $val   .= "('".$nLigne."','".$nSite."','".$value[1]."','".$value[5]."','".$value[6]."','".$value[2]."','".$value[3]."','".$val_qte."','".$cb[0]["YBPSEAN_0"]."','".$value[7]."','".$value[9]."','".$value[10]."','".$value[11]."','".$value[8]."','".$utilisateur."','".$this->getUserIpAddr()."','0')".$m;
            }
        }

        $query = "INSERT INTO [dbo].[invSession]
                    ([nLigne]
                    ,[site]
                    ,[ligne]
                    ,[reference]
                    ,[designation]
                    ,[qte]
                    ,[qty]
                    ,[val_qte]
                    ,[codebarre]
                    ,[unite]
                    ,[lot]
                    ,[emplacement]
                    ,[sta_st]
                    ,[coef]
                    ,[utilisateur]
                    ,[ip_adresse]
                    ,[statut])
                 VALUES ".$val;

        if(sqlsrv_query($this->link2, $query)){
            return $nLigne;
        }
    }

    public function InsertLigneNouveau($nLigne,$ref,$qte){
        $donnee  = $this->getArticleX3($ref);
        $val     = "";
        $emp     = $this->getInvEmp($nLigne);
        $val_qte = ($qte > 0) ? '1' : '2';
        $val     .= "('".$nLigne."','".$this->site."','','".$ref."','".$donnee[0]["ITMDES1_0"]."','".$qte."','".$qte."','".$val_qte."','".$donnee[0]["YBPSEAN_0"]."','".$donnee[0]["STU_0"]."','XXX','".$emp."','A','1','".$this->user."','".$this->getUserIpAddr()."','0','31/12/2099');";

        $query = "INSERT INTO [dbo].[invSession]
                    ([nLigne]
                    ,[site]
                    ,[ligne]
                    ,[reference]
                    ,[designation]
                    ,[qte]
                    ,[qty]
                    ,[val_qte]
                    ,[codebarre]
                    ,[unite]
                    ,[lot]
                    ,[emplacement]
                    ,[sta_st]
                    ,[coef]
                    ,[utilisateur]
                    ,[ip_adresse]
                    ,[statut]
                    ,[dlvdate])
                 VALUES ".$val;

        if(sqlsrv_query($this->link2, $query)){
            return $nLigne;
        }
    }

    public function getUserIpAddr(){
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    public function csv_to_array($csv_file){
        if (($handle = fopen($csv_file, 'r')) !== false) {
            $arr    = array();
            while (($data = fgetcsv($handle, 1005)) !== false) {
                $line = array();
                foreach($data as $d){
                    $line = array_merge($line, str_getcsv($d, ';'));
                }
                $arr[] = $line;
            }
            fclose($handle);
            return $arr;
        }
    }

    public function upload_csv($file){
        $uploadFolder = "uploads/";
        $fileName     = basename($_FILES["file"]["name"]);
        $fileType     = pathinfo($_FILES["file"]["name"],PATHINFO_EXTENSION);
        $fileType     = strtolower($fileType);
        $allowTypes   = array('csv'); 
        $msg          = "";

        if(in_array($fileType,$allowTypes)){
            if(move_uploaded_file($_FILES["file"]["tmp_name"],$uploadFolder.$fileName)){
                $msg = "<div class='alert alert-success'><b>$fileName</b> Téléchargement réussi</div>";
            }else{
                $msg = "<div class='alert alert-danger'><b>$fileName</b> Échec du téléchargement. Essayer à nouveau.</div>";
            }
        }else{
            $msg = "<div class='alert alert-danger'>Échec du téléchargement. <b>$fileType</b> Fichier non autorisé.</div>";
        }
        return $msg;
        
    }
}
?>