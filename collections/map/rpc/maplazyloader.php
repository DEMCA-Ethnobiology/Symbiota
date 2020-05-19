<?php
include_once('../../../config/symbini.php');
include_once($SERVER_ROOT.'/classes/MapInterfaceManager.php');
include_once($SERVER_ROOT.'/classes/EthnoSearchManager.php');
include_once($SERVER_ROOT.'/classes/SOLRManager.php');

$stArrJson = $_REQUEST["starr"];
$occIndex = $_REQUEST['index'];
$recordCnt = $_REQUEST['reccnt'];
$mapType = $_REQUEST['maptype'];

$mapManager = new MapInterfaceManager();
$solrManager = new SOLRManager();

$retArr = Array();

$stArr = json_decode($stArrJson, true);

if($stArr || ($mapType && $mapType == 'occquery')){
    if(!$ETHNO_ACTIVE){
        if($stArr){
            $mapManager->setSearchTermsArr($stArr);
        }
        $mapWhere = $mapManager->getSqlWhere();
        if($SOLR_MODE){
            $solrManager->setSearchTermsArr($stArr);
            $collArr = $mapManager->getCollArr();
            $solrManager->setCollArr($collArr);
            $solrArr = $solrManager->getGeoArr($occIndex,1000);
            $retArr['recarr'] = $solrManager->translateSOLRGeoCollList($solrArr);
            $retArr['rectot'] = $solrManager->getRecordCnt();
        }
        else{
            $retArr['recarr'] = $mapManager->getCollGeoCoords($mapWhere,$occIndex,1000);
            $retArr['rectot'] = $recordCnt;
        }
    }
    else{
        $ethnoSearchManager = new EthnoSearchManager();
        if($stArr){
            $ethnoSearchManager->setSearchTermsArr($stArr);
        }
        $mapWhere = $ethnoSearchManager->getSqlWhere();
        $retArr['recarr'] = $ethnoSearchManager->getCollGeoCoords($mapWhere,$occIndex,1000);
        $retArr['rectot'] = $recordCnt;
    }
}

echo json_encode($retArr);
?>
