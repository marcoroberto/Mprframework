<!doctype html>
<html lang="PT">
    <head>
        <meta charset="utf-8">
        <title>Login Form</title>
        <meta name="description" content="The HTML5 Herald">
        <meta name="author" content="SitePoint">

        <link rel="stylesheet" href="css/styles.css">
        
    </head>
    <body>
        <!-- login form for open id //-->
        <form name="login" method="post" action="testLogin.php">
            <div id="divUsername">
                <label for=""paramUsername">Username</label>
                <input type="text" name="username" id="paramUsername" placeholder="username">
            </div>
            <div id="divPassword">
                <label for="paramPassword">Password:</label>
                <input type="password" name="password" id="paramPassword" placeholder="password">
            </div>
            <div id="divSubmit">
                <button type="submit">Submit</button>
            </div>
            <input type="hidden" name="controller" value="Login">
            <input type="hidden" name="action" value="signin">
            <div id="divToken">
                <?php echo $data->Helper::generateFormToken('signin');?>
            </div>
        </form>
        <script language="javascript" src="js/global.js"></script>
    </body>
</html>