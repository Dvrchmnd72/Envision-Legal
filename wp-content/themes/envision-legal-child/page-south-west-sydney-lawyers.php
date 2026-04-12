<?php
/**
 * Template Name: South-West Sydney Lawyers
 *
 * Landing page for the South-West Sydney local SEO area.
 *
 * @package EnvisionLegal
 */

get_header();
envision_legal_page_open( 'el-page--local' );
?>

<!-- ── Hero ──────────────────────────────────────────────────────────────── -->
<section class="el-hero" aria-labelledby="local-heading">
	<div class="el-container">
		<div class="el-hero__inner">
			<p class="el-hero__eyebrow"><?php esc_html_e( 'Commercial Lawyers · South-West Sydney', 'envision-legal' ); ?></p>
			<h1 id="local-heading"><?php the_title(); ?></h1>
			<p class="el-hero__sub">
				<?php esc_html_e( 'Local legal expertise for businesses in Campbelltown, Liverpool, Parramatta and surrounding suburbs. We understand the South-West Sydney business community because we\'re part of it.', 'envision-legal' ); ?>
			</p>
			<div class="el-hero__actions">
				<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="el-btn el-btn--primary">
					<?php esc_html_e( 'Free Consultation', 'envision-legal' ); ?>
				</a>
				<a href="<?php echo esc_url( home_url( '/practice-areas/' ) ); ?>" class="el-btn el-btn--outline">
					<?php esc_html_e( 'What We Do', 'envision-legal' ); ?>
				</a>
			</div>
		</div>
	</div>
</section>

<!-- ── Dynamic Page Content ───────────────────────────────────────────────── -->
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<?php if ( get_the_content() ) : ?>
		<section class="el-section">
			<div class="el-container">
				<div class="el-post-content__inner"><?php the_content(); ?></div>
			</div>
		</section>
	<?php endif; ?>
<?php endwhile; endif; ?>

<!-- ── Areas We Serve ─────────────────────────────────────────────────────── -->
<section class="el-section el-section--cream" aria-labelledby="areas-heading">
	<div class="el-container">
		<header class="el-section__header">
			<p class="el-section__eyebrow"><?php esc_html_e( 'Local Coverage', 'envision-legal' ); ?></p>
			<h2 id="areas-heading"><?php esc_html_e( 'Areas We Serve', 'envision-legal' ); ?></h2>
			<p><?php esc_html_e( 'We serve businesses and individuals across South-West Sydney and beyond, including:', 'envision-legal' ); ?></p>
		</header>
		<div class="el-grid">
			<?php
			$suburbs = array(
				'Campbelltown', 'Liverpool', 'Parramatta', 'Bankstown',
				'Fairfield', 'Penrith', 'Macarthur', 'Camden',
				'Wollondilly', 'Ingleburn',
			);
			foreach ( $suburbs as $suburb ) :
				?>
				<div class="el-practice-card" style="padding:1.25rem 1.5rem">
					<p style="font-weight:600;margin:0;color:var(--el-navy)"><?php echo esc_html( $suburb ); ?></p>
				</div>
				<?php
			endforeach;
			?>
		</div>
	</div>
</section>

<!-- ── Practice Areas ─────────────────────────────────────────────────────── -->
<section class="el-section" aria-labelledby="local-services-heading">
	<div class="el-container">
		<header class="el-section__header">
			<h2 id="local-services-heading"><?php esc_html_e( 'Commercial Legal Services', 'envision-legal' ); ?></h2>
			<p><?php esc_html_e( 'From contracts to business sales, trademarks to startup legals—we cover the full commercial spectrum.', 'envision-legal' ); ?></p>
		</header>
		<div class="el-grid">
			<?php
			$services = array(
				__( 'Business Contracts', 'envision-legal' ),
				__( 'Business Sales &amp; Acquisitions', 'envision-legal' ),
				__( 'Shareholder Agreements', 'envision-legal' ),
				__( 'Intellectual Property', 'envision-legal' ),
				__( 'Startup Legals', 'envision-legal' ),
				__( 'Fractional General Counsel', 'envision-legal' ),
			);
			foreach ( $services as $svc ) :
				?>
				<div class="el-practice-card">
					<h3><?php echo wp_kses_post( $svc ); ?></h3>
					<a href="<?php echo esc_url( home_url( '/practice-areas/' ) ); ?>" class="el-card__link">
						<?php esc_html_e( 'Learn more &rarr;', 'envision-legal' ); ?>
					</a>
				</div>
				<?php
			endforeach;
			?>
		</div>
	</div>
</section>

<!-- ── CTA ────────────────────────────────────────────────────────────────── -->
<section class="el-cta-banner" aria-labelledby="local-cta">
	<div class="el-container">
		<h2 id="local-cta"><?php esc_html_e( 'Your Local Commercial Lawyers in South-West Sydney', 'envision-legal' ); ?></h2>
		<p><?php esc_html_e( 'Book a free 30-minute consultation and find out how we can help your business.', 'envision-legal' ); ?></p>
		<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="el-btn el-btn--navy">
			<?php esc_html_e( 'Get in Touch', 'envision-legal' ); ?>
		</a>
	</div>
</section>

<?php
envision_legal_page_close();
get_footer();
