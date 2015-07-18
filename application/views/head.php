<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html lang="en-US" class="no-js"><!--<![endif]-->

<!-- head -->
	<head>
		<meta charset="utf-8">
		<!--[if IE]><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/><![endif]-->
		<title><?php echo $title?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<meta name="keywords" content="<?php echo $seo_keyword?>" />
		<meta name="description" content="<?php echo $seo_desc?>" />
	
		<!-- stylesheet -->
		
		<style type="text/css" media="all">
		
			/* Body Font face */
			body {
				   		font-family: 'Open Sans', serif;
		    }
		
			/* Headings Font face */
			h1,h2,.main article h1,.widget_footer .widget-title,h2.post-title,.site-title {
				   		font-family: 'Rancho', serif;
		    }
		
		   	/* Headings Font colors */
			h1,h2,h3,h4,h5,h6  {
				color:#A1B1B3;
			}
	
		
		</style>
			<!-- custom typography -->
	
	   
	
		<!-- wp_head -->
		<link rel='stylesheet' id='prettyphoto-css-css'  href='webs/wnp/lib/prettyphoto/css/prettyPhoto.css' type='text/css' media='all' />
		<link rel='stylesheet' id='superfish-css-css'  href='webs/wnp/lib/superfish/superfish.css' type='text/css' media='all' />
		<link rel='stylesheet' id='clippy-style-css'  href='webs/wnp/css/style.css' type='text/css' media='all' />
		<script type='text/javascript' src='webs/wnp/js/jquery-1.11.1.js'></script>
		<!-- wp_head -->
 		<script src="webs/wnp/js/jquery.masonry.min.js"></script> 
 		<script src ="webs/wnp/js/jquery.autocomplete.js"></script>
 		<script src="webs/wnp/js/jquery.infinitescroll.min.js"></script>    
	    <script type="text/javascript">
	    	
	        <?php if((isset($_GET['m']) && $_GET['m']=='all') || isset($_GET['scroll'])){?>
	        $(function(){ 
	        	var $container = $('#container');
		        var totalpage = <?php echo $totalpage;?>;//这里是从服务端得到总共分页数  
		        var readedpage = 1;//当前滚动到的页数  
		        readedpage++;  
		        if(totalpage>1){//如果总共只有一页，那就不需要滚动加载效果了  
		                 $("#page-nav a").attr("href","index.php?<?php echo $_SERVER['QUERY_STRING'];?>&page="+readedpage);//c=wnp_index_list&m=all
		                 $container.imagesLoaded(function(){  
		                     $container.masonry({ 
			                     	<?php if(isset($_GET['c']) && $_GET['c']=='wnp_view'){?>
			                     	itemSelector : '.mh_box',
			                     	<?php }elseif(isset($_GET['scroll'])){?> 
			                     	itemSelector : '.mh_list',
			                     	<?php }else{?>
				    	            itemSelector : '.box_all',
				    	            <?php }?>
				    	            gutterWidth : 15,
		                     });  
		                   });//这里参数可以为空，但必须要初始化masonry，否则后面会报找不到方法appended。
		                   
		                 $container.infinitescroll({  
		                     navSelector  : '#page-nav',    //指定page-nav  
		                     nextSelector : '#page-nav a',  // page-nav下一页的链接  
	                     	<?php if(isset($_GET['c']) && $_GET['c']=='wnp_view'){?>
	                     	itemSelector : '.mh_box',
	                     	<?php }elseif(isset($_GET['scroll'])){?> 
	                     	itemSelector : '.mh_list',
	                     	<?php }else{?>
		    	            itemSelector : '.box_all',
		    	            <?php }?>
		                     loading: {
			                      
		                         finishedMsg: '你也太厉害了库中已经见底了',  
		                         img: 'webs/wnp/img/loading.gif'  
		                       }
		                     },
		                     function( newElements ) {  
		                         var $newElems = $( newElements ).css({ opacity: 0 });  
		                         $newElems.imagesLoaded(function(){   
		                           $newElems.animate({ opacity: 1 });  
		                           $container.masonry('appended', $newElems, true);  
		                           readedpage++;//当前页滚动完后，定位到下一页  
		                           if(readedpage>totalpage){//如果滚动到超过最后一页，置成不要再滚动。  
		                                 $("#page-nav").remove();  
		                                 $container.infinitescroll({state:{isDone:true}});  
		                           }else{  
		                              //'#page-nav a置成下一页的值  
		                                $("#page-nav a").attr("href","index.php?<?php echo $_SERVER['QUERY_STRING'];?>&page="+readedpage);  
		                           } 
		                   		});
		                   });  
		        }  
	             
	          });           
	        <?php }else{?>
			$(function(){
				var $container = $('#container');
				$container.imagesLoaded( function(){
					$container.masonry({
					<?php if($_GET['c']!='wnp_list'){?>
					itemSelector : '.box_list',
					<?php }else{?>
					itemSelector : '.mh_list',
					<?php }?>
					gutterWidth : 15,
					//isAnimated: true,
					});
				});
			});
		    <?php }?>

             $(function(){

         		function formatItem(row) {
        			return row[0] + " (<strong>" + row[2] + "</strong>)";
        		}
        		function formatResult(row) {
        			return row[0].replace(/(<.+?>)/gi, '');
        		}
                 $("#keyword").autocomplete('index.php?c=wnp_index&m=search',{
	              		width: 300,
	            		multiple: true,
	            		matchContains: true,
	            		formatItem: formatItem,
	            		formatResult: formatResult
                     });

            	$("#click_bt").click(function(){
						var key = encodeURI($("#keyword").val());
						var url = 'index.php?c=wnp_index&m=showres&key='+key;
						if(key.length==0){
							alert('请输入要查找的内容!');
							}else{
							window.location.href = url;
							}
                	});
             });    

	    </script>
    
	</head>
	
	
<!-- head -->

	<body class="withsidebar sidebar-footer home blog">



		<div class="header-container">
           <header class="wrapper clearfix">
           	   <h1 class="site-title"><a href="index.php?c=wnp_index&m=index">WoNiuPa蜗牛爬</a></h1>
               
               <p class="site-description">爬一个漫画看看</p>

				<!-- search -->
				<div id='search'>
					<input id='keyword' type='text' placeholder='请输入您要查找的内容'>
					<div id='click_bt'>查 找</div>
				</div>
                <!-- .top-menu-container -->
		        <div class="top-menu-container">
			        <nav>
						<div id="top-menu">
							<ul id="menu-main-menu" class="sf-menu">
								<li id="menu-item-126" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-126">
									<a href="index.php?c=wnp_index&m=index" title='你有本事再点下我试试！'>返回首页</a>
								</li>
								<li id="menu-item-126" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-126">
									<a href="index.php?c=wnp_index_list&m=sj" title='你有本事再点下我试试！'>随机看看</a>
								</li>
								<li id="menu-item-128" class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-128">
									<a href="index.php?c=wnp_news&m=index">更新漫画</a>
								</li>
								<li id="menu-item-134" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-134">
									<a href="index.php?c=wnp_index_list&m=wj">完结漫画</a>
								</li>
								<li id="menu-item-134" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-134">
									<a href="index.php?c=wnp_index_list&m=lz">连载漫画</a>
								</li>								
								<li id="menu-item-134" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-134">
									<a href="index.php?c=wnp_index_list&m=all">全部漫画</a>
								</li>								
							</ul>
						</div>
					</nav>
				</div>
           </header>
        </div>
