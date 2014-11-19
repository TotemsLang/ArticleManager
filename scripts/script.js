    var Title = new Array();
    var Author = new Array();
    var CTime = new Array();
    var Content = new Array();
    var Index = new Array();
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
    
    var show = "<div style=\"text-align:left\">";	
    show += "<h1 class='title'>";
    show += Title[i];
    show += "</h1><h3>";
    show += Author[i];
    show += "</h3>";
    show += "<footer><address>";
    show += "<p>";
    show += CTime[i];
    show += "&nbsp;&nbsp;";
    show += "<span onclick='javascript:edit(";
    show += i;
    show += ");'>";
    show += "编辑";
    show += "</span>";
    show += "&nbsp;&nbsp;";
    show += "<span onclick='javascript:del(";
    show += i;
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
    var show = "<div style=\"text-align:left\">";	
    show += "<h1 class='title'>";
    show += "<span  onclick=\"javascript:show_detail('"
    show += i;
    show += "')\">";
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
    show += "<span>";
    show += "评论";
    show += "</span>";
    show += "&nbsp;&nbsp;";
    show += "<span onclick='javascript:edit(";
    show += d;
    show += ");'>";
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