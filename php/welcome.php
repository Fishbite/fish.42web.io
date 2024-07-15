<?php
   include('session.php');
   include('config.php')
?>
<html>
<head>
   <title>Welcome </title>
</head>
<body>
   <h1>Welcome <?php echo $login_session; ?></h1>
   <p>DB Connnection: <?php echo DB_DATABASE; ?></p>
   <h2><a href = "logout.php">Sign Out</a></h2>
</body>
</html>