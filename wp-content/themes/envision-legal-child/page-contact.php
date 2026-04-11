<?php
/**
 * Template Name: Contact
 *
 * @package EnvisionLegal
 */

get_header();
envision_legal_page_open( 'el-page--contact' );
?>

<section class="el-page-header" aria-labelledby="contact-heading">
	<div class="el-container">
		<p class="el-section__eyebrow"><?php esc_html_e( 'Contact', 'envision-legal' ); ?></p>
		<h1 id="contact-heading"><?php the_title(); ?></h1>
		<p><?php esc_html_e( 'Ready to talk? We\'re happy to help. Book a free consultation or send us a message.', 'envision-legal' ); ?></p>
	</div>
</section>

<div class="el-section">
	<div class="el-container">
		<div class="el-contact-layout">

			<!-- Contact Form Area -->
			<div class="el-contact-form">
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile; endif; ?>

				<?php
				// Fallback contact form when no page content / shortcode installed
				if ( ! have_posts() || get_the_content() === '' ) :
					?>
						<?php
						$el_sent = isset($_GET["sent"]) ? sanitize_text_field( wp_unslash( $_GET["sent"] ) ) : "";
						if ( $el_sent === "ok" ) : ?>
							<div class="el-alert el-alert--success" role="status" style="margin:0 0 1rem;padding:1rem;border:1px solid #b7e1c1;background:#f1fff4;border-radius:8px;">Thanks — your message has been sent. We’ll be in touch within one business day.</div>
						<?php elseif ( $el_sent === "invalid" ) : ?>
							<div class="el-alert el-alert--error" role="alert" style="margin:0 0 1rem;padding:1rem;border:1px solid #f2b8b5;background:#fff5f5;border-radius:8px;">Please complete the required fields and try again.</div>
						<?php elseif ( $el_sent === "error" ) : ?>
							<div class="el-alert el-alert--error" role="alert" style="margin:0 0 1rem;padding:1rem;border:1px solid #f2b8b5;background:#fff5f5;border-radius:8px;">Something went wrong. Please try again.</div>
						<?php endif; ?>

					<h2><?php esc_html_e( 'Send Us a Message', 'envision-legal' ); ?></h2>
					<form class="el-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
						<?php wp_nonce_field( 'envision_contact', 'el_contact_nonce' ); ?>
						<input type="hidden" name="action" value="envision_contact">

						<div class="el-form__group">
							<label for="el-name"><?php esc_html_e( 'Your Name', 'envision-legal' ); ?> <span aria-hidden="true">*</span></label>
							<input type="text" id="el-name" name="el_name" required autocomplete="name"
								placeholder="<?php esc_attr_e( 'Jane Smith', 'envision-legal' ); ?>">
						</div>
						<div class="el-form__group">
							<label for="el-email"><?php esc_html_e( 'Email Address', 'envision-legal' ); ?> <span aria-hidden="true">*</span></label>
							<input type="email" id="el-email" name="el_email" required autocomplete="email"
								placeholder="<?php esc_attr_e( 'jane@example.com', 'envision-legal' ); ?>">
						</div>
						<div class="el-form__group">
							<label for="el-phone"><?php esc_html_e( 'Phone Number', 'envision-legal' ); ?></label>
							<input type="tel" id="el-phone" name="el_phone" autocomplete="tel"
								placeholder="<?php esc_attr_e( '0400 000 000', 'envision-legal' ); ?>">
						</div>
						<div class="el-form__group">
							<label for="el-message"><?php esc_html_e( 'How Can We Help?', 'envision-legal' ); ?> <span aria-hidden="true">*</span></label>
							<textarea id="el-message" name="el_message" rows="5" required
								placeholder="<?php esc_attr_e( 'Tell us a bit about your matter...', 'envision-legal' ); ?>"></textarea>
						</div>

						<button type="submit" class="el-btn el-btn--primary">
							<?php esc_html_e( 'Send Message', 'envision-legal' ); ?>
						</button>
					</form>
					<style>
					.el-form__group { margin-bottom: 1.25rem; }
					.el-form__group label { display: block; font-weight: 600; margin-bottom: 0.4rem; font-size: 0.9rem; }
					.el-form__group input,
					.el-form__group textarea {
						width: 100%; padding: 0.75rem 1rem;
						border: 1px solid var(--el-border); border-radius: var(--el-radius);
						font-family: var(--el-font-body); font-size: 1rem;
					}
					.el-form__group input:focus,
					.el-form__group textarea:focus { outline: 2px solid var(--el-navy); outline-offset: 2px; }
					</style>
					<?php
				endif;
				?>
			</div>

			<!-- Contact Details -->
			<aside class="el-contact-details">
				<h3><?php esc_html_e( 'Get In Touch', 'envision-legal' ); ?></h3>
				<p>
					<strong><?php esc_html_e( 'Phone', 'envision-legal' ); ?></strong><br>
					<a href="tel:<?php echo esc_attr( preg_replace( '/\s/', '', get_theme_mod( 'envision_legal_phone', '+61280000000' ) ) ); ?>">
						<?php echo envision_legal_get_phone(); ?>
					</a>
				</p>
				<p>
					<strong><?php esc_html_e( 'Email', 'envision-legal' ); ?></strong><br>
					<a href="mailto:<?php echo esc_attr( get_theme_mod( 'envision_legal_email', 'hello@envisionlegal.com.au' ) ); ?>">
						<?php echo envision_legal_get_email(); ?>
					</a>
				</p>
				<p>
					<strong><?php esc_html_e( 'Location', 'envision-legal' ); ?></strong><br>
					<?php echo envision_legal_get_address(); ?>
				</p>

				<hr style="border:none;border-top:1px solid var(--el-border);margin:1.5rem 0">

				<h3><?php esc_html_e( 'Office Hours', 'envision-legal' ); ?></h3>
				<p><?php esc_html_e( 'Monday – Friday: 9:00 am – 5:30 pm', 'envision-legal' ); ?></p>
				<p><?php esc_html_e( 'Saturday: By appointment', 'envision-legal' ); ?></p>
				<p><?php esc_html_e( 'Sunday: Closed', 'envision-legal' ); ?></p>
			</aside>
		</div>
	</div>
</div>

<?php
envision_legal_page_close();
get_footer();
