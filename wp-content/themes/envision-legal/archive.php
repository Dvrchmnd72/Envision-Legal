<?php
/**
 * Archive Template – Blog Index / Category / Tag / Date
 *
 * @package EnvisionLegal
 */

get_header();
envision_legal_header();
envision_legal_page_open( 'el-page--archive' );
?>

<!-- ── Archive Header ─────────────────────────────────────────────────────── -->
<header class="el-archive-header">
	<div class="el-container">
		<?php
		if ( is_category() ) {
			echo '<p class="el-section__eyebrow">' . esc_html__( 'Category', 'envision-legal' ) . '</p>';
			the_archive_title( '<h1>', '</h1>' );
			the_archive_description( '<p>', '</p>' );
		} elseif ( is_tag() ) {
			echo '<p class="el-section__eyebrow">' . esc_html__( 'Tag', 'envision-legal' ) . '</p>';
			the_archive_title( '<h1>', '</h1>' );
		} elseif ( is_author() ) {
			echo '<p class="el-section__eyebrow">' . esc_html__( 'Articles by', 'envision-legal' ) . '</p>';
			the_archive_title( '<h1>', '</h1>' );
		} elseif ( is_year() || is_month() || is_day() ) {
			echo '<p class="el-section__eyebrow">' . esc_html__( 'Archive', 'envision-legal' ) . '</p>';
			the_archive_title( '<h1>', '</h1>' );
		} elseif ( is_search() ) {
			echo '<p class="el-section__eyebrow">' . esc_html__( 'Search Results', 'envision-legal' ) . '</p>';
			echo '<h1>' . sprintf(
				/* translators: %s search term */
				esc_html__( 'Results for: %s', 'envision-legal' ),
				'<em>' . esc_html( get_search_query() ) . '</em>'
			) . '</h1>';
		} else {
			echo '<p class="el-section__eyebrow">' . esc_html__( 'Insights', 'envision-legal' ) . '</p>';
			echo '<h1>' . esc_html__( 'Blog', 'envision-legal' ) . '</h1>';
		}
		?>
	</div>
</header>

<!-- ── Post Grid ──────────────────────────────────────────────────────────── -->
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
									<?php the_post_thumbnail( 'envision-card', array( 'alt' => get_the_title() ) ); ?>
								</a>
							</div>
						<?php else : ?>
							<div class="el-card__image el-card__image--placeholder" aria-hidden="true">
								<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="white"><path d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zm0 16H5V5h14v14zM7 17l3-4 2 3 3-4 4 5H7z"/></svg>
							</div>
						<?php endif; ?>

						<div class="el-card__body">
							<p class="el-card__meta">
								<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>">
									<?php echo esc_html( get_the_date() ); ?>
								</time>
								<?php if ( get_the_category_list() ) : ?>
									&nbsp;&middot;&nbsp;
									<?php echo get_the_category_list( ', ' ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
								<?php endif; ?>
							</p>
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<?php the_excerpt(); ?>
							<a href="<?php the_permalink(); ?>" class="el-card__link">
								<?php esc_html_e( 'Read more &rarr;', 'envision-legal' ); ?>
							</a>
						</div>
					</article>
					<?php
				endwhile;
				?>
			</div>

			<!-- Pagination -->
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
			<div style="text-align:center;padding:var(--el-space-lg) 0">
				<h2><?php esc_html_e( 'Nothing Found', 'envision-legal' ); ?></h2>
				<p><?php esc_html_e( 'It looks like nothing was found at this location.', 'envision-legal' ); ?></p>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="el-btn el-btn--navy">
					<?php esc_html_e( 'Return Home', 'envision-legal' ); ?>
				</a>
			</div>
		<?php endif; ?>
	</div>
</div>

<?php
envision_legal_page_close();
envision_legal_footer();
get_footer();
