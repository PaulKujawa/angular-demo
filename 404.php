<!DOCTYPE HTML>
<?php
echo "<html>";
	include("includes/head.php");
	echo "<body>
		<p id='errorPage'>Ein Fehler trat auf:</br><em>" .$_GET['e']. "<em></p>
	</body>
</html>";
?>