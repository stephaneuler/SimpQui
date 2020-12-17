<div class="row"> 
	<div class="col-md-offset-0 col-md-8">
		<p style="margin-bottom: 30px;">
			Überprüfe dein Wissen in verschiedenen Modulen mit einem kleinen Quiz.<br />
		</p>
		<div class="card">
			<h2 class="card_header card_header_margin" style="height: 50px;">Themen</h2>
			<hr/>
			<div class="container_home">
				<?php 
					$topics = getTopics();
					echo "<table>";

					foreach( $topics as $topic ) {
						$t = str_replace(".top","", $topic);
						echo "<tr>";
						echo "<th style='width:100px; '>";
						echo "<a href='index.php?inhalt=topic&topic=$topic' style='margin-left:20px; '>$t</a> ";
						echo "</th>";
						echo "<th style='font-weight:normal;'>";
							$comment = getComments( $t, "top");
							$comment =  preg_replace( "/<br>.*/", "", $comment);
						echo "$comment</th></tr>";
					}
					echo "</table>";
				?>
			</div>
		</div>
	</div>
</div>