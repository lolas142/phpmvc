
	<h1 class='wide'><?=$title?></h1>
	<?php 
	 if (isset($tags[0])){

		$html = "<div class='popular-tags'>";
		foreach ($tags as $tag) {
			$html .= "<h4 class='tag'><a href=" . $this->url->create('tags/id/' . $tag->id) . "> " . $tag->name . "</a></h4>";
		}
		$html .= "</div>";
		echo $html;
	}
	?> 
