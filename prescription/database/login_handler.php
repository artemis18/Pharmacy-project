<?php
require_once "database.php";
require_once "db_connect.php";

$query = 
"SELECT * FROM users
 WHERE Username='{$_POST['username']}' 
   AND Password='{$_POST['password']}'";
$result = mysql_query($query);

/* If there is a match, we create the session with the required fields, using the
   results of the query */
if ($result){
    $row = mysql_fetch_array($result, MYSQL_ASSOC);
    session_start();
    $_SESSION['privilege'] = $row['Privilege'];
    $_SESSION['name'] = $row['Name'];
    $_SESSION['username'] = $row['Username'];
    $_SESSION['user_id'] = $row['UserID'];
    //Now that the session has been started, we need to redirect the user
    header( 'Location: /prescription/index.php');
    exit(); //Quit the script
} else {
?>
    <h1>Account does not exist</h1>
    <h3>Please speak to admin to receive account details</h3>
    <a href='/prescription/view/login.php'>Back</a>
<?php           
}
?>
