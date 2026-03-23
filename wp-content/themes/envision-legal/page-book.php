<?php
/**
 * Template Name: Book a Consultation
 *
 * Dedicated template for /book/ – renders a full-width hero then
 * outputs the page content (booking plugin shortcode/blocks).
 *
 * @package EnvisionLegal
 */

get_header();
envision_legal_header();
envision_legal_page_open( 'el-page--book' );
?>

<section class="el-page-header" aria-labelledby="book-heading">
	<div class="el-container">
		<p class="el-section__eyebrow"><?php esc_html_e( 'Free Consultation', 'envision-legal' ); ?></p>
		<h1 id="book-heading"><?php the_title(); ?></h1>
		<p><?php esc_html_e( 'Schedule your free 30-minute consultation with our commercial lawyers.', 'envision-legal' ); ?></p>
	</div>
</section>

<div class="el-section">
	<div class="el-container">
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php the_content(); ?>
		<?php endwhile; endif; ?>
	</div>
</div>

<?php
envision_legal_page_close();
envision_legal_footer();
get_footer();
