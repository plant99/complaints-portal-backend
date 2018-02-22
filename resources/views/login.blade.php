<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="css/login.css">
</head>
<body>
<div id="login-page">
    <form class="form" method="POST" action="/user_login">
        <p id="toaster"></p>
        <input name="username" id="emailId" type="text" placeholder="email"/>
        <input name="password" id="password" type="password" placeholder="password"/>
        <button id="submit" type="submit">login</button>
    </form>
</div>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.form.js"></script>
<script type="text/javascript" src="js/slider.js"></script>
</body>
</html>

