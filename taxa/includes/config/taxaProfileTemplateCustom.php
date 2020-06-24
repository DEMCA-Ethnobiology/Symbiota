<?php
include('includes/config/taxaProfileElementsDefault.php');
if(file_exists('includes/config/taxaProfileElementsCustom.php')){
    include('includes/config/taxaProfileElementsCustom.php');
}

$topRowElements = Array();
$leftColumnElements = Array();
$rightColumnElements = Array();
$bottomRowElements = Array();
$footerRowElements = Array();

if($taxonRank){
    if($taxonRank > 180){
        $topRowElements = Array($editButtonDiv,$scinameHeaderDiv,$ambiguousDiv,$webLinksDiv);
        $leftColumnElements = Array($taxonNotesDiv,$taxonSourcesDiv,$familyDiv,$synonymsDiv,$centralImageDiv);
        $rightColumnElements = Array($ethnoTabsDiv);
        $bottomRowElements = Array($mapThumbDiv,$imgDiv,$imgTabDiv);
        $footerRowElements = Array($footerLinksDiv);
    }
    elseif($taxonRank == 180){
        $topRowElements = Array();
        $leftColumnElements = Array($scinameHeaderDiv,$familyDiv,$taxonNotesDiv,$taxonSourcesDiv,$projectDiv,$centralImageDiv);
        $rightColumnElements = Array($editButtonDiv,$ethnoTabsDiv);
        $bottomRowElements = Array($ethnoImgBoxDiv);
        $footerRowElements = Array($footerLinksDiv);
    }
    else{
        $topRowElements = Array();
        $leftColumnElements = Array($scinameHeaderDiv,$familyDiv,$taxonNotesDiv,$taxonSourcesDiv,$projectDiv,$centralImageDiv);
        $rightColumnElements = Array($editButtonDiv,$ethnoTabsDiv);
        $bottomRowElements = Array($ethnoImgBoxDiv);
        $footerRowElements = Array($footerLinksDiv);
    }
}
elseif($taxonValue){
    $topRowElements = Array($notFoundDiv);
}
else{
    $topRowElements = Array('ERROR!');
}
?>
