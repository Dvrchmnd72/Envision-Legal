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
define( 'ENVISION_LEGAL_VERSION', '2.0.0' );
define( 'ENVISION_LEGAL_DIR', get_stylesheet_directory() );
define( 'ENVISION_LEGAL_URI', get_stylesheet_directory_uri() );

// ── Enqueue styles and scripts ────────────────────────────────────────────────
add_action( 'wp_enqueue_scripts', 'envision_legal_enqueue_assets' );
function envision_legal_enqueue_assets() {
	// 1. Child theme style overrides
	wp_enqueue_style(
		'envision-legal-style',
		ENVISION_LEGAL_URI . '/style.css',
		array(),
		ENVISION_LEGAL_VERSION
	);

	// 3. Google Fonts – Inter + Playfair Display
	wp_enqueue_style(
		'envision-legal-google-fonts',
		'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;600;700&display=swap',
		array(),
		null
	);

	// 4. Theme JavaScript
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

// ── Override parent stylesheet – runs after the default priority-10 enqueue ──
add_action( 'wp_enqueue_scripts', 'envision_legal_child_override_styles', 20 );
function envision_legal_child_override_styles() {
	// Ensure the child theme's CSS wins even if a parent theme registered the
	// same handle at the default priority (10).
	wp_dequeue_style( 'envision-legal-theme' );
	wp_deregister_style( 'envision-legal-theme' );

	wp_enqueue_style(
		'envision-legal-theme',
		ENVISION_LEGAL_URI . '/assets/css/theme.css',
		array( 'envision-legal-style' ),
		ENVISION_LEGAL_VERSION
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
if ( ! function_exists( 'envision_legal_header' ) ) :
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
				<svg class="el-nav-toggle__icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#111827" stroke-width="2" stroke-linecap="round" aria-hidden="true">
					<line x1="3" y1="6" x2="21" y2="6"/>
					<line x1="3" y1="12" x2="21" y2="12"/>
					<line x1="3" y1="18" x2="21" y2="18"/>
				</svg>
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
endif;

// Fallback menu when no menu is assigned
function envision_legal_fallback_menu() {
	echo '<ul class="el-nav__list">';
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'envision-legal' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/about' ) ) . '">' . esc_html__( 'About', 'envision-legal' ) . '</a></li>';
	echo '<li><a href="' . esc_url( home_url( '/practice-areas/' ) ) . '">' . esc_html__( 'Practice Areas', 'envision-legal' ) . '</a></li>';
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
					<a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><?php esc_html_e( 'Privacy Policy', 'envision-legal' ); ?></a>
					&nbsp;&middot;&nbsp;
					<a href="<?php echo esc_url( home_url( '/terms-of-use/' ) ); ?>"><?php esc_html_e( 'Terms of Use', 'envision-legal' ); ?></a>
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

// ── Optional head hook for theme-level customizations ─────────────────────────
add_action( 'wp_head', 'envision_legal_custom_head', 20 );
function envision_legal_custom_head() {
	// Intentionally empty by default; available as a stable hook point.
}

/**
 * Force-disable GoDaddy Launch "Coming Soon" page so the site renders normally.
 */

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
 * 301 redirects for legacy unhyphenated slugs → canonical hyphenated versions.
 */
add_action( 'template_redirect', function () {
	$request = untrailingslashit( strtok( wp_unslash( $_SERVER['REQUEST_URI'] ?? '' ), '?' ) );

	$redirects = array(
		'/practiceareas'  => '/practice-areas/',
		'/termsofuse'     => '/terms-of-use/',
		'/privacypolicy'  => '/privacy-policy/',
	);

	if ( isset( $redirects[ $request ] ) ) {
		wp_safe_redirect( home_url( $redirects[ $request ] ), 301 );
		exit;
	}
} );


/**
 * Global "Book Consultation" CTA on pages (except Home, Contact, and Book page).
 * Injected into the main page content via the_content filter.
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
 * Return a human-readable label for a lead source slug.
 *
 * @param  string $source  The raw source slug stored in post meta.
 * @return string          Human-readable label, or a title-cased fallback.
 */
function el_lead_source_label( $source ) {
	$map = array(
		'practice-bsa-callback'        => 'Business Sales & Acquisitions — Callback',
		'practice-bc-callback'         => 'Business Contracts — Callback',
		'practice-uct-callback'        => 'Unfair Contract Terms — Callback',
		'practice-sha-callback'        => 'Shareholder Agreements — Callback',
		'practice-sl-callback'         => 'Startup Legals — Callback',
		'practice-ip-callback'         => 'Intellectual Property — Callback',
		'practice-fgc-callback'        => 'Fractional General Counsel — Callback',
		'fractional-counsel-info-pack' => 'Fractional Counsel — Info Pack Download',
		'contact-send-us-a-message'    => 'Contact — Send Us a Message',
	);

	if ( isset( $map[ $source ] ) ) {
		return $map[ $source ];
	}

	// Fallback: title-case the slug.
	return ucwords( str_replace( '-', ' ', $source ) );
}

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
			'post_title'  => el_lead_source_label( $source ) . ' — ' . $email,
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

	$new['title']        = 'Lead';
	$new['lead_name']    = 'Name';
	$new['lead_email']   = 'Email';
	$new['lead_source']  = 'Source';
	$new['lead_details'] = 'Details';
	$new['date']         = $columns['date'] ?? 'Date';

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
		$source = get_post_meta( $post_id, 'lead_source', true );
		echo esc_html( el_lead_source_label( $source ) );
		return;
	}
	if ( 'lead_details' === $column ) {
		// Keys that are already shown in other columns or are internal.
		$skip = array( 'lead_source', 'name', 'email', 'created_utc', 'ip', 'user_agent', 'page_url', 'page', 'pdf_url' );
		$all  = get_post_meta( $post_id );
		$bits = array();

		foreach ( $all as $key => $values ) {
			if ( strpos( $key, '_' ) === 0 || in_array( $key, $skip, true ) ) {
				continue;
			}
			$val = $values[0] ?? '';
			if ( '' === $val ) {
				continue;
			}
			$label  = el_lead_meta_label( $key );
			$bits[] = $label . ': ' . wp_trim_words( $val, 8, '…' );
		}

		echo esc_html( implode( ' | ', $bits ) );
		return;
	}
}, 10, 2 );

/**
 * Human-readable labels for known lead meta keys.
 *
 * @param  string $key  The raw meta key.
 * @return string       Readable label.
 */
function el_lead_meta_label( $key ) {
	$labels = array(
		'lead_source'      => 'Source',
		'name'             => 'Name',
		'email'            => 'Email',
		'phone'            => 'Phone',
		'created_utc'      => 'Created (UTC)',
		'ip'               => 'IP Address',
		'user_agent'       => 'User Agent',
		'page_url'         => 'Page URL',
		'page'             => 'Page',
		'pdf_url'          => 'PDF URL',
		'message'          => 'Message',
		'role'             => 'Role',
		'value'            => 'Deal Value',
		'notes'            => 'Notes',
		'type'             => 'Type',
		'need'             => 'Help Needed',
		'shareholders'     => 'Shareholders',
		'incorporated'     => 'Incorporated',
		'concerns'         => 'Concerns',
		'stage'            => 'Stage',
		'company'          => 'Company',
		'size'             => 'Number of Employees',
		'spend'            => 'Monthly Legal Spend',
		'bsa_role'         => 'Role (Buying/Selling)',
		'bsa_value'        => 'Approximate Deal Value',
		'bsa_notes'        => 'Additional Notes',
		'bc_type'          => 'Contract Type',
		'bc_notes'         => 'Additional Notes',
		'uct_need'         => 'Help Needed',
		'uct_notes'        => 'Additional Notes',
		'sha_shareholders' => 'Number of Shareholders',
		'sha_incorporated' => 'Company Incorporated',
		'sha_concerns'     => 'Main Concerns',
		'sha_notes'        => 'Additional Notes',
		'sl_stage'         => 'Startup Stage',
		'sl_need'          => 'Primary Need',
		'sl_notes'         => 'Additional Notes',
		'ip_type'          => 'IP Matter Type',
		'ip_notes'         => 'Additional Notes',
		'fgc_company'      => 'Company',
		'fgc_size'         => 'Number of Employees',
		'fgc_spend'        => 'Monthly Legal Spend',
		'fgc_notes'        => 'Additional Notes',
	);

	if ( isset( $labels[ $key ] ) ) {
		return $labels[ $key ];
	}

	// Fallback: title-case the key.
	return ucwords( str_replace( '_', ' ', $key ) );
}

/**
 * Read-only meta box on the el_lead edit screen.
 */
add_action( 'add_meta_boxes_el_lead', function() {
	add_meta_box(
		'el_lead_details_meta_box',
		'Lead Details',
		'el_render_lead_details_meta_box',
		'el_lead',
		'normal',
		'high'
	);
} );

function el_render_lead_details_meta_box( $post ) {
	$all_meta = get_post_meta( $post->ID );

	if ( empty( $all_meta ) ) {
		echo '<p>No meta data stored for this lead.</p>';
		return;
	}

	echo '<table class="widefat fixed striped" style="border:0">';
	echo '<thead><tr><th style="width:25%">Field</th><th>Value</th></tr></thead><tbody>';

	foreach ( $all_meta as $key => $values ) {
		// Skip internal WP keys.
		if ( strpos( $key, '_' ) === 0 ) {
			continue;
		}

		$label = el_lead_meta_label( $key );
		$val   = $values[0] ?? '';

		// If the source field, show the human-readable label.
		if ( 'lead_source' === $key ) {
			$val = el_lead_source_label( $val );
		}

		echo '<tr>';
		echo '<td><strong>' . esc_html( $label ) . '</strong></td>';
		echo '<td>' . nl2br( esc_html( $val ) ) . '</td>';
		echo '</tr>';
	}

	echo '</tbody></table>';
}

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

// ══════════════════════════════════════════════════════════════════════════════
// SEO Layer – meta descriptions, Open Graph, JSON-LD schema, sitemap, robots
// ══════════════════════════════════════════════════════════════════════════════

/**
 * Return page-specific SEO data based on template or page type.
 *
 * @return array{title:string,description:string,schema:array,breadcrumb:array}
 */
function el_get_seo_data() {
	$site_name = get_bloginfo( 'name' );
	$home      = home_url( '/' );
	$phone     = envision_legal_get_phone();
	$email     = envision_legal_get_email();
	$logo_url  = esc_url( ENVISION_LEGAL_URI . '/assets/images/logo.png' );

	// Base LocalBusiness schema shared by home + local pages.
	$local_business_schema = array(
		'@context'     => 'https://schema.org',
		'@type'        => array( 'LegalService', 'LocalBusiness' ),
		'name'         => 'Envision Legal',
		'url'          => $home,
		'logo'         => $logo_url,
		'telephone'    => $phone,
		'email'        => $email,
		'address'      => array(
			'@type'           => 'PostalAddress',
			'addressLocality' => 'Leppington',
			'addressRegion'   => 'NSW',
			'addressCountry'  => 'AU',
		),
		'areaServed'   => array(
			'Campbelltown', 'Liverpool', 'Parramatta', 'Bankstown',
			'Fairfield', 'Penrith', 'Macarthur', 'Camden', 'Wollondilly', 'Leppington',
		),
		'priceRange'   => '$$',
		'openingHours' => 'Mo-Fr 09:00-17:00',
		'sameAs'       => array(),
	);

	// Helper to build a LegalService schema for practice area pages.
	$practice_schema = function ( $service_type, $description ) use ( $local_business_schema ) {
		$schema               = $local_business_schema;
		$schema['@type']      = 'LegalService';
		$schema['serviceType'] = $service_type;
		$schema['description'] = $description;
		return $schema;
	};

	// Helper to build FAQPage schema.
	$faq_schema = function ( $faqs ) {
		$entities = array();
		foreach ( $faqs as $q => $a ) {
			$entities[] = array(
				'@type'          => 'Question',
				'name'           => $q,
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => $a,
				),
			);
		}
		return array(
			'@context'   => 'https://schema.org',
			'@type'      => 'FAQPage',
			'mainEntity' => $entities,
		);
	};

	$template = get_page_template_slug();

	// ── Front Page ──────────────────────────────────────────────────────────
	if ( is_front_page() ) {
		return array(
			'title'       => 'Commercial Lawyers South-West Sydney | Envision Legal',
			'description' => 'Envision Legal is a boutique commercial law firm in South-West Sydney. Fixed-fee business contracts, startup legals, shareholder agreements and fractional general counsel. Free consultation.',
			'schema'      => array( $local_business_schema ),
			'breadcrumb'  => array(),
		);
	}

	// ── Business Contracts ──────────────────────────────────────────────────
	if ( 'page-business-contracts.php' === $template ) {
		return array(
			'title'       => 'Business Contract Lawyers Sydney | Envision Legal',
			'description' => 'Expert business contract lawyers serving Campbelltown, Liverpool and Parramatta. Fixed-fee drafting, review and negotiation of commercial contracts. Get a free call back today.',
			'schema'      => array(
				$practice_schema( 'Business Contracts', 'Expert business contract lawyers serving Campbelltown, Liverpool and Parramatta. Fixed-fee drafting, review and negotiation of commercial contracts.' ),
				$faq_schema( array(
					'How much does a commercial contract cost?' => 'Simple NDAs and standard service agreements typically start from $500 + GST on a fixed-fee basis. More complex contracts are quoted after a brief consultation. We are transparent about costs before we start.',
					'Can you review a contract someone else has sent me?' => 'Yes. Contract review is one of our most common services. We read the full document, flag any terms that expose you to risk, and advise on what to push back on before you sign.',
					'What if the other side uses their own standard terms?' => 'We negotiate on your behalf. We identify the clauses that matter most — liability caps, indemnities, termination rights — and work to get you better terms without blowing up the deal.',
					'Do you handle ongoing contract management?' => 'Yes — through our Fractional General Counsel service, we can manage your contract library, run renewals and flag risk across your entire agreement portfolio on a retainer basis.',
				) ),
			),
			'breadcrumb' => array(
				'Home'               => $home,
				'Practice Areas'     => home_url( '/practice-areas/' ),
				'Business Contracts' => home_url( '/business-contracts/' ),
			),
		);
	}

	// ── Business Sales & Acquisitions ────────────────────────────────────────
	if ( 'page-business-sales-acquisitions.php' === $template ) {
		return array(
			'title'       => 'Business Sales & Acquisitions Lawyers Sydney | Envision Legal',
			'description' => 'Buying or selling a business in Sydney? Envision Legal guides buyers and sellers through due diligence, business sale agreements, and settlement. Free call back.',
			'schema'      => array(
				$practice_schema( 'Business Sales and Acquisitions', 'Buying or selling a business in Sydney? Envision Legal guides buyers and sellers through due diligence, business sale agreements, and settlement.' ),
				$faq_schema( array(
					'How long does a business sale take?' => 'A straightforward asset sale typically completes in 4–8 weeks from execution of the sale agreement. More complex transactions or those involving regulatory approvals can take longer. Early legal involvement reduces delays.',
					'What is the difference between an asset sale and a share sale?' => 'In an asset sale, the buyer acquires specific business assets. In a share sale, the buyer acquires the company itself including all its history and liabilities. Each has different tax, risk and stamp duty implications.',
					'Do I need a lawyer if I am using a business broker?' => 'Yes. A broker manages the commercial negotiation and marketing — a lawyer reviews and drafts the legal documents that bind you. The two roles are complementary, not interchangeable.',
				) ),
			),
			'breadcrumb' => array(
				'Home'                         => $home,
				'Practice Areas'               => home_url( '/practice-areas/' ),
				'Business Sales & Acquisitions' => home_url( '/business-sales-acquisitions/' ),
			),
		);
	}

	// ── Shareholder Agreements ───────────────────────────────────────────────
	if ( 'page-shareholder-agreements.php' === $template ) {
		return array(
			'title'       => 'Shareholder Agreement Lawyers Sydney | Envision Legal',
			'description' => 'Protect your shares and business relationships with a properly drafted shareholders agreement. Serving businesses across South-West Sydney. Fixed-fee, free call back.',
			'schema'      => array(
				$practice_schema( 'Shareholder Agreements', 'Protect your shares and business relationships with a properly drafted shareholders agreement. Serving businesses across South-West Sydney.' ),
				$faq_schema( array(
					'How much does a shareholders agreement cost?' => 'A straightforward two-shareholder agreement for a small business typically starts from $1,500 + GST. More complex structures with multiple shareholders, vesting schedules or bespoke exit mechanisms are quoted individually.',
					'Do I need one if I already have a company constitution?' => 'Yes. A constitution is a public document that must comply with the Corporations Act. A shareholders agreement is private, flexible and can address any issue the shareholders agree is important.',
					'When is the best time to put one in place?' => 'Before you need it. The conversation is straightforward when all shareholders are aligned and optimistic. It becomes significantly harder and more expensive once a dispute has arisen or a shareholder wants to exit.',
					'Can you review an existing agreement?' => 'Absolutely. We review existing shareholders agreements and partnership agreements, identify gaps or unfair terms, and advise on whether amendments are required.',
				) ),
			),
			'breadcrumb' => array(
				'Home'                    => $home,
				'Practice Areas'          => home_url( '/practice-areas/' ),
				'Shareholder Agreements'  => home_url( '/shareholder-agreements/' ),
			),
		);
	}

	// ── Startup Legals ──────────────────────────────────────────────────────
	if ( 'page-startup-legals.php' === $template ) {
		return array(
			'title'       => 'Startup Lawyers Sydney | Co-Founder Agreements & SAFE Notes | Envision Legal',
			'description' => 'Legal foundations for startups and founders in Sydney. Co-founder agreements, SAFE notes, ESOPs, IP assignment and seed investment documents. Fixed-fee, free call back.',
			'schema'      => array(
				$practice_schema( 'Startup Legal Services', 'Legal foundations for startups and founders in Sydney. Co-founder agreements, SAFE notes, ESOPs, IP assignment and seed investment documents.' ),
				$faq_schema( array(
					'When should I get legal advice as a founder?' => 'Before you take on a co-founder, before you bring in your first employee, and before you accept any investment. These are the three moments where a poorly structured deal creates problems that are very expensive to unwind later.',
					'What is a SAFE note and do I need one?' => 'A SAFE (Simple Agreement for Future Equity) is a short-form investment instrument where an investor puts in money now in exchange for the right to receive equity at a future valuation event. It is faster and cheaper than a priced round and is standard for early-stage Australian startups.',
					'How does founder vesting work?' => 'Founder vesting means that equity is earned over time rather than granted upfront. A typical structure is a 4-year vest with a 1-year cliff — meaning if a founder leaves in year one, they receive nothing; after that equity vests monthly or quarterly.',
					'Do you work with pre-revenue startups?' => 'Yes. We offer fixed-fee packages for early-stage founders and can work with you on a staged basis as you grow. We would rather help you get it right early than fix a structural problem during a due diligence process.',
				) ),
			),
			'breadcrumb' => array(
				'Home'           => $home,
				'Practice Areas' => home_url( '/practice-areas/' ),
				'Startup Legals' => home_url( '/startup-legals/' ),
			),
		);
	}

	// ── Intellectual Property ────────────────────────────────────────────────
	if ( 'page-intellectual-property.php' === $template ) {
		return array(
			'title'       => 'Intellectual Property & Trademark Lawyers Sydney | Envision Legal',
			'description' => 'Trademark registration, IP licensing and copyright advice for businesses in South-West Sydney. Protect your brand before someone else does. Fixed-fee, free call back.',
			'schema'      => array(
				$practice_schema( 'Intellectual Property Law', 'Trademark registration, IP licensing and copyright advice for businesses in South-West Sydney. Protect your brand before someone else does.' ),
				$faq_schema( array(
					'How much does trademark registration cost?' => 'IP Australia\'s government fees start from around $250 per class for online applications. Our legal fees for a standard single-class application start from $600 + GST. We provide a fixed-fee quote before commencing.',
					'Do I automatically own the IP my contractor creates?' => 'No — under Australian copyright law, the creator owns copyright unless there is a written agreement transferring ownership. If you have engaged a designer, developer or consultant without a written IP assignment, you may not own what you paid for.',
					'What is the difference between a trademark and a business name?' => 'Registering a business name with ASIC gives you the right to trade under that name — it does not give you exclusive trademark rights. A registered trademark gives you the legal right to stop others from using a confusingly similar mark.',
					'How long does trademark registration take?' => 'In Australia, a trademark application typically takes 7–9 months from filing to registration, assuming no objections. We manage the process and keep you updated at each stage.',
				) ),
			),
			'breadcrumb' => array(
				'Home'                  => $home,
				'Practice Areas'        => home_url( '/practice-areas/' ),
				'Intellectual Property'  => home_url( '/intellectual-property/' ),
			),
		);
	}

	// ── Unfair Contract Terms ────────────────────────────────────────────────
	if ( 'page-unfair-contract-terms.php' === $template ) {
		return array(
			'title'       => 'Unfair Contract Terms Lawyers Sydney | ACL Compliance | Envision Legal',
			'description' => 'Is your business ready for Australia\'s strengthened unfair contract terms regime? Envision Legal audits and redrafts standard-form contracts for ACL compliance. Get a free call back.',
			'schema'      => array(
				$practice_schema( 'Unfair Contract Terms', 'Envision Legal audits and redrafts standard-form contracts for ACL compliance with Australia\'s strengthened unfair contract terms regime.' ),
				$faq_schema( array(
					'What are the penalties for including unfair terms?' => 'Businesses face civil penalties of up to $50 million for bodies corporate. Individuals face penalties of up to $2.5 million. This is a significant increase from the previous regime where no pecuniary penalties applied.',
					'Does this apply to B2B contracts?' => 'Yes — the UCT regime applies to standard-form contracts with small businesses up to 100 employees or $10 million turnover. If you use standard-form contracts with any of these counterparties, you need to review them.',
					'What is a standard-form contract?' => 'A standard-form contract is one prepared by one party and presented to the other on a take-it-or-leave-it basis with little opportunity to negotiate. Courts look at the substance — even a lightly negotiated contract can be treated as standard-form.',
					'How quickly can you audit our contracts?' => 'For most standard-form contracts we can complete an initial risk assessment within 3–5 business days and provide a written summary of findings and recommended changes.',
				) ),
			),
			'breadcrumb' => array(
				'Home'                  => $home,
				'Practice Areas'        => home_url( '/practice-areas/' ),
				'Unfair Contract Terms'  => home_url( '/unfair-contract-terms/' ),
			),
		);
	}

	// ── Fractional General Counsel ───────────────────────────────────────────
	if ( 'page-fractional-general-counsel.php' === $template ) {
		return array(
			'title'       => 'Fractional General Counsel Sydney | In-House Legal on Retainer | Envision Legal',
			'description' => 'Senior in-house legal expertise on a flexible retainer from $2,500/month + GST. Envision Legal\'s Fractional General Counsel service for growing businesses in South-West Sydney.',
			'schema'      => array(
				$practice_schema( 'Fractional General Counsel', 'Senior in-house legal expertise on a flexible retainer. Envision Legal\'s Fractional General Counsel service for growing businesses in South-West Sydney.' ),
				$faq_schema( array(
					'How much does Fractional General Counsel cost?' => 'Most clients start from $2,500 + GST per month on a fixed monthly fee agreed after an initial scoping conversation — no surprise bills.',
					'What size business is this suited to?' => 'Businesses with 10–200 employees or $2M–$50M annual turnover. If you are spending more than $3,000/month on ad hoc legal fees, a retainer almost certainly makes more financial sense.',
					'Can I still use other lawyers for specialist matters?' => 'Yes. We coordinate with your existing advisors and refer specialist matters — litigation, property or tax — to trusted specialists, managing those relationships on your behalf.',
					'Is there a minimum commitment?' => 'We ask for an initial three-month engagement so we can properly embed in your business. After that the arrangement continues on a rolling monthly basis with 30 days notice to end.',
				) ),
			),
			'breadcrumb' => array(
				'Home'                       => $home,
				'Fractional General Counsel'  => home_url( '/fractional-general-counsel/' ),
			),
		);
	}

	// ── South-West Sydney Lawyers ────────────────────────────────────────────
	if ( 'page-south-west-sydney-lawyers.php' === $template ) {
		return array(
			'title'       => 'Commercial Lawyers South-West Sydney | Campbelltown, Liverpool & Parramatta',
			'description' => 'Local commercial law firm serving Campbelltown, Liverpool, Parramatta, Bankstown and surrounding suburbs. Business contracts, startup legals, IP and fractional counsel. Free consultation.',
			'schema'      => array( $local_business_schema ),
			'breadcrumb'  => array(),
		);
	}

	// ── Referrals ────────────────────────────────────────────────────────────
	if ( 'page-referrals.php' === $template ) {
		return array(
			'title'       => 'Referral Partner Program | Envision Legal',
			'description' => 'Refer your clients to Envision Legal and earn competitive referral fees. Accountants, finance brokers, business brokers and financial planners welcome. Submit a referral in 2 minutes.',
			'schema'      => array(
				array(
					'@context'    => 'https://schema.org',
					'@type'       => 'Service',
					'serviceType' => 'Legal Referral Program',
					'provider'    => array(
						'@type' => 'LegalService',
						'name'  => 'Envision Legal',
						'url'   => $home,
					),
				),
			),
			'breadcrumb' => array(),
		);
	}

	// ── Contact ──────────────────────────────────────────────────────────────
	if ( 'page-contact.php' === $template ) {
		return array(
			'title'       => 'Contact Envision Legal | Commercial Lawyers South-West Sydney',
			'description' => 'Get in touch with Envision Legal. Book a free consultation, send us a message, or call us directly. We respond within one business day.',
			'schema'      => array(
				array(
					'@context' => 'https://schema.org',
					'@type'    => 'ContactPage',
					'name'     => 'Contact Envision Legal',
					'url'      => home_url( '/contact/' ),
				),
			),
			'breadcrumb' => array(),
		);
	}

	// ── About ────────────────────────────────────────────────────────────────
	if ( 'page-about.php' === $template ) {
		return array(
			'title'       => 'About Envision Legal | Commercial Lawyers South-West Sydney',
			'description' => 'Learn about Envision Legal — a boutique commercial law firm in South-West Sydney. We provide fixed-fee, commercially-minded legal advice to businesses across Campbelltown, Liverpool and Parramatta.',
			'schema'      => array(
				array(
					'@context'    => 'https://schema.org',
					'@type'       => 'AboutPage',
					'name'        => 'About Envision Legal',
					'url'         => home_url( '/about/' ),
					'description' => 'Envision Legal is a boutique commercial law firm in South-West Sydney providing fixed-fee, commercially-minded legal advice to businesses.',
					'publisher'   => array(
						'@type' => 'LegalService',
						'name'  => 'Envision Legal',
						'url'   => home_url( '/' ),
					),
				),
				$local_business_schema,
			),
			'breadcrumb' => array(),
		);
	}

	// ── Book a Consultation ──────────────────────────────────────────────────
	if ( 'page-book.php' === $template ) {
		return array(
			'title'       => 'Book a Free Consultation | Envision Legal',
			'description' => 'Book your free 30-minute consultation with Envision Legal. Our commercial lawyers serve businesses across South-West Sydney including Campbelltown, Liverpool and Parramatta.',
			'schema'      => array(
				array(
					'@context'        => 'https://schema.org',
					'@type'           => 'LegalService',
					'name'            => 'Envision Legal',
					'url'             => $home,
					'telephone'       => $phone,
					'potentialAction' => array(
						'@type'  => 'ReserveAction',
						'name'   => 'Book a Free Consultation',
						'target' => home_url( '/book/' ),
					),
				),
				$local_business_schema,
			),
			'breadcrumb' => array(),
		);
	}

	// ── Fallback ─────────────────────────────────────────────────────────────
	$fallback_title = is_singular()
		? get_the_title() . ' | ' . $site_name
		: $site_name;
	$fallback_desc  = get_bloginfo( 'description' );

	return array(
		'title'       => $fallback_title,
		'description' => $fallback_desc,
		'schema'      => array(),
		'breadcrumb'  => array(),
	);
}

/**
 * Override <title> via WordPress title-tag support.
 */
add_filter( 'pre_get_document_title', 'el_seo_title' );
function el_seo_title( $title ) {
	if ( is_admin() ) {
		return $title;
	}
	$seo = el_get_seo_data();
	return $seo['title'] ? $seo['title'] : $title;
}

/**
 * Output meta description, canonical, Open Graph, Twitter Card and JSON-LD.
 */
add_action( 'wp_head', 'el_seo_head', 1 );
function el_seo_head() {
	$seo       = el_get_seo_data();
	$title     = $seo['title'];
	$desc      = $seo['description'];
	$canonical = is_singular() ? get_permalink() : home_url( '/' );

	if ( is_front_page() ) {
		$canonical = home_url( '/' );
	}

	$og_type = is_single() ? 'article' : 'website';

	// ── Meta description ────────────────────────────────────────────────────
	if ( $desc ) {
		echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
	}

	// ── Canonical ───────────────────────────────────────────────────────────
	echo '<link rel="canonical" href="' . esc_url( $canonical ) . '">' . "\n";

	// ── Open Graph ──────────────────────────────────────────────────────────
	echo '<meta property="og:type" content="' . esc_attr( $og_type ) . '">' . "\n";
	echo '<meta property="og:title" content="' . esc_attr( $title ) . '">' . "\n";
	if ( $desc ) {
		echo '<meta property="og:description" content="' . esc_attr( $desc ) . '">' . "\n";
	}
	echo '<meta property="og:url" content="' . esc_url( $canonical ) . '">' . "\n";
	echo '<meta property="og:site_name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">' . "\n";
	echo '<meta property="og:locale" content="' . esc_attr( get_locale() ) . '">' . "\n";

	// ── Twitter Card ────────────────────────────────────────────────────────
	echo '<meta name="twitter:card" content="summary">' . "\n";
	echo '<meta name="twitter:title" content="' . esc_attr( $title ) . '">' . "\n";
	if ( $desc ) {
		echo '<meta name="twitter:description" content="' . esc_attr( $desc ) . '">' . "\n";
	}

	// ── JSON-LD Schema ──────────────────────────────────────────────────────
	if ( ! empty( $seo['schema'] ) ) {
		foreach ( $seo['schema'] as $block ) {
			echo '<script type="application/ld+json">' . "\n";
			echo wp_json_encode( $block, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT );
			echo "\n</script>\n";
		}
	}

	// ── Breadcrumb JSON-LD ──────────────────────────────────────────────────
	if ( ! empty( $seo['breadcrumb'] ) ) {
		$bc_items  = array();
		$position  = 1;
		foreach ( $seo['breadcrumb'] as $name => $url ) {
			$bc_items[] = array(
				'@type'    => 'ListItem',
				'position' => $position,
				'name'     => $name,
				'item'     => $url,
			);
			$position++;
		}
		$breadcrumb_block = array(
			'@context'        => 'https://schema.org',
			'@type'           => 'BreadcrumbList',
			'itemListElement' => $bc_items,
		);
		echo '<script type="application/ld+json">' . "\n";
		echo wp_json_encode( $breadcrumb_block, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT );
		echo "\n</script>\n";
	}
}

/**
 * Render visible breadcrumb navigation trail.
 *
 * Uses the breadcrumb data from el_get_seo_data() to output an accessible
 * <nav> element. Intended for use inside .el-page-header hero sections.
 */
function el_render_breadcrumb() {
	$seo        = el_get_seo_data();
	$breadcrumb = $seo['breadcrumb'];

	if ( empty( $breadcrumb ) ) {
		return;
	}

	$items = array();
	$keys  = array_keys( $breadcrumb );
	$last  = end( $keys );

	foreach ( $breadcrumb as $label => $url ) {
		if ( $label === $last ) {
			$items[] = '<li><span aria-current="page">' . esc_html( $label ) . '</span></li>';
		} else {
			$items[] = '<li><a href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a></li>';
		}
	}

	echo '<nav class="el-breadcrumb" aria-label="Breadcrumb">' . "\n";
	echo '  <ol>' . "\n    " . implode( "\n    ", $items ) . "\n  </ol>\n";
	echo "</nav>\n";
}

// ══════════════════════════════════════════════════════════════════════════════
// Robots.txt – custom output via WordPress filter
// ══════════════════════════════════════════════════════════════════════════════

add_filter( 'robots_txt', 'el_robots_txt', 10, 2 );
/**
 * Custom robots.txt content.
 *
 * @param string $output Default robots.txt output.
 * @param string $public Site visibility setting (1 = public).
 * @return string
 */
function el_robots_txt( $output, $public ) {
	if ( '1' !== (string) $public ) {
		return $output;
	}
	$sitemap_url = home_url( '/sitemap.xml' );
	$output  = "User-agent: *\n";
	$output .= "Disallow: /wp-admin/\n";
	$output .= "Allow: /wp-admin/admin-ajax.php\n";
	$output .= "Disallow: /wp-login.php\n";
	$output .= "Disallow: /referrals/intake\n";
	$output .= "Disallow: /referral-partner-terms\n";
	$output .= "Disallow: /privacy-policy/\n";
	$output .= "Disallow: /terms-of-use/\n";
	$output .= "Disallow: /?s=\n";
	$output .= "Disallow: /*?s=\n";
	$output .= "Disallow: /*?enquiry=\n";
	$output .= "Disallow: /*?sent=\n";
	$output .= "Disallow: /*?download=\n";
	$output .= "Disallow: /book/*?\n";
	$output .= "\n";
	$output .= "User-agent: Googlebot\n";
	$output .= "Disallow: /wp-login.php\n";
	$output .= "Disallow: /wp-admin/\n";
	$output .= "Allow: /wp-admin/admin-ajax.php\n";
	$output .= "\nSitemap: {$sitemap_url}\n";
	return $output;
}

// ══════════════════════════════════════════════════════════════════════════════
// XML Sitemap – served via rewrite rule at /sitemap.xml
// ══════════════════════════════════════════════════════════════════════════════

/**
 * Register the sitemap rewrite rule.
 *
 * Note: After first activation, visit Settings → Permalinks (or run
 * flush_rewrite_rules()) so WordPress picks up the new rule.
 */
add_action( 'init', 'el_sitemap_rewrite' );
function el_sitemap_rewrite() {
	add_rewrite_rule( 'sitemap\.xml$', 'index.php?el_sitemap=1', 'top' );
}

/**
 * Register the custom query variable.
 */
add_filter( 'query_vars', 'el_sitemap_query_var' );
function el_sitemap_query_var( $vars ) {
	$vars[] = 'el_sitemap';
	return $vars;
}

/**
 * Intercept the request and serve XML sitemap if requested.
 */
add_action( 'template_redirect', 'el_sitemap_render' );

/**
 * Return the last-modified date for a page identified by slug.
 *
 * @param string $slug Page slug (empty string for front page).
 * @return string Date in Y-m-d format.
 */
function el_sitemap_lastmod( $slug ) {
	if ( '' === $slug ) {
		$front_page_id = (int) get_option( 'page_on_front' );
		if ( $front_page_id ) {
			return get_post_modified_time( 'Y-m-d', true, $front_page_id );
		}
		return gmdate( 'Y-m-d' );
	}
	$page = get_page_by_path( $slug );
	if ( $page ) {
		return get_post_modified_time( 'Y-m-d', true, $page );
	}
	return gmdate( 'Y-m-d' );
}

function el_sitemap_render() {
	if ( ! get_query_var( 'el_sitemap' ) ) {
		return;
	}

	$home = home_url( '/' );

	// Static pages with priority and change frequency.
	// Note: referral-partner-terms is intentionally excluded (disallowed in robots.txt).
	$static_pages = array(
		array( 'loc' => $home,                                          'slug' => '',                           'priority' => '1.0',  'changefreq' => 'weekly' ),
		array( 'loc' => home_url( '/practice-areas/' ),                  'slug' => 'practice-areas',             'priority' => '0.9',  'changefreq' => 'monthly' ),
		array( 'loc' => home_url( '/business-contracts/' ),             'slug' => 'business-contracts',         'priority' => '0.9',  'changefreq' => 'monthly' ),
		array( 'loc' => home_url( '/business-sales-acquisitions/' ),    'slug' => 'business-sales-acquisitions','priority' => '0.9',  'changefreq' => 'monthly' ),
		array( 'loc' => home_url( '/shareholder-agreements/' ),         'slug' => 'shareholder-agreements',     'priority' => '0.9',  'changefreq' => 'monthly' ),
		array( 'loc' => home_url( '/startup-legals/' ),                 'slug' => 'startup-legals',             'priority' => '0.9',  'changefreq' => 'monthly' ),
		array( 'loc' => home_url( '/intellectual-property/' ),          'slug' => 'intellectual-property',      'priority' => '0.9',  'changefreq' => 'monthly' ),
		array( 'loc' => home_url( '/unfair-contract-terms/' ),          'slug' => 'unfair-contract-terms',      'priority' => '0.9',  'changefreq' => 'monthly' ),
		array( 'loc' => home_url( '/fractional-general-counsel/' ),     'slug' => 'fractional-general-counsel', 'priority' => '0.95', 'changefreq' => 'monthly' ),
		array( 'loc' => home_url( '/south-west-sydney-lawyers/' ),      'slug' => 'south-west-sydney-lawyers',  'priority' => '0.85', 'changefreq' => 'monthly' ),
		array( 'loc' => home_url( '/referrals/' ),                      'slug' => 'referrals',                  'priority' => '0.7',  'changefreq' => 'monthly' ),
		array( 'loc' => home_url( '/about/' ),                          'slug' => 'about',                      'priority' => '0.7',  'changefreq' => 'monthly' ),
		array( 'loc' => home_url( '/contact/' ),                        'slug' => 'contact',                    'priority' => '0.8',  'changefreq' => 'monthly' ),
		array( 'loc' => home_url( '/book/' ),                           'slug' => 'book',                       'priority' => '0.8',  'changefreq' => 'monthly' ),
	);

	// Blog posts – latest 50.
	$posts = get_posts( array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => 50,
		'orderby'        => 'date',
		'order'          => 'DESC',
	) );

	header( 'Content-Type: application/xml; charset=UTF-8' );
	echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
	echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

	foreach ( $static_pages as $page ) {
		echo "\t<url>\n";
		echo "\t\t<loc>" . esc_url( $page['loc'] ) . "</loc>\n";
		echo "\t\t<lastmod>" . esc_xml( el_sitemap_lastmod( $page['slug'] ) ) . "</lastmod>\n";
		echo "\t\t<changefreq>" . esc_xml( $page['changefreq'] ) . "</changefreq>\n";
		echo "\t\t<priority>" . esc_xml( $page['priority'] ) . "</priority>\n";
		echo "\t</url>\n";
	}

	foreach ( $posts as $post ) {
		echo "\t<url>\n";
		echo "\t\t<loc>" . esc_url( get_permalink( $post ) ) . "</loc>\n";
		echo "\t\t<lastmod>" . esc_xml( get_the_modified_date( 'Y-m-d', $post ) ) . "</lastmod>\n";
		echo "\t\t<changefreq>weekly</changefreq>\n";
		echo "\t\t<priority>0.6</priority>\n";
		echo "\t</url>\n";
	}

	echo '</urlset>' . "\n";
	exit;
}

// ══════════════════════════════════════════════════════════════════════════════
// Analytics & Tracking – GTM, GA4, conversion event dataLayer pushes
// ══════════════════════════════════════════════════════════════════════════════

/**
 * 1. Customizer: Analytics & Tracking section with GTM and GA4 ID fields.
 */
add_action( 'customize_register', 'el_customizer_analytics' );
function el_customizer_analytics( $wp_customize ) {
	$wp_customize->add_section(
		'envision_legal_analytics',
		array(
			'title'    => esc_html__( 'Analytics & Tracking', 'envision-legal' ),
			'priority' => 160,
		)
	);

	// GTM Container ID.
	$wp_customize->add_setting(
		'envision_gtm_id',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'envision_gtm_id',
		array(
			'label'       => esc_html__( 'GTM Container ID', 'envision-legal' ),
			'description' => esc_html__( 'e.g. GTM-XXXXXXX', 'envision-legal' ),
			'section'     => 'envision_legal_analytics',
			'type'        => 'text',
		)
	);

	// GA4 Measurement ID.
	$wp_customize->add_setting(
		'envision_ga4_id',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'envision_ga4_id',
		array(
			'label'       => esc_html__( 'GA4 Measurement ID', 'envision-legal' ),
			'description' => esc_html__( 'e.g. G-XXXXXXXXXX', 'envision-legal' ),
			'section'     => 'envision_legal_analytics',
			'type'        => 'text',
		)
	);
}

/**
 * 2. dataLayer push on form conversion success pages.
 *
 * Fires at wp_head priority 0 — BEFORE GTM loads at priority 1 — so
 * the event is already queued when GTM processes the initial dataLayer.
 */
add_action( 'wp_head', 'el_gtm_datalayer_push', 0 );
function el_gtm_datalayer_push() {
	$event     = null;
	$form_name = null;
	$page_path = wp_parse_url( home_url( isset( $_SERVER['REQUEST_URI'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '/' ), PHP_URL_PATH );
	$page_path = $page_path ? $page_path : '/';

	// Detect which success state is present.
	$sent     = isset( $_GET['sent'] )     ? sanitize_key( $_GET['sent'] )     : '';
	$enquiry  = isset( $_GET['enquiry'] )  ? sanitize_key( $_GET['enquiry'] )  : '';
	$download = isset( $_GET['download'] ) ? sanitize_key( $_GET['download'] ) : '';

	if ( 'ok' === $sent && is_page( 'contact' ) ) {
		$event     = 'form_submission';
		$form_name = 'Contact — Send Us a Message';
	} elseif ( 'ok' === $download && is_page( 'fractional-general-counsel' ) ) {
		$event     = 'lead_magnet_download';
		$form_name = 'Fractional Counsel — Info Pack Download';
	} elseif ( 'ok' === $enquiry ) {
		$event = 'form_submission';
		// Map by current page template slug.
		$template = get_page_template_slug();
		$map = array(
			'page-business-contracts.php'          => 'Business Contracts — Callback',
			'page-business-sales-acquisitions.php' => 'Business Sales & Acquisitions — Callback',
			'page-shareholder-agreements.php'      => 'Shareholder Agreements — Callback',
			'page-startup-legals.php'              => 'Startup Legals — Callback',
			'page-intellectual-property.php'       => 'Intellectual Property — Callback',
			'page-unfair-contract-terms.php'       => 'Unfair Contract Terms — Callback',
			'page-fractional-general-counsel.php'  => 'Fractional General Counsel — Callback',
		);
		$form_name = isset( $map[ $template ] ) ? $map[ $template ] : null;
	}

	if ( ! $event || ! $form_name ) {
		return; // No conversion on this page load.
	}

	$data = array(
		'event'     => $event,
		'form_name' => $form_name,
		'page_path' => $page_path,
	);
	?>
	<script>
	window.dataLayer = window.dataLayer || [];
	window.dataLayer.push(<?php echo wp_json_encode( $data ); ?>);
	</script>
	<?php
}

/**
 * 3. GTM <head> snippet (priority 1) with GA4 gtag.js fallback.
 *
 * If GTM ID is set → output the GTM container script.
 * Else if GA4 ID is set → output the direct gtag.js snippet as fallback.
 */
add_action( 'wp_head', 'el_gtm_head', 1 );
function el_gtm_head() {
	$gtm_id = sanitize_text_field( get_theme_mod( 'envision_gtm_id', '' ) );
	$ga4_id = sanitize_text_field( get_theme_mod( 'envision_ga4_id', '' ) );

	if ( $gtm_id ) {
		$gtm_id = esc_attr( $gtm_id );
		echo "\n<!-- Google Tag Manager -->\n";
		echo '<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({\'gtm.start\':';
		echo 'new Date().getTime(),event:\'gtm.js\'});var f=d.getElementsByTagName(s)[0],';
		echo 'j=d.createElement(s),dl=l!=\'dataLayer\'?\'&l=\'+l:\'\';j.async=true;j.src=';
		echo '\'https://www.googletagmanager.com/gtm.js?id=\'+i+dl;f.parentNode.insertBefore(j,f);';
		echo '})(window,document,\'script\',\'dataLayer\',\'' . $gtm_id . '\');</script>';
		echo "\n<!-- End Google Tag Manager -->\n";
	} elseif ( $ga4_id ) {
		$ga4_id = esc_attr( $ga4_id );
		echo "\n<!-- Google Analytics 4 -->\n";
		echo '<script async src="https://www.googletagmanager.com/gtag/js?id=' . $ga4_id . '"></script>' . "\n";
		echo '<script>window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments);}gtag(\'js\',new Date());gtag(\'config\',\'' . $ga4_id . '\');</script>';
		echo "\n<!-- End Google Analytics 4 -->\n";
	}
}

/**
 * 4. GTM <body> noscript snippet (priority 1).
 */
add_action( 'wp_body_open', 'el_gtm_body', 1 );
function el_gtm_body() {
	$gtm_id = sanitize_text_field( get_theme_mod( 'envision_gtm_id', '' ) );
	if ( ! $gtm_id ) {
		return;
	}
	$gtm_id = esc_attr( $gtm_id );
	echo "\n<!-- Google Tag Manager (noscript) -->\n";
	echo '<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=' . $gtm_id . '" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>';
	echo "\n<!-- End Google Tag Manager (noscript) -->\n";
}

// ── Exit-intent / Scroll-depth Popup CTA ─────────────────────────────────────

/**
 * Inline CSS for the exit-intent popup modal.
 */
add_action( 'wp_head', 'el_exit_popup_css', 5 );
function el_exit_popup_css() {
	?>
	<style id="el-exit-popup-css">
	/* ── Exit-intent popup overlay ─────────────────────────────────────────── */
	#el-exit-overlay {
		display: none;
		position: fixed;
		inset: 0;
		background: rgba(10, 20, 50, 0.65);
		z-index: 9998;
		opacity: 0;
		transition: opacity 0.3s ease;
	}
	#el-exit-overlay.is-visible {
		display: block;
		opacity: 1;
	}

	/* ── Popup card ────────────────────────────────────────────────────────── */
	#el-exit-popup {
		display: none;
		position: fixed;
		left: 50%;
		top: 50%;
		transform: translate(-50%, -44%);
		width: min(560px, calc(100vw - 2rem));
		background: #fff;
		border-radius: 12px;
		box-shadow: 0 24px 64px rgba(10, 20, 50, 0.22);
		z-index: 9999;
		opacity: 0;
		transition: opacity 0.3s ease, transform 0.3s ease;
		overflow: hidden;
	}
	#el-exit-popup.is-visible {
		display: block;
		opacity: 1;
		transform: translate(-50%, -50%);
	}

	/* ── Accent bar at top ─────────────────────────────────────────────────── */
	#el-exit-popup::before {
		content: '';
		display: block;
		height: 4px;
		background: linear-gradient(90deg, var(--el-navy, #1a2744) 0%, var(--el-gold, #c9a84c) 100%);
	}

	/* ── Close button ──────────────────────────────────────────────────────── */
	.el-popup__close {
		position: absolute;
		top: 1rem;
		right: 1rem;
		background: none;
		border: none;
		cursor: pointer;
		color: var(--el-text-muted, #6b7280);
		display: flex;
		align-items: center;
		justify-content: center;
		padding: 0.25rem;
		border-radius: 4px;
		transition: color 0.2s ease, background 0.2s ease;
	}
	.el-popup__close:hover {
		color: var(--el-navy, #1a2744);
		background: var(--el-cream, #f8f6f1);
	}

	/* ── Body ──────────────────────────────────────────────────────────────── */
	.el-popup__body {
		padding: 2.5rem 2.5rem 2rem;
	}

	.el-popup__eyebrow {
		font-size: 0.75rem;
		font-weight: 600;
		letter-spacing: 0.1em;
		text-transform: uppercase;
		color: var(--el-gold, #c9a84c);
		margin: 0 0 0.75rem;
	}

	#el-popup-title {
		font-size: 1.65rem;
		font-weight: 700;
		color: var(--el-navy, #1a2744);
		line-height: 1.25;
		margin: 0 0 1rem;
	}

	.el-popup__sub {
		font-size: 0.95rem;
		color: var(--el-text-muted, #6b7280);
		line-height: 1.65;
		margin: 0 0 1.75rem;
	}

	/* ── Actions ───────────────────────────────────────────────────────────── */
	.el-popup__actions {
		display: flex;
		align-items: center;
		gap: 1rem;
		flex-wrap: wrap;
		margin-bottom: 1.5rem;
	}

	.el-btn--ghost {
		background: none;
		border: none;
		color: var(--el-text-muted, #6b7280);
		font-size: 0.875rem;
		font-weight: 500;
		cursor: pointer;
		padding: 0.5rem 0;
		text-decoration: underline;
		text-underline-offset: 2px;
		transition: color 0.2s ease;
	}
	.el-btn--ghost:hover {
		color: var(--el-navy, #1a2744);
	}

	/* ── Trust bullets ─────────────────────────────────────────────────────── */
	.el-popup__trust {
		list-style: none;
		padding: 0;
		margin: 0;
		display: flex;
		flex-wrap: wrap;
		gap: 0.5rem 1.5rem;
	}
	.el-popup__trust li {
		font-size: 0.8rem;
		color: var(--el-text-muted, #6b7280);
	}

	/* ── Mobile ────────────────────────────────────────────────────────────── */
	@media (max-width: 480px) {
		.el-popup__body { padding: 2rem 1.5rem 1.5rem; }
		#el-popup-title { font-size: 1.35rem; }
		.el-popup__actions { flex-direction: column; align-items: flex-start; }
	}
	</style>
	<?php
}

/**
 * Exit-intent / scroll-depth popup CTA.
 * Rendered in footer on home + practice area pages only.
 */
add_action( 'wp_footer', 'el_exit_popup_html', 20 );
function el_exit_popup_html() {
	// Only show on home page and practice area pages.
	$show = false;

	if ( is_front_page() ) {
		$show = true;
	}

	$practice_templates = array(
		'page-business-contracts.php',
		'page-business-sales-acquisitions.php',
		'page-shareholder-agreements.php',
		'page-startup-legals.php',
		'page-intellectual-property.php',
		'page-unfair-contract-terms.php',
		'page-fractional-general-counsel.php',
		'page-south-west-sydney-lawyers.php',
		'page-practiceareas.php',
		'page-about.php',
	);

	if ( is_page() && in_array( get_page_template_slug(), $practice_templates, true ) ) {
		$show = true;
	}

	if ( ! $show ) {
		return;
	}

	$book_url = esc_url( home_url( '/book/' ) );
	?>
	<div id="el-exit-overlay" aria-hidden="true"></div>

	<div
		id="el-exit-popup"
		role="dialog"
		aria-modal="true"
		aria-labelledby="el-popup-title"
		aria-hidden="true"
	>
		<button class="el-popup__close" aria-label="<?php esc_attr_e( 'Close', 'envision-legal' ); ?>">
			<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20" aria-hidden="true">
				<path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
			</svg>
		</button>

		<div class="el-popup__body">
			<p class="el-popup__eyebrow"><?php esc_html_e( 'Free Consultation', 'envision-legal' ); ?></p>
			<h2 id="el-popup-title"><?php esc_html_e( 'Not sure where to start?', 'envision-legal' ); ?></h2>
			<p class="el-popup__sub"><?php esc_html_e( 'Book a free 30-minute consultation with one of our commercial lawyers. No obligation — just a conversation about your situation.', 'envision-legal' ); ?></p>

			<div class="el-popup__actions">
				<a href="<?php echo $book_url; ?>" class="el-btn el-btn--primary">
					<?php esc_html_e( 'Book free consultation →', 'envision-legal' ); ?>
				</a>
				<button class="el-popup__dismiss el-btn el-btn--ghost">
					<?php esc_html_e( 'No thanks', 'envision-legal' ); ?>
				</button>
			</div>

			<ul class="el-popup__trust">
				<li><?php esc_html_e( '✓ Fixed-fee quotes upfront', 'envision-legal' ); ?></li>
				<li><?php esc_html_e( '✓ Senior lawyer — not a paralegal', 'envision-legal' ); ?></li>
				<li><?php esc_html_e( '✓ Response within one business day', 'envision-legal' ); ?></li>
			</ul>
		</div>
	</div>
	<?php
}
