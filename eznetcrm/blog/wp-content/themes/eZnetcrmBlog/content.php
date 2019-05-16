<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
		<div class="featured-post">
			<?php _e( 'Featured post', 'twentytwelve' ); ?>
		</div>
		<?php endif; ?>
                     			
              <?php if (has_post_thumbnail( $post->ID ) ): ?>
             <div class="postPic">
		<div class="imgBorder mb15">
		<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' ); ?>

		     <a href="<?php the_permalink(); ?>" class="post-thumbnail">
			<img alt="" class="twentytwelve-full-width-img" title="<?php the_title(); ?>" alt="<?php the_title(); ?>" src="<?php echo $image[0]; ?>">
		     </a>
                </div>  
		
	       </div>
		<?php endif; ?>
          <div id="main_blog">

              <div class="postMeta blog_main">
		    <div class="postDate">
			    <span class="dateDay"><?php the_time('j'); ?></span>
			    <span class="dateMonth"><?php the_time('F'); ?></span>
			    <span class="dateMonth"><?php the_time('Y'); ?></span>
		    </div>
		   
	      </div>

             <div class="blog_content_main">
		<?php if ( is_single() ) : ?>
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php else : ?>
			<h1 class="entry-title">
				<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>"><?php the_title(); ?></a>
			</h1>
		<?php endif; // is_single() ?>

                  <ul class="entry-meta">
                       
                  <?php the_category(', '); ?>

                   <li class="sep-meta"> | </li> 

			<li class="entry-author">
		            <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
				<?php printf( __( '%s', 'twentytwelve' ), get_the_author() ); ?></a>
		        </li>
                     <li class="sep-meta"> | </li>  

                        <li class="entry-comments">
                          <span class="icon-comment-1"><?php if ( comments_open() ) : ?>
				<div class="comments-link">
					<?php comments_popup_link( '<span class="leave-reply">' . __( '0 Comment', 'twentytwelve' ) . '</span>', __( '1 Comment', 'twentytwelve' ), __( '% Replies', 'twentytwelve' ) ); ?>
				</div><!-- .comments-link -->
			<?php endif; // comments_open() ?></span></li>
                                   
                      

        	</ul>

              <?php if ( is_search() ) : // Only display Excerpts for Search ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
		<?php else : ?>
		<div class="entry-content">
                     <?php if ( is_single() ) : ?> <?php the_content(); ?> <?php else : ?><p><?php the_excerpt(); ?></p><?php endif; ?>
			<?php// the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentytwelve' ) ); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'twentytwelve' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		<?php endif; ?>

	     </div>
	</div>	

		

		

		<?php /*?><footer class="entry-meta">
			<?php twentytwelve_entry_meta(); ?>
			<?php edit_post_link( __( 'Edit', 'twentytwelve' ), '<span class="edit-link">', '</span>' ); ?>
			<?php if ( is_singular() && get_the_author_meta( 'description' ) && is_multi_author() ) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries. ?>
				<div class="author-info">
					<div class="author-avatar">
						<?php
						/** This filter is documented in author.php 
						$author_bio_avatar_size = apply_filters( 'twentytwelve_author_bio_avatar_size', 68 );
						echo get_avatar( get_the_author_meta( 'user_email' ), $author_bio_avatar_size );
						?>
					</div><!-- .author-avatar -->
					<div class="author-description">
						<h2><?php printf( __( 'About %s', 'twentytwelve' ), get_the_author() ); ?></h2>
						<p><?php the_author_meta( 'description' ); ?></p>
						<div class="author-link">
							<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
								<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'twentytwelve' ), get_the_author() ); ?>
							</a>
						</div><!-- .author-link	-->
					</div><!-- .author-description -->
				</div><!-- .author-info -->
			<?php endif; ?>
		</footer><!-- .entry-meta --><?php */?>
	</article><!-- #post -->
<?php twentytwelve_content_nav( 'nav-below' ); ?>
