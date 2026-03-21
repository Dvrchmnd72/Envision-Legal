<?php
/**
 * 404 – Page Not Found
 *
 * @package EnvisionLegal
 */

get_header();
envision_legal_header();
envision_legal_page_open( 'el-page--404' );
?>

<div class="el-404">
	<div class="el-container">
		<div class="el-404__code" aria-hidden="true">404</div>
		<h1><?php esc_html_e( 'Page Not Found', 'envision-legal' ); ?></h1>
		<p style="color:var(--el-text-muted);margin:1rem 0 2rem;max-width:480px;margin-inline:auto">
			<?php esc_html_e( 'Sorry, the page you\'re looking for doesn\'t exist or may have been moved. Let\'s get you back on track.', 'envision-legal' ); ?>
		</p>
		<div style="display:flex;flex-wrap:wrap;gap:1rem;justify-content:center">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="el-btn el-btn--primary">
				<?php esc_html_e( 'Go to Home Page', 'envision-legal' ); ?>
			</a>
			<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="el-btn el-btn--navy">
				<?php esc_html_e( 'Contact Us', 'envision-legal' ); ?>
			</a>
			<a href="<?php echo esc_url( home_url( '/blog' ) ); ?>" class="el-btn el-btn--outline">
				<?php esc_html_e( 'Browse Blog', 'envision-legal' ); ?>
			</a>
		</div>
	</div>
</div>

<?php
envision_legal_page_close();
envision_legal_footer();
get_footer();
