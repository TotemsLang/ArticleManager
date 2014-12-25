    var Title = new Array();
    var Author = new Array();
    var CTime = new Array();
    var Content = new Array();
    var Index = new Array();
    var current_Index;
    var current_Class;
    var isNew;
    var length = 0;
    var buf;

//////////////////////////////////////////////////////////////
//                        AJAX                              //
//////////////////////////////////////////////////////////////
function get_article(method,value)
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
            get_data();
        }
    }
    
    xmlhttp.open("GET","getarticle.php?method="+method+"&value="+value,true);
    xmlhttp.send();
}

function get_data()
{
    var createDiv=document.createElement("div"); 
    var i;
    var ele;
    createDiv.innerHTML = buf;
    length = createDiv.childElementCount;
    for(i=0;i<length;i++)
    {
        ele = createDiv.children[i];
        Title[i] = ele.children[0].innerHTML;
        Author[i] = ele.children[1].innerHTML;
        CTime[i] = ele.children[2].innerHTML;
        Content[i] = ele.children[3].innerHTML;
        Index[i] = ele.children[4].innerHTML;
    }
    right_content_refresh();
    document.body.scrollTop= 0;
}
//////////////////////////////////////////////////////////////
//                      ShowDetail                          //
//////////////////////////////////////////////////////////////

function get_count_by_index(index)
{
    var i;
    for(i=0;i<length;i++)
    {
        if(Index[i] == index)
        {
            return i;
        }
    }
    return -1;
}

function show_detail(index)
{
    var i;
    i = get_count_by_index(index);
    if(i == -1)
    {
        alert("索引错误！");
        return;
    }
    document.getElementById('content').innerHTML= "";
    
    var show = "<div class=\"article_detail\" style=\"text-align:left\">";	
    show += "<h1 class='title'>";
    if(Title[i] == "")
        show += "无标题"
    else
        show += Title[i];
    show += "</h1><h3>";
    show += Author[i];
    show += "</h3>";
    show += "<footer><address>";
    show += "<p>";
    show += CTime[i];
    show += "&nbsp;&nbsp;";
    show += "<span onclick='javascript:edit(";
    show += index;
    show += ",0);'>";
    show += "编辑";
    show += "</span>";
    show += "&nbsp;&nbsp;";
    show += "<span onclick='javascript:del(";
    show += index;
    show += ");'>";
    show += "删除";
    show += "</span>";
    show += "</p>";
    show += "</address></footer>";
    show += "<p id='Content";
    show += i;
    show += "'>";
    show += Content[i];
    show += "</p>";
    show += "</div>";
    

    var createDiv=document.createElement("div"); 
    createDiv.innerHTML = show;
    document.getElementById('content').appendChild(createDiv);
    document.body.scrollTop= 0;
}

//////////////////////////////////////////////////////////////
//                       Refresh                            //
//////////////////////////////////////////////////////////////

function right_content_refresh()
{
    document.getElementById('content').innerHTML= "";
    var i=0;
    for(i = 0; i < length; i++)
    {
        makecontent(Title[i],Author[i],Content[i].substring(0,260)+"......",Index[i],CTime[i],Index[i],0);
    }
}

function makecontent(a,b,c,d,e,i,isdetail)
{
    var show = "<div class=\"article_list\" style=\"text-align:left\">";	
    show += "<h1 class='title'>";
    show += "<span  onclick=\"javascript:show_detail('"
    show += i;
    show += "')\">";
    if(a == "")
        show += "无标题"
    else
        show += a;
    show += "</span></h1><h3>";
    show += b;
    show += "</h3>";
    show += "<p id='Content";
    show += d;
    show += "'>";
    show += c;
    show += "</p>";
    show += "<footer><address>";
    show += "<p>";
    show += e;
    show += "&nbsp;&nbsp;";
    show += "<span onclick='javascript:edit(";
    show += d;
    show += ",0);'>";
    show += "编辑";
    show += "</span>";
    show += "&nbsp;&nbsp;";
    show += "<span onclick='javascript:del(";
    show += d;
    show += ");'>";
    show += "删除";
    show += "</span>";
    show += "</p>";
    show += "</address></footer>";
    show += "<p id=\"dot\" >..................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................................</p>";
    show += "</div>";
    
    var createDiv=document.createElement("div"); 
    createDiv.innerHTML = show;
    document.getElementById('content').appendChild(createDiv);
}


//////////////////////////////////////////////////////////////
//                         edit                             //
//////////////////////////////////////////////////////////////

function edit(Index,flag)
{
    var theEdit = document.getElementById('edit');
    var theShadow = document.getElementById('shadow');
    var theFrame = document.getElementById('editorWidgIframe');
    isNew = flag;
    current_Index = Index;
    theShadow.style.zIndex = 1;
    theShadow.style.opacity = 1;
    theEdit.style.zIndex = 2;
    theEdit.style.opacity = 1;
    theFrame.contentWindow.document.body.innerHTML = Content[get_count_by_index(Index)];
    document.getElementById('InputTitle').value = Title[get_count_by_index(Index)];
    document.getElementById('InputAuthor').value = Author[get_count_by_index(Index)];
    
}

function back()
{
    var theEdit = document.getElementById('edit');
    var theShadow = document.getElementById('shadow');
    
    isNew = -1;
    current_Index = -1;
    theShadow.style.opacity = 0;
    theEdit.style.opacity = 0;

    setTimeout(function(){
        document.getElementById('edit').style.zIndex = -1;
        document.getElementById('shadow').style.zIndex = -1;
    },1000);
}

function save(Index)
{
    var postcontent = document.getElementById('editorWidgIframe').contentWindow.document.body.innerHTML;
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
            alert(buf);
            if(isNew == 0)
                get_article(2,current_Class);
            else if(isNew == 1)
                get_article(-1,-1);
            back();
        }
    }

    xmlhttp.open("POST","edit.php?title="+document.getElementById('InputTitle').value+"&author="+document.getElementById('InputAuthor').value+"&index="+Index+"&isnew="+isNew,true);
    xmlhttp.setRequestHeader('Content-type', 'text/plain');  
    xmlhttp.send(postcontent); 
}


function del(Index)
{
    if(!confirm('确定删除?'))
        return;
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
            alert(buf);
            if(current_Class != -1)
                get_article(2,current_Class);
            back();
        }
    }

    xmlhttp.open("GET","delete.php?index="+Index,true);
    xmlhttp.send(); 
}


//////////////////////////////////////////////////////////////
//                         class                            //
//////////////////////////////////////////////////////////////


function select(select)
{
    var index = (parseInt(select.id[5]) + 1);
    current_Class = select.value;
    if(select.selectedIndex == '0')
    {
        update_class(index-1)
        return;
    }
    else
    {
        get_article(2,select.value);
        update_class(index-1);
    }
    
}

function update_class(current)
{
    var select_class = new Array(document.getElementById('class0'),document.getElementById('class1'),document.getElementById('class2')) ;
    var i = 0;
    for(i = current + 1; i < 3; i++)
    {
        clear_select(select_class[i]);
    }
    if(current != 2)
    {
        if(select_class[current].selectedIndex == 0 || select_class[current].selectedIndex == 1)
        {
            return;
        }
        make_select(select_class[current].value,select_class[current+1]);
        select_class[current+1].value = '-1';
    }
    
}

function make_select(Index,select)
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
            if(buf)
            {
                select.innerHTML += buf;
            }
        }
    }

    xmlhttp.open("GET","getclass.php?index="+Index,true);
    xmlhttp.send(); 
}

function clear_select(select)
{
    if(!select)
        return;
    var default_node = select.children[0];
    select.innerHTML = "";
    select.appendChild(default_node);
}




//////////////////////////////////////////////////////////////
//                        profile                           //
//////////////////////////////////////////////////////////////


function profile()
{
    window.location.href = "profile.php";
}


