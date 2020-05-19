<?php
include_once('../config/symbini.php');
include_once($SERVER_ROOT.'/content/lang/collections/list.'.$LANG_TAG.'.php');
include_once($SERVER_ROOT.'/classes/OccurrenceListManager.php');
include_once($SERVER_ROOT.'/classes/EthnoDataManager.php');
include_once($SERVER_ROOT.'/classes/EthnoSearchManager.php');
header("Content-Type: text/html; charset=".$CHARSET);

$tabIndex = array_key_exists("tabindex",$_REQUEST)?$_REQUEST["tabindex"]:1;
$taxonFilter = array_key_exists("taxonfilter",$_REQUEST)?$_REQUEST["taxonfilter"]:0;
$targetTid = array_key_exists("targettid",$_REQUEST)?$_REQUEST["targettid"]:0;
$cntPerPage = array_key_exists("cntperpage",$_REQUEST)?$_REQUEST["cntperpage"]:100;
$pageNumber = array_key_exists("page",$_REQUEST)?$_REQUEST["page"]:1;

//Sanitation
if(!is_numeric($taxonFilter)) $taxonFilter = 1;
if(!is_numeric($cntPerPage)) $cntPerPage = 100;

$collManager = new OccurrenceListManager();
$ethnoDataManager = new EthnoDataManager();
$ethnoSearchManager = new EthnoSearchManager();
$stArr = Array();
$collArr = Array();
$stArrSearchJson = '';
$stArrCollJson = '';
$resetPageNum = false;

if(isset($_REQUEST['taxa']) || isset($_REQUEST['country']) || isset($_REQUEST['state']) || isset($_REQUEST['county']) ||
    isset($_REQUEST['local']) || isset($_REQUEST['elevlow']) || isset($_REQUEST['elevhigh']) || isset($_REQUEST['upperlat']) ||
    isset($_REQUEST['pointlat']) || isset($_REQUEST['collector']) || isset($_REQUEST['collnum']) || isset($_REQUEST['eventdate1']) ||
    isset($_REQUEST['eventdate2']) || isset($_REQUEST['catnum']) || isset($_REQUEST['typestatus']) || isset($_REQUEST['hasimages']) ||
    isset($_REQUEST['semantics']) || isset($_REQUEST['verbatimVernacularName']) || isset($_REQUEST['annotatedVernacularName']) || isset($_REQUEST['verbatimLanguage']) ||
    isset($_REQUEST['languageid']) || isset($_REQUEST['otherVerbatimVernacularName']) || isset($_REQUEST['otherLangId']) || isset($_REQUEST['verbatimParse']) ||
    isset($_REQUEST['annotatedParse']) || isset($_REQUEST['verbatimGloss']) || isset($_REQUEST['annotatedGloss']) || isset($_REQUEST['freetranslation']) ||
    isset($_REQUEST['taxonomicDescription']) || isset($_REQUEST['typology']) || isset($_REQUEST['parts']) || isset($_REQUEST['uses']) ||
    isset($_REQUEST['consultantComments'])){
    if(!$ETHNO_ACTIVE){
        $stArr = $collManager->getSearchTerms();
    }
    else{
        $stArr = $ethnoSearchManager->getSearchTermsArr();
        $ethnoDataArr = $ethnoSearchManager->getEthnoDataArr();
    }
    $stArrSearchJson = json_encode($stArr);
    if(!isset($_REQUEST['page']) || !$_REQUEST['page']) {
        $resetPageNum = true;
    }
}

if(isset($_REQUEST['db'])){
    $reqDBStrStr = str_replace("(","",$_REQUEST['db']);
    $reqDBStrStr = str_replace(")","",$reqDBStrStr);
    if(preg_match('/^[0-9,;]+$/', $reqDBStrStr) || $reqDBStrStr == 'all'){
        $collArr['db'] = $reqDBStrStr;
        $stArrCollJson = json_encode($collArr);
        if(!isset($_REQUEST['page']) || !$_REQUEST['page']) $resetPageNum = true;
    }
    if(!isset($_REQUEST['page']) || !$_REQUEST['page']) $resetPageNum = true;
}
if($ETHNO_ACTIVE){
    $langArr = $ethnoDataManager->getLangNameSearchDropDownList();
    $ethnoPersonnelArr = $ethnoDataManager->getSearchPersonnelArr();
    $ethnoNameSemanticTagArr = $ethnoDataManager->getNameSemanticTagArr();
    $ethnoUsePartsUsedTagArr = $ethnoDataManager->getPartsUsedTagArrFull();
    $ethnoUseUseTagArr = $ethnoSearchManager->getUseTagArrFull();
}
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $CHARSET;?>">
	<title><?php echo $DEFAULT_TITLE.' '.$LANG['PAGE_TITLE']; ?></title>
	<link href="../css/base.css?ver=<?php echo $CSS_VERSION; ?>" type="text/css" rel="stylesheet" />
	<link href="../css/main.css<?php echo (isset($CSS_VERSION_LOCAL)?'?ver='.$CSS_VERSION_LOCAL:''); ?>" type="text/css" rel="stylesheet" />
	<link type="text/css" href="../css/jquery-ui.css" rel="Stylesheet" />
	<style type="text/css">
		.ui-tabs .ui-tabs-nav li a { margin-left:10px;}
	</style>
	<script type="text/javascript" src="../js/jquery.js?ver=20130917"></script>
	<script type="text/javascript" src="../js/jquery-ui.js?ver=20130917"></script>
    <script type="text/javascript" src="../js/symb/collections.search.js"></script>
    <script type="text/javascript">
		<?php include_once($SERVER_ROOT.'/config/googleanalytics.php'); ?>
	</script>
	<script type="text/javascript">
        var starrJson = '';
        var collJson = '';
        var listPage = <?php echo $pageNumber; ?>;

        $(document).ready(function() {
            <?php
            if($stArrSearchJson){
                ?>
                starrJson = '<?php echo $stArrSearchJson; ?>';
                sessionStorage.jsonstarr = starrJson;
                <?php
            }
            else{
                ?>
                if(sessionStorage.jsonstarr){
                    starrJson = sessionStorage.jsonstarr;
                }
                <?php
            }
            ?>

            <?php
            if($stArrCollJson){
                ?>
                collJson = '<?php echo $stArrCollJson; ?>';
                sessionStorage.jsoncollstarr = collJson;
                <?php
            }
            else{
                ?>
                if(sessionStorage.jsoncollstarr){
                    collJson = sessionStorage.jsoncollstarr;
                }
                <?php
            }
            ?>

            <?php
            if(!$resetPageNum){
                ?>
                if(sessionStorage.collSearchPage){
                    listPage = sessionStorage.collSearchPage;
                }
                else{
                    sessionStorage.collSearchPage = listPage;
                }
                <?php
            }
            else{
                echo "sessionStorage.collSearchPage = listPage;\n";
            }
            ?>

            document.getElementById("taxatablink").href = 'checklist.php?starr='+starrJson+'&jsoncollstarr='+collJson+'&taxonfilter=<?php echo $taxonFilter; ?>';
            document.getElementById("mapdllink").href = 'download/index.php?starr='+starrJson+'&jsoncollstarr='+collJson+'&dltype=georef';
            document.getElementById("kmldlcolljson").value = collJson;
            document.getElementById("kmldlstjson").value = starrJson;

            setOccurrenceList(listPage);
            $('#tabs').tabs({
                active: <?php echo $tabIndex; ?>,
                beforeLoad: function( event, ui ) {
                    $(ui.panel).html("<p>Loading...</p>");
                }
            });
        });

        function setOccurrenceList(listPage){
            sessionStorage.collSearchPage = listPage;
            document.getElementById("queryrecords").innerHTML = "<p>Loading... <img src='../images/workingcircle.gif' width='15px' /></p>";
            <?php
			//echo "console.log('rpc/getoccurrencelist.php?starr='+starrJson+'&jsoncollstarr='+collJson+'&page='+listPage+'&targettid=".$targetTid."');";
            ?>
            $.ajax({
                type: "POST",
                url: "rpc/getoccurrencelist.php",
                data: {
                    starr: starrJson,
                    jsoncollstarr: collJson,
                    targettid: <?php echo $targetTid; ?>,
                    page: listPage
                },
                dataType: "html"
            }).done(function(msg) {
                if(!msg) msg = "<p>An error occurred retrieving records.</p>";
                document.getElementById("queryrecords").innerHTML = msg;
            });
        }

		function addAllVouchersToCl(clidIn){
			var occJson = document.getElementById("specoccjson").value;

			$.ajax({
				type: "POST",
				url: "rpc/addallvouchers.php",
				data: { clid: clidIn, jsonOccArr: occJson, tid: <?php echo ($targetTid?$targetTid:'0'); ?> }
			}).done(function( msg ) {
				if(msg == "1"){
					alert("Success! All vouchers added to checklist.");
				}
				else{
					alert(msg);
				}
			});
		}

        function copySearchUrl(){
            var urlPrefix = document.getElementById('urlPrefixBox').value;
            var urlFixed = urlPrefix+'&page='+sessionStorage.collSearchPage;
            var copyBox = document.getElementById('urlFullBox');
            copyBox.value = urlFixed;
            copyBox.focus();
            copyBox.setSelectionRange(0,copyBox.value.length);
            document.execCommand("copy");
            copyBox.value = '';
        }
    </script>
</head>
<body>
<?php
	$displayLeftMenu = (isset($collections_listMenu)?$collections_listMenu:false);
	include($SERVER_ROOT.'/header.php');
	if(isset($collections_listCrumbs)){
		if($collections_listCrumbs){
			echo '<div class="navpath">';
			echo $collections_listCrumbs.' &gt;&gt; ';
			echo ' <b>'.$LANG['NAV_SPECIMEN_LIST'].'</b>';
			echo '</div>';
		}
	}
	else{
		echo '<div class="navpath">';
		echo '<a href="../index.php">'.$LANG['NAV_HOME'].'</a> &gt;&gt; ';
		echo '<a href="index.php">'.$LANG['NAV_COLLECTIONS'].'</a> &gt;&gt; ';
		echo '<a href="harvestparams.php">'.$LANG['NAV_SEARCH'].'</a> &gt;&gt; ';
		echo '<b>'.$LANG['NAV_SPECIMEN_LIST'].'</b>';
		echo '</div>';
	}
	?>
<!-- This is inner text! -->
<div id="innertext">
	<div id="tabs" style="width:95%;">
		<ul>
			<li>
				<a id='taxatablink' href=''>
					<span><?php echo $LANG['TAB_CHECKLIST']; ?></span>
				</a>
			</li>
			<li>
				<a href="#speclist">
					<span><?php echo $LANG['TAB_OCCURRENCES']; ?></span>
				</a>
			</li>
            <?php
            if($ETHNO_ACTIVE){
                ?>
                <li>
                    <a href="#ethnolist">
                        <span>Ethnobiological Records</span>
                    </a>
                </li>
                <?php
            }
            ?>
			<li>
				<a href="#maps">
					<span><?php echo $LANG['TAB_MAP']; ?></span>
				</a>
			</li>
		</ul>
		<div id="speclist">
            <div id="queryrecords"></div>
		</div>
        <?php
        if($ETHNO_ACTIVE){
            ?>
            <div id="ethnolist">
                <?php
                if($ethnoDataArr){
                    ?>
                    <div id="ethnodatatab" class="<?php echo ($styleClass==='species'?'sptab':'spptab'); ?>">
                        <?php
                        $prevCollid = 0;
                        foreach($ethnoDataArr as $dataId => $dataArr){
                            $dataPersonelStr = '';
                            $dataSemanticsStr = '';
                            $dataTypologyStr = '';
                            $dataUseStr = '';
                            $dataPartsStr = '';
                            $dataPersonelArr = $dataArr["personnelArr"];
                            $dataSemanticsArr = $dataArr["semanticTags"];
                            $dataUseArr = $dataArr["useTags"];
                            $dataPartsArr = $dataArr["partsTags"];
                            foreach($ethnoPersonnelArr as $id => $pArr){
                                if(in_array($id,$dataPersonelArr)){
                                    $dataPersonelStr .= $pArr['title'].' '.$pArr['firstname'].' '.$pArr['lastname'].'; ';
                                }
                            }
                            if($dataPersonelStr) $dataPersonelStr = substr($dataPersonelStr,0,-2);
                            foreach($ethnoNameSemanticTagArr as $id => $stArr){
                                if(in_array($id,$dataSemanticsArr)){
                                    $dataSemanticsStr .= $stArr['ptag'].'; ';
                                }
                                unset($stArr['ptag']);
                                unset($stArr['pdesc']);
                                if($stArr){
                                    foreach($stArr as $cid => $cArr){
                                        if(in_array($cid,$dataSemanticsArr)){
                                            $dataSemanticsStr .= $cArr['ctag'].'; ';
                                        }
                                    }
                                }
                            }
                            if($dataSemanticsStr) $dataSemanticsStr = substr($dataSemanticsStr,0,-2);
                            foreach($ethnoUsePartsUsedTagArr as $id => $text){
                                if(in_array($id,$dataPartsArr)){
                                    $dataPartsStr .= $text.'; ';
                                }
                            }
                            if($dataPartsStr) $dataPartsStr = substr($dataPartsStr,0,-2);
                            foreach($ethnoUseUseTagArr as $tid => $tidUArr){
                                foreach($tidUArr as $id => $uArr){
                                    $tempStr = '';
                                    $header = $uArr['header'];
                                    unset($uArr['header']);
                                    foreach($uArr as $uid => $text){
                                        if(in_array($uid,$dataUseArr)){
                                            if(!$tempStr) $tempStr = '<b>'.$header.':</b> ';
                                            $tempStr .= $text.'; ';
                                        }
                                    }
                                    if($tempStr) $dataUseStr .= $tempStr;
                                }
                            }
                            if($dataUseStr) $dataUseStr = substr($dataUseStr,0,-2);
                            if($dataArr["typology"]==='opaque') $dataTypologyStr = 'Opaque';
                            elseif($dataArr["typology"]==='transparent') $dataTypologyStr = 'Transparent';
                            elseif($dataArr["typology"]==='modifiedopaque') $dataTypologyStr = 'Modified opaque';
                            elseif($dataArr["typology"]==='modifiedtransparent') $dataTypologyStr = 'Modified transparent';
                            $collId = $dataArr["collid"];
                            if($collId != $prevCollid){
                                $prevCollid = $collId;
                                $isEditor = false;
                                if($SYMB_UID && ($IS_ADMIN || (array_key_exists('CollAdmin',$USER_RIGHTS) && in_array($collId,$USER_RIGHTS['CollAdmin'])) || (array_key_exists('CollEditor',$USER_RIGHTS) && in_array($collId,$USER_RIGHTS['CollEditor'])))){
                                    $isEditor = true;
                                }
                                $instCode = $dataArr["institutioncode"];
                                if($dataArr["collectioncode"]) $instCode .= ":".$dataArr["collectioncode"];
                                echo '<h2>';
                                echo '<a href="misc/collprofiles.php?collid='.$collId.'">'.$dataArr["collectionname"].'</a>';
                                echo '</h2><hr />';
                            }
                            ?>
                            <div style="margin-top:10px">
                                <?php
                                if($dataArr["sciname"]){
                                    ?>
                                    <div style="font-size:13px;">
                                        <b>Scientific name:</b>
                                        <?php echo $dataArr["sciname"]; ?>
                                    </div>
                                    <?php
                                }
                                if($dataArr["reftitle"]){
                                    ?>
                                    <div style="font-size:13px;">
                                        <b>Reference title:</b>
                                        <?php echo $dataArr["reftitle"]; ?>
                                    </div>
                                    <?php
                                }
                                if($dataArr["refpages"]){
                                    ?>
                                    <div style="font-size:13px;">
                                        <b>Reference pages:</b>
                                        <?php echo $dataArr["refpages"]; ?>
                                    </div>
                                    <?php
                                }
                                if($dataArr["dataeventstr"]){
                                    ?>
                                    <div style="font-size:13px;">
                                        <b>Elicitation event:</b>
                                        <?php echo $dataArr["dataeventstr"]; ?>
                                    </div>
                                    <?php
                                }
                                if($dataPersonelStr){
                                    ?>
                                    <div style="font-size:13px;">
                                        <b>Consultants:</b>
                                        <?php echo $dataPersonelStr; ?>
                                    </div>
                                    <?php
                                }
                                if($dataArr["verbatimVernacularName"]){
                                    ?>
                                    <div style="font-size:13px;">
                                        <b>Verbatim vernacular name:</b>
                                        <?php echo $dataArr["verbatimVernacularName"]; ?>
                                    </div>
                                    <?php
                                }
                                if($dataArr["annotatedVernacularName"]){
                                    ?>
                                    <div style="font-size:13px;">
                                        <b>Annotated vernacular name:</b>
                                        <?php echo $dataArr["annotatedVernacularName"]; ?>
                                    </div>
                                    <?php
                                }
                                if($dataSemanticsStr){
                                    ?>
                                    <div style="font-size:13px;">
                                        <b>Semantic tags:</b>
                                        <?php echo $dataSemanticsStr; ?>
                                    </div>
                                    <?php
                                }
                                if($dataArr["verbatimLanguage"]){
                                    ?>
                                    <div style="font-size:13px;">
                                        <b>Verbatim language:</b>
                                        <?php echo $dataArr["verbatimLanguage"]; ?>
                                    </div>
                                    <?php
                                }
                                if($dataArr["langName"]){
                                    ?>
                                    <div style="font-size:13px;">
                                        <b>Glottolog language:</b>
                                        <?php echo $dataArr["langName"]; ?>
                                    </div>
                                    <?php
                                }
                                if($dataArr["otherVerbatimVernacularName"]){
                                    ?>
                                    <div style="font-size:13px;">
                                        <b>Other verbatim vernacular name:</b>
                                        <?php echo $dataArr["otherVerbatimVernacularName"]; ?>
                                    </div>
                                    <?php
                                }
                                if($dataArr["otherLangName"]){
                                    ?>
                                    <div style="font-size:13px;">
                                        <b>Other verbatim vernacular name Glottolog language:</b>
                                        <?php echo $dataArr["otherLangName"]; ?>
                                    </div>
                                    <?php
                                }
                                if($dataArr["verbatimParse"]){
                                    ?>
                                    <div style="font-size:13px;">
                                        <b>Verbatim parse:</b>
                                        <?php echo $dataArr["verbatimParse"]; ?>
                                    </div>
                                    <?php
                                }
                                if($dataArr["annotatedParse"]){
                                    ?>
                                    <div style="font-size:13px;">
                                        <b>Annotated parse:</b>
                                        <?php echo $dataArr["annotatedParse"]; ?>
                                    </div>
                                    <?php
                                }
                                if($dataArr["verbatimGloss"]){
                                    ?>
                                    <div style="font-size:13px;">
                                        <b>Verbatim gloss:</b>
                                        <?php echo $dataArr["verbatimGloss"]; ?>
                                    </div>
                                    <?php
                                }
                                if($dataArr["annotatedGloss"]){
                                    ?>
                                    <div style="font-size:13px;">
                                        <b>Annotated gloss:</b>
                                        <?php echo $dataArr["annotatedGloss"]; ?>
                                    </div>
                                    <?php
                                }
                                if($dataTypologyStr){
                                    ?>
                                    <div style="font-size:13px;">
                                        <b>Typology:</b>
                                        <?php echo $dataTypologyStr; ?>
                                    </div>
                                    <?php
                                }
                                if($dataArr["translation"]){
                                    ?>
                                    <div style="font-size:13px;">
                                        <b>Translation:</b>
                                        <?php echo $dataArr["translation"]; ?>
                                    </div>
                                    <?php
                                }
                                if($dataArr["taxonomicDescription"]){
                                    ?>
                                    <div style="font-size:13px;">
                                        <b>Taxonomic description:</b>
                                        <?php echo $dataArr["taxonomicDescription"]; ?>
                                    </div>
                                    <?php
                                }
                                if($dataArr["nameDiscussion"]){
                                    ?>
                                    <div style="font-size:13px;">
                                        <b>Consultant comments on name:</b>
                                        <?php echo $dataArr["nameDiscussion"]; ?>
                                    </div>
                                    <?php
                                }
                                if($dataPartsStr){
                                    ?>
                                    <div style="font-size:13px;">
                                        <b>Parts used:</b>
                                        <?php echo $dataPartsStr; ?>
                                    </div>
                                    <?php
                                }
                                if($dataUseStr){
                                    ?>
                                    <div style="font-size:13px;">
                                        <b>Uses:</b>
                                        <?php echo $dataUseStr; ?>
                                    </div>
                                    <?php
                                }
                                if($dataArr["consultantComments"]){
                                    ?>
                                    <div style="font-size:13px;">
                                        <b>Consultant comments:</b>
                                        <?php echo $dataArr["consultantComments"]; ?>
                                    </div>
                                    <?php
                                }
                                if($dataArr["useDiscussion"]){
                                    ?>
                                    <div style="font-size:13px;">
                                        <b>Consultant comments on use:</b>
                                        <?php echo $dataArr["useDiscussion"]; ?>
                                    </div>
                                    <?php
                                }
                                if($isEditor){
                                    ?>
                                    <div style="margin-top:8px;">
                                        <a href="../ethno/manager/dataeditor.php?collid=<?php echo $collId; ?>&eventid=<?php echo $dataArr["etheventid"]; ?>&dataid=<?php echo $dataId; ?>">Edit this record</a>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                            <hr/>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
                else{
                    echo '<div><h3>Your query did not return any results.</h3></div>';
                }
            ?>
            </div>
            <?php
        }
        ?>
		<div id="maps" style="min-height:400px;margin-bottom:10px;">
			<div class="button" style="margin-top:20px;float:right;width:13px;height:13px;" title="<?php echo $LANG['MAP_DOWNLOAD']; ?>">
				<a id='mapdllink' href=''><img src="../images/dl.png"/></a>
			</div>
			<div style='margin-top:10px;'>
				<h2><?php echo $LANG['GOOGLE_MAP_HEADER']; ?></h2>
			</div>
			<div style='margin:10 0 0 20;'>
				<a href="#" onclick="openMapPU();" >
					<?php echo $LANG['GOOGLE_MAP_DISPLAY']; ?>
				</a>
			</div>
			<div style='margin:10 0 0 20;'>
				<?php echo $LANG['GOOGLE_MAP_DESCRIPTION'];?>
			</div>

			<div style='margin-top:10px;'>
				<h2><?php echo $LANG['GOOGLE_EARTH_HEADER']; ?></h2>
			</div>
			<form name="kmlform" action="../map/googlekml.php" method="post" onsubmit="">
				<div style='margin:10 0 0 20;'>
					<?php echo $LANG['GOOGLE_EARTH_DESCRIPTION'];?>
				</div>
				<div style="margin:20px;">
					<input name="jsoncollstarr" id="kmldlcolljson" type="hidden" value='' />
					<input name="starr" id="kmldlstjson" type="hidden" value='' />
					<button name="formsubmit" type="submit" value="<?php echo $LANG['CREATE_KML']; ?>"><?php echo $LANG['CREATE_KML']; ?></button>
				</div>
				<div style='margin:10 0 0 20;'>
					<a href="#" onclick="toggleFieldBox('fieldBox');">
						<?php echo $LANG['GOOGLE_EARTH_EXTRA']; ?>
					</a>
				</div>
				<div id="fieldBox" style="display:none;">
					<fieldset>
						<div style="width:600px;">
							<?php
							$occFieldArr = Array('occurrenceid','family', 'scientificname', 'sciname',
								'tidinterpreted', 'scientificnameauthorship', 'identifiedby', 'dateidentified', 'identificationreferences',
								'identificationremarks', 'taxonremarks', 'identificationqualifier', 'typestatus', 'recordedby', 'recordnumber',
								'associatedcollectors', 'eventdate', 'year', 'month', 'day', 'startdayofyear', 'enddayofyear',
								'verbatimeventdate', 'habitat', 'substrate', 'fieldnumber','occurrenceremarks', 'associatedtaxa', 'verbatimattributes',
								'dynamicproperties', 'reproductivecondition', 'cultivationstatus', 'establishmentmeans',
								'lifestage', 'sex', 'individualcount', 'samplingprotocol', 'preparations',
								'country', 'stateprovince', 'county', 'municipality', 'locality',
								'decimallatitude', 'decimallongitude','geodeticdatum', 'coordinateuncertaintyinmeters',
								'locationremarks', 'verbatimcoordinates', 'georeferencedby', 'georeferenceprotocol', 'georeferencesources',
								'georeferenceverificationstatus', 'georeferenceremarks', 'minimumelevationinmeters', 'maximumelevationinmeters',
								'verbatimelevation','language',
								'labelproject','basisofrecord');
							foreach($occFieldArr as $k => $v){
								echo '<div style="float:left;margin-right:5px;">';
								echo '<input type="checkbox" name="kmlFields[]" value="'.$v.'" />'.$v.'</div>';
							}
							?>
						</div>
					</fieldset>
				</div>
			</form>
        </div>
	</div>
</div>
<?php
include($SERVER_ROOT."/footer.php");
?>
</body>
</html>
