<?php
/**
 * Archive Template - Blog Index / Category / Tag / Date
 * @package EnvisionLegal
 */
get_header();
envision_legal_page_open( "el-page--archive" );
?>

<header class="el-archive-header">
	<div class="el-container">
		<?php
		if ( is_category() ) {
			echo "<p class='el-section__eyebrow'>" . esc_html__( "Category", "envision-legal" ) . "</p>";
			the_archive_title( "<h1>", "</h1>" );
			the_archive_description( "<p>", "</p>" );
		} elseif ( is_tag() ) {
			echo "<p class='el-section__eyebrow'>" . esc_html__( "Tag", "envision-legal" ) . "</p>";
			the_archive_title( "<h1>", "</h1>" );
		} elseif ( is_author() ) {
			echo "<p class='el-section__eyebrow'>" . esc_html__( "Articles by", "envision-legal" ) . "</p>";
			the_archive_title( "<h1>", "</h1>" );
		} elseif ( is_year() || is_month() || is_day() ) {
			echo "<p class='el-section__eyebrow'>" . esc_html__( "Archive", "envision-legal" ) . "</p>";
			the_archive_title( "<h1>", "</h1>" );
		} elseif ( is_search() ) {
			echo "<p class='el-section__eyebrow'>" . esc_html__( "Search Results", "envision-legal" ) . "</p>";
			echo "<h1>" . sprintf( esc_html__( "Results for: %s", "envision-legal" ), "<em>" . esc_html( get_search_query() ) . "</em>" ) . "</h1>";
		} else {
			echo "<p class='el-section__eyebrow'>" . esc_html__( "Insights", "envision-legal" ) . "</p>";
			echo "<h1>" . esc_html__( "Latest Articles", "envision-legal" ) . "</h1>";
		}
		?>
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
							if ( $cats ) :
								echo "<span class='el-card__cat-pill'>" . esc_html( strtoupper( $cats[0]->name ) ) . "</span>";
							endif;
							?>
							<time class="el-card__date" datetime="<?php echo esc_attr( get_the_date( "c" ) ); ?>">
								<?php echo esc_html( get_the_date( "M j, Y" ) ); ?>
							</time>
						</div>
						<h3 class="el-card__title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h3>
						<?php the_excerpt(); ?>
						<a href="<?php the_permalink(); ?>" class="el-card__link">
							<?php esc_html_e( "Read More &rarr;", "envision-legal" ); ?>
						</a>
					</div>
				</div>
				<?php endwhile; ?>
			</div>

			<div class="el-pagination">
				<?php the_posts_pagination( array(
					"prev_text" => "&larr; " . esc_html__( "Older", "envision-legal" ),
					"next_text" => esc_html__( "Newer", "envision-legal" ) . " &rarr;",
				) ); ?>
			</div>

		<?php else : ?>
			<div style="text-align:center;padding:var(--el-space-lg) 0">
				<h2><?php esc_html_e( "Nothing Found", "envision-legal" ); ?></h2>
				<p><?php esc_html_e( "It looks like nothing was found at this location.", "envision-legal" ); ?></p>
				<a href="<?php echo esc_url( home_url( "/" ) ); ?>" class="el-btn el-btn--navy"><?php esc_html_e( "Return Home", "envision-legal" ); ?></a>
			</div>
		<?php endif; ?>
	</div>
</div>

<?php
envision_legal_page_close();
get_footer();
