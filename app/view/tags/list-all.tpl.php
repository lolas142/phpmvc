<div class='grid'>
	<h1><?=$title?></h1>
	<?php 
	 if (isset($tags[0])){

	 
		$html = "<div class='all-questions'>";
		foreach ($tags as $tag) {
			$html .= "<h4 class='tag'><a href=" . $this->url->create('tags/id/' . $tag->id) . "> " . $tag->name . " (" . count($number[$tag->id]) . ")</a></h4>";
		}
		$html .= "</div>";
		echo $html;
	}
	?> 
</div>