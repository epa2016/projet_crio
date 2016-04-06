<?php

	require(connetion.php);
	$today = time()-time()%86400;
	$tomorrow = (time()+(24*60*60)) - time()%86400;
	echo date('D M j G:i:s T Y',$today);
	echo date('D M j G:i:s T Y',$tomorrow);

	$datetime = new DateTime();
	//echo $datetime->getTimestamp(); 


	$sql = 'SELECT start_time, create_by FROM mrbs_entry WHERE start_time BETWEEN "'.$today.'" AND "'.$tomorrow.'"';
	$req = $dbh->query($sql);

	
	while($d = $req->fetch(PDO::FETCH_OBJ)){
		echo '<pre>';
		$date = $d->start_time;
		echo date('D M j G:i:s T Y',$date);
		echo '</pre>';
	}

?>