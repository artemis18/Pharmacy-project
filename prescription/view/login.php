<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Prescription Tester</title>
    <link href="css/style.css" media="all" type="text/css" rel="stylesheet">
</head>
<body>
    <!-- Page container -->
    <div style="width: 500px;margin-left: auto; margin-right: auto; margin-top: 150px;">
        <div id="banner"></div>
        <form method="POST" action="../database/login_handler.php">
            <fieldset>
                <legend>Enter login details</legend>
                <label for="username">Username</label><br/>
                <input type="text" name="username" value=""/><br/>
                <label for="password">Password</label><br/>
                <input type="password" size="8" maxlength="8" name="password"/><br/>
                <input type="submit" name="login" value="Login"/>
            </fieldset>
         </form>
    </div>
</body>
</html>
