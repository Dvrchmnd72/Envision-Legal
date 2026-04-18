<?php
/**
 * Front Page Template – Home
 *
 * Displayed when WordPress Settings → Reading is set to "A static page" with
 * this page selected as the Front page. Falls back automatically to a dynamic
 * homepage view when no static front page is assigned.
 *
 * @package EnvisionLegal
 */

get_header();
envision_legal_page_open( 'el-page--home' );
?>

<!-- ── Hero ──────────────────────────────────────────────────────────────── -->
<section class="el-hero" aria-labelledby="hero-heading">
	<div class="el-container">
		<div class="el-hero__inner">
			<p class="el-hero__eyebrow"><?php esc_html_e( 'Commercial Law · Fractional Counsel', 'envision-legal' ); ?></p>
			<h1 id="hero-heading"><?php esc_html_e( 'Practical Legal Advice for Growing Businesses', 'envision-legal' ); ?></h1>
			<p class="el-hero__sub">
				<?php esc_html_e( 'Envision Legal is a boutique commercial law firm helping entrepreneurs, startups, and established businesses protect their interests and seize opportunities—without the big-firm price tag.', 'envision-legal' ); ?>
			</p>
			<div class="el-hero__actions">
				<a href="<?php echo esc_url( home_url( '/book/' ) ); ?>" class="el-btn el-btn--primary">
					<?php esc_html_e( 'Book Consultation', 'envision-legal' ); ?>
				</a>
				<a href="<?php echo esc_url( home_url( '/practice-areas/' ) ); ?>" class="el-btn el-btn--outline">
					<?php esc_html_e( 'Our Practice Areas', 'envision-legal' ); ?>
				</a>
				<a href="<?php echo esc_url( home_url( '/referrals' ) ); ?>" class="el-btn el-btn--outline">
					<?php esc_html_e( 'Referrals', 'envision-legal' ); ?>
				</a>
			</div>
		</div>
	</div>
</section>

<!-- ── Trust bar ─────────────────────────────────────────────────────────── -->
<section class="el-section el-section--cream" aria-label="<?php esc_attr_e( 'Key highlights', 'envision-legal' ); ?>">
	<div class="el-container">
		<div class="el-stats">
			<div class="el-stat" style="--el-stat-c:var(--el-navy)">
				<div class="el-stat__number" style="color:var(--el-navy)">10+</div>
				<div class="el-stat__label" style="color:var(--el-text-muted)"><?php esc_html_e( 'Years Experience', 'envision-legal' ); ?></div>
			</div>
			<div class="el-stat">
				<div class="el-stat__number" style="color:var(--el-navy)">200+</div>
				<div class="el-stat__label" style="color:var(--el-text-muted)"><?php esc_html_e( 'Clients Served', 'envision-legal' ); ?></div>
			</div>
			<div class="el-stat">
				<div class="el-stat__number" style="color:var(--el-navy)">100%</div>
				<div class="el-stat__label" style="color:var(--el-text-muted)"><?php esc_html_e( 'Commercial Focus', 'envision-legal' ); ?></div>
			</div>
			<div class="el-stat">
				<div class="el-stat__number" style="color:var(--el-navy)">SW</div>
				<div class="el-stat__label" style="color:var(--el-text-muted)"><?php esc_html_e( 'Sydney Based', 'envision-legal' ); ?></div>
			</div>
		</div>
	</div>
</section>

<!-- ── Practice Areas ─────────────────────────────────────────────────────── -->
<section class="el-section" aria-labelledby="practice-heading">
	<div class="el-container">
		<header class="el-section__header">
			<p class="el-section__eyebrow"><?php esc_html_e( 'What We Do', 'envision-legal' ); ?></p>
			<h2 id="practice-heading"><?php esc_html_e( 'Practice Areas', 'envision-legal' ); ?></h2>
			<p><?php esc_html_e( 'We focus exclusively on commercial law so that you receive deep, specialised advice rather than a generalist perspective.', 'envision-legal' ); ?></p>
		</header>

		<div class="el-grid">
			<?php
			$practice_areas = array(	array(
		'title'  => __( 'Business Contracts', 'envision-legal' ),
		'link'   => '/business-contracts/',
		'accent' => '#2f7d7c',
		'icon'   => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm4 18H6V4h7v5h5v11zM8 13h8v2H8v-2zm0-4h5v2H8V9z"/>',
	),
	array(
		'title'  => __( 'Business Sales & Acquisitions', 'envision-legal' ),
		'link'   => '/business-sales-acquisitions/',
		'accent' => '#2e7d32',
		'icon'   => '<path d="M21 10.5l-4.2-4.2a2 2 0 0 0-2.83 0l-1.17 1.17a2 2 0 0 1-2.83 0L8.8 6.27a2 2 0 0 0-2.83 0L3 9.24l4.1 4.1a2 2 0 0 0 2.83 0l.35-.35.7.7-.35.35a2 2 0 0 0 0 2.83l.35.35a2 2 0 0 0 2.83 0l.35-.35.35.35a2 2 0 0 0 2.83 0l.35-.35.35.35a2 2 0 0 0 2.83 0l1.06-1.06a2 2 0 0 0 0-2.83l-2.47-2.47 1.06-1.06L21 10.5z"/>',
	),
	array(
		'title'  => __( 'Intellectual Property', 'envision-legal' ),
		'link'   => '/intellectual-property/',
		'accent' => '#6a4fb3',
		'icon'   => '<path d="M9 21h6v-1H9v1zm3-20C7.93 1 5 3.93 5 7c0 2.38 1.19 4.47 3 5.74V15c0 1.1.9 2 2 2h4c1.1 0 2-.9 2-2v-2.26c1.81-1.27 3-3.36 3-5.74 0-3.07-2.93-6-7-6zm2.3 10.05-.3.2V15h-4v-3.75l-.3-.2A4.97 4.97 0 0 1 7 7c0-2.76 2.24-5 5-5s5 2.24 5 5c0 1.63-.8 3.16-2.7 4.05z"/>',
	),
	array(
		'title'  => __( 'Shareholder Agreements', 'envision-legal' ),
		'link'   => '/shareholder-agreement-lawyers-sydney/',
		'accent' => '#b38a2e',
		'icon'   => '<path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>',
	),
	array(
		'title'  => __( 'Startup Legals', 'envision-legal' ),
		'link'   => '/startup-legals/',
		'accent' => '#d07a2a',
		'icon'   => '<path d="M12 2c-2.76 0-5 2.24-5 5v1.5L5 10v2l2-.5V13c0 2.76 2.24 5 5 5s5-2.24 5-5v-1.5l2 .5v-2l-2-1.5V7c0-2.76-2.24-5-5-5zm0 2c1.65 0 3 1.35 3 3v1.08l-3 1.5-3-1.5V7c0-1.65 1.35-3 3-3zm0 12c-1.65 0-3-1.35-3-3v-1.08l3 1.5 3-1.5V13c0 1.65-1.35 3-3 3z"/>',
	),
	array(
		'title'  => __( 'Fractional General Counsel', 'envision-legal' ),
		'link'   => '/fractional-general-counsel/',
		'accent' => '#1a2744',
		'icon'   => '<path d="M10 4h4v2h-4V4zm-2 0a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2h2a2 2 0 0 1 2 2v3h-7v-1H9v1H2V8a2 2 0 0 1 2-2h2V4zm14 7v9a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-9h7v1h6v-1h7z"/>',
	),
	array(
		'title'  => __( 'Referrals', 'envision-legal' ),
		'accent' => '#8a5a2b',
		'icon'   => '<path d="M3.9 12a5 5 0 0 1 5-5h3v2h-3a3 3 0 0 0 0 6h3v2h-3a5 5 0 0 1-5-5zm7.1 1h2v-2h-2v2zm4-6h-3V7h3a5 5 0 0 1 0 10h-3v-2h3a3 3 0 0 0 0-6z"/>',
		'link'   => '/referrals',
	),
);

foreach ( $practice_areas as $area ) :
				?>
				<div class="el-practice-card" style="--el-accent: <?php echo esc_attr( $area['accent'] ?? '#c9a84c' ); ?>">
					<div class="el-practice-card__icon">
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
							<?php echo $area['icon']; // phpcs:ignore WordPress.Security.EscapeOutput ?>
						</svg>
					</div>
					<h3><?php echo esc_html( $area['title'] ); ?></h3>
					<p><?php echo esc_html( $area['desc'] ); ?></p>
					<a href="<?php echo esc_url( home_url( isset( $area['link'] ) ? $area['link'] : '/practice-areas/' ) ); ?>" class="el-card__link">
						<?php esc_html_e( 'Learn more &rarr;', 'envision-legal' ); ?>
					</a>
				</div>
				<?php
			endforeach;
			?>
		</div>
	</div>
</section>

<!-- ── Why Envision Legal ──────────────────────────────────────────────────── -->
<section class="el-section el-section--navy" aria-labelledby="why-heading">
	<div class="el-container">
		<div class="el-home-why-grid">
			<div>
				<p class="el-section__eyebrow"><?php esc_html_e( 'Why Us', 'envision-legal' ); ?></p>
				<h2 id="why-heading"><?php esc_html_e( 'Legal Expertise That Matches Your Business Ambition', 'envision-legal' ); ?></h2>
				<p style="color:rgba(255,255,255,.8);margin-top:1rem">
					<?php esc_html_e( 'We combine big-firm expertise with boutique agility. Our lawyers understand your commercial reality—because we\'ve worked on both sides of the table.', 'envision-legal' ); ?>
				</p>
				<ul style="list-style:none;padding:0;margin:1.5rem 0;color:rgba(255,255,255,.85)">
					<?php
					$points = array(
						__( 'Fixed-fee options on most matters', 'envision-legal' ),
						__( 'Direct access to a senior lawyer—not a paralegal', 'envision-legal' ),
						__( 'Fast turnaround without cutting corners', 'envision-legal' ),
						__( 'South-West Sydney community roots', 'envision-legal' ),
					);
					foreach ( $points as $point ) :
						?>
						<li style="display:flex;gap:.75rem;margin-bottom:.75rem;align-items:flex-start">
							<span style="color:var(--el-navy);font-size:1.1rem;line-height:1.6">&#10003;</span>
							<?php echo esc_html( $point ); ?>
						</li>
						<?php
					endforeach;
					?>
				</ul>
				<a href="<?php echo esc_url( home_url( '/about' ) ); ?>" class="el-btn el-btn--outline">
					<?php esc_html_e( 'Meet the Team', 'envision-legal' ); ?>
				</a>
			</div>
			<div style="background:rgba(255,255,255,.05);border-radius:12px;padding:2.5rem;border:1px solid rgba(255,255,255,.1)">
				<h3 style="color:var(--el-white)"><?php esc_html_e( 'Free Initial Consultation', 'envision-legal' ); ?></h3>
				<p style="color:rgba(255,255,255,.8);margin-bottom:1.5rem">
					<?php esc_html_e( 'Get clarity on your legal issue with a 30-minute no-obligation consultation.', 'envision-legal' ); ?>
				</p>
				<a href="<?php echo esc_url( home_url( '/book/' ) ); ?>" class="el-btn el-btn--primary" style="width:100%;display:block;text-align:center">
					<?php esc_html_e( 'Book Consultation', 'envision-legal' ); ?>
				</a>
			</div>
		</div>
	</div>
</section>

<!-- ── Latest Blog Posts ───────────────────────────────────────────────────── -->
<?php
$recent_posts = new WP_Query(
	array(
		'post_type'      => 'post',
		'posts_per_page' => 3,
		'post_status'    => 'publish',
	)
);

if ( $recent_posts->have_posts() ) :
	?>
	<section class="el-section" aria-labelledby="blog-heading">
		<div class="el-container">
			<header class="el-section__header">
				<p class="el-section__eyebrow"><?php esc_html_e( 'Insights', 'envision-legal' ); ?></p>
				<h2 id="blog-heading"><?php esc_html_e( 'From the Blog', 'envision-legal' ); ?></h2>
			</header>

			<div class="el-archive-grid">
				<?php
				while ( $recent_posts->have_posts() ) :
					$recent_posts->the_post();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class( 'el-card' ); ?>>
						<?php if ( has_post_thumbnail() ) : ?>
							<div class="el-card__image">
								<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'envision-card' ); ?></a>
							</div>
						<?php else : ?>
							<div class="el-card__image el-card__image--placeholder" aria-hidden="true">
								<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="white"><path d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2zm0 16H5V5h14v14zM7 17l3-4 2 3 3-4 4 5H7z"/></svg>
							</div>
						<?php endif; ?>
						<div class="el-card__body">
							<p class="el-card__meta"><?php echo esc_html( get_the_date() ); ?></p>
							<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
							<?php the_excerpt(); ?>
							<a href="<?php the_permalink(); ?>" class="el-card__link"><?php esc_html_e( 'Read more &rarr;', 'envision-legal' ); ?></a>
						</div>
					</article>
					<?php
				endwhile;
				wp_reset_postdata();
				?>
			</div>

			<div class="el-text-center el-mt-md">
				<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" class="el-btn el-btn--navy">
					<?php esc_html_e( 'View All Articles', 'envision-legal' ); ?>
				</a>
			</div>
		</div>
	</section>
	<?php
endif;
?>

<!-- ── CTA Banner ─────────────────────────────────────────────────────────── -->
<section class="el-cta-banner" aria-labelledby="cta-heading">
	<div class="el-container">
		<h2 id="cta-heading"><?php esc_html_e( 'Ready to Protect and Grow Your Business?', 'envision-legal' ); ?></h2>
		<p><?php esc_html_e( 'Talk to a commercial lawyer who understands your world. Book your free consult today.', 'envision-legal' ); ?></p>
		<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="el-btn el-btn--navy">
			<?php esc_html_e( 'Get in Touch', 'envision-legal' ); ?>
		</a>
	</div>
</section>

<?php
envision_legal_page_close();
get_footer();
