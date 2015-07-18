
<?php require_once 'head.php';?>
	<div id='hd_title'>
		<?php echo $list_title;?>
	
	</div>
	<nav id="page-nav" style='display:none;'>  
	  <a href="index.php?c=wnp_list&scroll=1&page=1"></a>  
	</nav> 
	<div id="container">
	<?php foreach($list as $row){?>
	<div class='mh_list'>
			<a href="index.php?c=wnp_view&scroll=1&id=<?php echo $row['id'];?>" target='_blank' class="post-thumb-link">
				<img src="index.php?c=wnp_img&m=img&type=236&id=<?php echo $row['id'];?>" class="attachment-post-thumb wp-post-image" alt="<?php echo $row['name']?>" />
			</a>
			<div class="mh_title_box">
				<span class="mh_title"><?php echo $row['name'];?></span>
			</div>		
			
	</div>
	<?php }?>
	</div>
<?php require_once 'foot.php';?>