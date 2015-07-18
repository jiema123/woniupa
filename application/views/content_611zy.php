<!DOCTYPE HTML>

<head>

    <title><?php echo $title?></title>
    <meta name="keywords" content="create from keywords">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    

<!-- CSS Files -->

    <link rel="stylesheet" type="text/css" media="screen" href="webs/611zy/style.css">
    <link rel="stylesheet" type="text/css" media="screen" href="webs/611zy/simple_menu.css">
    <link rel="stylesheet" href="webs/611zy/prettyPhoto.css" type="text/css" media="screen"/>
    <link rel="stylesheet" href="webs/611zy/nivo-slider.css" type="text/css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="webs/611zy/style6.css" />

<!-- JS Files -->

	<script type="text/javascript" src="webs/611zy/js/jquery.min.js"></script>
    <script type="text/javascript" src="webs/611zy/js/events.js" /></script>

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
              <li><a href="index.php?c=index_611zy&m=blist&dq=<?php echo $val;?>"><?php echo $val;?></a></li> 
              <?php }?>
              </ol>
        </li><!-- END sub menu -->
        
              
        <li><a href="#">影片类型</a>
        
              <!-- sub menu -->
              <ol>     
              <?php foreach($fldy as $val){?>
              <li><a href="index.php?c=index_611zy&m=blist&fl=<?php echo $val;?>"><?php echo $val;?></a></li> 
              <?php }?>
              </ol>
        </li><!-- END sub menu -->
        <li><a href="index.php?c=index_611zy&m=index&new=true">今日更新</a>
        </li><!-- END sub menu -->           
    </ol>
    
    
    </div><!-- END header -->


    <div id="container">


<div class="two-third">

        <div class="coupon_content">
        
        
        <img title="" src="<?php echo str_replace($rootpath,'',$imgpath);?>" alt="" style="float:left; margin-right: 20px" />
        
        <h2 style="margin-top:0; margin-bottom:5px"><?php echo $title;?></h2>
        <div class="discount_value">15%</div>
        <small>更新日期：<?php if(date('Ymd',strtotime($itime))==date('Ymd')){echo '今天';}else{echo $itime;}?></small>
        
        <p><strong>Description:</strong> 
        		本站仅提供低品质影视欣赏方面的信息,电影版权归相关电影公司所有 本站数据采集自<a href='http://www.611zy.com'>611zy.com</a>!
        </p>
        
        <p style="font-weight:bold">影片类型： | <?php echo $fl;?> </p>
        <p style="font-weight:bold">影片地区： | <?php echo $dq;?> </p>
        
        <!-- PHP Coupong Code -->
            
          <div style="background: #690; color: #FFF; padding: 10px 10px 20px; margin-bottom: 5px; border-radius: 5px; text-align: center; font-weight: bold; float: right; width: 268px">
             <p>幸运数字: </p> <p style="font-size: 1.8em; padding-bottom: 20px">
             <?php // Generate a random number
			        echo mt_rand(2100, 2200); ?>
             </p>
          </div>
             
          <div style="margin-top: 15px; text-align:right">
          
       <!-- Share Buttons -->
       
        <div title="Like on Facebook"> 

        </div> 
     
        </div> <!-- END PHP Coupon Code -->
        
       <div style="clear:both"></div>
        </div> <!-- END Coupon content box -->
        
        
        <?php if($bt){?>
        <h2>种子地址</h2>
        <p><a href='<?php echo $bt;?>' target='_blank'><?php echo $bt;?></a></p>
        <?php }?>
        
        <?php if($vod){?>
        <p><?php echo $vod;?></p>   
         <h2>在线观看</h2>
         <div>
			<object classid="clsid:F3D0D36F-23F8-4682-A195-74C92B03D4AF" width="660px" height="480px" id="QvodPlayer" name="QvodPlayer" onerror="installqvod();">
			<param name="URL" value="<?php echo $vod;?>">
			<param name="Autoplay" value="-1">
			<param name="QvodAdUrl" value="http://www.qvod.com/">
			<embed url="<?php echo $vod;?>" width="660px" height="480px" type="application/qvod-plugin">
			</object>
		</div>
		<?php }?>
        
</div><!-- close two third -->


      <div class="sidebar_right">
      
      
	      <div class="coupon_seller_info">
				广告位
	      </div>
	      
	      
	      <div class="coupon_seller_info">
				广告位
	      </div>     
      
      
      
      </div><!-- end sidebar right -->
   
      <div style="clear:both; height: 40px"></div>
      
</div><!-- end container -->


    <div id="footer">

    <!-- Third Column -->
    
    <div class="one-fourth">
        <h3>声明</h3>
        本站特为除中国大陆以外华人设立，由于中国大陆法律限制，本站不允许任何中国大陆人士观看，传播。否则，后果自负！
        
        <div id="social_icons">
        注:本站仅提供低品质影视欣赏方面的信息,电影版权归相关电影公司所有!
        </div>
        
    </div>
    
    <div style="clear:both"></div>
    
    </div> <!-- END footer -->

</body>
</html>