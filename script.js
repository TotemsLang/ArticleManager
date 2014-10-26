
			var timer;
			var timer1;
			var op;
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
			
			function unmove(a){
				var move2 = document.getElementById('right-info');
				var move1 = document.getElementById('left');
				move1.style.width = move2.offsetLeft + a;
				
				move2.style.width =  ex - a;
				ex  = ex - a;
				
				if(move1.style.width == '400px')
				{
					clearInterval(timer);
					move1.style.width = '30%';
					move2.style.width = '70%';
					move2.style.overflowY = 'auto';
					document.getElementById('content').innerHTML = "";
					init();
				}
			}
			
			function move(a){
				var move2 = document.getElementById('right-info');
				var move1 = document.getElementById('left');
				move1.style.width = move2.offsetLeft - a;
				
				move2.style.width =  ex + a;
				ex  = ex + a;
				
				if(move1.style.width == '0px')
				{
					clearInterval(timer);
					document.getElementById('right-info').style.width = '100%';
					document.getElementById('right-info').style.overflowY = 'auto';
					makecontent(Name[choosen],Author[choosen],Content[choosen],choosen,0);
				}

			}
			
			function startmove()
			{
					var dist1= document.getElementById('content');
					dist1.innerHTML = "";
					dist1.style.opacity = 1;
					clearInterval(timer1);
					ex = window.screen.availWidth * 0.698;
					document.getElementById('right-info').style.overflowY = 'hidden';
					timer = setInterval('move(5)',5);
			}
			function startunmove()
			{
				document.getElementById('right-info').style.overflowY = 'hidden';
				timer = setInterval('unmove(5)',5);
			}
			
			function back()
			{
				op = 1;
				timer1 = setInterval("hid(startunmove);",20);
				
			}
			
			 
			function showdetail(name){
				choosen = nameindex[name];
				op = 1;
				timer1 = setInterval("hid(startmove);",20);
			}
