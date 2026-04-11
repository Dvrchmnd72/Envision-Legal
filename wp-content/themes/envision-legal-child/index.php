<?php
/**
 * Index - fallback template / Posts Page
 * @package EnvisionLegal
 */
get_header();
envision_legal_page_open( 'el-page--archive' );
?>

<header class="el-archive-header">
	<div class="el-container">
		<p class="el-section__eyebrow"><?php esc_html_e( 'Insights', 'envision-legal' ); ?></p>
		<h1><?php esc_html_e( 'Latest Articles', 'envision-legal' ); ?></h1>
	</div>
</header>

<div class="el-section">
	<div class="el-container">
		<?php if ( have_posts() ) : ?>
			<div class="el-archive-grid">
				<?php while ( have_posts() ) : the_post(); ?>
				<div class="el-card">
					<div class="el-card__body">
						<div class="el-card__top-row">
							<?php
							$cats = get_the_category();
							if ( $cats ) {
								echo '<span class="el-card__cat-pill">' . esc_html( strtoupper( $cats[0]->name ) ) . '</span>';
							}
							?>
							<time class="el-card__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
								<?php echo esc_html( get_the_date( 'M j, Y' ) ); ?>
							</time>
						</div>
						<h3 class="el-card__title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h3>
						<?php the_excerpt(); ?>
						<a href="<?php the_permalink(); ?>" class="el-card__link">
							<?php esc_html_e( 'Read More &rarr;', 'envision-legal' ); ?>
						</a>
					</div>
				</div>
				<?php endwhile; ?>
			</div>
			<div class="el-pagination">
				<?php the_posts_pagination( array(
					'prev_text' => '&larr; ' . esc_html__( 'Older', 'envision-legal' ),
					'next_text' => esc_html__( 'Newer', 'envision-legal' ) . ' &rarr;',
				) ); ?>
			</div>
		<?php else : ?>
			<div style="text-align:center;padding:var(--el-space-lg) 0">
				<h2><?php esc_html_e( 'Nothing Found', 'envision-legal' ); ?></h2>
				<p><?php esc_html_e( 'No posts found. Check back soon.', 'envision-legal' ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</div>

<?php
envision_legal_page_close();
get_footer();