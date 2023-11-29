<?php

Class API{

    public $link;
    public $link2;
    public $site;

    public function getDetailArticle($recherche){
        $w = "";
        if(is_array($recherche)){
            $recherche  = implode("','",$recherche);
        }
        else{
            $w = "  OR UPPER(IM.ITMREF_0) LIKE '%".strtoupper($recherche)."%'
                    OR UPPER(IM.ITMDES1_0) LIKE '%".strtoupper($recherche)."%'
                    OR UPPER(IM.YBPSEAN_0) LIKE '%".strtoupper($recherche)."%'
                    OR UPPER(IB.BPSNUM_0) LIKE '%".strtoupper($recherche)."%'
                    OR UPPER(BPS.BPSNAM_0) LIKE '%".strtoupper($recherche)."%'
                    OR UPPER(IB.ITMREFBPS_0) LIKE '%".strtoupper($recherche)."%' ";
        }

        $queryParams    = $data = array();
        $queryOptions   = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $query          = " SELECT 
                                CASE WHEN 
                                    ZB.ITMREF_0 IS NOT NULL
                                    THEN 
                                        ZB.CPNITMREF_0 
                                    ELSE
                                        IM.ITMREF_0
                                    END AS REF
                                ,CASE WHEN 
                                    ZB.ITMREF_0 IS NOT NULL
                                    THEN 
                                        (SELECT ITMDES1_0 FROM [ZITMMASTER] WHERE ITMREF_0 = ZB.CPNITMREF_0 )
                                    ELSE
                                        IM.ITMDES1_0
                                    END AS DESS
                                ,IM.TSICOD_1 AS FAM
                                ,IM.TSICOD_2 AS FAM2
                                ,IM.TSICOD_3 AS FAM3
                                ,CASE WHEN 
                                    ZB.ITMREF_0 IS NOT NULL
                                    THEN 
                                        (SELECT ISNULL(YBPSEAN_0,'') FROM [ZITMMASTER] WHERE ITMREF_0 = ZB.CPNITMREF_0 )
                                    ELSE
                                        ISNULL(IM.YBPSEAN_0,'')
                                    END AS CB
                                ,ISNULL(IB.BPSNUM_0,'') AS FOURN
                                ,ISNULL(BPS.BPSNAM_0,'') AS FOURNN
                                ,CASE WHEN 
                                    ZB.ITMREF_0 IS NOT NULL
                                    THEN 
                                        (SELECT ISNULL(ITMREFBPS_0,'') FROM [ZITMBPS] WHERE ITMREF_0 = ZB.CPNITMREF_0 AND DEFBPSFLG_0 = 2)
                                    ELSE
                                        ISNULL(IB.ITMREFBPS_0,'')
                                    END AS REF_F
                                ,SP.PRI_0 AS PV_TTC
                                ,ISNULL(IM.STU_0,'') AS UN
                                ,CONVERT(VARCHAR, ZL.SHLDAT_0, 103) AS DAT_P
                                ,ISNULL(ZL.LOT_0,'') AS LOT
                                ,ISNULL(ZST.QTYSTU_0,0) * CASE WHEN 
                                                            ZB.ITMREF_0 IS NOT NULL
                                                            THEN 
                                                                ZB.LIKQTY_0
                                                            ELSE
                                                                1
                                                            END AS QTE
                                ,ISNULL(ZST.LOC_0,'') AS EMPL
                                ,ISNULL(ZST.LOCTYP_0,'') AS EMPL_T
                                
                            FROM 
                                [ZITMMASTER] IM
                                INNER JOIN ZSOUSFAMILLE ZF ON ZF.SOUSFAM = IM.TSICOD_1
                                LEFT JOIN [ZITMBPS] IB ON IB.ITMREF_0 = IM.ITMREF_0 AND IB.DEFBPSFLG_0 = 2
                                LEFT JOIN [ZBPSUPPLIER] BPS ON BPS.BPSNUM_0 = IB.BPSNUM_0
                                LEFT JOIN [ZSPRICLIST] SP ON SP.PLICRI1_0 = IM.ITMREF_0 AND SP.PLI_0 = 'TGEN'
                                LEFT JOIN [ZBOMD] ZB ON ZB.ITMREF_0 = IM.ITMREF_0
                                LEFT JOIN [ZSTOLOT] ZL ON ZL.ITMREF_0 = IM.ITMREF_0
                                INNER JOIN [ZSTOCK] ZST ON ZST.ITMREF_0 = ZL.ITMREF_0 AND ZL.LOT_0 = ZST.LOT_0 AND ZST.QTYSTU_0 > 0 AND ZST.STOFCY_0 = '".$this->site."'

                            WHERE
                                ZF.FAM IN ('50', '51', '52','60','61','62','63','64','65')
                                AND ( 
                                        IM.ITMREF_0 IN ('".$recherche."')
                                        ".$w."
                                    ) 
                            GROUP BY 
                                ZB.ITMREF_0
                                ,ZB.CPNITMREF_0
                                ,IM.ITMREF_0
                                ,IM.ITMDES1_0
                                ,IM.TSICOD_1
                                ,IM.TSICOD_2
                                ,IM.TSICOD_3
                                ,IM.YBPSEAN_0
                                ,IB.BPSNUM_0
                                ,BPS.BPSNAM_0
                                ,IB.ITMREFBPS_0
                                ,SP.PRI_0
                                ,IM.STU_0
                                ,ZL.SHLDAT_0
                                ,ZL.LOT_0
                                ,ZST.QTYSTU_0
                                ,ZST.LOC_0
                                ,ZST.LOCTYP_0
                                ,ZB.LIKQTY_0
                            ORDER BY
                                ZST.LOCTYP_0";
        //echo $query;

        $resultat       = sqlsrv_query($this->link, $query, $queryParams, $queryOptions);
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

    public function getSortie($d,$f){
        $queryParams    = $data = array();
        $queryOptions   = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $query          = " SELECT 
                                * 
                            FROM 
                                [x3v12prod].dbo.ZSORTIE_CASSE
                                --[x3v12prod].dbo.ZSORTIECASSE_BAS

                            WHERE
                                CAST(DATES AS DATE) BETWEEN '".$d."' AND '".$f."'
                           
                            ORDER BY 
                              DATES
                              ,NUM";

        $resultat       = sqlsrv_query($this->link, $query, $queryParams, $queryOptions);
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

    public function getNomenclatureArticle($recherche){
        $queryParams    = $data = array();
        $queryOptions   = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $query          = " SELECT ITMREF_0 FROM [ZBOMD] WHERE ITMREF_0 = '".$recherche."' ";

        $resultat       = sqlsrv_query($this->link, $query, $queryParams, $queryOptions);
        if ($resultat == FALSE) {
            var_dump(sqlsrv_errors());
            return false;
        } elseif (sqlsrv_num_rows($resultat) == 0) {
            return 0;
        } else {
            return 1;
        }
    }

    public function preg_replace_($xml){
        $xml = preg_replace("/\n/", "", $xml);
        $xml = preg_replace("/>\s*</", "><", $xml);
        return $xml;
    }

    public function soap_API($ref,$emp,$lot,$qte,$date){
        $soapClient = new SoapClient(
            $this->url_soap,
            array(
                'trace'    => true,
                'login'    => $this->login,
                'password' => $this->password,
            )
        );
        $m          = "";
        $context    = array('codeLang'=>$this->codeLang, 'poolAlias'=>$this->poolAlias,'poolId'=>'','requestConfig'=>'adxwss.trace.on=on&adxwss.trace.size=16384&adonix.trace.on=on&adonix.trace.level=3&adonix.trace.size=8');

        $inputXml   = $this->ligne($ref,$emp,$lot,$qte,$date);

        $result     = $soapClient->__call("run",array($context,'YWSMAJSTO',$inputXml));
        $xml        = simplexml_load_string($result->resultXml);

        $message    = $xml->GRP[1];

        foreach ($message as $val) {
            $m = $val;
        }

        return $m;
    }


    public function xml2array($fname){
      $sxi      = new SimpleXmlIterator($fname);
      return $this->sxiToArray($sxi);
    }

    public function sxiToArray($sxi){
      $a = array();
      for( $sxi->rewind(); $sxi->valid(); $sxi->next() ) {
        if(!array_key_exists($sxi->key(), $a)){
          $a[$sxi->key()]   = array();
        }
        if($sxi->hasChildren()){
          $a[$sxi->key()][] = $this->sxiToArray($sxi->current());
        }
        else{
          $a[$sxi->key()][] = strval($sxi->current());
        }
      }
      return $a;
    }

    public function ligne($ref,$emp,$lot,$qte,$date){
        $xml    =   '<PARAM>
                        <GRP ID="IN">
                            <FLD NAM="YITMREF">'.$ref.'</FLD>
                        </GRP>
                        <GRP ID="IN">
                            <FLD NAM="YFCY">'.$this->site.'</FLD>
                        </GRP>
                        <GRP ID="IN">
                            <FLD NAM="YLOC">'.$emp.'</FLD>
                        </GRP>
                        <GRP ID="IN">
                            <FLD NAM="YLOT">'.$lot.'</FLD>
                        </GRP>
                        <GRP ID="IN">
                            <FLD NAM="YQTY">'.$qte.'</FLD>
                        </GRP>
                        <GRP ID="IN">
                            <FLD NAM="YDATPER">'.$date.'</FLD>
                        </GRP>
                    </PARAM>';
        $xml    = $this->preg_replace_($xml);
        return $xml;
    }

    public function soap_API2($array){
        $soapClient = new SoapClient(
            $this->url_soap,
            array(
                'trace'    => true,
                'login'    => $this->login,
                'password' => $this->password,
            )
        );
        $m = $ligne = "";
        $i = 1;
        if (is_array($array) || is_object($array)) {
            foreach ($array as $key=>$value) {
                $exp   = explode('-----',$value);
                $emp   = explode(' - ',$exp[0]);
                $ref   = $key;
                $lot   = $exp[1];
                $qte   = $exp[2];
                $ligne .= $this->ligne_sortie($ref,$emp[0],$lot,$qte,$i);
                $i++;
            }
        }
        
        $inputXml      = '<PARAM>
                            <GRP ID="IN">
                                <FLD NAM="YSTOFCY">'.$this->site.'</FLD>
                                <FLD NAM="YCODEFAM">'.$this->codeFamille.'</FLD>
                            </GRP>
                            <TAB ID="IND">
                                '.$ligne.'
                            </TAB>
                        </PARAM>';
        $inputXml      = $this->preg_replace_($inputXml);

        $context    = array('codeLang'=>$this->codeLang, 'poolAlias'=>$this->poolAlias,'poolId'=>'','requestConfig'=>'adxwss.trace.on=on&adxwss.trace.size=16384&adonix.trace.on=on&adonix.trace.level=3&adonix.trace.size=8');

        $result     = $soapClient->__call("run",array($context,'YGENSOR',$inputXml));
        $xml        = simplexml_load_string($result->resultXml);

        $message    = $xml->GRP[1];

        foreach ($message as $val) {
            $m = $val;
        }

        return $m;
    }

    public function ligne_sortie($ref,$emp,$lot,$qte,$i){
        $xml    =   '<LIN ID="IND" NUM="'.$i.'">
                        <FLD NAM="YITMREF">'.$ref.'</FLD>
                        <FLD NAM="YQTY">'.$qte.'</FLD>
                        <FLD NAM="YEMP">'.$emp.'</FLD>
                        <FLD NAM="YLOT">'.$lot.'</FLD>
                    </LIN>';
        $xml    = $this->preg_replace_($xml);
        return $xml;
    }

    public function InsertSortie($n){
        $return = 0;
        $query  = "INSERT INTO [dbo].[historique_mvt_sortie] ([num]) VALUES ('".$n."')";
        if(sqlsrv_query($this->link2, $query)){
            $return = 1;
        }
        return $return;
    }

    public function getDesignation($num){
        $queryParams    = $data = array();
        $queryOptions   = array("Scrollable" => SQLSRV_CURSOR_KEYSET);
        $query          = " SELECT ITMDES1_0 AS DESS FROM [ZITMMASTER] WHERE ITMREF_0 = '".$num."' ";

        $resultat       = sqlsrv_query($this->link, $query, $queryParams, $queryOptions);
        if ($resultat == FALSE) {
            var_dump(sqlsrv_errors());
            return false;
        } else {
            $row = sqlsrv_fetch_array($resultat, SQLSRV_FETCH_ASSOC);
            return $row["DESS"];
        }
    }

    public function ligne_($array){
        $msg = "";
        if (is_array($array) || is_object($array)) {
            foreach ($array as $key=>$value) {
                $exp   = explode('-----',$value);
                $emp   = explode(' - ',$exp[0]);
                $ref   = $key;
                $lot   = $exp[1];
                $qte   = $exp[2];
                $dess  = $this->getDesignation($ref);
                $msg   .= '<strong>Réference :</strong> '.$ref.' - '.$dess.' ---> <strong>Quantité:</strong> '.$qte.'<br>';
            }
        }
        return $msg;
    }

    public function mail($e,$l){
        $sujet   = "Mouvement de sortie KIBO";
        $objet   = "Bonjour,<br><br>";
        $objet  .= "Un mouvement de sortie a été crée dans sage X3.<br>";
        $objet  .= "Ci-après les details du document:<br><br>";
        $objet  .= "<strong>N° :</strong>".$e."<br>";
        $objet  .= $l."<br><br>";
        $objet  .= "<strong>Cordialement</strong><br>
                    <strong>Winny Tsiorintsoa RAZAFINDRAKOTO</strong><br>
                    <strong>DEVELOPPEUR</strong><br>
                    Lot II I 20 AA Morarano<br>
                    Antananarivo – MADAGASCAR<br>
                    Tél. : +261 34 07 635 84<br>
                    Tél. : +261 20 22 530 81<br>
                    Fax : +261 20 22 530 80<br>
                    Mail : winny.devinfo@talys.mg<br>
                    Site : www.kibo.mg<br>";
        
        envoiMail($sujet,$objet);
    }


}
?>