<?php
session_start();

// Initialisation des variables
$username = "";
$email    = "";
$errors = array(); 

// On se connecte à la bdd
 // si dans l'array $_SERVER y'a l'un des truc local ça veut dire qu'on est en local
$mysqli = new mysqli("localhost", "root", "", "test"); // la base de donné local

// Enregistrement :)
if (isset($_POST['reg_user'])) {
  // On recup les valeurs des inputs
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

  
 // On push l'error correspondante :)
if (empty($username)) { array_push($errors, "Username is required"); }
if (empty($email)) { array_push($errors, "Email is required"); }
if (empty($password_1)) { array_push($errors, "Password is required"); }
if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

// On vérifié si l'utilisateur existe pas déjà
$user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
$result = mysqli_query($db, $user_check_query);
$user = mysqli_fetch_assoc($result);
  
if ($user) { // Si il existe
	if ($user['username'] === $username) {
		//On push l'error correspondante ( pour l'username ici)
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
		// Et l'email ici
      array_push($errors, "email already exists");
    }
  }

  // Enfin, si tout est renseigné, on envoie dans la bdd
  if (count($errors) == 0) {
  	$password = hash("sha3-256", $password_1);// On hash le mdp ( hash : suite d'operations à sens unique)
	// Insertion des données de l'utilisateur
  	$query = "INSERT INTO users (username, email, password) 
  			  VALUES('$username', '$email', '$password')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
}

// Connexion
if (isset($_POST['login_user'])) {
	$username = mysqli_real_escape_string($db, $_POST['username']);
	$password = mysqli_real_escape_string($db, $_POST['password']);
	// Si le champ correspondant est vide
	if (empty($username)) {
		// On renvoie l'erreur correspondante 
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}
	// Si il n'y a pas d'erreurs
	if (count($errors) == 0) {
		$password = md5($password);
		// On connecte
		$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
		$results = mysqli_query($db, $query);
		if (mysqli_num_rows($results) == 1) {
		  $_SESSION['username'] = $username;
		  $_SESSION['success'] = "You are now logged in";
		  header('location: index.php');
		}else {
			// Si il y a finalement une erreur, on l'a renvoie
			array_push($errors, "Wrong username/password combination");
		}
	}
  }
  
  ?>