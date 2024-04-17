<?php
namespace Form;
use Entity\user_table;
class user_tableform{
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

	public function birthdate(){
		echo "<input type='date' name='birthdate' id='birthdate'>";
	}

	public function end(){
		echo "<button type='submit'>Envoyer</button>";
		echo "</form>";
	}

	public function collect(){
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$age = $_POST['age'];
		$birthdate = $_POST['birthdate'];
		$user_table = new user_table();
		$user_table->SET_ROW($firstname, $lastname, $age, $birthdate);
		}
}
