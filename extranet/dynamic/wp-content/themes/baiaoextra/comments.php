					<section id="comments" class="comments-area">
<?php 					if ( have_comments() ) : ?>
						<h2 class="comments-title"><?php comments_number( 'Comente essa publicação', '1 comentário sobre essa publicação', '% comentários sobre essa publicação' ) ?></h2>
						<ol class="comment-list">
							<?php
							wp_list_comments( array(
								'callback' 	  => 'my_theme_comment',
								'reply_text'  => 'Responder esse usuário',
								'style'       => 'ol',
								'format' 	  => 'html5',
								'short_ping'  => true,
							) );
							?>
						</ol>
<?php 					endif; ?>
<?php 					my_comment_form(); ?>
					</section>
