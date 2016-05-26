<?php

	$question =	$question->getProperties();
	extract($question);
?>

<div class='grid'>
	<?php
		$user = $this->UserController->getUserAction($userId);
		$tags = $this->TagsController->getTagsByQuestion($id);
		$questionId = $id;
		$html = "<nav class='button'><a href=" . $this->url->create('questions/list') . ">Gå tillbaka till alla frågor</a></nav>";
		$html .= "<div class='question'>";
		$html .= "<div id='textHeader'>" . $subject . "</div>";
		$html .= "<span class='date'>" . $created . "</span>";
		$html .= "<span class='tags'> Taggar: ";
			foreach ($tags as $id => $name) {
				$html .= "<a href=" . $this->url->create('tags/id/' . $id) . ">" . $name . "</a> "; 
			}
		$html .= "</span>";
		$html .= "<article class='content'>";
		$html .= $this->textFilter->doFilter($text, 'shortcode, markdown') . "</p>";
		$html .= "</article><span class='username'>";
		$html .= "Fråga av <a href=" . $this->url->create('user/id/' . $user->id) . ">" . $user->username . "</a></span>";
		$html .= "<nav class='button right'><a href=" . $this->url->create('comments/form/question/' . 	$questionId ) . ">Lämna kommentar</a></nav>";
		$html .="<hr>";
		$html .= "<section class='comments'><div id='textHeaderMedium'>Kommentarer</div>";
		$comments = $this->CommentsController->getCommentsForQuestion($questionId);
		foreach ($comments as $comment) {
			$user = $this->UserController->getUserAction($comment->userId);
			$html .= "<div class='comment'>
				<div class='username'>
					<a href=" . $this->url->create('user/id/' . $user->id) . ">" . $user->username . "</a>
				</div>
				<div class='text'>" . $comment->text . "</div>
				<div class='date'>" . $comment->created . "</div>
			</div>";
		}
		$html .= "</div></section>";

		$html .= "<section class='answers'>";
		$html .= "<div id='textHeader'>" . count($answers) . " svar</div>";

		foreach ($answers as $answer) {
			$answer =	$answer->getProperties();
			extract($answer);
			$user = $this->UserController->getUserAction($userId);
			$html .= "<div class='answer'>";
			$html .= "<span class='date'>" . $created . "</span>";
			$html .= "<span class='tags'>";
			$html .= "</span>";
			$html .= "<article>";				
			$html .= $this->textFilter->doFilter($text, 'shortcode, markdown') . "</p>";
			$html .= "</article><span class='username'>";
			$html .= "Svar av <a href=" . $this->url->create('user/id/' . $user->id) . ">" . $user->username . "</a></span>"; 
			$html .= "<nav class='button right'><a href=" . $this->url->create('comments/form/answer/' . $id) . ">Lämna kommentar</a></nav>";
			$html .= "<hr>";
			$comments = $this->CommentsController->getCommentsForAnswer($id);
			foreach ($comments as $comment) {
			$user = $this->UserController->getUserAction($comment->userId);
			$html .= "<div class='comment'>
				<div class='username'>
					<a href=" . $this->url->create('user/id/' . $user->id) . ">" . $user->username . "</a>
				</div>
				<div class='text'>" . $comment->text . "</div>
				<div class='date'>" . $comment->created . "</div>
			</div>";
		}
			$html .= "</div>";
		}
		$html .= "</section>";
		
		echo $html;

		echo $form;
	
	
	?> 	
</div>