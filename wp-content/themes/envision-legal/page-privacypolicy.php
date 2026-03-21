<?php
/**
 * Template Name: Privacy Policy
 *
 * @package EnvisionLegal
 */

get_header();
envision_legal_header();
envision_legal_page_open( 'el-page--legal' );
?>

<section class="el-page-header" aria-labelledby="privacy-heading">
	<div class="el-container">
		<h1 id="privacy-heading"><?php the_title(); ?></h1>
		<p><?php esc_html_e( 'We respect your privacy and are committed to protecting your personal information.', 'envision-legal' ); ?></p>
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
					?>
					<p><em><?php esc_html_e( 'Last updated:', 'envision-legal' ); ?> <?php echo esc_html( get_the_modified_date() ); ?></em></p>

					<h2><?php esc_html_e( '1. Who We Are', 'envision-legal' ); ?></h2>
					<p>
						<?php
						printf(
							/* translators: %s site name */
							esc_html__( '%s ("we", "us", "our") is an Australian commercial law firm. This Privacy Policy explains how we collect, use, disclose and protect your personal information in accordance with the Privacy Act 1988 (Cth) and the Australian Privacy Principles (APPs).', 'envision-legal' ),
							esc_html( get_bloginfo( 'name' ) )
						);
						?>
					</p>

					<h2><?php esc_html_e( '2. Information We Collect', 'envision-legal' ); ?></h2>
					<p><?php esc_html_e( 'We may collect personal information including your name, email address, phone number and details about your legal matter when you contact us through this website or engage our services.', 'envision-legal' ); ?></p>

					<h2><?php esc_html_e( '3. How We Use Your Information', 'envision-legal' ); ?></h2>
					<p><?php esc_html_e( 'We use your information to respond to enquiries, provide legal services, send relevant communications, and improve our website. We will not sell your personal information to third parties.', 'envision-legal' ); ?></p>

					<h2><?php esc_html_e( '4. Cookies', 'envision-legal' ); ?></h2>
					<p><?php esc_html_e( 'This website uses cookies to improve your experience. You can disable cookies through your browser settings, but some features may not function correctly.', 'envision-legal' ); ?></p>

					<h2><?php esc_html_e( '5. Third-Party Services', 'envision-legal' ); ?></h2>
					<p><?php esc_html_e( 'We may use third-party services such as Google Analytics to understand how visitors use our website. These services have their own privacy policies.', 'envision-legal' ); ?></p>

					<h2><?php esc_html_e( '6. Your Rights', 'envision-legal' ); ?></h2>
					<p><?php esc_html_e( 'You may request access to, or correction of, personal information we hold about you. Contact us using the details below.', 'envision-legal' ); ?></p>

					<h2><?php esc_html_e( '7. Contact', 'envision-legal' ); ?></h2>
					<p>
						<?php
						printf(
							/* translators: %s email address */
							esc_html__( 'Privacy enquiries: %s', 'envision-legal' ),
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
