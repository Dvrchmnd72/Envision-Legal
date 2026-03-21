<?php
/**
 * Template Name: Terms of Use
 *
 * @package EnvisionLegal
 */

get_header();
envision_legal_header();
envision_legal_page_open( 'el-page--legal' );
?>

<section class="el-page-header" aria-labelledby="terms-heading">
	<div class="el-container">
		<h1 id="terms-heading"><?php the_title(); ?></h1>
		<p><?php esc_html_e( 'Please read these terms carefully before using this website.', 'envision-legal' ); ?></p>
	</div>
</section>

<section class="el-section">
	<div class="el-container">
		<div class="el-post-content__inner">
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<?php
				if ( get_the_content() ) :
					the_content();
				else :
					// Default placeholder content
					?>
					<p><em><?php esc_html_e( 'Last updated:', 'envision-legal' ); ?> <?php echo esc_html( get_the_modified_date() ); ?></em></p>

					<h2><?php esc_html_e( '1. Acceptance of Terms', 'envision-legal' ); ?></h2>
					<p><?php esc_html_e( 'By accessing and using this website, you accept and agree to be bound by these Terms of Use and our Privacy Policy. If you do not agree, please do not use this website.', 'envision-legal' ); ?></p>

					<h2><?php esc_html_e( '2. Legal Information Disclaimer', 'envision-legal' ); ?></h2>
					<p><?php esc_html_e( 'The content on this website is provided for general informational purposes only. It does not constitute legal advice and does not create a solicitor-client relationship. You should obtain specific legal advice relevant to your circumstances from a qualified lawyer.', 'envision-legal' ); ?></p>

					<h2><?php esc_html_e( '3. Intellectual Property', 'envision-legal' ); ?></h2>
					<p><?php esc_html_e( 'All content on this website, including text, graphics, logos and images, is the property of Envision Legal or its content suppliers and is protected by applicable intellectual property laws.', 'envision-legal' ); ?></p>

					<h2><?php esc_html_e( '4. Limitation of Liability', 'envision-legal' ); ?></h2>
					<p><?php esc_html_e( 'To the fullest extent permitted by law, Envision Legal excludes all liability for loss or damage arising from your use of, or reliance on, information on this website.', 'envision-legal' ); ?></p>

					<h2><?php esc_html_e( '5. Governing Law', 'envision-legal' ); ?></h2>
					<p><?php esc_html_e( 'These Terms of Use are governed by the laws of New South Wales, Australia.', 'envision-legal' ); ?></p>

					<h2><?php esc_html_e( '6. Contact', 'envision-legal' ); ?></h2>
					<p>
						<?php
						printf(
							/* translators: %s email address */
							esc_html__( 'Questions about these terms? Email us at %s.', 'envision-legal' ),
							'<a href="mailto:' . esc_attr( get_theme_mod( 'envision_legal_email', 'hello@envisionlegal.com.au' ) ) . '">'
							. esc_html( get_theme_mod( 'envision_legal_email', 'hello@envisionlegal.com.au' ) )
							. '</a>'
						);
						?>
					</p>
					<?php
				endif;
				?>
			<?php endwhile; endif; ?>
		</div>
	</div>
</section>

<?php
envision_legal_page_close();
envision_legal_footer();
get_footer();
