<link href="<?php echo $CLIENT_ROOT; ?>/css/mag.css" type="text/css" rel="stylesheet" />
<link href="<?php echo $CLIENT_ROOT; ?>/css/mag-theme-default.css" type="text/css" rel="stylesheet" />
<style type="text/css">
    .img-thumbnail {
        display: inline-block;
        max-width: 100%;
        height: auto;
        padding: 4px;
        line-height: 1.42857143;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        -webkit-transition: all .2s ease-in-out;
        -o-transition: all .2s ease-in-out;
        transition: all .2s ease-in-out;
    }
</style>
<div style="width:100%;height:1050px;">
	<fieldset style="height:95%;background-color:white;">
		<legend><b>Label Processing</b></legend>
		<div style="margin-top:-10px;height:15px;position:relative">
			<div style="float:right;padding:0px 3px;margin:0px 3px;"><input id="imgreslg" name="resradio" type="radio" onchange="changeImgRes('lg')" />High Res.</div>
			<div style="float:right;padding:0px 3px;margin:0px 3px;"><input id="imgresmed" name="resradio"  type="radio" checked onchange="changeImgRes('med')" />Med Res.</div>
			<?php
			reset($imgArr);
			$imgUrl = current($imgArr); 
			if(strpos($imgUrl['web'],'bisque.cyverse')){
				echo '<div style="float:right;padding:0px 3px;margin:2px 20px 0px 0px;">Rotate: <a href="#" onclick="rotateiPlantImage(-90)">&nbsp;L&nbsp;</a> &lt;&gt; <a href="#" onclick="rotateiPlantImage(90)">&nbsp;R&nbsp;</a></div>';
			}
			?>
		</div>
		<div id="labelprocessingdiv" style="clear:both;">
			<?php
			$imgCnt = 1;
			foreach($imgArr as $imgCnt => $iArr){
				$cssText = 'height:400px;width:auto;';
			    $iUrl = $iArr['web'];
                $iLgUrl = (array_key_exists('lg',$iArr)?$iArr['lg']:$iArr['web']);
				$imgId = $iArr['imgid'];
                $sizeArr = array();
				if(file_exists($iLgUrl)){
                    $sizeArr = (getimagesize($iLgUrl)?getimagesize($iLgUrl):array());
                }
				if(array_key_exists('0',$sizeArr)) {
				    if($sizeArr['0'] > $sizeArr['1']) {
                        $cssText = 'height:auto;width:400px;';
                    }
                }
				?>
				<div id="labeldiv-<?php echo $imgCnt; ?>" style="display:<?php echo ($imgCnt==1?'block':'none'); ?>;">
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $host<?php echo $imgCnt; ?> = $('[mag-thumb="inner-inline-<?php echo $imgCnt; ?>"]');
                            $host<?php echo $imgCnt; ?>.mag({
                                position: 'drag',
                                initial: {
                                    zoom: 0
                                }
                            });
                        });
                    </script>
                    <div style="height:400px;">
                        <div>
                            <div mag-thumb="inner-inline-<?php echo $imgCnt; ?>" mag-flow="inline" class="mag-eg-el">
                                <img id="activeimg-<?php echo $imgCnt; ?>" src="<?php echo $iUrl; ?>" style="<?php echo $cssText; ?>" />
                            </div>
                            <div mag-zoom="inner-inline-<?php echo $imgCnt; ?>" mag-flow="inline" class="mag-eg-el">
                                <img src="<?php echo $iLgUrl; ?>" style="<?php echo $cssText; ?>" />
                            </div>
                        </div>
                    </div>
					<?php 
					if(array_key_exists('error', $iArr)){
						echo '<div style="font-weight:bold;color:red">'.$iArr['error'].'</div>';
					}
					?>
					<div style="width:100%;clear:both;">
						<div style="float:left;">
							<input type="button" value="OCR Image" onclick="ocrImage(this,<?php echo $imgId.','.$imgCnt; ?>);" />
							<img id="workingcircle-<?php echo $imgCnt; ?>" src="../../images/workingcircle.gif" style="display:none;" />
						</div>
						<div style="float:left;">
							<fieldset style="width:200px;background-color:lightyellow;">
								<legend>Options</legend>
								<input type="checkbox" id="ocrfull" value="1" /> OCR whole image<br/>
								<input type="checkbox" id="ocrbest" value="1" /> OCR w/ analysis
							</fieldset>
						</div>
						<div style="float:right;margin-right:20px;font-weight:bold;">
							Image <?php echo $imgCnt; ?> of
							<?php
							echo count($imgArr);
							if(count($imgArr)>1){
								echo '<a href="#" onclick="return nextLabelProcessingImage('.($imgCnt+1).');">=&gt;&gt;</a>';
							}
							?>
						</div>
					</div>
					<div style="width:100%;clear:both;">
						<?php
						$fArr = array();
						if(array_key_exists($imgId,$fragArr)){
							$fArr = $fragArr[$imgId];
						}
						?>
						<div id="tfadddiv-<?php echo $imgCnt; ?>" style="display:none;">
							<form id="ocraddform-<?php echo $imgCnt; ?>" name="ocraddform-<?php echo $imgId; ?>" method="post" action="occurrenceeditor.php">
								<div>
									<textarea name="rawtext" rows="12" cols="48" style="width:97%;background-color:#F8F8F8;"></textarea>
								</div>
								<div title="OCR Notes">
									<b>Notes:</b>
									<input name="rawnotes" type="text" value="" style="width:97%;" />
								</div>
								<div title="OCR Source">
									<b>Source:</b>
									<input name="rawsource" type="text" value="" style="width:97%;" />
								</div>
								<div style="float:left">
									<input type="hidden" name="imgid" value="<?php echo $imgId; ?>" />
									<input type="hidden" name="occid" value="<?php echo $occId; ?>" />
									<input type="hidden" name="collid" value="<?php echo $collId; ?>" />
									<input type="hidden" name="occindex" value="<?php echo $occIndex; ?>" />
									<input type="hidden" name="csmode" value="<?php echo $crowdSourceMode; ?>" />
									<input name="submitaction" type="submit" value="Save OCR" />
								</div>
							</form>
							<div style="font-weight:bold;float:right;">&lt;New&gt; of <?php echo count($fArr); ?></div>
						</div>
						<div id="tfeditdiv-<?php echo $imgCnt; ?>" style="clear:both;">
							<?php
							if(array_key_exists($imgId,$fragArr)){
								$fragCnt = 1;
								$targetPrlid = '';
								if(isset($newPrlid) && $newPrlid) $targetPrlid = $newPrlid;
								if(array_key_exists('editprlid',$_REQUEST)) $targetPrlid = $_REQUEST['editprlid'];
								foreach($fArr as $prlid => $rArr){
									$displayBlock = 'none';
									if($targetPrlid){
										if($prlid == $targetPrlid){
											$displayBlock = 'block';
										}
									}
									elseif($fragCnt==1){
										$displayBlock = 'block';
									}
									?>
									<div id="tfdiv-<?php echo $imgCnt.'-'.$fragCnt; ?>" style="display:<?php echo $displayBlock; ?>;">
										<form id="tfeditform-<?php echo $prlid; ?>" name="tfeditform-<?php echo $prlid; ?>" method="post" action="occurrenceeditor.php">
											<div>
												<textarea name="rawtext" rows="12" cols="48" style="width:97%"><?php echo $rArr['raw']; ?></textarea>
											</div>
											<div title="OCR Notes">
												<b>Notes:</b>
												<input name="rawnotes" type="text" value="<?php echo $rArr['notes']; ?>" style="width:97%;" />
											</div>
											<div title="OCR Source">
												<b>Source:</b>
												<input name="rawsource" type="text" value="<?php echo $rArr['source']; ?>" style="width:97%;" />
											</div>
											<div style="float:left;margin-left:10px;">
												<input type="hidden" name="editprlid" value="<?php echo $prlid; ?>" />
												<input type="hidden" name="collid" value="<?php echo $collId; ?>" />
												<input type="hidden" name="occid" value="<?php echo $occId; ?>" />
												<input type="hidden" name="occindex" value="<?php echo $occIndex; ?>" />
												<input type="hidden" name="csmode" value="<?php echo $crowdSourceMode; ?>" />
												<input name="submitaction" type="submit" value="Save OCR Edits" />
											</div>
											<div style="float:left;margin-left:20px;">
												<input type="hidden" name="iurl" value="<?php echo $iUrl; ?>" />
												<input type="hidden" id="cnumber" name="cnumber" value="<?php echo array_key_exists('catalognumber',$occArr)?$occArr['catalognumber']:''; ?>" />
												<?php
												if(isset($NLP_SALIX_ACTIVATED) && $NLP_SALIX_ACTIVATED){
													echo '<input name="salixocr" type="button" value="SALIX Parser" onclick="nlpSalix(this,'.$prlid.')" />';
													echo '<img id="workingcircle_salix-'.$prlid.'" src="../../images/workingcircle.gif" style="display:none;" />';
												}
												if(isset($NLP_LBCC_ACTIVATED) && $NLP_LBCC_ACTIVATED){
													echo '<input id="nlplbccbutton" name="nlplbccbutton" type="button" value="LBCC Parser" onclick="nlpLbcc(this,'.$prlid.')" />';
													echo '<img id="workingcircle_lbcc-'.$prlid.'" src="../../images/workingcircle.gif" style="display:none;" />';
												}
												?>
											</div>
										</form>
										<div style="float:right;font-weight:bold;margin-right:20px;">
											<?php
											echo $fragCnt.' of '.count($fArr);
											if(count($fArr) > 1){
												?>
												<a href="#" onclick="return nextRawText(<?php echo $imgCnt.','.($fragCnt+1); ?>)">=&gt;&gt;</a>
												<?php
											}
											?>
										</div>
										<div style="clear:both;">
											<form name="tfdelform-<?php echo $prlid; ?>" method="post" action="occurrenceeditor.php" style="margin-left:10px;width:100px;" >
												<input type="hidden" name="delprlid" value="<?php echo $prlid; ?>" />
												<input type="hidden" name="collid" value="<?php echo $collId; ?>" />
												<input type="hidden" name="occid" value="<?php echo $occId; ?>" /><br/>
												<input type="hidden" name="occindex" value="<?php echo $occIndex; ?>" />
												<input type="hidden" name="csmode" value="<?php echo $crowdSourceMode; ?>" />
												<input name="submitaction" type="submit" value="Delete OCR" />
											</form>
										</div>
									</div>
									<?php
									$fragCnt++;
								}
							}
							?>
						</div>
					</div>
                </div>
                <script>
                    var evt<?php echo $imgCnt; ?> = new Event(),
                        m<?php echo $imgCnt; ?> = new Magnifier(evt<?php echo $imgCnt; ?>);

                    m<?php echo $imgCnt; ?>.attach({
                        thumb: '#activeimg-<?php echo $imgCnt; ?>',
                        large: '<?php echo $iLgUrl; ?>',
                        zoom: 3
                    });
                </script>
				<?php
				$imgCnt++;
			}
			?>
		</div>
	</fieldset>
</div>
<script type="text/javascript" src="<?php echo $CLIENT_ROOT; ?>/js/jquery.bridget.js"></script>
<script type="text/javascript" src="<?php echo $CLIENT_ROOT; ?>/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo $CLIENT_ROOT; ?>/js/jquery.event.drag.js"></script>
<script type="text/javascript" src="<?php echo $CLIENT_ROOT; ?>/js/mag.js"></script>
<script type="text/javascript" src="<?php echo $CLIENT_ROOT; ?>/js/mag-jquery.js"></script>
<script type="text/javascript" src="<?php echo $CLIENT_ROOT; ?>/js/mag-control.js"></script>
