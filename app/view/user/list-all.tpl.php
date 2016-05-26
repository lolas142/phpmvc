<div class='grid'>
<?php
	 if (isset($users[0])){
	 	$users = array_reverse($users);
		$html = "<div class='all-users'>";
		foreach ($users as $user) {
			$html .= "<div class='user'><a href=" . $this->url->create('user/id/' . $user->id) . "><img src=" . get_gravatar($user->email,160) . "><h3>" . $user->username . "</h3></a>";
			
			
			/*if(empty($user->text)){
				$html .= "<article>" . $user->acronym  . " har inte skrivit något presentation ännu</article>";
			}
			else {
				$html .= "<article>" . $this->textFilter->doFilter($user->text, 'shortcode, markdown') . "</article>";
			}*/

				
			$html .= "</div>";
		}
		$html .= "</div>";
		echo $html;


	}

	?> 


</div>