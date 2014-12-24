<?php
    header("Content-Type: text/html;charset=utf-8");
    if($_COOKIE["isLogin"] != '1')
    {
        echo "未登录!2秒后跳转到登陆页面";
        header("Refresh:2;url=login.php");
        die();
    }

    $username = $_COOKIE["username"];
    
    echo "Enter";
    if ($_FILES["file"]["error"] > 0)
    {
        echo "Error: ".$_FILES["file"]["error"]."<br />";
    }
    $filepath = "images/head-img/".$username.".".substr(strrchr($_FILES["file"]["type"], "/"), 1);
    if(!move_uploaded_file($_FILES["file"]["tmp_name"],$filepath))
    {
        die("Fail to move uploaded file!");
    }

?>

<html>
    <head>
        <script>
            parent.upload_success('<?php echo $username.".".substr(strrchr($_FILES["file"]["type"], "/"), 1) ?>');
        </script>
    </head>
    <body>
    </body>

</html>