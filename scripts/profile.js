var upload = 0;
var headimg;
var panel = new Array();
var current;
var buf;




function init()
{
    document.getElementById('up_head_img').style.left = document.getElementById('head_show').offsetLeft;
    document.getElementById('right').style.left = document.getElementById('right').offsetLeft - 50;
    current = 1;
    panel[0] = document.getElementById('modify_profile');
    panel[1] = document.getElementById('modify_class');
    panel[1].style.display = 'block';
    panel[1].style.opacity = 1;
    panel[0].style.display = 'none';
    panel[0].style.opacity = 0;
    
    
}

function show_panel(e)
{
    if(e == 0)
    {
        f = 1;
    }
    else
    {
        f = 0;
    }
    panel[e].style.display = 'none';
    panel[f].style.display = 'block';
    panel[f].style.opacity = 1;
}

function switch_panel()
{
    if(current)
    {
        current = 0;
        panel[1].style.opacity = 0;
        setTimeout("show_panel(1)",500)
    }
    else
    {
        current = 1;
        panel[0].style.opacity = 0;
        setTimeout("show_panel(0)",500)
    }
}

function submit_head_img()
{
    document.getElementById('img_submit').submit(); 
}

function upload_success(path)
{
    headimg = path;
    document.getElementById('newimg').value = path;
    document.getElementById('head_show').src = "images/head-img/" + path;
}

function to_modify()
{
    var oldpw = document.getElementById('oldpw').value; 
    var newpw = document.getElementById('newpw').value; 
    var surepw = document.getElementById('surepw').value; 
    var headimg = document.getElementById('newimg').value;
    if(oldpw == "" | newpw == "" | surepw == "")
    {
        alert('输入不能为空！');
        return;
    }
    if(newpw != surepw)
    {
        alert('两次输入密码一致，请检查！');
        return;
    }
    ajax_modify(oldpw,newpw,headimg);
}

function ajax_modify(oldpw,newpw,headimg)
{
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            buf = xmlhttp.responseText;
            if(buf == "OK")
            {
                alert("修改成功！");
                window.location.href='login.php';
            }
            else
            {
                alert("修改失败："+buf);
            }
        }
    }
    
    xmlhttp.open("GET","modify.php?oldpw="+oldpw+"&newpw="+newpw+"&headimg="+headimg,true);
    xmlhttp.send();
}

function select_del_tar(select)
{
    
}

function select_del(select)
{
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            var default_node = document.getElementById('target_node').children[0];
            document.getElementById('target_node').innerHTML = "";
            document.getElementById('target_node').appendChild(default_node);
            buf = xmlhttp.responseText;
            if(buf == "")
                return;
            var info = buf.split("&");
            var show = info[0].split("|");
            var book = info[1].split("|");
            var i;
            
            for(i=0;i<show.length;i++)
            {
                var section = document.createElement("option");
                var name = show[i].split(",")[0];
                var id = show[i].split(",")[1];
                section.value = id;
                section.innerHTML = name;
                document.getElementById('target_node').appendChild(section);
            }
            
            var section = document.createElement("option");
            section.value = -1;
            section.innerHTML = "------------------------------";
            document.getElementById('target_node').appendChild(section);
            document.getElementById('target_node').name = show.length + 1;
            
            for(i=0;i<book.length;i++)
            {
                var section = document.createElement("option");
                var name = book[i].split(",")[0];
                var id = book[i].split(",")[1];
                section.value = id;
                section.innerHTML = name;
                section.name = "book";
                document.getElementById('target_node').appendChild(section);
            }
        
        }
    }
    
    xmlhttp.open("GET","getlist.php?method=del_node&index="+select.value,true);
    xmlhttp.send();
}

function modify_name()
{
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            buf = xmlhttp.responseText;
            if(buf == "")
            {
                alert("修改成功！");
                location.reload();
            }
            else
            {
                alert("修改失败: " + buf);
            }
        }
    }
    
    xmlhttp.open("GET","classmgr.php?method=change_name&param1="+document.getElementById('target_class').value+"&param2="+document.getElementById('new_name').value,true);
    xmlhttp.send();
}


function modify_add()
{
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            buf = xmlhttp.responseText;
            if(buf == "")
            {
                alert("修改成功！");
                location.reload();
            }
            else
            {
                alert("修改失败: " + buf);
            }
        }
    }
    
    xmlhttp.open("GET","classmgr.php?method=add_article&param1="+document.getElementById('add_ariticle_to_class').value+"&param2="+document.getElementById('ariticle_to_add').value,true);
    xmlhttp.send();
}


function modify_new(){
    var xmlhttp;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            buf = xmlhttp.responseText;
            if(buf == "")
            {
                alert("添加成功！");
                location.reload();
            }
            else
            {
                alert("添加失败: " + buf);
            }
        }
    }
    
    xmlhttp.open("GET","classmgr.php?method=add_class&param1="+document.getElementById('add_parent').value+"&param2="+document.getElementById('new_class').value,true);
    xmlhttp.send();
}

function modify_del_node(){
    var xmlhttp;
    var isbook;
    if (window.XMLHttpRequest)
    {// code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    }
    else
    {// code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            buf = xmlhttp.responseText;
            if(buf == "")
            {
                alert("删除成功！");
                location.reload();
            }
            else
            {
                alert("删除失败: " + buf);
            }
        }
    }
    if(document.getElementById('target_node').selectedIndex >= parseInt(document.getElementById('target_node').name))
    {
        isbook = "book";
    }
    else
    {
        isbook = "node";
    }
    xmlhttp.open("GET","classmgr.php?method=del_node&param1="+document.getElementById('del_p_class').value+"&param2="+document.getElementById('target_node').value+"&param3="+isbook,true);
    xmlhttp.send();
}

function select_add(select)
{
    
}
























