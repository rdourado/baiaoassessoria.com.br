<?php get_header() ?>
	<div class="header">
<?php 	while( have_posts() ) : the_post(); ?>
		<h1 class="header-title"><?php my_category() ?></h1>
	</div>
	<div class="body">
		<article class="content hentry">
			<h1 class="post-title entry-title"><?php the_title() ?></h1>
			<div class="post-content entry-content">
				<?php the_content(); ?>
			</div>
			<ul class="post-share">
				<li class="share-item share-fb">
					<div class="fb-like" data-href="<?php the_permalink() ?>" data-colorscheme="light" data-layout="button_count" data-action="like" data-show-faces="false" data-send="true"></div>
				</li>
				<li class="share-item share-tw">
					<a href="https://twitter.com/share" class="twitter-share-button" data-via="baiaoassessoria">Tweet</a>
				</li>
				<li class="share-item share-g1">
					<div class="g-plusone" data-size="medium"></div>
				</li>
				<li class="share-item share-in">
					<script src="//platform.linkedin.com/in.js" type="text/javascript">
					 lang: pt_BR
					</script>
					<script type="IN/Share" data-counter="right"></script>
				</li>
			</ul>
		</article>
<?php 	endwhile; ?>
<?php 	get_sidebar(); ?>
	</div>

	<!-- Facebook -->
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
	  var js, fjs = d.getElementsByTagName(s)[0];
	  if (d.getElementById(id)) return;
	  js = d.createElement(s); js.id = id;
	  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=537174072986192";
	  fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<!-- Twitter -->
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
	<!-- Google+ -->
	<script type="text/javascript">
	  window.___gcfg = {lang: 'pt-BR'};
	  (function() {
	    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
	    po.src = 'https://apis.google.com/js/plusone.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	  })();
	</script>

<?php get_footer() ?>