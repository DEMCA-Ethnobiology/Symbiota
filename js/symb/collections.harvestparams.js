$(document).ready(function() {
    function split( val ) {
        return val.split( /,\s*/ );
    }
    function extractLast( term ) {
        return split( term ).pop();
    }

    $( "#taxa" )
    	// don't navigate away from the field on tab when selecting an item
        .bind( "keydown", function( event ) {
            if ( event.keyCode === $.ui.keyCode.TAB &&
                $( this ).data( "autocomplete" ).menu.active ) {
                event.preventDefault();
            }
        })
        .autocomplete({
            source: function( request, response ) {
                $.getJSON( "rpc/taxalist.php", {
                    term: extractLast( request.term ), t: function() { return document.harvestparams.taxontype.value; }
                }, response );
            },
            search: function() {
                // custom minLength
                var term = extractLast( this.value );
                if ( term.length < 4 ) {
                    return false;
                }
            },
            focus: function() {
                // prevent value inserted on focus
                return false;
            },
            select: function( event, ui ) {
                var terms = split( this.value );
                // remove the current input
                terms.pop();
                // add the selected item
                terms.push( ui.item.value );
                this.value = terms.join( ", " );
                return false;
            }
        },{});
});

	

function changeTableDisplay(){
    if(document.getElementById("showtable").checked==true){
        document.harvestparams.action = "listtabledisplay.php";
        sessionStorage.collsearchtableview = true;
    }
    else{
        document.harvestparams.action = "list.php";
        sessionStorage.removeItem('collsearchtableview');
    }
}

function checkUpperLat(){
    if(document.harvestparams.upperlat.value != ""){
        if(document.harvestparams.upperlat_NS.value=='N'){
            document.harvestparams.upperlat.value = Math.abs(parseFloat(document.harvestparams.upperlat.value));
        }
        else{
            document.harvestparams.upperlat.value = -1*Math.abs(parseFloat(document.harvestparams.upperlat.value));
        }
    }
}

function checkBottomLat(){
    if(document.harvestparams.bottomlat.value != ""){
        if(document.harvestparams.bottomlat_NS.value == 'N'){
            document.harvestparams.bottomlat.value = Math.abs(parseFloat(document.harvestparams.bottomlat.value));
        }
        else{
            document.harvestparams.bottomlat.value = -1*Math.abs(parseFloat(document.harvestparams.bottomlat.value));
        }
    }
}

function checkRightLong(){
    if(document.harvestparams.rightlong.value != ""){
        if(document.harvestparams.rightlong_EW.value=='E'){
            document.harvestparams.rightlong.value = Math.abs(parseFloat(document.harvestparams.rightlong.value));
        }
        else{
            document.harvestparams.rightlong.value = -1*Math.abs(parseFloat(document.harvestparams.rightlong.value));
        }
    }
}

function checkLeftLong(){
    if(document.harvestparams.leftlong.value != ""){
        if(document.harvestparams.leftlong_EW.value=='E'){
            document.harvestparams.leftlong.value = Math.abs(parseFloat(document.harvestparams.leftlong.value));
        }
        else{
            document.harvestparams.leftlong.value = -1*Math.abs(parseFloat(document.harvestparams.leftlong.value));
        }
    }
}

function checkPointLat(){
    if(document.harvestparams.pointlat.value != ""){
        if(document.harvestparams.pointlat_NS.value=='N'){
            document.harvestparams.pointlat.value = Math.abs(parseFloat(document.harvestparams.pointlat.value));
        }
        else{
            document.harvestparams.pointlat.value = -1*Math.abs(parseFloat(document.harvestparams.pointlat.value));
        }
    }
}

function checkPointLong(){
    if(document.harvestparams.pointlong.value != ""){
        if(document.harvestparams.pointlong_EW.value=='E'){
            document.harvestparams.pointlong.value = Math.abs(parseFloat(document.harvestparams.pointlong.value));
        }
        else{
            document.harvestparams.pointlong.value = -1*Math.abs(parseFloat(document.harvestparams.pointlong.value));
        }
    }
}

function updateRadius(){
    var radiusUnits = document.getElementById("radiusunits").value;
    var radiusInMiles = document.getElementById("radiustemp").value;
    if(radiusUnits == "km"){
        radiusInMiles = radiusInMiles*0.6214;
    }
    document.getElementById("radius").value = radiusInMiles;
}

function openPointRadiusMap() {
    mapWindow=open("mappointradius.php","pointradius","resizable=0,width=700,height=630,left=20,top=20");
    if (mapWindow.opener == null) mapWindow.opener = self;
    mapWindow.focus();
}

function openBoundingBoxMap() {
    mapWindow=open("mapboundingbox.php","boundingbox","resizable=0,width=700,height=630,left=20,top=20");
    if (mapWindow.opener == null) mapWindow.opener = self;
    mapWindow.focus();
}
