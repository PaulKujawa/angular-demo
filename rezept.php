<!DOCTYPE HTML>

<html>
<?php include("includes/head.php");?>
	
<body> 
	<?php
	include("includes/sql.php");
	include("includes/header.php");
	include("includes/nav.php");

	echo "<div id='navSectionWrapper' class='clearFloat'>";
		include("includes/aside.php");		
		echo "<section class='withAside'>";
			
			$id = $_GET['id'];
			$gericht = sql_getRezeptname($id);
			$sql = sql_getRezeptrating($id);
			while ($row = mysql_fetch_assoc($sql))
				$like = $row["rating"];
			$dislike=100-$like;?>
			
			<div id="toolbar">
				<ul class="floatedUL">
					<a href='includes/voting.php?id=<?php echo $id;?>&vote=%2B' id='toolbarLikeBtn'>
						<li>
							<img src="img/like.ico">
						</li>
					</a>
					<a href='includes/voting.php?id=<?php echo $id;?>&vote=-' id='toolbarDislikeBtn'>
						<li>
							<img src="img/dislike.ico">
						</li>
					</a>
				</ul>
				
				<div id="toolbarRatingDisplay">
						<?php echo $like."%"; ?>
				</div>
				
				<canvas id="toolbarLikesline" style="width:<?php echo $like?>%;"></canvas>
				<canvas id="toolbarDislikesline" style="width:<?php echo $dislike?>%;"></canvas>
			</div>

			<!-- Header -->
			<h1><?php echo $gericht;?></h1> 
			<img id='rezeptImg' src='img/rezepte/<?php echo $id;?>.jpg' alt='picture of <?php echo $gericht;?>'>
			
			
			
			<table id='makroTable' border='1'> <?php
				$sql_hauptzutat = sql_getHauptzutatKcal($id);
				$sql_nebenzutat = sql_getNebenzutatKcal($id);
				$label = array(0=>"kcal", 1=>"eiweiß", 2=>"kohlenhydrate", 3=>"zucker", 4=>"fett", 5=>"gesFett");
				
				// Berechnung
				while($row = mysql_fetch_assoc($sql_hauptzutat)) {
					if ($row["menge"]==null || $row["mengenart"] == 1)
						echo "Error: Inkonstenz im Datenbestand.";
						
					$gr = $row["menge"];
					if ($row["mengenart"] == 2)
						$gr *= $row["gewicht"]; // stk.
					$faktor = $gr/$row["je100g"];
				
					$hauptzutat = array(0=>0, 1=>0, 2=>0, 3=>0, 4=>0, 5=>0);
					$hauptzutatTyp = $row["typ"];
					$hauptzutatGr = $gr;
					for ($i=0; $i <=5; $i++)
						$hauptzutat[$i] += $row[$label[$i]]*$faktor;
				}
				
				$nebenzutatGr = 0;
				$nebenzutat = array(0=>0, 1=>0, 2=>0, 3=>0, 4=>0, 5=>0);
				while($row = mysql_fetch_assoc($sql_nebenzutat)) {
					if ( ($row["menge"]==null && $row["mengenart"]!=1) || ($row["menge"]!=null && $row["mengenart"]== 1)  )
						echo "Error: Inkonstenz im Datenbestand.";
					
					elseif ( $row["mengenart"] != 1) { // einheit mit gewicht
						$gr = $row["menge"];
						if ($row["mengenart"] == 2)
							$gr *= $row["gewicht"];
						$faktor = $gr/$row["je100g"];
					
						$nebenzutatGr += $gr;
						for ($i=0; $i <=5; $i++)
							$nebenzutat[$i] += $row[$label[$i]]*$faktor;
					}
				}
								
				// Anzeige	
				echo "
					<tr>
						<th>Wert</th>
						<th>".$hauptzutatTyp." 100g</th>
						<th>Rest 100g</th>
						<th>ges. ".($hauptzutatGr + $nebenzutatGr)."g</th>
					</tr>";

				for ($i=0; $i<=5; $i++)
					echo "<tr>
							<td>" .$label[$i]. 									"</td>
							<td>" .round(100/$hauptzutatGr*$hauptzutat[$i], 1). "</td>
							<td>" .round(100/$nebenzutatGr*$nebenzutat[$i], 1).	"</td>
							<td>" .round($hauptzutat[$i]+$nebenzutat[$i], 0). 	"</td>
						</tr>";?>
			</table>
			
			
			<ul id="zutatenliste"><?php
				$sql_hauptzutat = sql_getHauptzutat($id);
				$sql_nebenzutat = sql_getNebenzutat($id);
				
				while ($row = mysql_fetch_assoc($sql_hauptzutat))
					echo "<li>".$row["menge"].$row["art"]." ".$row["typ"]."</li>";
				while ($row = mysql_fetch_assoc($sql_nebenzutat)) {
					if ($row["art"] != "*" && $row["art"] != "n.B.")
						echo "<li>".$row["menge"].$row["art"]." ".$row["typ"]."</li>";
					else
						echo "<li>".$row["menge"]." ".$row["typ"]."</li>"; 
				} ?>
			</ul>
			
			
			<ol id="zubereitung"><?php
				$sql = sql_getRezeptzubereitung($id);
				while ($row = mysql_fetch_assoc($sql))
					echo "<li>".$row["beschreibung"]."</li>";?>
			</ol>
		</section>
	</div> <!-- navSectionWrapper -->
	<?php include("includes/footer.php");?>
</body>
</html>