<?php require_once 'head.php';?>
	<div id='hd_title'>
		<?php echo $list_title;?>
	
	</div>
	<nav id="page-nav" style='display:none;'>  
	  <a href="index.php?c=wnp_view&scroll=1&page=1"></a>  
	</nav> 
	<div id="container">
	<?php foreach($list as $row){?>
		<div class='mh_box'>
			<img src = 'index.php?c=wnp_img&m=img&iid=<?php echo $row['id'];?>'>
		</div>
	<?php }?>
	
	</div>
<?php require 'foot.php';?>