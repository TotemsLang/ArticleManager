
			var hid_timer;
			var move_timer;
			var op = 1;
			var hid_speed = 20;
			var move_speed = 3;
			var ex;
			var choosen;
			var leftwidth;
			var leftpx;
			var buf;
			
			function init()
			{
				document.getElementById('content').innerHTML= "";
				var i=0;
				for(i=0;i<count;i++)
				{
					makecontent(Name[i],Author[i],Content[i].substring(0,250) + "......",Index[i],CTime[i],1);
				}
			}
			
			function makecontent(a,b,c,d,e,init)
			{
				c = c.replace(/ /g,"&nbsp");
				c = c.replace(/\n/g,"<br />");
				var show = "<div style=\"text-align:left\">";
				if(init == 1)
				{	
					show += "<h1 class='title' onclick=\"javascript:showdetail('";
					show += a;
					show += "')\">";
					show += a;
					show += "</h1><h3>";
				}
				else
				{
					show += "<p id='back' onclick='javascript:goback();'>返回</p>"
					show += "<h1>";
					show += a;
					show += "</h1><h3>";
				}
				
				show += b;
				show += "</h3><p ";
				show += "id='Content";
				show += d;
				show += "'>";
				show += c;
				show += "</p>";
				
				if(init == 1)
				{
					show += "<footer><address>";
					show += "<p>";
					show += "<span>";
					show += e;
					show += "</span>";
					show += "<span>";
					show += " 评论 ";
					show += "</span>";
					show += "<span onclick='javascript:edit(";
					show += d;
					show += ");'>";
					show += " 编辑 ";
					show += "</span>";
					show += "<span onclick='javascript:del(";
					show += d;
					show += ");'>";
					show += " 删除 ";
					show += "</span>";
					show += "</p>";
					show += "</address></footer>";
				}
				
				show += "<input name='index' value='";
				show += d;
				show += "' style='display:none'>";
				show += "<br />"
				
				show += "</div>";

				var createDiv=document.createElement("div"); 
				createDiv.innerHTML = show;
				createDiv.style.clear = 'both';
				document.getElementById('content').appendChild(createDiv);
				
			}
			
			function unhid(next){
				var dist= document.getElementById('left-info');
				var dist1= document.getElementById('content');
				dist1.style.opacity = op + 0.1;
				dist.style.opacity = op + 0.1;
				op = op + 0.1;
				if(op >= 1)
				{
						next();
				}
			}
			
			
			
	/////////////////////////////////////////////////////////////////		
			
			function hid(next){
				var dist= document.getElementById('left-info');
				var dist1= document.getElementById('content');
				dist1.style.opacity = op - 0.1;
				dist.style.opacity = op - 0.1;
				op = op - 0.1;
				if(op <= 0)
				{
						next();
				}
			}
			
			function unhid_detail()
			{
				clearInterval(hid_timer);
			}
			
			function move(speed)
			{
				var left_div = document.getElementById('left');
				var right_div = document.getElementById('right-info');
				if(right_div.offsetLeft <= speed)
					left_div.style.width  = 0;
				else
					left_div.style.width = right_div.offsetLeft - speed;

				if( left_div.style.width == '0px')
				{
					clearInterval(move_timer);
					document.getElementById('left').style.display = 'none';
					document.getElementById('right-info').style.width = '100%';
					document.getElementById('right-info').scrollTop= 0;
					document.getElementById('right-info').style.overflowY = 'auto';
					document.getElementById('content').innerHTML = "";
					makecontent(Name[choosen],Author[choosen],Content[choosen],Index[choosen],CTime[choosen],0);
					hid_timer = setInterval("unhid(unhid_detail);",hid_speed);
				}
			}

			function hid_move()
			{
				clearInterval(hid_timer);
				document.getElementById('right-info').style.overflowY = 'hidden';
				document.getElementById('guide').style.display = 'none';
				move_timer = setInterval('move(5)',move_speed);
			}
			 
			function showdetail(name){
				choosen = nameindex[name];
				leftwidth = document.getElementById('right-info').offsetLeft;
				leftpx = leftwidth.toString() + 'px';
				hid_timer = setInterval("hid(hid_move);",hid_speed);
			}
			
			
	/////////////////////////////////////////////////////////////////	
	
			function move_back(speed)
			{
				var left_div = document.getElementById('left');
				var right_div = document.getElementById('right-info');
				if(right_div.offsetLeft >= (leftwidth-speed))
					left_div.style.width  = leftwidth;
				else
					left_div.style.width = right_div.offsetLeft + speed;

				if(left_div.style.width == leftpx)
				{
					clearInterval(move_timer);
					document.getElementById('left').style.width = '30%';
					document.getElementById('right-info').style.overflowY = 'auto';
					document.getElementById('content').innerHTML = "";
					init();
					document.getElementById('guide').style.display = 'block';
					hid_timer = setInterval("unhid(unhid_detail);",hid_speed);
				}
			}
	
			function hid_back()
			{
				clearInterval(hid_timer);
				document.getElementById('left').style.display = 'block';
				document.getElementById('right-info').style.overflowY = 'hidden';
				document.getElementById('right-info').style.width = '70%';
				move_timer = setInterval('move_back(5)',move_speed);
			}
	
	
			function goback()
			{
				hid_timer = setInterval("hid(hid_back);",hid_speed);
			}
			
		/////////////////////////////////////////////////////////////////////////////////////
		
		
			function updateContent(section,value)
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
							handleContent();
						}
				}
				
				xmlhttp.open("GET","GetContent.php?class="+section+"&value="+value,true);
				xmlhttp.send();
			}
			
			function handleContent()
			{
				var createDiv=document.createElement("div"); 
				var i;
				var ele;
				createDiv.innerHTML = buf;
				count = createDiv.childElementCount;
				for(i=0;i<count;i++)
				{
					ele = createDiv.children[i];
					Name[i] = ele.children[0].innerHTML;
					nameindex[Name[i]] = i;
					Author[i] = ele.children[1].innerHTML;
					CTime[i] = ele.children[2].innerHTML;
					Content[i] = ele.children[3].innerHTML;
					Index[i] = ele.children[4].innerHTML;
				}
				init();
				document.getElementById('right-info').scrollTop= 0;
				if(document.getElementById('content').childElementCount == 0)
				{
					alert("没有找到相应的条目");
				}
			}
		////////////////////////////////////////////////////////////////////////////////////////////
			function edit(index){
				window.location.href = "edit.php?action=edit&index="+index;
			}
			
			function del(index){
				window.location.href = "delete.php?index="+index;
			}
		
		
		
		