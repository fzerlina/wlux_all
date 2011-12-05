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
<p>Please solve the following problems by writing a program in JavaScript in the <b>Task Window</b>. The problems involve using an API that is under development to give Web programmers access to certain state Lottery functions. Web programmers would use such an API to create web pages and web sites that allow their users to find lottery games and the winning numbers of previous lottery games.
Clicking the <b>TryIt!</b> button below the <b>Task Window</b> will display the results of your program in the <b>Output Window</b>. The text that your solution writes in the <b>Output Window</b> does not need to be formatted in any specific way, but it must contain the results requested in the task instructions. The code does not require any error handling, unless specifically required by the task. Each task should take about than 10 minutes to complete?</p>



<form id="browseurlform" method="post" target="_blank" action="<?php echo $url['0']['safe_value'],$_SESSION['session_id']; ?>">
	<!-- Change these to hidden values later -->
	
	<div style="display: none; ">CSS1:<input type="text" name="ss1" value="<?php echo $ss1; ?>" style="border:1px solid black;" />
	<br />
	CSS2:<input type="text" name="ss2" value="<?php echo $ss2; ?>" style="border:1px solid black;" />
	<br/>
	Condition:<input type="text" name="cid" value="<?php echo $filecontents ?>" style="border:1px solid black;" />
	<br/>
	</div>
	
	<input type="submit" value="Visit Study Website" style="padding:10px;" onclick="javascript:showContinue();" />
</form>
