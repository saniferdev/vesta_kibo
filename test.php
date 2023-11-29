<?php
$soapClient = new SoapClient(
    "http://192.168.124.130:8124/soap-wsdl/syracuse/collaboration/syracuse/CAdxWebServiceXmlCC?wsdl",
    array(
        'login'    => 'admin',
        'password' => 'admin',
    )
);

$context 		= array('codeLang'=>'FRA', 'poolAlias'=>"POOLBAS",'poolId'=>'?','requestConfig'=>'');	
$publicName     = 'YCONSTOCK';
$inputXml       = '<PARAM>
                        <TAB ID="IN">
                            <LIN ID="IN" NUM="1">
                                <FLD NAM="YITMREF">01000058</FLD>
                            </LIN>
                        </TAB>
                    </PARAM>';

$inputXml  = preg_replace("/\n/", "", $inputXml);
$inputXml  = preg_replace("/>\s*</", "><", $inputXml);

$result    = $soapClient->__call("run",array($context,$publicName,$inputXml));

$status = (int)$result->status;



echo'<br>-----------------------<br>';
$xml        = simplexml_load_string($result->resultXml);

$article    = $xml->TAB[1];
foreach ($article as $val) {
	var_dump( $val->FLD);
}

?>