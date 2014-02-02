<?php
	
	include "config.php";
	include "utils/upload_image.php";
	$user_first_name = $_POST["user_first_name"];
	$user_last_name = $_POST["user_last_name"];
	$user_email = $_POST["user_email"];
	$user_password = $_POST["user_password"];
	$user_newsletter = $_POST["user_newsletter"];
	/**if(isset($_FILES['avatar'])){
		$user_avatar_type = $_FILES['avatar']['type'];
		
		$mime = array();
		$mime[' text/x-php '] = '.php';
		$mime[' image/png '] = '.png'; 
		
		$user_avatar = md5(uniqid(time())).".".$user_avatar_type;//Returns the archive name
		$user_avatar_dir = "img/";
		move_uploaded_file($_FILES['avatar']['tmp_name'], $user_avatar_dir.$user_avatar);
	}	
	else{
		$user_avatar ="img/default_130x130.png";
	}**/
	$sql = mysql_query("insert into user(user_first_name, user_last_name, user_email, user_password, user_avatar, user_newsletter) values('$user_first_name', '$user_last_name', '$user_email', '$user_password', '$user_avatar', '$user_newsletter')", $db_connection) or die("Error: Insert ".mysql_Error());
	ob_end_clean();
	if(($sql) > 0){
		echo "Usuario cadastrado com sucesso.";
	} 
	else{
		echo "Erro ao tentar cadastrar usuario.";
	}
	mysql_close($db_connection);
?>