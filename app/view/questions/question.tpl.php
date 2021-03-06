<?php 
	$html = "<div class='all-questions'>";
		foreach ($questions as $question) {
			$user = $this->UserController->getUserAction($question->userId);
			$tags = $this->TagsController->getTagsByQuestion($question->id);
			$answers = $this->AnswersController->getAnswers($question->id);

			$html .= "<hr>";
			$html .= "<div class='questions'>";
				$html .= "<img src=" . get_gravatar($user->email,80) . ">
				<div id='questions'>
				<a href=" . $this->url->create('questions/id/' . $question->id) . ">" . $question->subject . "</a>
				<span class='number-answers'> (" . count($answers) . " svar) </span>
				</div>"; 
			$html .= "<div id='author'>av " . $user->username . "</div id='author'>";
			$html .= "<article>" . $this->textFilter->doFilter($question->text, 'shortcode, markdown') . "</article><span class='tags'> ";
				
				foreach ($tags as $id => $name) {
					$html .= "<a href=" . $this->url->create('tags/id/' . $id) . ">" . $name . "</a> "; 
				}

			$html .= "</span>";
			$html .= "<span class='date'>" . $question->created . "</span>";
			$html .= "</div>";
		}
		$html .= "</div>";
		echo $html;
	?> 
