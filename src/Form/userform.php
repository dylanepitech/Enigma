<?php
namespace Form;
use Entity\user;
class userform{
	public function start($action, $method){
		echo "<form action='$action' method='$method'>";
	}

	public function firstname(){
		echo "<input type='text' name='firstname' id='firstname'>";
	}

	public function lastname(){
		echo "<input type='text' name='lastname' id='lastname'>";
	}

	public function age(){
		echo "<input type='number' name='age' id='age'>";
	}

	public function end(){
		echo "<button type='submit'>Envoyer</button>";
		echo "</form>";
	}

	public function collect(){
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$age = $_POST['age'];
		$user = new user();
		$user->SET_ROW($firstname, $lastname, $age);
		}
}
