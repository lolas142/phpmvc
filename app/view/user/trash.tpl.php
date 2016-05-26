<div class='grid'>
	<h1><?=$title?></h1>

	<?php 
	if (isset($users[0])){
	$keys = array_keys($users[0]->getProperties());
	$thead = '<thead>';
	foreach ($keys as $key => $value) {
		if ($value != 'password') {
		$thead .= '<th>' . $value . '</th>';
		}
	}
	$thead .= '<th>Activate</th><th>Delete</th></thead>';
	$tbody = '<tbody>';
	foreach ($users as $user) {
		$values = $user->getProperties();
		$tbody .= '<tr>';
		foreach ($values as $key => $value) {
			if ($key == 'id') {
				$url = $this->url->create('users/id/' . $value);
				$tbody .= '<td><a href="' . $url . '">' . $value . '</a></td>';
			}
			elseif ($key != 'password') {
			$tbody .= '<td>' . $value . '</td>';
			}
		}
		$activate = $this->url->create('users/activate/' . $values['id']);
		$delete = $this->url->create('users/delete/' . $values['id']);
		$tbody .= '<td><a href="' . $activate . '">Activate</a></td><td><a href="' . $delete . '">Delete</a></td></tr>';
	}
	$tbody .= '</tbody>';
	$table = '<table>' . $thead . $tbody . '</table>';

	echo $table; 
	}
	?> 
	<nav>
		<a href="<?=$this->url->create('users/setup/');?>">Setup</a>
		<a href="<?=$this->url->create('users/add/');?>">Add user</a>
		<a href="<?=$this->url->create('users/active/');?>">View only active users</a>
		<a href="<?=$this->url->create('users/list/');?>">List All</a>
	</nav>
</div>
 
