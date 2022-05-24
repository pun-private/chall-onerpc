<?php 

namespace Greeting;

/* *************************** private functions *************************** */

function is_minor($age) {
	if ($age < 18)
		throw new \Exception("You are not old enough to request this method.");
}

/* *************************** Exposed functions **************************** */

function register_hello() {
	return "Hello World !";
}

function register_welcome($name) {
	return "Welcome $name !";
}

function register_who_are_you($name, $age, $hobbies) {

	is_minor($age);

	$text = "Your name is $name and you are $age years old. ";

	if (empty($hobbies))
		return $text;

	$text .= "Your hobbies are : " . implode(', ', $hobbies) . ".";
	
	return $text;
}