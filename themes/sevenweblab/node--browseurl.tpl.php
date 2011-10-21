<p style="background: #DDEE99; color:black; padding:15px">Task: Browse this site for 10 to 15 minutes, learning as much as you can to prepare for your upcoming summer job as a park tour guide.</p>

<?php
	$ssall = field_get_items('node', $node, 'field_stylesheets');
	$url = field_get_items('node', $node, 'field_url');
	//echo print_r($ssall['0']['safe_value']);
	
	$sssingle = explode(",", $ssall['0']['safe_value']);
	//echo print_r($sssingle);
	
	$file = fopen(path_to_theme()."/count.txt", "r");
	$filecontents = fgets($file);
	fclose($file);
	
	$ss1;
	$ss2;
	
	if($filecontents == "0") {
		$ss1 = $sssingle[0];
		$ss2 = $sssingle[2];
	} else if ($filecontents == "1") {
		$ss1 = $sssingle[0];
		$ss2 = $sssingle[3];
	} else if($filecontents == "2") {
		$ss1 = $sssingle[1];
		$ss2 = $sssingle[2];
	} else {
		$ss1 = $sssingle[1];
		$ss2 = $sssingle[3];
	}
?>

<form id="browseurlform" method="post" target="_blank" action="<?php echo $url['0']['safe_value'],$_SESSION['session_id']; ?>">
	<!-- Change these to hidden values later -->
	CSS1:<input type="text" name="ss1" value="<?php echo $ss1; ?>" style="border:1px solid black;" />
	<br />
	CSS2:<input type="text" name="ss2" value="<?php echo $ss2; ?>" style="border:1px solid black;" />
	<br/>
	Condition:<input type="text" name="cid" value="<?php echo $filecontents ?>" style="border:1px solid black;" />
	<br/>
	<input type="submit" value="Visit Study Website" style="padding:10px;" onclick="javascript:showContinue();" />
</form>
