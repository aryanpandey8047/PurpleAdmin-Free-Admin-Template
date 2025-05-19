<?php
include_once 'core/session.php';

if(isset($_POST['email']) && isset($_POST['password'])){
	$email = $_POST['email'];
	$pword = $_POST['password'];
	
	include_once 'core/user.php';
    
    $user = new User();
    $user_id = $user->getUserId($email, $pword);


	if($user_id){
		$_SESSION['uid'] = $user_id;
		$logged_in_user = $user_id;
	}
}

if(isset($logged_in_user)){
	echo <<<_END
	<meta http-equiv='refresh' content='0;url=table/basic-table.php'>
_END;
}else{
	// TODO: Redirect the user to login and handle return
	echo <<<_END
	<meta http-equiv='refresh' content='0;url=http://localhost/accounts.oaks.pro/login.php?app=POS&redirect_url=http://localhost/PurpleAdmin-Free-Admin-Template/login.php'>
_END;
}

?>