<!DOCTYPE HTML>

<head>

    <title>ACC 电影资源网</title>
    <meta name="keywords" content="create from keywords">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
<!-- Google Fonts -->

    <!--link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'-->

<!-- CSS Files -->

    <link rel="stylesheet" type="text/css" media="screen" href="webs/611zy/style.css">
    <link rel="stylesheet" type="text/css" media="screen" href="webs/611zy/simple_menu.css">
  
<!-- JS Files -->

    <script type="text/javascript" src="webs/611zy/js/jquery.min.js"></script>
    
    <!-- Masonry -->
    
	<script src="webs/611zy/js/jquery.masonry.min.js"></script>
    
    <script>
      $(function(){
    
        var $container = $('#container');
      
        $container.imagesLoaded( function(){
          $container.masonry({
            itemSelector : '.box',
			isFitWidth: true,
			isAnimated: true
          });
        });
      
      });
    </script>
    


</head>

<body>

    <div class="header">
    
    <div id="site_title"><a href="index.php?c=index_611zy&m=index">ACC 电影资源网</a></div>


    <!-- Main Menu -->
    <ol id="menu">
             <li class="active_menu_item"><a href="index.php?c=index_611zy&m=index">首页</a>
        
              </li><!-- END sub menu -->
        
        <li><a href="#">影片地区</a>
        
              <!-- sub menu -->
              <ol>
              <?php foreach($dqdy as $val){?>
              <li><a href="index.php?c=index_611zy&m=blist&dq=<?php echo urlencode($val);?>"><?php echo $val;?></a></li> 
              <?php }?>
              </ol>
        </li><!-- END sub menu -->
        
              
        <li><a href="#">影片类型</a>
        
              <!-- sub menu -->
              <ol>     
              <?php foreach($fldy as $val){?>
              <li><a href="index.php?c=index_611zy&m=blist&fl=<?php echo urlencode($val);?>"><?php echo $val;?></a></li> 
              <?php }?>
              </ol>
        </li><!-- END sub menu -->
        <li><a href="index.php?c=index_611zy&m=index&new=true">今日更新</a>
        </li><!-- END sub menu -->        

    </ol>
    
    
    </div><!-- END header -->
    
    <div class='page_links'>
    	<?php echo $page_link;?>
    </div>
    
    <div id="container" style="background-color: rgba(0,0,0,0.2);">

	<?php foreach($result as $k=>$sarr){?>

    <div class="box photo col3">
    <div class="discount_value">15%</div>
      <a target='_blank' href="index.php?c=index_611zy&m=content&id=<?php echo $sarr['id']?>" title="<?php echo $sarr['title'];?>"><img src="<?php echo str_replace($rootpath,'',$sarr['imgpath']);?>" alt="<?php echo$sarr['title'];?>" /></a>
      <h3><?php echo $sarr['title']?></h3>
    </div>
    <?php }?>


    <div style="clear:both; height: 40px"></div>
    </div>

    <!-- END container -->
    
    <div class='page_links'>
    	<?php echo $page_link;?>
    </div>
    <div id="footer">

    <!-- First Column -->

    <!-- div class="one-fourth">
        <h3>友情链接</h3>
            <ul class="footer_links">
                <li><a href="#">#</a></li>
                <li><a href="#">#</a></li>
                <li><a href="#">#</a></li>
                <li><a href="#">#</a></li>
            </ul>
    </div-->
    
    <!-- Second Column -->
    
    <!--div class="one-fourth">
        <h3>Terms</h3>
            <ul class="footer_links">
                <li><a href="#">Lorem Ipsum</a></li>
                <li><a href="#">Ellem Ciet</a></li>
                <li><a href="#">Currivitas</a></li>
                <li><a href="#">Salim Aritu</a></li>
            </ul>
    </div-->
    
    <!-- Third Column -->
    
    <div class="one-fourth">
        <h3>声明</h3>
        本站特为除中国大陆以外华人设立，由于中国大陆法律限制，本站不允许任何中国大陆人士观看，传播。否则，后果自负！
        
        <div id="social_icons">
        注:本站仅提供低品质影视欣赏方面的信息,电影版权归相关电影公司所有!
        </div>
        
    </div>
    
    <!-- Fourth Column -->
    
    <!--div class="one-fourth last">
        <h3> </h3>
            <img src="img/icon_fb.png" alt="Facebook">
            <img src="img/icon_twitter.png" alt="Facebook">
            <img src="img/icon_in.png" alt="Facebook">
    </div-->

    <div style="clear:both"></div>
    
    </div> <!-- END footer -->



<div style="display:none"><script src="http://v1.cnzz.com/z_stat.php?id=1000419013&web_id=1000419013" language="JavaScript"></script></div>
</body>
</html>