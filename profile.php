<?php
    header("Content-Type: text/html;charset=utf-8");
    if($_COOKIE["isLogin"] != '1')
    {
        echo "未登录!2秒后跳转到登陆页面";
        header("Refresh:2;url=login.php");
        die();
    }

    $username = $_COOKIE["username"];
    $link = mysql_connect('localhost','root','root');
    if(!$link){
        die('Fail to connect database'.mysql_error());
    }

    mysql_select_db('article',$link) or die('Unable to use database bookdb: '.mysql_error());
    mysql_query("set names 'utf8'");

    $sqlfind =  "select * from user where Username = '".$username."'";
    $result = mysql_query($sqlfind);
    $row = mysql_fetch_row($result);
    $head_img = $row[4];


    $sqlfind =  "select * from book where Class = '".$username."'";
    $result = mysql_query($sqlfind);
    $art_count = 0;
    while($row = mysql_fetch_row($result))
    {
        $article_id[$art_count] = $row[6];
        $article_name[$art_count] = $row[0];
        $art_count = $art_count + 1;
    }

    $sqlfind =  "select * from class where User = '".$username."'";
    $result = mysql_query($sqlfind);
    $res_count = 0;
    while($row = mysql_fetch_row($result))
    {
        $class_id[$res_count] = $row[0];
        $class_name[$res_count] = $row[1];
        $class_type[$res_count] = $row[2];
        $res_count = $res_count + 1;
    }
    

?>

<html>
	<head>
	<meta charset="utf-8">
    <script src="scripts/md5.js"></script>
    <script src="scripts/profile.js"></script>
	<link href="css/profile.css" rel="stylesheet" type="text/css"/>
		<title>修改用户资料</title>
	</head>
	<body onload="javascript:init();">
        <div id="modify_profile" class="panel">
            <form id="img_submit" method="post" enctype="multipart/form-data" action="upload.php" target="ajax_frame_name">
                <div id="m_head_img" >
                    <img id="head_show" src="images/head-img/<?php echo $head_img ?>">
                    <input type="file" name="file" id="up_head_img" onchange="javascript:submit_head_img()">             
                </div>
            </form>
            
                <p>
                    <label for="oldpw">旧的密码：</label>
                    <input type="password" name="oldpw" id="oldpw">
                </p>

                <p>
                    <label for="newpw">新的密码：</label>
                    <input type="password" name="newpw" id="newpw">
                </p>
                <p>
                    <label for="surepw">确认密码：</label>
                    <input type="password" name="surepw" id="surepw">
                </p>
                <input type="text" name="head" id="newimg">
                <p>
                      <button type="button" onclick="javascript:to_modify();" class="login-button"></button>
                </p>
            
        </div>
        
        <div id="modify_class" class="panel">  
        <br>
        <h1>分类管理</h1>
        <table>
            <tr id="add_class">
                <td>
                    <p>添加一个新类</p>
                </td>
                <td>
                    <label for="add_parent">添加到：</label>
                </td>
                <td>
                    <span class="dropdown dropdown-dark">
                        <select id="add_parent" onchange="javascript:select(this);" class="dropdown-select">
                            <option value="-1">请选择一项</option>
                            <?php
                            for($i = 0; $i < $res_count; $i++)
                            {
                                echo "<option value=\"".$class_id[$i]."\">".$class_name[$i]."</option>";
                            }
                            ?>
                        </select>
                    </span>
                </td>
                <td>
                        
                    <label for="new_class">类名：</label>
                </td>
                <td>
                    <input type="text" name="new_class_name" id="new_class">
                </td>
                <td>
                    <button type="button" onclick="javascript:modify_new();" class="login-button">Login</button>
                </td>
                        
            </tr>
            
            <tr id="edit_class">
                <td>
                    <p>修改类名</p>
                </td>
                <td>
                    <label for="target_class">目标：</label>
                    </td>
                <td>
                    <span class="dropdown dropdown-dark">
                        <select id="target_class" onchange="javascript:select(this);" class="dropdown-select">
                            <option value="-1">请选择一项</option>
                            <?php
                                for($i = 0; $i < $res_count; $i++)
                                {
                                    echo "<option value=\"".$class_id[$i]."\">".$class_name[$i]."</option>";
                                }
                            ?>
                        </select>
                    </span>
                </td>
                <td>
                    <label for="new_name">新名称：</label>
                    </td>
                <td>
                    <input type="text" name="new_name" id="new_name">
                </td>
                <td>
                    <button type="button" onclick="javascript:modify_name();" class="login-button">Login</button>
                </td>
            </tr>
            
            <tr id="add_article">
                <td>
                    <p>向分类中添加文章</p>
                </td>
                <td>
                    <label for="add_ariticle_to_class">添加到：</label>
                </td>
                <td>
                    <span class="dropdown dropdown-dark">
                        <select id="add_ariticle_to_class" onchange="javascript:select_add(this);" class="dropdown-select">
                            <option value="-1">请选择一项</option>
                            <?php
                                for($i = 0; $i < $res_count; $i++)
                                {
                                    echo "<option value=\"".$class_id[$i]."\">".$class_name[$i]."</option>";
                                }
                            ?>  
                        </select>
                    </span>
                </td>
                <td>
                    <label for="ariticle_to_add">文章：</label>
                </td>
                <td>
                    <span class="dropdown dropdown-dark">
                        <select id="ariticle_to_add" onchange="javascript:select(this);" class="dropdown-select">
                            <option value="-1">请选择一项</option>
                            <?php
                                for($i = 0; $i < $art_count; $i++)
                                {
                                    echo "<option value=\"".$article_id[$i]."\">".$article_name[$i]."</option>";
                                }
                            ?>  
                        </select>
                    </span>
                </td>
                <td>
                    <button type="button" onclick="javascript:modify_add();" class="login-button">Login</button>
                </td>
            </tr>
            
            
            
            <?php
            /*
            <tr id="edit_class_parent">
                <td>
                    <p>修改父类型</p>
                </td>
                <td>
                    <label for="target_parent">目标父类：</label>
                    </td>
                <td>
                    <span class="dropdown dropdown-dark">
                        <select id="target_parent" onchange="javascript:select(this);" class="dropdown-select">
                            <option value="-1">请选择一项</option>
                            <?php
                                for($i = 0; $i < $res_count; $i++)
                                {
                                    echo "<option value=\"".$class_id[$i]."\">".$class_name[$i]."</option>";
                                }
                            ?>
                        </select>
                    </span>
                </td>
                <td>
                    <label for="old_class">类：</label>
                    </td>
                <td>
                    <span class="dropdown dropdown-dark">
                        <select id="old_class" onchange="javascript:select(this);" class="dropdown-select">
                            <option value="-1">请选择一项</option>
                            <?php
                                for($i = 0; $i < $res_count; $i++)
                                {
                                    echo "<option value=\"".$class_id[$i]."\">".$class_name[$i]."</option>";
                                }
                            ?>
                        </select>
                    </span>
                </td>
                <td>
                    <button type="button" onclick="javascript:modify_parent();" class="login-button">Login</button>
                </td>
            </tr>
            */?>
            
            <?php
                /*
                <tr id="delete_class">
                <td>
                    <p>删除一个分类</p>
                </td>
                <td>
                    <label for="del_class">要删除的类：</label>
                </td>
                <td>
                    <span class="dropdown dropdown-dark">
                        <select id="del_class" onchange="javascript:select(this);" class="dropdown-select">
                            <option value="-1">请选择一项</option>
                            <?php
                                for($i = 0; $i < $res_count; $i++)
                                {
                                    echo "<option value=\"".$class_id[$i]."\">".$class_name[$i]."</option>";
                                }
                            ?>
                        </select>
                    </span>
                </td>
                <td>
                </td>
                <td>
                </td>
                <td>
                    <button type="button" onclick="javascript:modify_del_class();" class="login-button">Login</button>
            </td>
            </tr>
            */
            ?>
            
            <tr id="delete_node">
                <td>
                    <p>删除一个类或文章</p>
                </td>
                <td>
                    <label for="del_p_class">目标父类：</label>
                </td>
                <td>
                    <span class="dropdown dropdown-dark">
                        <select id="del_p_class" onchange="javascript:select_del(this);" class="dropdown-select">
                            <option value="-1">请选择一项</option>
                            <?php
                                for($i = 0; $i < $res_count; $i++)
                                {
                                    echo "<option value=\"".$class_id[$i]."\">".$class_name[$i]."</option>";
                                }
                            ?>
                        </select>
                    </span>
                    </td>
                <td>
                    <label for="target_node">目标节点：</label>
                    </td>
                <td>
                    <span class="dropdown dropdown-dark">
                        <select id="target_node" onchange="javascript:select(this);" class="dropdown-select">
                            <option value="-1">请选择一项</option>
                        </select>
                    </span>
                    </td>
                <td>
                    <button type="button" onclick="javascript:modify_del_node();" class="login-button">Login</button>
                    </td>
            </tr>
        
            
        </table>
            
            
        </div>
        
        <div id="left" onclick="window.location.href = 'index.php';">
        </div>
        
        <div id="right" onclick="javascript:switch_panel();">
        </div>
		
        <iframe id="ajax_frame" name="ajax_frame_name">
        </iframe>
            
	</body>
</html>
