<!DOCTYPE HTML>

<html>
<?php include("includes/head.php");?>
	
<body class="clearFloat"> 
	<?php
	include("includes/sql.php");
	include("includes/header.php");
	include("includes/nav.php");
	
	echo "<div id='navSectionWrapper' class='clearFloat'>";
		include("includes/aside.php"); ?>
		<section class="withAside">
			<p>
				Lorem ipsum dolor sit amet, 
				consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, 
				sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, 
				no sea takimata sanctus est Lorem ipsum dolor sit amet.
			</p>
			
			<div id="imageSlider">
				<div id="imageSliderInnerbox"> 
					<?php $sql = sql_getRezeptnamen();
					while ($row = mysql_fetch_assoc($sql))
						echo "
							<a href='rezept.php?id=".$row["nr"]."'>
								<img src='img/rezepte/".$row["nr"].".jpg' alt='".$row["name"]."'> 
							</a>"; ?>
				</div>
				<p></p>
			</div>
		</section>
	</div> <!-- navSectionWrapper -->
	<?php include ("includes/footer.php");?>
</body>
</html>