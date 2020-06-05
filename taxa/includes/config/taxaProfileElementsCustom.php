<?php
include_once($SERVER_ROOT.'/classes/EthnoDataManager.php');
include_once($SERVER_ROOT.'/classes/EthnoMediaManager.php');

$ethnoDataManager = new EthnoDataManager();
$ethnoMediaManager = new EthnoMediaManager();

ob_start();
$tId = $taxonManager->getTid();
$ethnoDataArr = $ethnoDataManager->getTaxaDataArr($tId);
$eafArr = $ethnoMediaManager->getTaxaEAFArr($tId);
$linkageArr = $ethnoDataManager->getTaxaLinkageArr($tId);
$descArr = $taxonManager->getDescriptions();
$isCollAdmin = false;
$descIndex = 0;
$descriptionText = 'There is currently no description for this taxon.';
$vernacularNameText = 'There are currently no vernacular names for this taxon.';
$vernacularUseText = 'There are currently no vernacular uses for this taxon.';
$multimediaText = 'There are currently no multimedia records associated with this taxon.';
if($SYMB_UID){
    if($IS_ADMIN){
        $isCollAdmin = true;
    }
    elseif($collid && ((array_key_exists("CollAdmin",$USER_RIGHTS) && in_array($collid,$USER_RIGHTS["CollAdmin"])) || (array_key_exists("CollEditor",$USER_RIGHTS) && in_array($collid,$USER_RIGHTS["CollEditor"])))){
        $isCollAdmin = true;
    }
}
if($ethnoDataArr){
    $ethnoUseKingdomId = $ethnoDataManager->getUseEditKingdomId($tId);
    $ethnoPersonnelArr = $ethnoDataManager->getTaxaPersonnelArr($tId);
    $ethnoNameSemanticTagArr = $ethnoDataManager->getNameSemanticTagArr();
    $ethnoUsePartsUsedTagArr = $ethnoDataManager->getPartsUsedTagArr($ethnoUseKingdomId);
    $ethnoUseUseTagArr = $ethnoDataManager->getUseTagArr($ethnoUseKingdomId);
}
foreach($descArr as $dArr){
    foreach($dArr as $id => $vArr){
        if($vArr["caption"] === 'Description'){
            $descriptionText = '';
            $stArr = $vArr["desc"];
            foreach($stArr as $tdsId => $stmt){
                $descriptionText .= $stmt." ";
            }
            unset($dArr[$id]);
        }
        if($vArr["caption"] === 'Vernacular name'){
            $vernacularNameText = '';
            $stArr = $vArr["desc"];
            foreach($stArr as $tdsId => $stmt){
                $vernacularNameText .= "<div style='margin-bottom:15px;'>";
                $vernacularNameText .= $stmt." ";
                $vernacularNameText .= "</div>";
            }
            unset($dArr[$id]);
        }
        if($vArr["caption"] === 'Vernacular use'){
            $vernacularUseText = '';
            $stArr = $vArr["desc"];
            foreach($stArr as $tdsId => $stmt){
                $vernacularUseText .= "<div style='margin-bottom:15px;'>";
                $vernacularUseText .= $stmt." ";
                $vernacularUseText .= "</div>";
            }
            unset($dArr[$id]);
        }
    }
}

?>
<div id="desctabs" class="ui-tabs" style="height:450px;width:640px;clear:both;">
    <ul class="ui-tabs-nav">
        <?php
        echo '<li><a href="#defaultdesctab">Description</a></li>';
        echo '<li><a href="#ethnonametab">Vernacular name</a></li>';
        echo '<li><a href="#ethnousetab">Vernacular use</a></li>';
        echo '<li><a href="#ethnomediatab">Multimedia</a></li>';
        if($descArr){
            $capCnt = 1;
            foreach($descArr as $dArr){
                foreach($dArr as $id => $vArr){
                    $cap = $vArr["caption"];
                    if($cap !== 'Description' && $cap !== 'Vernacular name' && $cap !== 'Vernacular use' && $cap !== 'Multimedia'){
                        if(!$cap){
                            $cap = 'Description #'.$capCnt;
                            $capCnt++;
                        }
                        echo '<li><a href="#tab'.$id.'">'.$cap.'</a></li>';
                    }
                }
            }
        }
        /*if($ethnoDataArr){
            echo '<li><a href="#ethnodatatab">Vernacular Data</a></li>';
        }
        if($eafArr){
            echo '<li><a href="#ethnomediatab">Multimedia</a></li>';
        }
        if($linkageArr){
            echo '<li><a href="#ethnolinkagetab">Linkages</a></li>';
        }*/
        ?>
    </ul>
    <div id="defaultdesctab" style="height:330px;width:94%;overflow:auto;">
        <?php echo $descriptionText; ?>
    </div>
    <div id="ethnonametab" style="height:330px;width:94%;overflow:auto;">
        <?php echo $vernacularNameText; ?>
    </div>
    <div id="ethnousetab" style="height:330px;width:94%;overflow:auto;">
        <?php echo $vernacularUseText; ?>
    </div>
    <div id="ethnomediatab" style="height:330px;width:94%;overflow:auto;">
        <?php
        if($eafArr) {
            foreach($eafArr as $cName => $cArr){
                echo "<div style='margin-bottom:15px;'><b>".$cName."</b><div style='margin-left:10px;'>";
                foreach($cArr as $medId => $mArr){
                    ?>
                    <div style="clear:both;margin:15px;display:flex;justify-content:space-between;">
                        <div>
                            <a href="<?php echo $CLIENT_ROOT; ?>/ethno/eaf/eafdetail.php?mediaid=<?php echo $medId; ?>" target="_blank"><?php echo $mArr['desc']; ?></a>
                        </div>
                        <?php
                        if($isCollAdmin) {
                            ?>
                            <div style="cursor:pointer;" title="Edit EAF Record">
                                <a href="<?php echo $CLIENT_ROOT; ?>/ethno/eaf/eafedit.php?mediaid=<?php echo $medId; ?>">
                                    <img style="border:0;width:15px;" src="../../../images/edit.png" />
                                </a>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <hr/>
                    <?php
                }
                echo "</div></div>";
            }
        }
        else {
            echo $multimediaText;
        }
        ?>
    </div>
    <?php
    if($descArr){
        foreach($descArr as $dArr){
            foreach($dArr as $id => $vArr){
                $cap = $vArr["caption"];
                if($cap !== 'Description' && $cap !== 'Vernacular name' && $cap !== 'Vernacular use' && $cap !== 'Multimedia'){
                    ?>
                    <div id="tab<?php echo $id; ?>" style="height:330px;width:94%;overflow:auto;">
                        <?php
                        if($vArr["source"]){
                            echo '<div id="descsource">';
                            if($vArr["url"]){
                                echo '<a href="'.$vArr['url'].'" target="_blank">';
                            }
                            echo $vArr["source"];
                            if($vArr["url"]){
                                echo "</a>";
                            }
                            echo '</div>';
                        }
                        $descArr = $vArr["desc"];
                        ?>
                        <div style="clear:both;">
                            <?php
                            foreach($descArr as $tdsId => $stmt){
                                echo $stmt." ";
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
            }
        }
    }
    /*if($ethnoDataArr){
        ?>
        <div id="ethnodatatab" class="<?php echo ($styleClass==='species'?'sptab':'spptab'); ?>">
            <?php
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
                foreach($ethnoUseUseTagArr as $id => $uArr){
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
                if($dataUseStr) $dataUseStr = substr($dataUseStr,0,-2);
                if($dataArr["typology"]==='opaque') $dataTypologyStr = 'Opaque';
                elseif($dataArr["typology"]==='transparent') $dataTypologyStr = 'Transparent';
                elseif($dataArr["typology"]==='modifiedopaque') $dataTypologyStr = 'Modified opaque';
                elseif($dataArr["typology"]==='modifiedtransparent') $dataTypologyStr = 'Modified transparent';
                ?>
                <div style="margin-top:10px">
                    <?php
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
                    ?>
                </div>
                <hr/>
                <?php
            }
            ?>
        </div>
        <?php
    }
    if($linkageArr){
        ?>
        <div id="ethnolinkagetab" class="<?php echo ($styleClass==='species'?'sptab':'spptab'); ?>">
            <?php
            foreach($linkageArr as $linkId => $linkArr){
                $linkageTypeStr = '';
                if($linkArr["linktype"]==='cognate') $linkageTypeStr = 'Cognate';
                elseif($linkArr["linktype"]==='loan') $linkageTypeStr = 'Loan';
                elseif($linkArr["linktype"]==='calque') $linkageTypeStr = 'Calque';
                ?>
                <div style="">
                    <?php
                    if($linkageTypeStr){
                        ?>
                        <div style="font-size:13px;">
                            <b>Link type:</b>
                            <?php echo $linkageTypeStr; ?>
                        </div>
                        <?php
                    }
                    if($linkArr["verbatimVernacularName"]){
                        ?>
                        <div style="font-size:13px;">
                            <b>Linked verbatim vernacular name:</b>
                            <?php echo $linkArr["verbatimVernacularName"]; ?>
                        </div>
                        <?php
                    }
                    if($linkArr["langName"]){
                        ?>
                        <div style="font-size:13px;">
                            <b>Linked Glottolog language:</b>
                            <?php echo $linkArr["langName"]; ?>
                        </div>
                        <?php
                    }
                    if($linkArr["sciname"]){
                        ?>
                        <div style="font-size:13px;">
                            <b>Linked scientific name:</b>
                            <?php echo $linkArr["sciname"]; ?>
                        </div>
                        <?php
                    }
                    if($linkArr["refSource"]){
                        ?>
                        <div style="font-size:13px;">
                            <b>Linkage reference source:</b>
                            <?php echo $linkArr["refSource"]; ?>
                        </div>
                        <?php
                    }
                    if($linkArr["refpages"]){
                        ?>
                        <div style="font-size:13px;">
                            <b>Linkage reference pages:</b>
                            <?php echo $linkArr["refpages"]; ?>
                        </div>
                        <?php
                    }
                    if($linkArr["discussion"]){
                        ?>
                        <div style="font-size:13px;">
                            <b>Linkage discussion:</b>
                            <?php echo $linkArr["discussion"]; ?>
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
    }*/
    ?>
</div>
<?php
$ethnoTabsDiv = ob_get_clean();
?>
