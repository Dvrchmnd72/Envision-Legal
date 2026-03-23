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
define( 'ENVISION_LEGAL_VERSION', '1.1.8' );
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
		array( 'envision-legal-style' ),
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
	echo '<li><a href="' . esc_url( home_url( '/blog' ) ) . '">' . esc_html__( 'Blog', 'envision-legal' ) . '</a></li>';
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
				<?php if ( has_custom_logo() ) : ?>
					<?php the_custom_logo(); ?>
				<?php else : ?>
					<span class="el-footer__site-name"><?php bloginfo( 'name' ); ?></span>
				<?php endif; ?>
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
