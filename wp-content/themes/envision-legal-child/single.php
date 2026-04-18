<?php
/**
 * Single Post Template – Blog
 *
 * @package EnvisionLegal
 */

get_header();

while ( have_posts() ) :
	the_post();

	envision_legal_page_open( 'el-page--single' );
	?>

	<!-- ── Post Header ──────────────────────────────────────────────────────── -->
	<header class="el-post-header">
		<div class="el-container">
			<p class="el-section__eyebrow">
				<?php echo get_the_category_list( ' &middot; ' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
			</p>
			<h1><?php the_title(); ?></h1>
			<div class="el-post-meta">
				<span>
					<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
						<?php echo esc_html( get_the_date() ); ?>
					</time>
				</span>
				<?php if ( get_the_author() ) : ?>
					<span><?php esc_html_e( 'By', 'envision-legal' ); ?> <?php the_author(); ?></span>
				<?php endif; ?>
				<span>
					<?php
					printf(
						/* translators: %s: reading time in minutes */
						esc_html__( '%s min read', 'envision-legal' ),
						esc_html( (string) max( 1, (int) ( str_word_count( wp_strip_all_tags( get_the_content() ) ) / 200 ) ) )
					);
					?>
				</span>
			</div>
		</div>
	</header>

	<!-- ── Featured Image ───────────────────────────────────────────────────── -->
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="el-section" style="padding-bottom:0">
			<div class="el-container">
				<div class="el-post-featured">
					<?php the_post_thumbnail( 'envision-featured', array( 'alt' => get_the_title() ) ); ?>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<!-- ── Post Content ─────────────────────────────────────────────────────── -->
	<article class="el-post-content">
		<div class="el-container">
			<div class="el-post-content__inner">
				<?php the_content(); ?>

				<?php
				wp_link_pages(
					array(
						'before' => '<div class="el-page-links"><strong>' . esc_html__( 'Pages:', 'envision-legal' ) . '</strong>',
						'after'  => '</div>',
					)
				);
				?>
			</div>

			<!-- Tags -->
			<?php if ( has_tag() ) : ?>
				<div class="el-post-tags" style="margin-top:2rem;padding-top:1.5rem;border-top:1px solid var(--el-border)">
					<strong><?php esc_html_e( 'Tags:', 'envision-legal' ); ?></strong>
					<?php the_tags( ' ', ', ', '' ); ?>
				</div>
			<?php endif; ?>

			<!-- Author bio -->
			<?php if ( get_the_author_meta( 'description' ) ) : ?>
				<div class="el-author-bio" style="margin-top:3rem;padding:2rem;background:var(--el-cream);border-radius:8px">
					<h3 style="margin-bottom:.5rem">
						<?php
						printf(
							/* translators: %s author name */
							esc_html__( 'About %s', 'envision-legal' ),
							esc_html( get_the_author() )
						);
						?>
					</h3>
					<p><?php echo wp_kses_post( get_the_author_meta( 'description' ) ); ?></p>
				</div>
			<?php endif; ?>

			<!-- Post navigation -->
			<nav class="el-post-nav" aria-label="<?php esc_attr_e( 'Post navigation', 'envision-legal' ); ?>">
				<?php
				$prev = get_previous_post();
				$next = get_next_post();
				if ( $prev ) :
					?>
					<a href="<?php echo esc_url( get_permalink( $prev ) ); ?>" class="el-btn el-btn--outline">
						&larr; <?php echo esc_html( get_the_title( $prev ) ); ?>
					</a>
					<?php
				else :
					echo '<span></span>';
				endif;
				if ( $next ) :
					?>
					<a href="<?php echo esc_url( get_permalink( $next ) ); ?>" class="el-btn el-btn--outline el-post-nav__next">
						<?php echo esc_html( get_the_title( $next ) ); ?> &rarr;
					</a>
					<?php
				endif;
				?>
			</nav>
		</div>
	</article>

	<!-- ── Related Posts ────────────────────────────────────────────────────── -->
	<?php
	$categories  = get_the_category();
	$category_id = $categories ? $categories[0]->term_id : 0;
	$related     = new WP_Query(
		array(
			'post_type'           => 'post',
			'posts_per_page'      => 3,
			'category__in'        => array( $category_id ),
			'post__not_in'        => array( get_the_ID() ),
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
		)
	);

	if ( $related->have_posts() ) :
		?>
		<section class="el-section el-section--cream" aria-labelledby="related-heading">
			<div class="el-container">
				<h2 id="related-heading"><?php esc_html_e( 'Related Articles', 'envision-legal' ); ?></h2>
				<div class="el-archive-grid">
					<?php
					while ( $related->have_posts() ) :
						$related->the_post();
						?>
						<article id="post-<?php the_ID(); ?>" <?php post_class( 'el-card' ); ?>>
							<?php if ( has_post_thumbnail() ) : ?>
								<div class="el-card__image">
									<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'envision-card' ); ?></a>
								</div>
							<?php else : ?>
								<div class="el-card__image el-card__image--placeholder" aria-hidden="true">
									<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="white"><path d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zm0 16H5V5h14v14zM7 17l3-4 2 3 3-4 4 5H7z"/></svg>
								</div>
							<?php endif; ?>
							<div class="el-card__body">
								<p class="el-card__meta"><?php echo esc_html( get_the_date() ); ?></p>
								<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
								<?php the_excerpt(); ?>
								<a href="<?php the_permalink(); ?>" class="el-card__link"><?php esc_html_e( 'Read more &rarr;', 'envision-legal' ); ?></a>
							</div>
						</article>
						<?php
					endwhile;
					wp_reset_postdata();
					?>
				</div>
			</div>
		</section>
		<?php
	endif;
	?>

	<!-- ── CTA ──────────────────────────────────────────────────────────────── -->
	<section class="el-cta-banner">
		<div class="el-container">
			<h2><?php esc_html_e( 'Need Legal Advice?', 'envision-legal' ); ?></h2>
			<p><?php esc_html_e( 'Book a free consultation and speak directly with a commercial lawyer.', 'envision-legal' ); ?></p>
			<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="el-btn el-btn--navy">
				<?php esc_html_e( 'Get in Touch', 'envision-legal' ); ?>
			</a>
		</div>
	</section>

	<?php
	envision_legal_page_close();
endwhile;

get_footer();
