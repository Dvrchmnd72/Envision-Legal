<?php
/**
 * Template Name: About
 *
 * @package EnvisionLegal
 */

get_header();
envision_legal_header();
envision_legal_page_open( 'el-page--about' );
?>

<section class="el-page-header" aria-labelledby="about-heading">
	<div class="el-container">
		<p class="el-section__eyebrow"><?php esc_html_e( 'About Us', 'envision-legal' ); ?></p>
		<h1 id="about-heading"><?php the_title(); ?></h1>
		<?php if ( has_excerpt() ) : ?>
			<p><?php the_excerpt(); ?></p>
		<?php else : ?>
			<p><?php esc_html_e( 'A boutique commercial law firm built around your business goals.', 'envision-legal' ); ?></p>
		<?php endif; ?>
	</div>
</section>

<section class="el-section">
	<div class="el-container">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<div class="el-post-content__inner">
				<?php the_content(); ?>
			</div>
		<?php endwhile; endif; ?>
	</div>
</section>

<!-- ── Values ─────────────────────────────────────────────────────────────── -->
<section class="el-section el-section--cream" aria-labelledby="values-heading">
	<div class="el-container">
		<header class="el-section__header">
			<p class="el-section__eyebrow"><?php esc_html_e( 'Our Values', 'envision-legal' ); ?></p>
			<h2 id="values-heading"><?php esc_html_e( 'What Drives Us', 'envision-legal' ); ?></h2>
		</header>
		<div class="el-grid">
			<?php
			$values = array(
				array(
					'title' => __( 'Commercial Clarity', 'envision-legal' ),
					'desc'  => __( 'We translate complex legal concepts into clear, practical guidance you can act on immediately.', 'envision-legal' ),
				),
				array(
					'title' => __( 'Genuine Partnership', 'envision-legal' ),
					'desc'  => __( 'We\'re invested in your success. We ask the questions others don\'t, and we listen to the answers.', 'envision-legal' ),
				),
				array(
					'title' => __( 'Accessible Expertise', 'envision-legal' ),
					'desc'  => __( 'Big-firm knowledge delivered without big-firm bureaucracy—or big-firm bills.', 'envision-legal' ),
				),
			);
			foreach ( $values as $val ) :
				?>
				<div class="el-practice-card">
					<h3><?php echo esc_html( $val['title'] ); ?></h3>
					<p><?php echo esc_html( $val['desc'] ); ?></p>
				</div>
				<?php
			endforeach;
			?>
		</div>
	</div>
</section>

<!-- ── CTA ────────────────────────────────────────────────────────────────── -->
<section class="el-cta-banner" aria-labelledby="about-cta">
	<div class="el-container">
		<h2 id="about-cta"><?php esc_html_e( 'Let\'s Work Together', 'envision-legal' ); ?></h2>
		<p><?php esc_html_e( 'Book a free 30-minute consultation and tell us about your business.', 'envision-legal' ); ?></p>
		<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="el-btn el-btn--navy">
			<?php esc_html_e( 'Get in Touch', 'envision-legal' ); ?>
		</a>
	</div>
</section>

<?php
envision_legal_page_close();
envision_legal_footer();
get_footer();
