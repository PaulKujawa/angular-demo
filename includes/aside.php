<aside>
	<?php
		$sql = sql_getRezeptnamen();		

		echo "<ul class='unpointedUL'>";
			while ($row = mysql_fetch_assoc($sql))
				echo "
					<a href='rezept.php?id=".$row["nr"]."'>
						<li>"
							.$row["name"].
						"</li>
					</a>";
		echo "</ul>";
	?>
</aside>