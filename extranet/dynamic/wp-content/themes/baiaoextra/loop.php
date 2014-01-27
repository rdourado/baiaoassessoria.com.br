					<li class='post-item'>
						<a href='<?php the_permalink() ?>'>
							<?php the_post_thumbnail() ?>
							<h4 class='post-title'><?php the_title() ?></h4>
						</a>
						<p class='post-excerpt'><?php the_excerpt() ?></p>
						<a class='post-link u' href='<?php the_permalink() ?>'>Leia esse texto completo</a>
						<a class='post-comment-link u' href='<?php comments_link() ?>'><?php comments_number( 'Nenhum comentário', '1 comentário', '% comentários' ) ?></a>
					</li>
