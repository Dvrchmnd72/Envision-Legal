<?php
/**
 * Template Name: Practice Areas
 *
 * @package EnvisionLegal
 */

get_header();
envision_legal_header();
envision_legal_page_open( 'el-page--practice' );
?>

<section class="el-page-header" aria-labelledby="practice-heading">
	<div class="el-container">
		<p class="el-section__eyebrow"><?php esc_html_e( 'Expertise', 'envision-legal' ); ?></p>
		<h1 id="practice-heading"><?php the_title(); ?></h1>
		<p><?php esc_html_e( 'Commercial legal services tailored to help your business grow, protected and prepared.', 'envision-legal' ); ?></p>
	</div>
</section>

<!-- Dynamic content from page editor -->
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	<?php if ( get_the_content() ) : ?>
		<section class="el-section">
			<div class="el-container">
				<div class="el-post-content__inner"><?php the_content(); ?></div>
			</div>
		</section>
	<?php endif; ?>
<?php endwhile; endif; ?>

<!-- ── Practice Area Detail Cards ─────────────────────────────────────────── -->
<section class="el-section el-section--cream" aria-labelledby="services-heading">
	<div class="el-container">
		<header class="el-section__header">
			<h2 id="services-heading"><?php esc_html_e( 'Our Services', 'envision-legal' ); ?></h2>
		</header>

		<!-- Accordion-style practice areas -->
		<div class="el-accordion" role="list">
			<?php
			$areas = array(
				array(
					'title'   => __( 'Business Contracts &amp; Commercial Agreements', 'envision-legal' ),
					'content' => __( '<p>Every business relationship starts with an agreement. We draft, review and negotiate contracts that clearly define rights, obligations and risk allocation—so you can transact with confidence.</p><p>Common contract types: supply agreements, service agreements, distribution agreements, licensing, NDAs, employment contracts and more.</p>', 'envision-legal' ),
				),
				array(
					'title'   => __( 'Business Sales, Acquisitions &amp; Due Diligence', 'envision-legal' ),
					'content' => __( '<p>Whether you\'re buying a competitor or selling the business you\'ve spent years building, our team guides you through every stage: due diligence, structure, negotiation, contracts and settlement.</p><p>We also assist with <em>5 Legal Red Flags That Kill Deals</em>—see our blog for details.</p>', 'envision-legal' ),
				),
				array(
					'title'   => __( 'Intellectual Property &amp; Trademarks', 'envision-legal' ),
					'content' => __( '<p>Your brand, technology and creative work are valuable assets. We help you register and protect trademarks, negotiate IP licences, and develop strategies to commercialise your intellectual property.</p>', 'envision-legal' ),
				),
				array(
					'title'   => __( 'Shareholder &amp; Partnership Agreements', 'envision-legal' ),
					'content' => __( '<p>A well-drafted shareholders\' agreement is the single best protection you can give your business. We cover decision-making, deadlock resolution, transfer restrictions, exit events and buy-sell mechanisms.</p>', 'envision-legal' ),
				),
				array(
					'title'   => __( 'Startup &amp; Emerging Company Legals', 'envision-legal' ),
					'content' => __( '<p>From co-founder agreements and cap table advice, to SAFE/KISS notes and seed investment documents—we speak startup and help you build the right legal foundation from day one.</p>', 'envision-legal' ),
				),
				array(
					'title'   => __( 'Unfair Contract Terms', 'envision-legal' ),
					'content' => __( '<p>Changes to the Australian Consumer Law (ACL) unfair contract terms regime now apply to a broader range of businesses. We audit your standard-form contracts to ensure compliance and advise on your rights when dealing with unfair terms imposed by others.</p>', 'envision-legal' ),
				),
				array(
					'title'   => __( 'Fractional General Counsel', 'envision-legal' ),
					'content' => __( '<p>Not ready for a full-time in-house lawyer? Our Fractional General Counsel service gives you senior legal counsel on a flexible retainer—embedded in your team, aligned with your goals.</p><p>Perfect for scale-ups and mid-market businesses that need strategic legal support without the overhead.</p>', 'envision-legal' ),
				),
			);

			foreach ( $areas as $i => $area ) :
				$id = 'pa-' . ( $i + 1 );
				?>
				<div class="el-accordion__item" role="listitem">
					<button class="el-accordion__trigger" aria-expanded="false" aria-controls="<?php echo esc_attr( $id ); ?>">
						<?php echo wp_kses_post( $area['title'] ); ?>
						<span class="el-accordion__icon" aria-hidden="true">+</span>
					</button>
					<div id="<?php echo esc_attr( $id ); ?>" class="el-accordion__panel" role="region" aria-labelledby="<?php echo esc_attr( $id . '-btn' ); ?>">
						<?php echo wp_kses_post( $area['content'] ); ?>
					</div>
				</div>
				<?php
			endforeach;
			?>
		</div>
	</div>
</section>

<!-- ── CTA ────────────────────────────────────────────────────────────────── -->
<section class="el-cta-banner" aria-labelledby="practice-cta">
	<div class="el-container">
		<h2 id="practice-cta"><?php esc_html_e( 'Not Sure Which Service You Need?', 'envision-legal' ); ?></h2>
		<p><?php esc_html_e( 'Tell us about your situation and we\'ll point you in the right direction—no obligation.', 'envision-legal' ); ?></p>
		<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="el-btn el-btn--navy">
			<?php esc_html_e( 'Talk to Us', 'envision-legal' ); ?>
		</a>
	</div>
</section>

<?php
envision_legal_page_close();
envision_legal_footer();
get_footer();
