<?php
/**
 * Index – fallback template
 *
 * WordPress uses this when no other template matches.
 *
 * @package EnvisionLegal
 */

get_header();
envision_legal_header();
envision_legal_page_open( 'el-page--index' );
?>

<section class="el-archive-header">
	<div class="el-container">
		<h1><?php esc_html_e( 'Latest Articles', 'envision-legal' ); ?></h1>
	</div>
</section>

<div class="el-section">
	<div class="el-container">
		<?php if ( have_posts() ) : ?>
			<div class="el-archive-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'el-card' ); ?>>
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="el-card__image">
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail( 'envision-card' ); ?>
								</a>
							</div>
						<?php else : ?>
							<div class="el-card__image el-card__image--placeholder">
								<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="white" aria-hidden="true"><path d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zm0 16H5V5h14v14zM7 17l3-4 2 3 3-4 4 5H7z"/></svg>
							</div>
						<?php endif; ?>

						<div class="el-card__body">
							<p class="el-card__meta">
								<?php echo esc_html( get_the_date() ); ?>
								<?php if ( get_the_category_list( ', ' ) ) : ?>
									&nbsp;&middot;&nbsp; <?php echo get_the_category_list( ', ' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
								<?php endif; ?>
							</p>
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<?php the_excerpt(); ?>
							<a href="<?php the_permalink(); ?>" class="el-card__link"><?php esc_html_e( 'Read more &rarr;', 'envision-legal' ); ?></a>
						</div>
					</article>
					<?php
				endwhile;
				?>
			</div>

			<div class="el-pagination">
				<?php
				the_posts_pagination(
					array(
						'prev_text' => '&larr; ' . esc_html__( 'Older', 'envision-legal' ),
						'next_text' => esc_html__( 'Newer', 'envision-legal' ) . ' &rarr;',
					)
				);
				?>
			</div>
		<?php else : ?>
			<p><?php esc_html_e( 'No content found. Check back soon.', 'envision-legal' ); ?></p>
		<?php endif; ?>
	</div>
</div>

<?php
envision_legal_page_close();
envision_legal_footer();
get_footer();
