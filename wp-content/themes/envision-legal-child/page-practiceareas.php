<?php
/**
 * Template Name: Practice Areas
 *
 * @package EnvisionLegal
 */

get_header();
envision_legal_page_open( 'el-page--practice' );
?>

<!-- ── Page Header ────────────────────────────────────────────────────────── -->
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
	<?php endif; endwhile; endif; ?>

<!-- ── Practice Area Cards ────────────────────────────────────────────────── -->
<section class="el-section" aria-labelledby="practice-cards-heading">
	<div class="el-container">
		<header class="el-section__header">
			<p class="el-section__eyebrow"><?php esc_html_e( 'What We Do', 'envision-legal' ); ?></p>
			<h2 id="practice-cards-heading"><?php esc_html_e( 'Practice Areas', 'envision-legal' ); ?></h2>
			<p><?php esc_html_e( 'We focus exclusively on commercial law so that you receive deep, specialised advice rather than a generalist perspective.', 'envision-legal' ); ?></p>
		</header>

		<div class="el-grid">

			<!-- Business Contracts -->
			<div class="el-practice-card" style="--el-accent:#2f7d7c">
				<div class="el-practice-card__icon">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
						<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm4 18H6V4h7v5h5v11zM8 13h8v2H8v-2zm0-4h5v2H8V9z"/>
					</svg>
				</div>
				<h3><?php esc_html_e( 'Business Contracts', 'envision-legal' ); ?></h3>
				<p><?php esc_html_e( 'Drafting, reviewing and negotiating commercial contracts that protect your interests and reduce risk.', 'envision-legal' ); ?></p>
				<a href="<?php echo esc_url( home_url( '/business-contracts/' ) ); ?>" class="el-card__link"><?php esc_html_e( 'Learn more →', 'envision-legal' ); ?></a>
			</div>

			<!-- Business Sales & Acquisitions -->
			<div class="el-practice-card" style="--el-accent:#2e7d32">
				<div class="el-practice-card__icon">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
						<path d="M21 10.5l-4.2-4.2a2 2 0 0 0-2.83 0l-1.17 1.17a2 2 0 0 1-2.83 0L8.8 6.27a2 2 0 0 0-2.83 0L3 9.24l4.1 4.1a2 2 0 0 0 2.83 0l.35-.35.7.7-.35.35a2 2 0 0 0 0 2.83l.35.35a2 2 0 0 0 2.83 0l.35-.35.35.35a2 2 0 0 0 2.83 0l.35-.35.35.35a2 2 0 0 0 2.83 0l1.06-1.06a2 2 0 0 0 0-2.83l-2.47-2.47 1.06-1.06L21 10.5z"/>
					</svg>
				</div>
				<h3><?php esc_html_e( 'Business Sales & Acquisitions', 'envision-legal' ); ?></h3>
				<p><?php esc_html_e( 'Expert guidance through every stage of buying or selling a business — due diligence to settlement.', 'envision-legal' ); ?></p>
				<a href="<?php echo esc_url( home_url( '/business-sales-acquisitions/' ) ); ?>" class="el-card__link"><?php esc_html_e( 'Learn more →', 'envision-legal' ); ?></a>
			</div>

			<!-- Intellectual Property -->
			<div class="el-practice-card" style="--el-accent:#6a4fb3">
				<div class="el-practice-card__icon">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
						<path d="M9 21h6v-1H9v1zm3-20C7.93 1 5 3.93 5 7c0 2.38 1.19 4.47 3 5.74V15c0 1.1.9 2 2 2h4c1.1 0 2-.9 2-2v-2.26c1.81-1.27 3-3.36 3-5.74 0-3.07-2.93-6-7-6zm2.3 10.05-.3.2V15h-4v-3.75l-.3-.2A4.97 4.97 0 0 1 7 7c0-2.76 2.24-5 5-5s5 2.24 5 5c0 1.63-.8 3.16-2.7 4.05z"/>
					</svg>
				</div>
				<h3><?php esc_html_e( 'Intellectual Property', 'envision-legal' ); ?></h3>
				<p><?php esc_html_e( 'Register and protect your trademarks, negotiate IP licences, and commercialise your creative assets.', 'envision-legal' ); ?></p>
				<a href="<?php echo esc_url( home_url( '/intellectual-property/' ) ); ?>" class="el-card__link"><?php esc_html_e( 'Learn more →', 'envision-legal' ); ?></a>
			</div>

			<!-- Shareholder Agreements -->
			<div class="el-practice-card" style="--el-accent:#b38a2e">
				<div class="el-practice-card__icon">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
						<path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
					</svg>
				</div>
				<h3><?php esc_html_e( 'Shareholder Agreements', 'envision-legal' ); ?></h3>
				<p><?php esc_html_e( 'Protect your ownership stake with robust agreements covering decision-making, exits and dispute resolution.', 'envision-legal' ); ?></p>
				<a href="<?php echo esc_url( home_url( '/shareholder-agreement-lawyers-sydney/' ) ); ?>" class="el-card__link"><?php esc_html_e( 'Learn more →', 'envision-legal' ); ?></a>
			</div>

			<!-- Startup Legals -->
			<div class="el-practice-card" style="--el-accent:#d07a2a">
				<div class="el-practice-card__icon">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
						<path d="M12 2c-2.76 0-5 2.24-5 5v1.5L5 10v2l2-.5V13c0 2.76 2.24 5 5 5s5-2.24 5-5v-1.5l2 .5v-2l-2-1.5V7c0-2.76-2.24-5-5-5zm0 2c1.65 0 3 1.35 3 3v1.08l-3 1.5-3-1.5V7c0-1.65 1.35-3 3-3zm0 12c-1.65 0-3-1.35-3-3v-1.08l3 1.5 3-1.5V13c0 1.65-1.35 3-3 3z"/>
					</svg>
				</div>
				<h3><?php esc_html_e( 'Startup Legals', 'envision-legal' ); ?></h3>
				<p><?php esc_html_e( 'Co-founder agreements, cap table advice, SAFE notes and seed investment documents — built for founders.', 'envision-legal' ); ?></p>
				<a href="<?php echo esc_url( home_url( '/startup-legals/' ) ); ?>" class="el-card__link"><?php esc_html_e( 'Learn more →', 'envision-legal' ); ?></a>
			</div>

			<!-- Unfair Contract Terms -->
			<div class="el-practice-card" style="--el-accent:#c0392b">
				<div class="el-practice-card__icon">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
						<path d="M12 2L1 21h22L12 2zm0 3.5L20.5 19h-17L12 5.5zM11 10v4h2v-4h-2zm0 6v2h2v-2h-2z"/>
					</svg>
				</div>
				<h3><?php esc_html_e( 'Unfair Contract Terms', 'envision-legal' ); ?></h3>
				<p><?php esc_html_e( 'Audit your standard-form contracts for ACL compliance and defend your rights against unfair terms.', 'envision-legal' ); ?></p>
				<a href="<?php echo esc_url( home_url( '/unfair-contract-terms/' ) ); ?>" class="el-card__link"><?php esc_html_e( 'Learn more →', 'envision-legal' ); ?></a>
			</div>

			<!-- Fractional General Counsel -->
			<div class="el-practice-card" style="--el-accent:#1a2744">
				<div class="el-practice-card__icon">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
						<path d="M10 4h4v2h-4V4zm-2 0a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2h2a2 2 0 0 1 2 2v3h-7v-1H9v1H2V8a2 2 0 0 1 2-2h2V4zm14 7v9a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2v-9h7v1h6v-1h7z"/>
					</svg>
				</div>
				<h3><?php esc_html_e( 'Fractional General Counsel', 'envision-legal' ); ?></h3>
				<p><?php esc_html_e( 'Senior in-house legal counsel on a flexible retainer — all the expertise, none of the overhead.', 'envision-legal' ); ?></p>
				<a href="<?php echo esc_url( home_url( '/fractional-general-counsel/' ) ); ?>" class="el-card__link"><?php esc_html_e( 'Learn more →', 'envision-legal' ); ?></a>
			</div>

			<!-- Referrals -->
			<div class="el-practice-card" style="--el-accent:#8a5a2b">
				<div class="el-practice-card__icon">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
						<path d="M3.9 12a5 5 0 0 1 5-5h3v2h-3a3 3 0 0 0 0 6h3v2h-3a5 5 0 0 1-5-5zm7.1 1h2v-2h-2v2zm4-6h-3V7h3a5 5 0 0 1 0 10h-3v-2h3a3 3 0 0 0 0-6z"/>
					</svg>
				</div>
				<h3><?php esc_html_e( 'Referrals', 'envision-legal' ); ?></h3>
				<p><?php esc_html_e( 'We work with accountants, brokers and advisors to deliver seamless legal support for your clients.', 'envision-legal' ); ?></p>
				<a href="<?php echo esc_url( home_url( '/referrals/' ) ); ?>" class="el-card__link"><?php esc_html_e( 'Learn more →', 'envision-legal' ); ?></a>
			</div>

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
get_footer();
