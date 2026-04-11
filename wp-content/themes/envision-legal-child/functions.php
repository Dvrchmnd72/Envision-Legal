<?php
/**
 * Envision Legal – Child Theme Functions
 *
 * @package EnvisionLegal
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// ── Constants ────────────────────────────────────────────────────────────────
define( 'ENVISION_LEGAL_VERSION', '1.1.18' );
define( 'ENVISION_LEGAL_DIR', get_stylesheet_directory() );
define( 'ENVISION_LEGAL_URI', get_stylesheet_directory_uri() );

// ── Enqueue parent + child styles and scripts ─────────────────────────────────
add_action( 'wp_enqueue_scripts', 'envision_legal_enqueue_assets' );
function envision_legal_enqueue_assets() {
	// 1. Astra parent stylesheet
	wp_enqueue_style(
		'astra-parent-style',
		get_template_directory_uri() . '/style.css',
		array(),
		ENVISION_LEGAL_VERSION
	);

	// 2. Child theme style overrides
	wp_enqueue_style(
		'envision-legal-style',
		ENVISION_LEGAL_URI . '/style.css',
		array( 'astra-parent-style' ),
		ENVISION_LEGAL_VERSION
	);

	// 3. Main theme CSS
	wp_enqueue_style(
		'envision-legal-theme',
		ENVISION_LEGAL_URI . '/assets/css/theme.css',
		array( 'envision-legal-style', 'astra-theme-css' ),
		ENVISION_LEGAL_VERSION
	);

	// 4. Google Fonts – Inter + Playfair Display
	wp_enqueue_style(
		'envision-legal-google-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap',
		array(),
		null
	);

	// 5. Theme JavaScript
	wp_enqueue_script(
		'envision-legal-theme',
		ENVISION_LEGAL_URI . '/assets/js/theme.js',
		array( 'jquery' ),
		ENVISION_LEGAL_VERSION,
		true
	);

	// Pass AJAX URL to JS
	wp_localize_script(
		'envision-legal-theme',
		'envisionLegal',
		array(
			'ajaxUrl' => admin_url( 'admin-ajax.php' ),
			'nonce'   => wp_create_nonce( 'envision_legal_nonce' ),
		)
	);
}

// ── Theme Support ─────────────────────────────────────────────────────────────
add_action( 'after_setup_theme', 'envision_legal_setup' );
function envision_legal_setup() {
	// Featured Images
	add_theme_support( 'post-thumbnails' );

	// Title tag
	add_theme_support( 'title-tag' );

	// HTML5
	add_theme_support(
		'html5',
		array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'script', 'style' )
	);

	// Custom logo
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 80,
			'width'       => 240,
			'flex-height' => true,
			'flex-width'  => true,
		)
	);

	// Feed links
	add_theme_support( 'automatic-feed-links' );

	// Wide/full-width block alignment
	add_theme_support( 'align-wide' );

	// Register image sizes
	add_image_size( 'envision-featured',  1200, 600, true );
	add_image_size( 'envision-card',       600, 400, true );
	add_image_size( 'envision-thumbnail',  400, 266, true );
}

// ── Navigation Menus ──────────────────────────────────────────────────────────
add_action( 'after_setup_theme', 'envision_legal_register_menus' );
function envision_legal_register_menus() {
	register_nav_menus(
		array(
			'primary'  => esc_html__( 'Primary Navigation', 'envision-legal' ),
			'footer'   => esc_html__( 'Footer Navigation', 'envision-legal' ),
		)
	);
}

// ── Widget Areas ──────────────────────────────────────────────────────────────
add_action( 'widgets_init', 'envision_legal_register_sidebars' );
function envision_legal_register_sidebars() {
	$shared = array(
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	);

	register_sidebar(
		array_merge(
			$shared,
			array(
				'name'        => esc_html__( 'Blog Sidebar', 'envision-legal' ),
				'id'          => 'sidebar-blog',
				'description' => esc_html__( 'Widgets for the blog sidebar.', 'envision-legal' ),
			)
		)
	);

	register_sidebar(
		array_merge(
			$shared,
			array(
				'name'        => esc_html__( 'Footer Widget Area', 'envision-legal' ),
				'id'          => 'footer-widgets',
				'description' => esc_html__( 'Widgets for the site footer.', 'envision-legal' ),
			)
		)
	);
}

// ── Customizer additions ───────────────────────────────────────────────────────
add_action( 'customize_register', 'envision_legal_customizer' );
function envision_legal_customizer( $wp_customize ) {
	// ── Firm Details section ──
	$wp_customize->add_section(
		'envision_legal_firm',
		array(
			'title'    => esc_html__( 'Firm Details', 'envision-legal' ),
			'priority' => 30,
		)
	);

	$firm_settings = array(
		'phone'   => array( 'label' => 'Phone Number',  'default' => '+61 2 8000 0000' ),
		'email'   => array( 'label' => 'Email Address', 'default' => 'hello@envisionlegal.com.au' ),
		'address' => array( 'label' => 'Office Address', 'default' => 'Sydney, NSW, Australia' ),
	);

	foreach ( $firm_settings as $key => $args ) {
		$wp_customize->add_setting(
			'envision_legal_' . $key,
			array(
				'default'           => $args['default'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'envision_legal_' . $key,
			array(
				'label'   => esc_html__( $args['label'], 'envision-legal' ),
				'section' => 'envision_legal_firm',
				'type'    => 'text',
			)
		);
	}
}

// ── Helper: get firm contact details ──────────────────────────────────────────
function envision_legal_get_phone() {
	return esc_html( get_theme_mod( 'envision_legal_phone', '+61 2 8000 0000' ) );
}
function envision_legal_get_email() {
	return esc_html( get_theme_mod( 'envision_legal_email', 'hello@envisionlegal.com.au' ) );
}
function envision_legal_get_address() {
	return esc_html( get_theme_mod( 'envision_legal_address', 'Sydney, NSW, Australia' ) );
}

// ── Helper: render site header ─────────────────────────────────────────────────
function envision_legal_header() {
	?>
	<header class="el-header" role="banner">
		<div class="el-container el-header__inner">
			<div class="el-header__logo">
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="el-header__site-name">
						<?php bloginfo( 'name' ); ?>
					</a>
				<?php endif; ?>
			</div>

			<button class="el-nav-toggle" aria-controls="el-primary-nav" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation', 'envision-legal' ); ?>">
				<span></span><span></span><span></span>
			</button>

			<nav id="el-primary-nav" class="el-nav" role="navigation" aria-label="<?php esc_attr_e( 'Primary', 'envision-legal' ); ?>">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_class'     => 'el-nav__list',
						'container'      => false,
						'fallback_cb'    => 'envision_legal_fallback_menu',
					)
				);
				?>
			</nav>

			<a href="<?php echo esc_url( get_permalink( get_page_by_path( 'contact' ) ) ); ?>" class="el-btn el-header__cta">
				<?php esc_html_e( 'Get in Touch', 'envision-legal' ); ?>
			</a>
		</div>
	</header>
	<?php
}

// Fallback menu when no menu is assigned
function envision_legal_fallback_menu() {
	echo '<ul class="el-nav__list">';
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'envision-legal' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/about' ) ) . '">' . esc_html__( 'About', 'envision-legal' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/practiceareas' ) ) . '">' . esc_html__( 'Practice Areas', 'envision-legal' ) . '</a></li>';
	echo '<li><a href="' . esc_url( get_permalink( get_option( 'page_for_posts' ) ) ) . '">' . esc_html__( 'Blog', 'envision-legal' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/contact' ) ) . '">' . esc_html__( 'Contact', 'envision-legal' ) . '</a></li>';
	echo '</ul>';
}

// ── Helper: render site footer ─────────────────────────────────────────────────
function envision_legal_footer() {
	$year = gmdate( 'Y' );
	?>
	<footer class="el-footer" role="contentinfo">
		<div class="el-container el-footer__inner">
			<div class="el-footer__brand">
				<span class="el-footer__site-name"><?php bloginfo( 'name' ); ?></span>
				<p class="el-footer__tagline"><?php bloginfo( 'description' ); ?></p>
			</div>

			<div class="el-footer__nav">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer',
						'menu_class'     => 'el-footer__list',
						'container'      => false,
						'depth'          => 1,
						'fallback_cb'    => false,
					)
				);
				?>
			</div>

			<div class="el-footer__contact">
				<p>
					<a href="tel:<?php echo esc_attr( preg_replace( '/\s/', '', get_theme_mod( 'envision_legal_phone', '+61280000000' ) ) ); ?>">
						<?php echo envision_legal_get_phone(); ?>
					</a>
				</p>
				<p>
					<a href="mailto:<?php echo esc_attr( get_theme_mod( 'envision_legal_email', 'hello@envisionlegal.com.au' ) ); ?>">
						<?php echo envision_legal_get_email(); ?>
					</a>
				</p>
				<p><?php echo envision_legal_get_address(); ?></p>
			</div>
		</div>

		<div class="el-footer__legal">
			<div class="el-container">
				<p>
					<?php
					printf(
						/* translators: %1$s = year, %2$s = site name */
						esc_html__( '&copy; %1$s %2$s. All rights reserved.', 'envision-legal' ),
						esc_html( $year ),
						esc_html( get_bloginfo( 'name' ) )
					);
					?>
					&nbsp;&mdash;&nbsp;
					<a href="<?php echo esc_url( home_url( '/privacypolicy' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'envision-legal' ); ?></a>
					&nbsp;&middot;&nbsp;
					<a href="<?php echo esc_url( home_url( '/termsofuse' ) ); ?>"><?php esc_html_e( 'Terms of Use', 'envision-legal' ); ?></a>
				</p>
			</div>
		</div>
	</footer>
	<?php
}

// ── Helper: page wrapper open ──────────────────────────────────────────────────
function envision_legal_page_open( $class = '' ) {
	$classes = 'el-page' . ( $class ? ' ' . $class : '' );
	echo '<main id="main-content" class="' . esc_attr( $classes ) . '" role="main">';
}

function envision_legal_page_close() {
	echo '</main>';
}

// ── Excerpt length ─────────────────────────────────────────────────────────────
add_filter( 'excerpt_length', function() { return 30; } );
add_filter( 'excerpt_more',   function() { return '&hellip;'; } );

// ── Remove Astra sections that conflict ───────────────────────────────────────
add_action( 'wp_head', 'envision_legal_custom_head', 20 );
function envision_legal_custom_head() {
	// nothing here by default – hook available for child theme overrides
}

/**
 * Force-disable GoDaddy Launch "Coming Soon" page so the site renders normally.
 */

/**
 * Disable Astra header/footer output (we render our own in header.php/footer.php).
 */
add_action( 'wp', function () {

	// Header.
	remove_action( 'astra_header', 'astra_header_markup_open', 5 );
	remove_action( 'astra_header', 'astra_header_markup_close', 15 );
	remove_action( 'astra_header', 'astra_header_content', 10 );

	// Footer.
	remove_action( 'astra_footer', 'astra_footer_markup_open', 5 );
	remove_action( 'astra_footer', 'astra_footer_markup_close', 15 );
	remove_action( 'astra_footer', 'astra_footer_content', 10 );

}, 20 );

/**
 * Disable Astra header/footer output (we render our own in header.php/footer.php).
 */
add_action( 'wp', function () {

	// Header.
	remove_action( 'astra_header', 'astra_header_markup_open', 5 );
	remove_action( 'astra_header', 'astra_header_markup_close', 15 );
	remove_action( 'astra_header', 'astra_header_content', 10 );

	// Footer.
	remove_action( 'astra_footer', 'astra_footer_markup_open', 5 );
	remove_action( 'astra_footer', 'astra_footer_markup_close', 15 );
	remove_action( 'astra_footer', 'astra_footer_content', 10 );

}, 20 );

/**
 * Redirect legacy /blog to the current Posts page (Insights).
 */
add_action( 'template_redirect', function () {
	$request_uri = $_SERVER['REQUEST_URI'] ?? '';
	if ( untrailingslashit( $request_uri ) === '/blog' ) {
		$posts_page_id = (int) get_option( 'page_for_posts' );
		if ( $posts_page_id ) {
			wp_safe_redirect( get_permalink( $posts_page_id ), 301 );
			exit;
		}
	}
} );


/**
 * Global "Book Consultation" CTA on pages (except Home, Contact, and Book page).
 * Injected into the main page content so it works even if Astra hooks aren't used.
 */
add_filter( 'the_content', function ( $content ) {

	// Only inject into main page content.
	if ( ! is_page() || ! in_the_loop() || ! is_main_query() ) {
		return $content;
	}

	// Exclusions: Home (7), Contact (9), Book (46).
	if ( is_page( array( 7, 9, 46 ) ) ) {
		return $content;
	}

	$book_url = esc_url( home_url( '/book/' ) );

	$cta  = '<div class="el-page-cta" style="margin: 1.25rem 0 2rem;">';
	$cta .= '<a class="el-btn el-btn--primary" href="' . $book_url . '">Book Consultation</a>';
	$cta .= '</div>';

	return $cta . $content;

}, 12 );


/**
 * Referral Partner Portal — CPT + form handler.
 */
require_once get_stylesheet_directory() . '/referral-handler.php';

// ── Remove Astra featured image from blog cards ───────────────────────────────
add_action( 'wp', function() {
	if ( is_archive() || is_home() || is_search() ) {
		remove_action( 'astra_entry_top', 'astra_entry_thumbnail_before' );
		remove_action( 'astra_entry_top', 'astra_entry_thumbnail_after' );
		add_filter( 'astra_blog_post_featured_image_enabled', '__return_false' );
		add_filter( 'astra_blog_post_thumbnail', '__return_false' );
	}
});

/**
 * Lead magnet: Fractional Counsel PDF download (single opt-in).
 */
add_action( 'admin_post_nopriv_el_fc_download', 'el_handle_fc_download' );
add_action( 'admin_post_el_fc_download', 'el_handle_fc_download' );

function el_handle_fc_download() {
	$pdf_url = 'https://envisionlegal.com.au/wp-content/uploads/2026/04/Fractional-Counsel_Envision-Legal-1.pdf';

	// Nonce + honeypot checks.
	if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'el_fc_download' ) ) {
		wp_safe_redirect( home_url( '/fractional-general-counsel/?download=error' ) );
		exit;
	}
	if ( ! empty( $_POST['el_company'] ) ) { // honeypot (should be empty)
		wp_safe_redirect( home_url( '/fractional-general-counsel/?download=ok' ) );
		exit;
	}

	$name  = isset( $_POST['el_name'] ) ? sanitize_text_field( wp_unslash( $_POST['el_name'] ) ) : '';
	$email = isset( $_POST['el_email'] ) ? sanitize_email( wp_unslash( $_POST['el_email'] ) ) : '';

	if ( empty( $email ) || ! is_email( $email ) ) {
		wp_safe_redirect( home_url( '/fractional-general-counsel/?download=invalid' ) );
		exit;
	}

	// 1) Alert email to hello@
	$admin_to      = 'hello@envisionlegal.com.au';
	$admin_subject = 'Info Pack Download Request — Fractional General Counsel';
	$admin_body    = "Someone requested the Fractional Counsel info pack.\n\n"
		. 'Name: ' . ( $name ? $name : '(not provided)' ) . "\n"
		. 'Email: ' . $email . "\n"
		. 'Page: ' . home_url( '/fractional-general-counsel/' ) . "\n"
		. 'Time (UTC): ' . gmdate( 'Y-m-d H:i:s' ) . "\n";

	wp_mail( $admin_to, $admin_subject, $admin_body );

	// 2) Email the user the link
	$user_subject = 'Your Fractional Counsel Info Pack (PDF) — Envision Legal';
	$user_body    = 'Hi' . ( $name ? " {$name}" : '' ) . ",\n\n"
		. "Thanks for your interest in our Fractional General Counsel service.\n\n"
		. "Download the info pack here:\n{$pdf_url}\n\n"
		. "If you’d like to discuss next steps, reply to this email or contact us here:\n"
		. home_url( '/contact/' ) . "\n\n"
		. "Regards,\nEnvision Legal\n";

	$headers = array( 'Reply-To: Envision Legal <hello@envisionlegal.com.au>' );

	wp_mail( $email, $user_subject, $user_body, $headers );

	wp_safe_redirect( home_url( '/fractional-general-counsel/?download=ok' ) );
	exit;
}


/**
 * Leads (admin-only): store submissions & download requests.
 */
add_action( 'init', function() {
	if ( post_type_exists( 'el_lead' ) ) {
		return;
	}

	register_post_type(
		'el_lead',
		array(
			'labels' => array(
				'name'          => 'Leads',
				'singular_name' => 'Lead',
			),
			'public'          => false,
			'show_ui'         => true,
			'show_in_menu'    => true,
			'menu_icon'       => 'dashicons-groups',
			'supports'        => array( 'title' ),
			'capability_type' => 'post',
		)
	);
} );

/**
 * Store a lead in WP Admin (CPT: el_lead).
 *
 * @return int|WP_Error Lead post ID or error.
 */
function el_store_lead( $source, $name, $email, $meta = array() ) {
	$source = sanitize_key( (string) $source );
	$name   = sanitize_text_field( (string) $name );
	$email  = sanitize_email( (string) $email );

	$lead_id = wp_insert_post(
		array(
			'post_type'   => 'el_lead',
			'post_status' => 'publish',
			'post_title'  => ucfirst( str_replace( '-', ' ', $source ) ) . ' — ' . $email,
		)
	);

	if ( ! $lead_id || is_wp_error( $lead_id ) ) {
		return $lead_id;
	}

	update_post_meta( $lead_id, 'lead_source', $source );
	update_post_meta( $lead_id, 'name', $name );
	update_post_meta( $lead_id, 'email', $email );
	update_post_meta( $lead_id, 'created_utc', gmdate( 'Y-m-d H:i:s' ) );
	update_post_meta( $lead_id, 'ip', $_SERVER['REMOTE_ADDR'] ?? '' );
	update_post_meta( $lead_id, 'user_agent', $_SERVER['HTTP_USER_AGENT'] ?? '' );

	if ( is_array( $meta ) ) {
		foreach ( $meta as $k => $v ) {
			update_post_meta( $lead_id, sanitize_key( (string) $k ), is_scalar( $v ) ? (string) $v : wp_json_encode( $v ) );
		}
	}

	return $lead_id;
}

/**
 * Lead magnet: Fractional Counsel PDF download (single opt-in) — v2.
 * Stores lead in WP Admin + emails user + alerts hello@.
 */
add_action( 'admin_post_nopriv_el_fc_download_v2', 'el_handle_fc_download_v2' );
add_action( 'admin_post_el_fc_download_v2', 'el_handle_fc_download_v2' );

function el_handle_fc_download_v2() {
	$pdf_url = 'https://envisionlegal.com.au/wp-content/uploads/2026/04/Fractional-Counsel_Envision-Legal-1.pdf';

	// Nonce + honeypot checks.
	if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'el_fc_download' ) ) {
		wp_safe_redirect( home_url( '/fractional-general-counsel/?download=error' ) );
		exit;
	}
	if ( ! empty( $_POST['el_company'] ) ) { // honeypot (should be empty)
		wp_safe_redirect( home_url( '/fractional-general-counsel/?download=ok' ) );
		exit;
	}

	$name  = isset( $_POST['el_name'] ) ? sanitize_text_field( wp_unslash( $_POST['el_name'] ) ) : '';
	$email = isset( $_POST['el_email'] ) ? sanitize_email( wp_unslash( $_POST['el_email'] ) ) : '';

	if ( empty( $email ) || ! is_email( $email ) ) {
		wp_safe_redirect( home_url( '/fractional-general-counsel/?download=invalid' ) );
		exit;
	}

	// Store lead in WP.
	el_store_lead(
		'fractional-counsel-info-pack',
		$name,
		$email,
		array(
			'pdf_url' => $pdf_url,
			'page'    => home_url( '/fractional-general-counsel/' ),
		)
	);

	// 1) Alert email to hello@
	$admin_to      = 'hello@envisionlegal.com.au';
	$admin_subject = 'Info Pack Download Request — Fractional General Counsel';
	$admin_body    = "Someone requested the Fractional Counsel info pack.\n\n"
		. 'Name: ' . ( $name ? $name : '(not provided)' ) . "\n"
		. 'Email: ' . $email . "\n"
		. 'Page: ' . home_url( '/fractional-general-counsel/' ) . "\n"
		. 'Time (UTC): ' . gmdate( 'Y-m-d H:i:s' ) . "\n";

	wp_mail( $admin_to, $admin_subject, $admin_body );

	// 2) Email the user the link
	$user_subject = 'Your Fractional Counsel Info Pack (PDF) — Envision Legal';
	$user_body    = 'Hi' . ( $name ? " {$name}" : '' ) . ",\n\n"
		. "Thanks for your interest in our Fractional General Counsel service.\n\n"
		. "Download the info pack here:\n{$pdf_url}\n\n"
		. "If you’d like to discuss next steps, reply to this email or contact us here:\n"
		. home_url( '/contact/' ) . "\n\n"
		. "Regards,\nEnvision Legal\n";

	$headers = array( 'Reply-To: Envision Legal <hello@envisionlegal.com.au>' );

	wp_mail( $email, $user_subject, $user_body, $headers );

	wp_safe_redirect( home_url( '/fractional-general-counsel/?download=ok' ) );
	exit;
}


/**
 * Admin columns for Leads CPT.
 */
add_filter( 'manage_el_lead_posts_columns', function( $columns ) {
	$new = array();

	// Keep checkbox first.
	if ( isset( $columns['cb'] ) ) {
		$new['cb'] = $columns['cb'];
	}

	$new['title']       = 'Lead';
	$new['lead_name']   = 'Name';
	$new['lead_email']  = 'Email';
	$new['lead_source'] = 'Source';
	$new['date']        = $columns['date'] ?? 'Date';

	return $new;
} );

add_action( 'manage_el_lead_posts_custom_column', function( $column, $post_id ) {
	if ( 'lead_name' === $column ) {
		echo esc_html( get_post_meta( $post_id, 'name', true ) );
		return;
	}
	if ( 'lead_email' === $column ) {
		$email = get_post_meta( $post_id, 'email', true );
		if ( $email ) {
			echo '<a href="mailto:' . esc_attr( $email ) . '">' . esc_html( $email ) . '</a>';
		}
		return;
	}
	if ( 'lead_source' === $column ) {
		echo esc_html( get_post_meta( $post_id, 'lead_source', true ) );
		return;
	}
}, 10, 2 );


/**
 * Contact page: "Send Us a Message" fallback form handler.
 */
add_action( 'admin_post_nopriv_envision_contact', 'el_handle_contact_form' );
add_action( 'admin_post_envision_contact', 'el_handle_contact_form' );

function el_handle_contact_form() {
	$redirect_base = home_url( '/contact/' );

	// Nonce check.
	$nonce = isset( $_POST['el_contact_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['el_contact_nonce'] ) ) : '';
	if ( ! $nonce || ! wp_verify_nonce( $nonce, 'envision_contact' ) ) {
		wp_safe_redirect( add_query_arg( 'sent', 'error', $redirect_base ) );
		exit;
	}

	// Sanitize inputs.
	$name    = isset( $_POST['el_name'] )    ? sanitize_text_field( wp_unslash( $_POST['el_name'] ) )       : '';
	$email   = isset( $_POST['el_email'] )   ? sanitize_email( wp_unslash( $_POST['el_email'] ) )           : '';
	$phone   = isset( $_POST['el_phone'] )   ? sanitize_text_field( wp_unslash( $_POST['el_phone'] ) )      : '';
	$message = isset( $_POST['el_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['el_message'] ) ) : '';

	// Validate required fields.
	if ( empty( $name ) || empty( $message ) || ! is_email( $email ) ) {
		wp_safe_redirect( add_query_arg( 'sent', 'invalid', $redirect_base ) );
		exit;
	}

	// Store lead.
	el_store_lead(
		'contact-send-us-a-message',
		$name,
		$email,
		array(
			'phone'   => $phone,
			'message' => $message,
			'page'    => home_url( '/contact/' ),
		)
	);

	// Admin email.
	$admin_to      = get_theme_mod( 'envision_legal_email', 'hello@envisionlegal.com.au' );
	$safe_name     = str_replace( array( "\r", "\n" ), '', $name );
	$admin_subject = 'New Contact Message from ' . $safe_name . ' — Envision Legal';
	$admin_body    = "New contact form submission (Send Us a Message).\n\n"
		. 'Name: '    . $name    . "\n"
		. 'Email: '   . $email   . "\n"
		. 'Phone: '   . ( $phone ? $phone : '(not provided)' ) . "\n"
		. 'Message: '  . "\n" . $message . "\n\n"
		. 'Page: '    . home_url( '/contact/' ) . "\n"
		. 'Time (UTC): ' . gmdate( 'Y-m-d H:i:s' ) . "\n";

	$admin_headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . $safe_name . ' <' . $email . '>',
	);

	$sent = wp_mail( $admin_to, $admin_subject, $admin_body, $admin_headers );

	// Brief confirmation email to the user.
	$user_subject = 'We received your message — Envision Legal';
	$user_body    = 'Hi ' . $name . ",\n\n"
		. "Thanks for getting in touch. We've received your message and will respond within one business day.\n\n"
		. "If your matter is urgent, feel free to call us directly.\n\n"
		. "Regards,\nEnvision Legal\n";

	$user_headers = array( 'Reply-To: Envision Legal <' . $admin_to . '>' );

	wp_mail( $email, $user_subject, $user_body, $user_headers );

	// Redirect based on admin email result.
	if ( $sent ) {
		wp_safe_redirect( add_query_arg( 'sent', 'ok', $redirect_base ) );
	} else {
		wp_safe_redirect( add_query_arg( 'sent', 'error', $redirect_base ) );
	}
	exit;
}


/**
 * Practice-area "Get a Free Call Back" intake form handler.
 *
 * A single handler for all practice-area callback forms. Each template posts
 * to admin-post.php with action=el_practice_intake, a nonce, and a hidden
 * el_source field that identifies the originating page.
 */
add_action( 'admin_post_nopriv_el_practice_intake', 'el_handle_practice_intake_form' );
add_action( 'admin_post_el_practice_intake', 'el_handle_practice_intake_form' );

function el_handle_practice_intake_form() {

	/* ── Page config ─────────────────────────────────────────────────────── */
	$pages = array(
		'bsa' => array(
			'slug'             => 'business-sales-acquisitions',
			'anchor'           => 'bsa-enquiry-form',
			'label'            => 'Business Sales & Acquisitions',
			'required_selects' => array( 'bsa_role', 'bsa_value' ),
			'text_fields'      => array(
				'bsa_role'  => 'Role (Buying/Selling)',
				'bsa_value' => 'Approximate deal value',
			),
			'textarea_fields'  => array( 'bsa_notes' => 'Additional notes' ),
		),
		'bc' => array(
			'slug'             => 'business-contracts',
			'anchor'           => 'bc-enquiry-form',
			'label'            => 'Business Contracts',
			'required_selects' => array( 'bc_type' ),
			'text_fields'      => array( 'bc_type' => 'Contract type' ),
			'textarea_fields'  => array( 'bc_notes' => 'Additional notes' ),
		),
		'uct' => array(
			'slug'             => 'unfair-contract-terms',
			'anchor'           => 'uct-enquiry-form',
			'label'            => 'Unfair Contract Terms',
			'required_selects' => array( 'uct_need' ),
			'text_fields'      => array( 'uct_need' => 'Help needed' ),
			'textarea_fields'  => array( 'uct_notes' => 'Additional notes' ),
		),
		'sha' => array(
			'slug'             => 'shareholder-agreements',
			'anchor'           => 'sha-enquiry-form',
			'label'            => 'Shareholder Agreements',
			'required_selects' => array( 'sha_shareholders', 'sha_incorporated' ),
			'text_fields'      => array(
				'sha_shareholders' => 'Number of shareholders',
				'sha_incorporated' => 'Company incorporated',
			),
			'array_fields'     => array( 'sha_concerns' => 'Main concerns' ),
			'textarea_fields'  => array( 'sha_notes' => 'Additional notes' ),
		),
		'sl' => array(
			'slug'             => 'startup-legals',
			'anchor'           => 'sl-enquiry-form',
			'label'            => 'Startup Legals',
			'required_selects' => array( 'sl_stage', 'sl_need' ),
			'text_fields'      => array(
				'sl_stage' => 'Startup stage',
				'sl_need'  => 'Primary need',
			),
			'textarea_fields'  => array( 'sl_notes' => 'Additional notes' ),
		),
		'ip' => array(
			'slug'             => 'intellectual-property',
			'anchor'           => 'ip-enquiry-form',
			'label'            => 'Intellectual Property',
			'required_selects' => array( 'ip_type' ),
			'text_fields'      => array( 'ip_type' => 'IP matter type' ),
			'textarea_fields'  => array( 'ip_notes' => 'Additional notes' ),
		),
		'fgc' => array(
			'slug'             => 'fractional-general-counsel',
			'anchor'           => 'fgc-enquiry-form',
			'label'            => 'Fractional General Counsel',
			'required_selects' => array( 'fgc_size', 'fgc_spend' ),
			'text_fields'      => array(
				'fgc_company' => 'Company',
				'fgc_size'    => 'Number of employees',
				'fgc_spend'   => 'Monthly legal spend',
			),
			'textarea_fields'  => array( 'fgc_notes' => 'Additional notes' ),
		),
	);

	/* ── Determine source & redirect base ────────────────────────────────── */
	$source = isset( $_POST['el_source'] ) ? sanitize_key( wp_unslash( $_POST['el_source'] ) ) : '';

	if ( ! isset( $pages[ $source ] ) ) {
		wp_safe_redirect( home_url( '/' ) );
		exit;
	}

	$cfg    = $pages[ $source ];
	$anchor = $cfg['anchor'];

	/* Build a reliable redirect base URL. */
	$referer = wp_get_referer();
	if ( $referer ) {
		/* Strip any existing query string / fragment from the referer. */
		$parts         = parse_url( $referer );
		$redirect_base = ( isset( $parts['scheme'] ) ? $parts['scheme'] . '://' : '' )
			. ( isset( $parts['host'] ) ? $parts['host'] : '' )
			. ( isset( $parts['path'] ) ? $parts['path'] : '/' );
	} else {
		$redirect_base = home_url( '/' . $cfg['slug'] . '/' );
	}

	/* ── Nonce ───────────────────────────────────────────────────────────── */
	$nonce = isset( $_POST['el_practice_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['el_practice_nonce'] ) ) : '';
	if ( ! $nonce || ! wp_verify_nonce( $nonce, 'el_practice_intake' ) ) {
		wp_safe_redirect( add_query_arg( 'enquiry', 'error', $redirect_base ) . '#' . $anchor );
		exit;
	}

	/* ── Common fields ───────────────────────────────────────────────────── */
	$prefix = $source . '_';
	$name   = isset( $_POST[ $prefix . 'name' ] )  ? sanitize_text_field( wp_unslash( $_POST[ $prefix . 'name' ] ) )  : '';
	$email  = isset( $_POST[ $prefix . 'email' ] ) ? sanitize_email( wp_unslash( $_POST[ $prefix . 'email' ] ) )      : '';
	$phone  = isset( $_POST[ $prefix . 'phone' ] ) ? sanitize_text_field( wp_unslash( $_POST[ $prefix . 'phone' ] ) ) : '';

	if ( empty( $name ) || ! is_email( $email ) || empty( $phone ) ) {
		wp_safe_redirect( add_query_arg( 'enquiry', 'invalid', $redirect_base ) . '#' . $anchor );
		exit;
	}

	/* ── Required selects ────────────────────────────────────────────────── */
	foreach ( $cfg['required_selects'] as $field ) {
		$val = isset( $_POST[ $field ] ) ? sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) : '';
		if ( empty( $val ) ) {
			wp_safe_redirect( add_query_arg( 'enquiry', 'invalid', $redirect_base ) . '#' . $anchor );
			exit;
		}
	}

	/* ── Collect all extra fields for meta + email body ──────────────────── */
	$meta        = array( 'phone' => $phone, 'page_url' => $redirect_base );
	$email_lines = '';

	// Text / select fields.
	if ( ! empty( $cfg['text_fields'] ) ) {
		foreach ( $cfg['text_fields'] as $field => $label ) {
			$val               = isset( $_POST[ $field ] ) ? sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) : '';
			$meta_key          = str_replace( $prefix, '', $field );
			$meta[ $meta_key ] = $val;
			$email_lines      .= $label . ': ' . ( $val ? $val : '(not provided)' ) . "\n";
		}
	}

	// Array (checkbox) fields.
	if ( ! empty( $cfg['array_fields'] ) ) {
		foreach ( $cfg['array_fields'] as $field => $label ) {
			$raw               = isset( $_POST[ $field ] ) ? wp_unslash( $_POST[ $field ] ) : array();
			$val               = is_array( $raw ) ? implode( ', ', array_map( 'sanitize_text_field', $raw ) ) : sanitize_text_field( $raw );
			$meta_key          = str_replace( $prefix, '', $field );
			$meta[ $meta_key ] = $val;
			$email_lines      .= $label . ': ' . ( $val ? $val : '(none selected)' ) . "\n";
		}
	}

	// Textarea fields.
	if ( ! empty( $cfg['textarea_fields'] ) ) {
		foreach ( $cfg['textarea_fields'] as $field => $label ) {
			$val               = isset( $_POST[ $field ] ) ? sanitize_textarea_field( wp_unslash( $_POST[ $field ] ) ) : '';
			$meta_key          = str_replace( $prefix, '', $field );
			$meta[ $meta_key ] = $val;
			$email_lines      .= $label . ":\n" . ( $val ? $val : '(not provided)' ) . "\n";
		}
	}

	/* ── Store lead ──────────────────────────────────────────────────────── */
	el_store_lead(
		'practice-' . $source . '-callback',
		$name,
		$email,
		$meta
	);

	/* ── Admin email ─────────────────────────────────────────────────────── */
	$admin_to      = sanitize_email( get_theme_mod( 'envision_legal_email', 'hello@envisionlegal.com.au' ) );
	if ( ! is_email( $admin_to ) ) {
		$admin_to = 'hello@envisionlegal.com.au';
	}
	$safe_name     = sanitize_text_field( str_replace( array( "\r", "\n" ), '', $name ) );
	$admin_subject = 'New ' . $cfg['label'] . ' Enquiry from ' . $safe_name . ' — Envision Legal';
	$admin_body    = 'New ' . $cfg['label'] . " callback enquiry from the website.\n\n"
		. 'Name: '  . $name  . "\n"
		. 'Email: ' . $email . "\n"
		. 'Phone: ' . $phone . "\n"
		. $email_lines . "\n"
		. 'Page: '         . $redirect_base              . "\n"
		. 'Time (UTC): '   . gmdate( 'Y-m-d H:i:s' )    . "\n";

	$admin_headers = array(
		'Content-Type: text/plain; charset=UTF-8',
		'Reply-To: ' . $safe_name . ' <' . $email . '>',
	);

	$sent = wp_mail( $admin_to, $admin_subject, $admin_body, $admin_headers );

	/* ── Confirmation email to user ──────────────────────────────────────── */
	$user_subject = 'We received your enquiry — Envision Legal';
	$user_body    = 'Hi ' . $name . ",\n\n"
		. "Thanks for getting in touch. We've received your enquiry and will respond within one business day.\n\n"
		. "If your matter is urgent, feel free to call us directly.\n\n"
		. "Regards,\nEnvision Legal\n";

	$user_headers = array( 'Reply-To: Envision Legal <' . $admin_to . '>' );

	wp_mail( $email, $user_subject, $user_body, $user_headers );

	/* ── Redirect ────────────────────────────────────────────────────────── */
	wp_safe_redirect( add_query_arg( 'enquiry', 'ok', $redirect_base ) . '#' . $anchor );
	exit;
}

