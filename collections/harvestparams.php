<?php
include_once('../config/symbini.php');
include_once($SERVER_ROOT.'/config/includes/searchVarDefault.php');
include_once($SERVER_ROOT.'/classes/OccurrenceManager.php');
include_once($SERVER_ROOT.'/classes/EthnoDataManager.php');
include_once($SERVER_ROOT.'/classes/EthnoSearchManager.php');
header("Content-Type: text/html; charset=".$charset);
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

if(file_exists($SERVER_ROOT.'/config/includes/searchVarCustom.php')){
    include($SERVER_ROOT.'/config/includes/searchVarCustom.php');
}

$collManager = new OccurrenceManager();
$ethnoDataManager = new EthnoDataManager();
$ethnoSearchManager = new EthnoSearchManager();

$collArr = Array();
$stArr = Array();
$stArrCollJson = '';
$stArrSearchJson = '';

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
    }
    $stArrSearchJson = json_encode($stArr);
}

if(isset($_REQUEST['db'])){
    if(is_array($_REQUEST['db']) || $_REQUEST['db'] == 'all'){
        $collArr['db'] = $collManager->getSearchTerm('db');
        $stArrCollJson = json_encode($collArr);
    }
}
if($ETHNO_ACTIVE){
    $langArr = $ethnoDataManager->getLangNameSearchDropDownList();
    $ethnoNameSemanticTagArr = $ethnoDataManager->getNameSemanticTagArr();
    $ethnoUsePartsUsedTagArr = $ethnoDataManager->getPartsUsedTagArrFull();
    $ethnoUseUseTagArr = $ethnoSearchManager->getUseTagArrFull();
}
?>
<html>
<head>
    <title><?php echo $defaultTitle.' '.$SEARCHTEXT['PAGE_TITLE']; ?></title>
	<link href="../css/base.css?ver=<?php echo $CSS_VERSION; ?>" type="text/css" rel="stylesheet" />
	<link href="../css/main.css<?php echo (isset($CSS_VERSION_LOCAL)?'?ver='.$CSS_VERSION_LOCAL:''); ?>" type="text/css" rel="stylesheet" />
	<link href="../css/jquery-ui.css" type="text/css" rel="Stylesheet" />
	<script type="text/javascript" src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/jquery-ui.js"></script>
    <script type="text/javascript" src="../js/symb/collections.harvestparams.js?ver=12"></script>
    <script type="text/javascript">
        var starrJson = '';

        $(document).ready(function() {
            <?php
            if($stArrCollJson){
                echo "sessionStorage.jsoncollstarr = '".$stArrCollJson."';";
            }

            if($stArrSearchJson){
                ?>
                starrJson = '<?php echo $stArrSearchJson; ?>';
                sessionStorage.jsonstarr = starrJson;
                setHarvestParamsForm();
                <?php
            }
            else{
                ?>
                if(sessionStorage.jsonstarr){
                    starrJson = sessionStorage.jsonstarr;
                    setHarvestParamsForm();
                }
                <?php
            }
            ?>
        });

        function selectAll(f){
            var dbElements = document.getElementsByName("occid[]");
            for(i = 0; i < dbElements.length; i++){
                dbElements[i].checked = boxesChecked;
            }

        }

        function setHarvestParamsForm(){
            var stArr = JSON.parse(starrJson);
            if(!stArr['usethes']){document.harvestparams.thes.checked = false;}
            if(stArr['taxontype']){document.harvestparams.type.value = stArr['taxontype'];}
            if(stArr['taxa']){document.harvestparams.taxa.value = stArr['taxa'];}
            if(stArr['country']){
                countryStr = stArr['country'];
                countryArr = countryStr.split(";");
                if(countryArr.indexOf('USA') > -1 || countryArr.indexOf('usa') > -1) countryStr = countryArr[0];
                //if(countryStr.indexOf('United States') > -1) countryStr = 'United States';
                document.harvestparams.country.value = countryStr;
            }
            if(stArr['state']){document.harvestparams.state.value = stArr['state'];}
            if(stArr['county']){document.harvestparams.county.value = stArr['county'];}
            if(stArr['local']){document.harvestparams.local.value = stArr['local'];}
            if(stArr['elevlow']){document.harvestparams.elevlow.value = stArr['elevlow'];}
            if(stArr['elevhigh']){document.harvestparams.elevhigh.value = stArr['elevhigh'];}
            if(stArr['assochost']){document.harvestparams.assochost.value = stArr['assochost'];}
            if(stArr['llbound']){
                var coordArr = stArr['llbound'].split(';');
                document.harvestparams.upperlat.value = coordArr[0];
                document.harvestparams.bottomlat.value = coordArr[1];
                document.harvestparams.leftlong.value = coordArr[2];
                document.harvestparams.rightlong.value = coordArr[3];
            }
            if(stArr['llpoint']){
                var coordArr = stArr['llpoint'].split(';');
                document.harvestparams.pointlat.value = coordArr[0];
                document.harvestparams.pointlong.value = coordArr[1];
                document.harvestparams.radiustemp.value = coordArr[2];
                document.harvestparams.radius.value = coordArr[2]*0.6214;
            }
            if(stArr['collector']){document.harvestparams.collector.value = stArr['collector'];}
            if(stArr['collnum']){document.harvestparams.collnum.value = stArr['collnum'];}
            if(stArr['eventdate1']){document.harvestparams.eventdate1.value = stArr['eventdate1'];}
            if(stArr['eventdate2']){document.harvestparams.eventdate2.value = stArr['eventdate2'];}
            if(stArr['catnum']){document.harvestparams.catnum.value = stArr['catnum'];}
            //if(!stArr['othercatnum']){document.harvestparams.includeothercatnum.checked = false;}
            if(stArr['typestatus']){document.harvestparams.typestatus.checked = true;}
            if(stArr['hasimages']){document.harvestparams.hasimages.checked = true;}
            if(stArr['hasgenetic']){document.harvestparams.hasgenetic.checked = true;}
            if(stArr['hasethno']){document.harvestparams.hasethno.checked = true;}
            if(stArr['hasmultimedia']){document.harvestparams.hasmultimedia.checked = true;}
            if(stArr['semantics']){
                var semanticValArr = stArr['semantics'].split(",");
                for (i = 0; i < semanticValArr.length; i++) {
                    if(document.getElementById('semcheck-'+semanticValArr[i])){
                        document.getElementById('semcheck-'+semanticValArr[i]).checked = true;
                    }
                    if(document.getElementById('sempar-'+semanticValArr[i])){
                        document.getElementById('sempar-'+semanticValArr[i]).checked = true;
                    }
                }
            }
            if(stArr['verbatimVernacularName']){document.harvestparams.verbatimVernacularName.value = stArr['verbatimVernacularName'];}
            if(stArr['annotatedVernacularName']){document.harvestparams.annotatedVernacularName.value = stArr['annotatedVernacularName'];}
            if(stArr['verbatimLanguage']){document.harvestparams.verbatimLanguage.value = stArr['verbatimLanguage'];}
            if(stArr['languageid']){document.harvestparams.languageid.value = stArr['languageid'];}
            if(stArr['otherVerbatimVernacularName']){document.harvestparams.otherVerbatimVernacularName.value = stArr['otherVerbatimVernacularName'];}
            if(stArr['otherLangId']){document.harvestparams.otherLangId.value = stArr['otherLangId'];}
            if(stArr['verbatimParse']){document.harvestparams.verbatimParse.value = stArr['verbatimParse'];}
            if(stArr['annotatedParse']){document.harvestparams.annotatedParse.value = stArr['annotatedParse'];}
            if(stArr['verbatimGloss']){document.harvestparams.verbatimGloss.value = stArr['verbatimGloss'];}
            if(stArr['annotatedGloss']){document.harvestparams.annotatedGloss.value = stArr['annotatedGloss'];}
            if(stArr['freetranslation']){document.harvestparams.freetranslation.value = stArr['freetranslation'];}
            if(stArr['taxonomicDescription']){document.harvestparams.taxonomicDescription.value = stArr['taxonomicDescription'];}
            if(stArr['typology']){document.harvestparams.typology.value = stArr['typology'];}
            if(stArr['parts']){
                var partsValArr = stArr['parts'].split(",");
                for (i = 0; i < partsValArr.length; i++) {
                    if(document.getElementById('partsUsed-'+partsValArr[i])){
                        document.getElementById('partsUsed-'+partsValArr[i]).checked = true;
                    }
                }
            }
            if(stArr['uses']){
                var usesValArr = stArr['uses'].split(",");
                for (i = 0; i < usesValArr.length; i++) {
                    if(document.getElementById('use-'+usesValArr[i])){
                        document.getElementById('use-'+usesValArr[i]).checked = true;
                    }
                }
            }
            if(stArr['consultantComments']){document.harvestparams.consultantComments.value = stArr['consultantComments'];}
            if(sessionStorage.collsearchtableview){
                document.getElementById('showtable').checked = true;
                changeTableDisplay();
            }
        }

        function resetHarvestParamsForm(f){
            f.thes.checked = true;
            f.type.value = 1;
            f.taxa.value = '';
            f.country.value = '';
            f.state.value = '';
            f.county.value = '';
            f.local.value = '';
            f.elevlow.value = '';
            f.elevhigh.value = '';
            if(f.assochost){f.assochost.value = '';}
            f.upperlat.value = '';
            f.bottomlat.value = '';
            f.leftlong.value = '';
            f.rightlong.value = '';
            f.upperlat_NS.value = 'N';
            f.bottomlat_NS.value = 'N';
            f.leftlong_EW.value = 'W';
            f.rightlong_EW.value = 'W';
            f.pointlat.value = '';
            f.pointlong.value = '';
            f.radiustemp.value = '';
            f.pointlat_NS.value = 'N';
            f.pointlong_EW.value = 'W';
            f.radiusunits.value = 'km';
            f.radius.value = '';
            f.collector.value = '';
            f.collnum.value = '';
            f.eventdate1.value = '';
            f.eventdate2.value = '';
            f.catnum.value = '';
            f.includeothercatnum.checked = true;
            f.typestatus.checked = false;
            f.hasimages.checked = false;
            var semanticElements = document.getElementsByName("semantics[]");
            for(i = 0; i < semanticElements.length; i++){
                semanticElements[i].checked = false;
            }
            f.verbatimVernacularName.value = '';
            f.annotatedVernacularName.value = '';
            f.verbatimLanguage.value = '';
            f.languageid.value = '';
            f.otherVerbatimVernacularName.value = '';
            f.otherLangId.value = '';
            f.verbatimParse.value = '';
            f.annotatedParse.value = '';
            f.verbatimGloss.value = '';
            f.annotatedGloss.value = '';
            f.freetranslation.value = '';
            f.taxonomicDescription.value = '';
            var typologyElements = document.getElementsByName('typology');
            for (var i = 0; i < typologyElements.length; i++) {
                typologyElements[i].checked = false;
            }
            var partsElements = document.getElementsByName("parts[]");
            for(i = 0; i < partsElements.length; i++){
                partsElements[i].checked = false;
            }
            var usesElements = document.getElementsByName("uses[]");
            for(i = 0; i < usesElements.length; i++){
                usesElements[i].checked = false;
            }
            f.consultantComments.value = '';
            sessionStorage.removeItem('jsonstarr');
            document.getElementById('showtable').checked = false;
            changeTableDisplay();
        }

        function checkHarvestparamsForm(frm){
            <?php
            if(!$SOLR_MODE){
                ?>
                //make sure they have filled out at least one field.
                if ((frm.taxa.value == '') && (frm.country.value == '') && (frm.state.value == '') && (frm.county.value == '') &&
                    (frm.locality.value == '') && (frm.upperlat.value == '') && (frm.pointlat.value == '') && (frm.catnum.value == '') &&
                    (frm.elevhigh.value == '') && (frm.eventdate2.value == '') && (frm.typestatus.checked == false) && (frm.hasimages.checked == false) && (frm.hasgenetic.checked == false) &&
                    (frm.collector.value == '') && (frm.collnum.value == '') && (frm.eventdate1.value == '') && (frm.elevlow.value == '') && (frm.hasethno.checked == false) && (frm.hasmultimedia.checked == false)) {
                    if(sessionStorage.jsoncollstarr){
                        var jsonArr = JSON.parse(sessionStorage.jsoncollstarr);
                        for(i in jsonArr){
                            if(jsonArr[i] == 'all'){
                                alert("Please fill in at least one search parameter!");
                                return false;
                            }
                        }
                    }
                    else{
                        alert("Please fill in at least one search parameter!");
                        return false;
                    }
                }
                <?php
            }
            ?>

            if(frm.upperlat.value != '' || frm.bottomlat.value != '' || frm.leftlong.value != '' || frm.rightlong.value != ''){
                // if Lat/Long field is filled in, they all should have a value!
                if(frm.upperlat.value == '' || frm.bottomlat.value == '' || frm.leftlong.value == '' || frm.rightlong.value == ''){
                    alert("Error: Please make all Lat/Long bounding box values contain a value or all are empty");
                    return false;
                }

                // Check to make sure lat/longs are valid.
                if(Math.abs(frm.upperlat.value) > 90 || Math.abs(frm.bottomlat.value) > 90 || Math.abs(frm.pointlat.value) > 90){
                    alert("Latitude values can not be greater than 90 or less than -90.");
                    return false;
                }
                if(Math.abs(frm.leftlong.value) > 180 || Math.abs(frm.rightlong.value) > 180 || Math.abs(frm.pointlong.value) > 180){
                    alert("Longitude values can not be greater than 180 or less than -180.");
                    return false;
                }
                if(parseFloat(frm.upperlat.value) < parseFloat(frm.bottomlat.value)){
                    alert("Your northern latitude value is less then your southern latitude value. Please correct this.");
                    return false;
                }
                if(parseFloat(frm.leftlong.value) > parseFloat(frm.rightlong.value)){
                    alert("Your western longitude value is greater then your eastern longitude value. Please correct this. Note that western hemisphere longitudes in the decimal format are negitive.");
                    return false;
                }
            }

            //Same with point radius fields
            if(frm.pointlat.value != '' || frm.pointlong.value != '' || frm.radius.value != ''){
                if(frm.pointlat.value == '' || frm.pointlong.value == '' || frm.radius.value == ''){
                    alert("Error: Please make all Lat/Long point-radius values contain a value or all are empty");
                    return false;
                }
            }

            if(frm.elevlow.value || frm.elevhigh.value){
                if(isNaN(frm.elevlow.value) || isNaN(frm.elevhigh.value)){
                    alert("Error: Please enter only numbers for elevation values");
                    return false;
                }
            }

            return true;
        }

        function checkSemanticParent(divid){
            document.getElementById(divid).checked = true;
        }

        function toggleEthnoDiv(targetName){
            var plusDivId = 'plusButton'+targetName;
            var minusDivId = 'minusButton'+targetName;
            var contentDivId = 'content'+targetName;
            var display = document.getElementById(contentDivId).style.display;
            if(display === 'none'){
                document.getElementById(contentDivId).style.display = 'block';
                document.getElementById(plusDivId).style.display = 'none';
                document.getElementById(minusDivId).style.display = 'flex';
            }
            if(display === 'block'){
                document.getElementById(contentDivId).style.display = 'none';
                document.getElementById(plusDivId).style.display = 'flex';
                document.getElementById(minusDivId).style.display = 'none';
            }
        }
    </script>
</head>
<body>
<?php
	$displayLeftMenu = (isset($collections_harvestparamsMenu)?$collections_harvestparamsMenu:false);
	include($serverRoot.'/header.php');
	if(isset($collections_harvestparamsCrumbs)){
		if($collections_harvestparamsCrumbs){
			echo '<div class="navpath">';
			echo $collections_harvestparamsCrumbs.' &gt;&gt; ';
			echo '<b>'.$LANG['NAV_SEARCH'].'</b>';
			echo '</div>';
		}
	}
	else{
		?>
		<div class='navpath'>
			<a href="../index.php"><?php echo $LANG['NAV_HOME']; ?></a> &gt;&gt;
			<a href="index.php"><?php echo $LANG['NAV_COLLECTIONS']; ?></a> &gt;&gt;
			<b><?php echo $LANG['NAV_SEARCH']; ?></b>
		</div>
		<?php
	}
	?>

	<div id="innertext">
		<h1><?php echo $SEARCHTEXT['PAGE_HEADER']; ?></h1>
		<?php echo $SEARCHTEXT['GENERAL_TEXT_1']; ?>
        <div style="margin:5px;">
			<input type='checkbox' name='showtable' id='showtable' value='1' onchange="changeTableDisplay();" /> Show results in table view
		</div>
		<form name="harvestparams" id="harvestparams" action="list.php" method="post">
			<div style="margin:10 0 10 0;"><hr></div>
			<div style='float:right;margin:5px 10px;'>
				<div style="margin-bottom:10px"><input type="submit" class="nextbtn" value="<?php echo isset($LANG['BUTTON_NEXT'])?$LANG['BUTTON_NEXT']:'Next >'; ?>" /></div>
				<div><button type="button" class="resetbtn" onclick='resetHarvestParamsForm(this.form);'><?php echo isset($LANG['BUTTON_RESET'])?$LANG['BUTTON_RESET']:'Reset Form'; ?></button></div>
			</div>
			<div>
				<h1><?php echo $SEARCHTEXT['TAXON_HEADER']; ?></h1>
				<span style="margin-left:5px;"><input type='checkbox' name='thes' value='1' CHECKED /><?php echo $SEARCHTEXT['GENERAL_TEXT_2']; ?></SPAN>
			</div>
			<div id="taxonSearch0">
				<div>
					<select id="taxontype" name="type">
						<option value='1'><?php echo $SEARCHTEXT['SELECT_1-1']; ?></option>
						<option value='2'><?php echo $SEARCHTEXT['SELECT_1-2']; ?></option>
						<option value='3'><?php echo $SEARCHTEXT['SELECT_1-3']; ?></option>
						<option value='4'><?php echo $SEARCHTEXT['SELECT_1-4']; ?></option>
						<?php
                        if(!$ETHNO_ACTIVE){
                            ?>
                            <option value='5'><?php echo $SEARCHTEXT['SELECT_1-5']; ?></option>
                            <?php
                        }
                        ?>
					</select>:
					<input id="taxa" type="text" size="60" name="taxa" value="" title="<?php echo $SEARCHTEXT['TITLE_TEXT_1']; ?>" />
				</div>
			</div>
			<div style="margin:10 0 10 0;"><hr></div>
			<div>
				<h1><?php echo $SEARCHTEXT['LOCALITY_HEADER']; ?></h1>
			</div>
			<div>
				<?php echo $SEARCHTEXT['COUNTRY_INPUT']; ?> <input type="text" id="country" size="43" name="country" value="" title="<?php echo $SEARCHTEXT['TITLE_TEXT_1']; ?>" />
			</div>
			<div>
				<?php echo $SEARCHTEXT['STATE_INPUT']; ?> <input type="text" id="state" size="37" name="state" value="" title="<?php echo $SEARCHTEXT['TITLE_TEXT_1']; ?>" />
			</div>
			<div>
				<?php echo $SEARCHTEXT['COUNTY_INPUT']; ?> <input type="text" id="county" size="37"  name="county" value="" title="<?php echo $SEARCHTEXT['TITLE_TEXT_1']; ?>" />
			</div>
			<div>
				<?php echo $SEARCHTEXT['LOCALITY_INPUT']; ?> <input type="text" id="locality" size="43" name="local" value="" />
			</div>
			<div>
				<?php echo $SEARCHTEXT['ELEV_INPUT_1']; ?> <input type="text" id="elevlow" size="10" name="elevlow" value="" /> <?php echo $SEARCHTEXT['ELEV_INPUT_2']; ?>
				<input type="text" id="elevhigh" size="10" name="elevhigh" value="" />
			</div>
            <?php
            if($QUICK_HOST_ENTRY_IS_ACTIVE) {
                ?>
                <div>
                    <?php echo $SEARCHTEXT['ASSOC_HOST_INPUT']; ?> <input type="text" id="assochost" size="43" name="assochost" value="" title="<?php echo $SEARCHTEXT['TITLE_TEXT_1']; ?>" />
                </div>
                <?php
            }
            ?>
			<div style="margin:10 0 10 0;">
				<hr>
				<h1><?php echo $SEARCHTEXT['LAT_LNG_HEADER']; ?></h1>
			</div>
			<div style="width:300px;float:left;border:2px solid brown;padding:10px;margin-bottom:10px;">
				<div style="font-weight:bold;">
					<?php echo $SEARCHTEXT['LL_BOUND_TEXT']; ?>
				</div>
				<div>
					<?php echo $SEARCHTEXT['LL_BOUND_NLAT']; ?> <input type="text" id="upperlat" name="upperlat" size="7" value="" onchange="checkUpperLat();" style="margin-left:9px;">
					<select id="upperlat_NS" name="upperlat_NS" onchange="checkUpperLat();">
						<option id="nlN" value="N"><?php echo $SEARCHTEXT['LL_N_SYMB']; ?></option>
						<option id="nlS" value="S"><?php echo $SEARCHTEXT['LL_S_SYMB']; ?></option>
					</select>
				</div>
				<div>
					<?php echo $SEARCHTEXT['LL_BOUND_SLAT']; ?> <input type="text" id="bottomlat" name="bottomlat" size="7" value="" onchange="javascript:checkBottomLat();" style="margin-left:7px;">
					<select id="bottomlat_NS" name="bottomlat_NS" onchange="checkBottomLat();">
						<option id="blN" value="N"><?php echo $SEARCHTEXT['LL_N_SYMB']; ?></option>
						<option id="blS" value="S"><?php echo $SEARCHTEXT['LL_S_SYMB']; ?></option>
					</select>
				</div>
				<div>
					<?php echo $SEARCHTEXT['LL_BOUND_WLNG']; ?> <input type="text" id="leftlong" name="leftlong" size="7" value="" onchange="javascript:checkLeftLong();">
					<select id="leftlong_EW" name="leftlong_EW" onchange="checkLeftLong();">
						<option id="llW" value="W"><?php echo $SEARCHTEXT['LL_W_SYMB']; ?></option>
						<option id="llE" value="E"><?php echo $SEARCHTEXT['LL_E_SYMB']; ?></option>
					</select>
				</div>
				<div>
					<?php echo $SEARCHTEXT['LL_BOUND_ELNG']; ?> <input type="text" id="rightlong" name="rightlong" size="7" value="" onchange="javascript:checkRightLong();" style="margin-left:3px;">
					<select id="rightlong_EW" name="rightlong_EW" onchange="checkRightLong();">
						<option id="rlW" value="W"><?php echo $SEARCHTEXT['LL_W_SYMB']; ?></option>
						<option id="rlE" value="E"><?php echo $SEARCHTEXT['LL_E_SYMB']; ?></option>
					</select>
				</div>
				<div style="clear:both;float:right;margin-top:8px;cursor:pointer;" onclick="openBoundingBoxMap();">
					<img src="../images/world.png" width="15px" title="<?php echo $SEARCHTEXT['LL_P-RADIUS_TITLE_1']; ?>" />
				</div>
			</div>
			<div style="width:260px; float:left;border:2px solid brown;padding:10px;margin-left:10px;">
				<div style="font-weight:bold;">
					<?php echo $SEARCHTEXT['LL_P-RADIUS_TEXT']; ?>
				</div>
				<div>
					<?php echo $SEARCHTEXT['LL_P-RADIUS_LAT']; ?> <input type="text" id="pointlat" name="pointlat" size="7" value="" onchange="javascript:checkPointLat();" style="margin-left:11px;">
					<select id="pointlat_NS" name="pointlat_NS" onchange="checkPointLat();">
						<option id="N" value="N"><?php echo $SEARCHTEXT['LL_N_SYMB']; ?></option>
						<option id="S" value="S"><?php echo $SEARCHTEXT['LL_S_SYMB']; ?></option>
					</select>
				</div>
				<div>
					<?php echo $SEARCHTEXT['LL_P-RADIUS_LNG']; ?> <input type="text" id="pointlong" name="pointlong" size="7" value="" onchange="javascript:checkPointLong();">
					<select id="pointlong_EW" name="pointlong_EW" onchange="checkPointLong();">
						<option id="W" value="W"><?php echo $SEARCHTEXT['LL_W_SYMB']; ?></option>
						<option id="E" value="E"><?php echo $SEARCHTEXT['LL_E_SYMB']; ?></option>
					</select>
				</div>
				<div>
					<?php echo $SEARCHTEXT['LL_P-RADIUS_RADIUS']; ?> <input type="text" id="radiustemp" name="radiustemp" size="5" value="" style="margin-left:15px;" onchange="updateRadius();">
					<select id="radiusunits" name="radiusunits" onchange="updateRadius();">
						<option value="km"><?php echo $SEARCHTEXT['LL_P-RADIUS_KM']; ?></option>
						<option value="mi"><?php echo $SEARCHTEXT['LL_P-RADIUS_MI']; ?></option>
					</select>
					<input type="hidden" id="radius" name="radius" value="" />
				</div>
				<div style="clear:both;float:right;margin-top:8px;cursor:pointer;" onclick="openPointRadiusMap();">
					<img src="../images/world.png" width="15px" title="<?php echo $SEARCHTEXT['LL_P-RADIUS_TITLE_1']; ?>" />
				</div>
			</div>
			<div style=";clear:both;"><hr/></div>
			<div>
				<h1><?php echo $SEARCHTEXT['COLLECTOR_HEADER']; ?></h1>
			</div>
			<div>
				<?php echo $SEARCHTEXT['COLLECTOR_LASTNAME']; ?>
				<input type="text" id="collector" size="32" name="collector" value="" title="<?php echo $SEARCHTEXT['TITLE_TEXT_1']; ?>" />
			</div>
			<div>
				<?php echo $SEARCHTEXT['COLLECTOR_NUMBER']; ?>
				<input type="text" id="collnum" size="31" name="collnum" value="" title="<?php echo $SEARCHTEXT['TITLE_TEXT_2']; ?>" />
			</div>
			<div>
				<?php echo $SEARCHTEXT['COLLECTOR_DATE']; ?>
				<input type="text" id="eventdate1" size="32" name="eventdate1" style="width:100px;" value="" title="<?php echo $SEARCHTEXT['TITLE_TEXT_3']; ?>" /> -
				<input type="text" id="eventdate2" size="32" name="eventdate2" style="width:100px;" value="" title="<?php echo $SEARCHTEXT['TITLE_TEXT_4']; ?>" />
			</div>
			<div style="float:right;">
				<input type="submit" class="nextbtn" value="<?php echo isset($LANG['BUTTON_NEXT'])?$LANG['BUTTON_NEXT']:'Next >'; ?>" />
			</div>
			<div>
				<h1><?php echo $SEARCHTEXT['SPECIMEN_HEADER']; ?></h1>
			</div>
			<div>
				<?php echo $SEARCHTEXT['CATALOG_NUMBER']; ?>
                <input type="text" id="catnum" size="32" name="catnum" value="" title="<?php echo $SEARCHTEXT['TITLE_TEXT_1']; ?>" />
                <input name="includeothercatnum" type="checkbox" value="1" checked /> <?php echo $SEARCHTEXT['INCLUDE_OTHER_CATNUM']; ?>
			</div>
			<div>
				<input type='checkbox' name='typestatus' value='1' /> <?php echo $SEARCHTEXT['TYPE']; ?>
			</div>
			<div>
				<input type='checkbox' name='hasimages' value='1' /> <?php echo $SEARCHTEXT['HAS_IMAGE']; ?>
			</div>
            <div id="searchGeneticCheckbox">
                <input type='checkbox' name='hasgenetic' value='1' /> <?php echo $SEARCHTEXT['HAS_GENETIC']; ?>
            </div>
            <?php
            if($ETHNO_ACTIVE){
                ?>
                <div id="searchEthnoCheckbox">
                    <input type='checkbox' name='hasethno' value='1' /> Limit to Specimens with Ethnobiological Data
                </div>
                <div id="searchEthnoMultimediaCheckbox">
                    <input type='checkbox' name='hasmultimedia' value='1' /> Limit to Specimens with Multimedia Files
                </div>
                <div>
                    <h1>Ethnobiological Criteria:</h1>
                </div>
                <div style="float:right;">
                    <input type="submit" class="nextbtn" value="<?php echo isset($LANG['BUTTON_NEXT'])?$LANG['BUTTON_NEXT']:'Next >'; ?>" />
                </div>
                <div>
                    <div style="cursor:pointer;font-size:13px;" onclick="toggleEthnoDiv('NameSemantic');">
                        <div id='plusButtonNameSemantic' style="display:none;align-items:center;">
                            Semantic Tags: <img style='border:0;margin-left:8px;width:13px;' src='../images/plus.png' />
                        </div>
                        <div id='minusButtonNameSemantic' style="display:flex;align-items:center;">
                            Semantic Tags: <img style='border:0;margin-left:8px;width:13px;' src='../images/minus.png' />
                        </div>
                    </div>
                    <div id="contentNameSemantic" style="display:block;padding-left:15px;clear:both;">
                        <?php
                        foreach($ethnoNameSemanticTagArr as $id => $smtArr){
                            $pTag = $smtArr['ptag'];
                            $pDesc = $smtArr['pdesc'];
                            $pTagLine = $pTag.' '.$pDesc;
                            $checkStr = "'sempar-".$id."'";
                            echo '<input name="semantics[]" id="sempar-'.$id.'" value="'.$id.'" type="checkbox" /> '.$pTagLine.'<br />';
                            unset($smtArr['ptag'], $smtArr['pdesc']);
                            if($smtArr){
                                echo '<div style="padding-left:15px;clear:both;">';
                                foreach($smtArr as $cid => $cArr){
                                    $cTag = $cArr['ctag'];
                                    $cDesc = $cArr['cdesc'];
                                    $cTagLine = $cTag.' '.$cDesc;
                                    echo '<input name="semantics[]" id="semcheck-'.$cid.'" value="'.$cid.'" type="checkbox" onchange="checkSemanticParent('.$checkStr.');" /> '.$cTagLine.'<br />';
                                }
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                </div>
                <div style="margin-top:15px;">
                    Verbatim vernacular name: <input name="verbatimVernacularName" id="verbatimVernacularName" type="text" size="60" />
                </div>
                <div>
                    Annotated vernacular name: <input name="annotatedVernacularName" id="annotatedVernacularName" type="text" size="60" />
                </div>
                <div>
                    Verbatim language: <input name="verbatimLanguage" id="verbatimLanguage" type="text" size="60" />
                </div>
                <div>
                    Glottolog language: <select id="ethnoNameLanguage" name="languageid" style="width:500px;">
                        <option value="">----Select Language----</option>
                        <?php
                        foreach($langArr as $k => $v){
                            echo '<option value="'.$v['id'].'">'.$v['name'].'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div>
                    Other verbatim vernacular name: <input name="otherVerbatimVernacularName" id="otherVerbatimVernacularName" type="text" size="60" />
                </div>
                <div>
                    Glottolog language: <select name="otherLangId" id="otherLangId" style="width:500px;">
                        <option value="">----Select Language----</option>
                        <?php
                        foreach($langArr as $k => $v){
                            echo '<option value="'.$v['id'].'">'.$v['name'].'</option>';
                        }
                        ?>
                    </select>
                </div>
                <div>
                    Verbatim parse: <input name="verbatimParse" id="verbatimParse" type="text" size="60" />
                </div>
                <div>
                    Annotated parse: <input name="annotatedParse" id="annotatedParse" type="text" size="60" />
                </div>
                <div>
                    Verbatim gloss: <input name="verbatimGloss" id="verbatimGloss" type="text" size="60" />
                </div>
                <div>
                    Annotated gloss: <input name="annotatedGloss" id="annotatedGloss" type="text" size="60" />
                </div>
                <div>
                    Free translation: <input name="freetranslation" id="freetranslation" type="text" size="60" />
                </div>
                <div>
                    Taxonomic description: <input name="taxonomicDescription" id="taxonomicDescription" type="text" size="60" />
                </div>
                <div>
                    <span style="font-size:13px;">Typology:</span>
                    <div style="clear:both;margin-left:20px;">
                        <input type="radio" name="typology" id="typology-opaque" value="opaque"> Opaque<br />
                        <input type="radio" name="typology" id="typology-transparent" value="transparent"> Transparent<br />
                        <input type="radio" name="typology" id="typology-modifiedopaque" value="modifiedopaque"> Modified opaque<br />
                        <input type="radio" name="typology" id="typology-modifiedtransparent" value="modifiedtransparent"> Modified transparent
                    </div>
                </div>
                <div style="float:right;">
                    <input type="submit" class="nextbtn" value="<?php echo isset($LANG['BUTTON_NEXT'])?$LANG['BUTTON_NEXT']:'Next >'; ?>" />
                </div>
                <div style="margin-top:10px;">
                    <div style="cursor:pointer;font-size:13px;" onclick="toggleEthnoDiv('PartsUsed');">
                        <div id='plusButtonPartsUsed' style="display:none;align-items:center;">
                            Parts used: <img style='border:0;margin-left:8px;width:13px;' src='../images/plus.png' />
                        </div>
                        <div id='minusButtonPartsUsed' style="display:flex;align-items:center;">
                            Parts used: <img style='border:0;margin-left:8px;width:13px;' src='../images/minus.png' />
                        </div>
                    </div>
                    <div id="contentPartsUsed" style="display:block;padding-left:15px;clear:both;">
                        <?php
                        foreach($ethnoUsePartsUsedTagArr as $tid => $tidPArr){
                            echo '<div id="part-'.$tid.'">';
                            foreach($tidPArr as $id => $text){
                                echo '<input name="parts[]" id="partsUsed-'.$id.'" value="'.$id.'" type="checkbox"/> '.$text.'<br />';
                            }
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
                <div style="margin-top:10px;">
                    <div style="cursor:pointer;font-size:13px;" onclick="toggleEthnoDiv('Uses');">
                        <div id='plusButtonUses' style="display:flex;align-items:center;">
                            Uses: <img style='border:0;margin-left:8px;width:13px;' src='../images/plus.png' />
                        </div>
                        <div id='minusButtonUses' style="display:none;align-items:center;">
                            Uses: <img style='border:0;margin-left:8px;width:13px;' src='../images/minus.png' />
                        </div>
                    </div>
                    <div id="contentUses" style="display:none;padding-left:15px;clear:both;">
                        <?php
                        foreach($ethnoUseUseTagArr as $tid => $tidUArr){
                            echo '<div id="use-'.$tid.'">';
                            foreach($tidUArr as $id => $uArr){
                                $header = $uArr['header'];
                                unset($uArr['header']);
                                if($header){
                                    $headerStr = str_replace(' ','',$header);
                                    echo '<div style="clear:both;margin-top:10px;">';
                                    ?>
                                    <div style="cursor:pointer;font-size:13px;" onclick="toggleEthnoDiv('<?php echo $headerStr; ?>');">
                                        <div id='plusButton<?php echo $headerStr; ?>' style="display:flex;align-items:center;">
                                            <?php echo $header; ?>: <img style='border:0;margin-left:8px;width:13px;' src='../images/plus.png' />
                                        </div>
                                        <div id='minusButton<?php echo $headerStr; ?>' style="display:none;align-items:center;">
                                            <?php echo $header; ?>: <img style='border:0;margin-left:8px;width:13px;' src='../images/minus.png' />
                                        </div>
                                    </div>
                                    <?php
                                    echo '<div id="content'.$headerStr.'" style="display:none;padding-left:15px;clear:both;">';
                                    foreach($uArr as $uid => $text){
                                        echo '<input name="uses[]" id="use-'.$uid.'" value="'.$uid.'" type="checkbox"/> '.$text.'<br />';
                                    }
                                    echo '</div>';
                                    echo '</div>';
                                }
                                else{
                                    foreach($uArr as $uid => $text){
                                        echo '<input name="uses[]" id="use-'.$uid.'" value="'.$uid.'" type="checkbox"/> '.$text.'<br />';
                                    }
                                }
                            }
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
                <div style="margin-top:15px;">
                    Consultant comments: <input name="consultantComments" id="consultantComments" type="text" size="60" />
                </div>
                <div style="float:right;">
                    <input type="submit" class="nextbtn" value="<?php echo isset($LANG['BUTTON_NEXT'])?$LANG['BUTTON_NEXT']:'Next >'; ?>" />
                </div>
                <?php
            }
            ?>
			<input type="hidden" name="reset" value="1" />
		</form>
    </div>
	<?php
	include($serverRoot.'/footer.php');
	?>
</body>
</html>
