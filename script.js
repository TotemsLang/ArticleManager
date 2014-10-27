
			var hid_timer;
			var move_timer;
			var op = 1;
			var hid_speed = 20;
			var move_speed = 1;
			var ex;
			var choosen;
			
			function init()
			{
				var i=0;
				for(i=0;i<count;i++)
				{
					makecontent(Name[i],Author[i],Content[i].substring(0,500),i,1);
				}
			}
			
			function makecontent(a,b,c,d,init)
			{
				c = c.replace(/ /g,"&nbsp");
				c = c.replace(/\n/g,"<br />");
				var show = "<div align='left'>";
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
				show += "</p></div>";

				var createDiv=document.createElement("div"); 
				createDiv.innerHTML = show;
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
				if(right_div.offsetLeft < speed)
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
					makecontent(Name[choosen],Author[choosen],Content[choosen],choosen,0);
					hid_timer = setInterval("unhid(unhid_detail);",hid_speed);
				}
			}
			
			function hid_move()
			{
				clearInterval(hid_timer);
				document.getElementById('right-info').style.overflowY = 'hidden';
				move_timer = setInterval('move(3)',move_speed);
			}

			 
			function showdetail(name){
				choosen = nameindex[name];
				hid_timer = setInterval("hid(hid_move);",hid_speed);
			}
			
			
	/////////////////////////////////////////////////////////////////	
	
			function move_back(speed)
			{
				var left_div = document.getElementById('left');
				var right_div = document.getElementById('right-info');
				if(right_div.offsetLeft > (405-speed))
					left_div.style.width  = 405;
				else
					left_div.style.width = right_div.offsetLeft + speed;

				if(left_div.style.width == '405px')
				{
					clearInterval(move_timer);
					document.getElementById('left').style.width = '30%';
					document.getElementById('right-info').style.overflowY = 'auto';
					document.getElementById('content').innerHTML = "";
					init();
					hid_timer = setInterval("unhid(unhid_detail);",hid_speed);
				}
			}
	
			function hid_back()
			{
				clearInterval(hid_timer);
				document.getElementById('left').style.display = 'block';
				document.getElementById('right-info').style.overflowY = 'hidden';
				document.getElementById('right-info').style.width = '70%';
				move_timer = setInterval('move_back(3)',move_speed);
			}
	
	
			function goback()
			{
				hid_timer = setInterval("hid(hid_back);",hid_speed);
			}