<?php
	// aktuelles rating
	$id = $_GET['id'];
	include("sql.php");
	$sql = sql_getRezeptrating($id);
	
	while ($row = mysql_fetch_assoc($sql)) {
		$oldVote = $row["rating"];	
		$votes = $row["votes"];
	}
	
	
	/* calculating new quote, e.g.
		(4*50+100)/5 = 60
		(4*50)/5 = 40
	*/
	if ($_GET['vote'] == '+')
		$rating = ($votes*$oldVote+100)/($votes+1);
	elseif ($_GET['vote'] == '-')
		$rating = ($votes*$oldVote)/($votes+1);
		
	
	// DB-update & refresh
	sql_setRezeptraiting($id, $rating, $votes+1);
	$ajax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
	if (!$ajax)
		header("Location:rezept.php?id=".$id);
	else
		echo $rating;
?>