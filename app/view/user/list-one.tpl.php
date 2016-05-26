<div class='grid one-user'>
<?php
			$html = "<div class='user'><img src=" . get_gravatar($user->email,120) . "></a>";

			if($edit) {
				$editLink =  "<a href=" . $this->url->create('user/edit/' . $user->id) . ">Redigera profil</a> "; 
			}
			else {
				$editLink = null;
			}

			
			if(empty($user->text)){
				$html .= "<article>" . $user->username  . " har inte skrivit något presentation ännu</article>" . $editLink;
			}
			else {
				$html .= "<article>" . $this->textFilter->doFilter($user->text, 'shortcode, markdown') . "</article>" . $editLink;
			}
			$html .= "</div>";
		if(!empty($questions)) {
			$html .= "<hr><h1>Frågor som " . $user->username . " har ställt</h1>";

			$html .= "<div class='all-questions'>";
			foreach ($questions as $question) {
				$tags = $this->TagsController->getTagsByQuestion($question->id);
				$answers = $this->AnswersController->getAnswers($question->id);


				$html .= "<div class='questions'><h3><a href=" . $this->url->create('questions/id/' . $question->id) . ">" . $question->subject . "</a><span class='number-answers'> (" . count($answers) . " svar) </span></h3> <h6>by " . $user->username . "</h6>";
				$html .= "<article>" . $this->textFilter->doFilter($question->text, 'shortcode, markdown') . "</article><hr><span class='tags'> ";
					
					foreach ($tags as $id => $name) {
						$html .= "<a href=" . $this->url->create('tags/id/' . $id) . ">" . $name . "</a> "; 
					}

				$html .= "</span>";
				$html .= "<span class='date'>" . $question->created . "</span>";
				$html .= "</div>";
			}
			$html .= "</div>";
		}

		if(!empty($discussions)) {
			$html .= "</div><hr><h1>Diskussioner som " . $user->username . " har detltagit i</h1>";
			$html .= "<div class='all-questions'>";
			foreach ($discussions as $discussion) {
				$question = $this->QuestionsController->getQuestion($discussion->questionId);
				extract($question);
				$user = $this->UserController->getUserAction($userId);
				$tags = $this->TagsController->getTagsByQuestion($id);
				$answers = $this->AnswersController->getAnswers($id);


				$html .= "<div class='questions'><div id='textHeader'><a href=" . $this->url->create('questions/id/' . $id) . ">" . $subject . "</a><span class='number-answers'> (" . count($answers) . " svar) </span></div> <div id='textHeaderMedium'>by " . $user->username . "</div>";
				$html .= "<article>" . $this->textFilter->doFilter($text, 'shortcode, markdown') . "</article><hr><span class='tags'> ";
					
					foreach ($tags as $id => $name) {
						$html .= "<a href=" . $this->url->create('tags/id/' . $id) . ">" . $name . "</a> "; 
					}

				$html .= "</span>";
				$html .= "<span class='date'>" . $created . "</span>";
				$html .= "</div>";
			}
			$html .= "</div>";
		}

		echo $html;

?>
</div>