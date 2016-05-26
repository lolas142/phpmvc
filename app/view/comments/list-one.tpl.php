<div class='grid'>

	<?php
			extract($content);
			$user = $this->UserController->getUserAction($userId);


			$html = "<nav class='button'><a href=" . $this->url->create('questions/list') . ">Gå tillbaka till alla frågor</a></nav>";
			$html .= "<div class='content'>";
			$html .= "<div id='textHeader'>Kommentera</div>";
			$html .= "<article>";
			$html .= $this->textFilter->doFilter($text, 'shortcode, markdown') . "</p>";
			$html .= "</span><span class='username'>";
			$html .= "Fråga av <a href=" . $this->url->create('user/id/' . $user->id) . ">" . $user->username . "</a></span>";

		$html .= "</section><hr><section class='comments'><div id='textHeaderMedium'>Kommentarer</div>";

		foreach ($comments as $comment) {
			$user = $this->UserController->getUserAction($comment->userId);
			$html .= "<div class='comment'><span class='text'>" . $comment->text . "</span><br><span class='date'>" . $comment->created . "</span> <br><span class='username'> av: <a href=" . $this->url->create('user/id/' . $user->id) . ">" . $user->username . "</a></span></span></div>";
		}

		$html .= "</section><hr>";
	
		echo $html;

		echo $form;
	
	
	?> 	
</div>