<?php require_once 'head.php';?>
       
<?php $date = date('Y-m-d')?>

		
<div class="main-container">
	<div class="main wrapper clearfix">
		<div class="column-one">
			<div id="posts" class="clearfix">
				<article id="post-117" class="post-117 post type-post status-publish format-standard hentry category-uncategorized clearfix box" role="article">

			
					<header>
						<h2 class="post-title"><a href="index.php?c=wnp_index_list&m=rq">人气动漫 >></a></h2>
					</header>

					
					<div id='gallery-1' class='gallery galleryid-117 gallery-columns-3 gallery-size-thumbnail'>
					<?php foreach($hotmanhua as $k => $row){?>
						<dl class='gallery-item'>
							<dt class='gallery-icon landscape'>
								<a  href='index.php?c=wnp_list&scroll=1&id=<?php echo $row['b_id'];?>' title='<?php echo $row['b_name'] .' | '. $row['b_status']?>'>
									<img width="150" height="150" src="index.php?c=wnp_img&url=<?php echo $row['b_coverlocalpath']?>" class="attachment-thumbnail" alt="people-q-c-1200-800-9" />
								</a>
							</dt>
						</dl>
					<?php }?>
						<br style='clear: both;' />
					</div>

					<div class="entry-content">
						<p>人气漫画，天天看看</p>
					</div>

					<div class="meta clearfix">
						<div class="icon icon-"></div>
						<span class="post-date"><?php echo $date?></span>
					</div>

			
				</article>

		
				<article id="post-117" class="post-117 post type-post status-publish format-standard hentry category-uncategorized clearfix box" role="article">

			
					<header>
						<h2 class="post-title"><a href="index.php?c=wnp_index_list&m=lz">连载动漫 >></a></h2>
					</header>

					
					<div id='gallery-1' class='gallery galleryid-117 gallery-columns-3 gallery-size-thumbnail'>
					<?php foreach($lzmanhua as $k => $row){?>
						<dl class='gallery-item'>
							<dt class='gallery-icon landscape'>
								<a  href='index.php?c=wnp_list&scroll=1&id=<?php echo $row['b_id'];?>' title='<?php echo $row['b_name'] .' | '. $row['b_status']?>' class='post-thumb-link'>
									
									<img width="150" height="150" src="index.php?c=wnp_img&url=<?php echo $row['b_coverlocalpath']?>" class="attachment-thumbnail" alt="people-q-c-1200-800-9" />
								</a>
							</dt>
						</dl>
					<?php }?>
						<br style='clear: both;' />
					</div>

					<div class="entry-content">
						<p>连载漫画有更新</p>
					</div>

					<div class="meta clearfix">
						<div class="icon icon-"></div>
						<span class="post-date"><?php echo $date?></span>
					</div>

			
				</article>
				

				<article id="post-114" class="post-114 post type-post status-publish format-status hentry category-uncategorized clearfix box" role="article">
					<h3>新闻公告</h3>
					<div class="entry-content">
						<p>test</p>
					</div>

					<div class="meta clearfix">
						<div class="icon icon-status"></div>
						<span class="post-date">23 Jan</span>
					</div>

			
				</article>

		
				<article id="post-117" class="post-117 post type-post status-publish format-standard hentry category-uncategorized clearfix box" role="article">

			
					<header>
						<h2 class="post-title"><a href="index.php?c=wnp_index_list&m=wj">完结动漫 >></a></h2>
					</header>

					
					<div id='gallery-1' class='gallery galleryid-117 gallery-columns-3 gallery-size-thumbnail'>
					<?php foreach($wjmanhua as $k => $row){?>
						<dl class='gallery-item'>
							<dt class='gallery-icon landscape'>
								<a  href='index.php?c=wnp_list&scroll=1&id=<?php echo $row['b_id'];?>' title='<?php echo $row['b_name'] .' | '. $row['b_status']?>' class='post-thumb-link'>
									
									<img width="150" height="150" src="index.php?c=wnp_img&url=<?php echo $row['b_coverlocalpath']?>" class="attachment-thumbnail" alt="people-q-c-1200-800-9" />
								</a>
							</dt>
						</dl>
					<?php }?>
						<br style='clear: both;' />
					</div>

					<div class="entry-content">
						<p>完结漫画经典就收藏吧</p>
					</div>

					<div class="meta clearfix">
						<div class="icon icon-"></div>
						<span class="post-date"><?php echo $date?></span>
					</div>

			
				</article>
				
				
				<article id="post-32" class="post-32 post type-post status-publish format-standard hentry category-category1 clearfix box" role="article">

					<a href="#"  class="post-thumb-link">
						<img width="320" height="320" src="images/people-q-c-1200-800-7-320x320.jpg" class="attachment-post-thumb wp-post-image" alt="people-q-c-1200-800-7" />
					</a>
					<header>
						<h2 class="post-title"><a href="#">Standard Post</a></h2>
					</header>


					<div class="entry-content">
						<p>Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Vestibulum id ligula porta felis euismod semper. Sed posuere consectetur est at lobortis. Cras mattis consectetur purus sit amet Cras mattis consectetur purus sit amet fermentum Donec sed odio dui Donec sed odio dui. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sed [&hellip;]</p>
					</div>

					<div class="meta clearfix">
						<div class="icon icon-"></div>
						<span class="post-date">22 Jan</span>
						<span class="post-comments">
								<a href="#" title="Comment on Standard Post">3</a>
						</span>
					</div>

			
				</article>

		

				<article id="post-30" class="post-30 post type-post status-publish format-audio hentry category-category2 tag-audio tag-hosted clearfix box" role="article">

			

					<div class="entry-audio">

						<script type="text/javascript">
							(function($) {
							  $(document).ready(function($){
							
							    if($().jPlayer) {
							      $("#jquery_jplayer_30").jPlayer({
							        ready: function () {
							          $(this).jPlayer("setMedia", {
							                        mp3: "http://demo.s5themes.com/shortnotes/files/2012/11/Miles_Davis-Freddie_Freeloader.mp3",
							                                    end: ""
							          });
							        },
							        size: {
							          width: "100%",
							          height: "auto",
							          cssClass: "jp-video-rP"
							        },
							        swfPath: "lib/jplayer",
							        cssSelectorAncestor: "#jp_interface_30",
							        supplied: "mp3,  all"
							      });
							    }
							  });
							})(jQuery);
						</script>

						<div id="jquery_jplayer_30" class="jp-jplayer jp-jplayer-audio"></div>
						<div class="jp-audio-container">
						      <div class="jp-audio">
						           <div class="jp-type-single">
						               <div id="jp_interface_30" class="jp-interface">
						                   <ul class="jp-controls">
						                    <li><div class="seperator-first"></div></li>
						                       <li><div class="seperator-second"></div></li>
						                       <li><a href="#" class="jp-play" tabindex="1">play</a></li>
						                       <li><a href="#" class="jp-pause" tabindex="1">pause</a></li>
						                       <li><a href="#" class="jp-mute" tabindex="1">mute</a></li>
						                       <li><a href="#" class="jp-unmute" tabindex="1">unmute</a></li>
						                   </ul>
						                   <div class="jp-progress-container">
						                       <div class="jp-progress">
						                           <div class="jp-seek-bar">
						                               <div class="jp-play-bar"></div>
						                           </div>
						                       </div>
						                   </div>
						                   <div class="jp-volume-bar-container">
						                       <div class="jp-volume-bar">
						                           <div class="jp-volume-bar-value"></div>
						                       </div>
						                   </div>
						               </div>
						           </div>
						       </div>
						</div>

				</div>

				<header>
					<h2 class="post-title"><a href="#">Miles Davis, Freddie Freeloader (self-hosted audio)</a></h2>
				</header>

				<div class="entry-content">
					<p>Some small description/details.</p>
				</div>

				<div class="meta clearfix">
					<div class="icon icon-audio"></div>
					<span class="post-date">22 Jan</span>
					<span class="post-comments">
							<a href="#" title="Comment on Miles Davis, Freddie Freeloader (self-hosted audio)">0</a>
					</span>
				</div>
			
			</article>

		

			<article id="post-27" class="post-27 post type-post status-publish format-standard hentry category-category1 tag-image tag-standard clearfix box" role="article">

				<a href="#"  class="post-thumb-link">
					<img width="320" height="320" src="images/people-q-c-1200-800-9-320x320.jpg" class="attachment-post-thumb wp-post-image" alt="people-q-c-1200-800-9" />
				</a>
				<header>
					<h2 class="post-title"><a href="#">Another standard post with gallery</a></h2>
				</header>


				<div id='gallery-2' class='gallery galleryid-27 gallery-columns-4 gallery-size-thumbnail'><dl class='gallery-item'>
					<dt class='gallery-icon landscape'>
						<a class="prettyPhoto[mixed]" href='/2013/01/23/gallery-post/people-q-c-1200-800-7/'><img width="150" height="150" src="images/people-q-c-1200-800-7-150x150.jpg" class="attachment-thumbnail" alt="people-q-c-1200-800-7" /></a>
					</dt></dl><dl class='gallery-item'>
					<dt class='gallery-icon landscape'>
						<a class="prettyPhoto[mixed]" href='/2013/01/23/gallery-post/people-q-c-1200-800-6/'><img width="150" height="150" src="images/people-q-c-1200-800-6-150x150.jpg" class="attachment-thumbnail" alt="people-q-c-1200-800-6" /></a>
					</dt></dl><dl class='gallery-item'>
					<dt class='gallery-icon landscape'>
						<a class="prettyPhoto[mixed]" href='/2013/01/23/gallery-post/fashion-q-c-1200-800-6/'><img width="150" height="150" src="images/fashion-q-c-1200-800-6-150x150.jpg" class="attachment-thumbnail" alt="fashion-q-c-1200-800-6" /></a>
					</dt></dl><dl class='gallery-item'>
					<dt class='gallery-icon landscape'>
						<a class="prettyPhoto[mixed]" href='/2013/01/23/gallery-post/nature-q-c-1200-800-6-2/'><img width="150" height="150" src="images/nature-q-c-1200-800-61-150x150.jpg" class="attachment-thumbnail" alt="nature-q-c-1200-800-6" /></a>
					</dt></dl><br style="clear: both" /><dl class='gallery-item'>
					<dt class='gallery-icon landscape'>
						<a class="prettyPhoto[mixed]" href='/2013/01/23/gallery-post/nature-q-c-1200-800-10/'><img width="150" height="150" src="images/nature-q-c-1200-800-10-150x150.jpg" class="attachment-thumbnail" alt="nature-q-c-1200-800-10" /></a>
					</dt></dl><dl class='gallery-item'>
					<dt class='gallery-icon landscape'>
						<a class="prettyPhoto[mixed]" href='/2013/01/23/gallery-post/nightlife-q-c-1200-800-2/'><img width="150" height="150" src="images/nightlife-q-c-1200-800-2-150x150.jpg" class="attachment-thumbnail" alt="nightlife-q-c-1200-800-2" /></a>
					</dt></dl><dl class='gallery-item'>
					<dt class='gallery-icon landscape'>
						<a class="prettyPhoto[mixed]" href='/2013/01/23/gallery-post/sports-q-c-1200-800-6/'><img width="150" height="150" src="images/sports-q-c-1200-800-6-150x150.jpg" class="attachment-thumbnail" alt="sports-q-c-1200-800-6" /></a>
					</dt></dl><dl class='gallery-item'>
					<dt class='gallery-icon landscape'>
						<a class="prettyPhoto[mixed]" href='/2013/01/23/gallery-post/sports-q-c-1200-800-7-2/'><img width="150" height="150" src="images/sports-q-c-1200-800-71-150x150.jpg" class="attachment-thumbnail" alt="sports-q-c-1200-800-7" /></a>
					</dt></dl><br style="clear: both" />
					<br style='clear: both;' />
						</div>

						<div class="entry-content">
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis cursus, ligula in eleifend dapibus, enim nunc elementum velit, eget viverra velit orci sit amet ipsum. Sed egestas justo a dolor fringilla ac laoreet lectus tincidunt. Quisque et felis sed metus congue porttitor. Morbi vel magna nisi, sit amet consequat sapien. Maecenas sodales tempus tempus. Vestibulum [&hellip;]</p>
						</div>

						<div class="meta clearfix">
							<div class="icon icon-"></div>
							<span class="post-date">22 Jan</span>
							<span class="post-comments">
									<a href="#" title="Comment on Another standard post with gallery">0</a>
							</span>
						</div>

					
					</article>

				

					<article id="post-25" class="post-25 post type-post status-publish format-video hentry category-category3 tag-felix tag-video clearfix box" role="article">
					


						<header>
							<h2 class="post-title"><a href="#">Felix Baumgartner�s supersonic freefall (video embed)</a></h2>
						</header>

						<div class="entry-content">
							<p>Video short description/details.</p>
						</div>

						<div class="meta clearfix">
							<div class="icon icon-video"></div>
							<span class="post-date">22 Jan</span>
							<span class="post-comments">
									<a href="#" title="Comment on Felix Baumgartner�s supersonic freefall (video embed)">0</a>
							</span>
						</div>
					
					</article>

				

					<article id="post-23" class="post-23 post type-post status-publish format-quote hentry category-category2 tag-quote clearfix box" role="article">

						<header>
							<h2 class="post-title"><a href="#">Quote</a></h2>
						</header>

						<div class="entry-quote">
							<blockquote>Elcvne commune elaboraret his, mea amet luptatum at. Modo aeterno propriae ius id. Viris definiebas reprehendunt ad eam. In mea melius commodo.</blockquote>
						
							<span class="quote-author">~ Albert Einstein ~</span>
						</div>

						<div class="entry-content">
							<p>Sed egestas justo a dolor fringilla ac laoreet lectus tincidunt.</p>
						</div>

						<div class="meta clearfix">
							<div class="icon icon-quote"></div>
							<span class="post-date">22 Jan</span>
							<span class="post-comments">
									<a href="#" title="Comment on Quote">0</a>
							</span>
						</div>
					
					</article>

				

					<article id="post-19" class="post-19 post type-post status-publish format-link hentry category-category3 tag-link tag- clearfix box" role="article">

						<header>
							<h2 class="post-title"><a href="#">Check out this link!</a></h2>
						</header>

						<div class="entry-link">
							<h3><a href="#">  Hosting</a></h3>
						</div>

						<div class="entry-content">
							<p>Some link description/details.</p>
						</div>

						<div class="meta clearfix">
							<div class="icon icon-link"></div>
							<span class="post-date">22 Jan</span>
							<span class="post-comments">
									<a href="#" title="Comment on Check out this link!">0</a>
							</span>
						</div>
					
					</article>

				

					<article id="post-69" class="post-69 post type-post status-publish format-aside hentry category-category3 tag-aside clearfix box" role="article">

						<div class="entry-content">
							<p>Small snippet of content, short thought to share with your readers etc.</p>
						</div>

						<div class="meta clearfix">
							<div class="icon icon-aside"></div>
							<span class="post-date">22 Jan</span>
							<span class="post-comments">
									<span>Comments Off</span>
							</span>
						</div>
					
					</article>

				

					<article id="post-12" class="post-12 post type-post status-publish format-image hentry category-category1 tag-image tag-landscape clearfix box" role="article">

					
						<div class="entry-image">
							
							<a class="prettyPhoto[mixed]" href="#"><img src="images/animals-q-c-1200-800-8-320x320.jpg"></a>	
						</div>

						<header>
							<h2 class="post-title"><a href="#">Image Post</a></h2>
							
						</header>


						<div class="entry-content">
							<p>Some content/description for the image post goes here.</p>
						</div>

						<div class="meta clearfix">
							<div class="icon icon-image"></div>
							<span class="post-date">22 Jan</span>
							<span class="post-comments">
									<a href="#" title="Comment on Image Post">0</a>
							</span>
						</div>
					
					</article>

				

					<article id="post-9" class="post-9 post type-post status-publish format-standard hentry category-category1 tag-standard clearfix box" role="article">

						<a href="#"  class="post-thumb-link">
							<img width="320" height="320" src="images/nature-q-c-1200-800-61-320x320.jpg" class="attachment-post-thumb wp-post-image" alt="nature-q-c-1200-800-6" />
						</a>
						<header>
							<h2 class="post-title"><a href="#">Standard Post</a></h2>
						</header>


						<div class="entry-content">
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis cursus, ligula in eleifend dapibus, enim nunc elementum velit, eget viverra velit orci sit amet ipsum. Sed egestas justo a dolor fringilla ac laoreet lectus tincidunt. Quisque et felis sed metus congue porttitor. Morbi vel magna nisi, sit amet consequat sapien. Maecenas sodales tempus tempus. Vestibulum [&hellip;]</p>
							<div class="page-links">Pages: 
								<a href="#">1</a>
								<a href="#">2</a>
								<a href="#">3</a>
								<a href="#">4</a>
							</div>
						</div>

						<div class="meta clearfix">
							<div class="icon icon-"></div>
							<span class="post-date">22 Jan</span>
							<span class="post-comments">
									<a href="#" title="Comment on Standard Post">0</a>
							</span>
						</div>

					
					</article>

				
				</div>
		</div>
	</div>
                
</div>



<?php require 'foot.php';?>