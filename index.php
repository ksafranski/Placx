<?php 

require_once('config.php');

// Logout
if(!empty($_GET['logout'])){ session_unset(); session_destroy(); session_start(); }

// Login
$p_fail = false;
if(isset($_POST['password'])){
    if(encPassword($_POST['password'])==$data->password){
        $_SESSION['placx'] = "1";
        header('location: index.php');
    }else{
        $p_fail = true;
    }
}

?>
<!doctype html>

<!--[if lte IE 8 ]><html lang="en" class="ie"><![endif]-->

<head>
    <meta charset="utf-8">
    <title>Placx</title>
    <!--[if lt IE 9]><script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js">IE7_PNG_SUFFIX=".png";</script><![endif]-->
    <!--[if gte IE 9]><style type="text/css">button,a{filter:none;}</style><![endif]-->
    <link rel="stylesheet" href="css/screen.css">
</head>

<body>

    <?php
    if(!isset($_SESSION['placx'])){
    ?>
    <div id="password">
        <form name="password" method="post" action="index.php">
            <?php if($p_fail==true){ ?><div id="p_fail">Incorrect!</div><?php } ?>
            <label>Password</label>
            <input autofocus="autofocus" id="p_field" type="password" name="password" />
            <button>Login</button>
        </form>
        <script src="js/jquery-1.6.2.min.js"></script>
        <script>
            $(function(){ $('#p_field').focus(); $('#p_fail').delay(1500).fadeOut(300); });
        </script>
    </div>
    </form>
    <?php
    }else{
    ?>
    <a id="settings" onclick="settings.load();"></a>
    <a id="logout" href="index.php?logout=true"></a>
    <div id="main"></div>  
    <div id="modal"></div>
    <div id="overlay"></div>

    <script src="js/jquery-1.6.2.min.js"></script>
    <script src="js/jquery-ui-1.8.18.min.js"></script>
    <script src="js/common.js"></script>
    <?php
    }
    ?>
</body>
</html>