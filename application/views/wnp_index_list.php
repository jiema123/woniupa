<?php require_once 'head.php';?>

    
<?php $date = date('Y-m-d')?>
	<div id='hd_title'>
		<?php echo $list_title;?>
	
	</div>
	<div class='link'>
		<?php if(isset($link)){echo $link;}?>
	</div> 
	<div id="container">
	    
<?php if($_GET['m']=='all'){?>
	<nav id="page-nav" style='display:none;'>  
	  <a href="index.php?c=wnp_index_list&m=all&page=1"></a>  
	</nav> 
	<?php foreach($list as $k => $row){?>
		<div class ='box_all'>
			<a href="index.php?c=wnp_list&scroll=1&id=<?php echo $row['b_id'];?>" target='_blank' class="post-thumb-link">
				<img src="index.php?c=wnp_img&url=<?php echo $row['b_coverlocalpath']?>" class="attachment-post-thumb wp-post-image" alt="<?php echo $row['b_name']?>" />
			</a>
			<header>
				<h3 class="post-title">
					<a href="index.php?c=wnp_list&scroll=1&id=<?php echo $row['b_id'];?>" target='_blank' >
						<?php echo $row['b_name']?>
					</a>
					
					<p class='<?php if($row['b_status']=='连载中'){echo 'title-s';}else{echo 'title-e';}?>'>
						<?php echo $row['b_status']?>
					</p>
				</h3>
			</header>
			<div class="meta clearfix">
				<div class="icon icon-"></div>
				<span class="post-date"><?php echo date('Y-m-d',strtotime($row['b_mtime']));?></span>
			</div>		
		
		</div>
	<?php }?>
<?php }else{?>
<?php foreach($list as $k =>$row){?>
				<div class="box_list">

					<a href="index.php?c=wnp_list&scroll=1&id=<?php echo $row['b_id'];?>" target='_blank'  class="post-thumb-link">
						<img src="index.php?c=wnp_img&url=<?php echo $row['b_coverlocalpath']?>" class="attachment-post-thumb wp-post-image" alt="<?php echo $row['b_name']?>" />
					</a>
					<header>
						<h3 class="post-title">
							<a href="index.php?c=wnp_list&scroll=1&id=<?php echo $row['b_id'];?>" target='_blank' >
								<?php echo $row['b_name']?>
							</a>
							
							<p class='<?php if($row['b_status']=='连载中'){echo 'title-s';}else{echo 'title-e';}?>'>
								<?php echo $row['b_status']?>
								<p class='author'>作者：<?php echo $row['b_author'];?></p>
							</p>
						</h3>
					</header>


					<div class="entry-content">
						<p><?php echo $row['b_describe'];?></p>
					</div>

					<div class="meta clearfix">
						<div class="icon icon-"></div>
						<span class="post-date"><?php echo date('Y-m-d',strtotime($row['b_mtime']));?></span>
					</div>

			
				</div>
				
<?php }?>
<?php }?>	
	</div>
<br style='clear: both;' />			
<?php require 'foot.php';?>