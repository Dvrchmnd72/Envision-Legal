<?php
/**
 * Template Name: Startup Legals
 *
 * @package EnvisionLegal
 */
get_header();
envision_legal_page_open( 'el-page--practice' );
?>

<section class="el-page-header" aria-labelledby="sl-heading">
	<div class="el-container">
		<?php el_render_breadcrumb(); ?>
						<p class="el-hero__eyebrow"><?php esc_html_e( 'Commercial Law · Fractional Counsel', 'envision-legal' ); ?></p>
<h1 id="sl-heading">Startup &amp; Emerging Company Lawyers</h1>
		<p>Build your startup on a solid legal foundation — from co-founder agreements to investor-ready documents.</p>
		<a href="#sl-enquiry-form" class="el-btn el-btn--white" style="margin-top:1.5rem;display:inline-block;">Get a Free Call Back</a>
	</div>
</section>

<section class="el-section" aria-labelledby="sl-about-heading">
	<div class="el-container" style="max-width:820px;">
		<h2 id="sl-about-heading">We Speak Startup</h2>
		<p>Most law firms treat startups as small businesses. We understand that startups are a different beast — fast-moving, equity-driven and often raising capital before they have revenue. We have advised founders at every stage from idea to Series A.</p>
		<p>At Envision Legal we help founders across South-West Sydney and beyond get the legal foundations right from day one — so that when you attract investors or acquirers, your structure is clean and your documents are in order.</p>

		<h2 style="margin-top:2.5rem;">What We Cover</h2>
		<ul style="line-height:2;">
			<li><strong>Co-founder agreements</strong> — equity splits, roles, vesting and founder exit mechanisms</li>
			<li><strong>Company structuring</strong> — choosing the right entity and shareholding structure</li>
			<li><strong>Vesting schedules</strong> — time-based and milestone-based vesting for founders and key employees</li>
			<li><strong>SAFE and KISS notes</strong> — simple agreements for early-stage convertible investment</li>
			<li><strong>Seed investment documents</strong> — term sheets, subscription agreements and shareholder deeds</li>
			<li><strong>Employee share option plans (ESOPs)</strong> — attract and retain talent with equity incentives</li>
			<li><strong>IP assignment from founders</strong> — ensuring the company owns its technology and brand</li>
			<li><strong>Early-stage employment contracts</strong> — competitive, compliant and startup-friendly</li>
		</ul>

		<h2 style="margin-top:2.5rem;">Frequently Asked Questions</h2>

		<h3 style="margin-top:1.5rem;">When should I get legal advice as a founder?</h3>
		<p>Before you take on a co-founder, before you bring in your first employee, and before you accept any investment. These are the three moments where a poorly structured deal creates problems that are expensive to fix later.</p>

		<h3 style="margin-top:1.5rem;">What is a SAFE note and do I need one?</h3>
		<p>A SAFE (Simple Agreement for Future Equity) is a short-form investment instrument where an investor puts in money now in exchange for the right to receive equity at a future valuation event. It is commonly used for pre-seed rounds because it is faster and cheaper than a priced round. We draft and review SAFEs and advise on their terms.</p>

		<h3 style="margin-top:1.5rem;">How does founder vesting work?</h3>
		<p>Founder vesting means that equity is earned over time rather than granted upfront. A typical structure is a 4-year vest with a 1-year cliff — meaning if a founder leaves in year one, they receive nothing; after that, equity vests monthly. This protects the remaining founders and the company.</p>

		<h3 style="margin-top:1.5rem;">Do you work with pre-revenue startups?</h3>
		<p>Yes. We offer fixed-fee packages for early-stage founders and can work with you on a staged basis as you grow. We would rather help you get it right early than fix a structural problem during a funding round.</p>
	</div>
</section>

<section class="el-section el-section--cream" id="sl-enquiry-form" aria-labelledby="sl-form-heading">
	<div class="el-container" style="max-width:680px;">
		<header class="el-section__header">
			<h2 id="sl-form-heading">Get a Free Call Back</h2>
			<p>Tell us about your startup and we will be in touch within one business day — no obligation.</p>
		</header>
		<?php
		$el_enquiry = isset( $_GET['enquiry'] ) ? sanitize_text_field( wp_unslash( $_GET['enquiry'] ) ) : '';
		if ( 'ok' === $el_enquiry ) : ?>
			<div style="background:#f0faf4;border:2px solid #2e7d32;border-radius:8px;text-align:center;padding:2.5rem;margin-bottom:1.5rem;">
				<div style="font-size:2.5rem;margin-bottom:1rem;">&#10003;</div>
				<h3 style="color:#2e7d32;margin:0 0 0.5rem;">Enquiry Received</h3>
				<p style="margin:0;">Thanks — we will be in touch within one business day.</p>
			</div>
		<?php elseif ( 'invalid' === $el_enquiry ) : ?>
			<div style="background:#fff5f5;border:2px solid #c0392b;border-radius:8px;text-align:center;padding:1rem;margin-bottom:1.5rem;" role="alert">
				Please complete all required fields and select the required options, then try again.
			</div>
		<?php elseif ( 'error' === $el_enquiry ) : ?>
			<div style="background:#fff5f5;border:2px solid #c0392b;border-radius:8px;text-align:center;padding:1rem;margin-bottom:1.5rem;" role="alert">
				Something went wrong — please try again.
			</div>
		<?php endif; ?>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="el_practice_intake">
			<input type="hidden" name="el_source" value="sl">
			<?php wp_nonce_field( 'el_practice_intake', 'el_practice_nonce' ); ?>
			<div class="sha-form-group">
				<label for="sl_name">Full Name *</label>
				<input type="text" id="sl_name" name="sl_name" required placeholder="Jane Smith">
			</div>
			<div class="sha-form-group">
				<label for="sl_email">Email Address *</label>
				<input type="email" id="sl_email" name="sl_email" required placeholder="jane@startup.com.au">
			</div>
			<div class="sha-form-group">
				<label for="sl_phone">Phone Number *</label>
				<input type="tel" id="sl_phone" name="sl_phone" required placeholder="04xx xxx xxx">
			</div>
			<div class="sha-form-group">
				<label for="sl_stage">What stage is your startup? *</label>
				<select id="sl_stage" name="sl_stage" required>
					<option value="">— Select —</option>
					<option value="Idea / pre-incorporation">Idea / pre-incorporation</option>
					<option value="Incorporated, pre-revenue">Incorporated, pre-revenue</option>
					<option value="Revenue stage">Revenue stage</option>
					<option value="Raising capital">Raising capital</option>
					<option value="Growth / Series A+">Growth / Series A+</option>
				</select>
			</div>
			<div class="sha-form-group">
				<label for="sl_need">What do you need help with? *</label>
				<select id="sl_need" name="sl_need" required>
					<option value="">— Select —</option>
					<option value="Co-founder agreement">Co-founder agreement</option>
					<option value="SAFE or KISS note">SAFE or KISS note</option>
					<option value="Seed investment documents">Seed investment documents</option>
					<option value="ESOP">Employee share option plan (ESOP)</option>
					<option value="IP assignment">IP assignment from founders</option>
					<option value="Employment contracts">Early-stage employment contracts</option>
					<option value="Other">Other</option>
				</select>
			</div>
			<div class="sha-form-group">
				<label for="sl_notes">Tell us more <span style="font-weight:400;color:#666;">(optional)</span></label>
				<textarea id="sl_notes" name="sl_notes" rows="4" placeholder="e.g. Two co-founders, about to take on our first angel investment of $150k..."></textarea>
			</div>
			<button type="submit" class="el-btn el-btn--navy" style="width:100%;margin-top:0.5rem;">Get a Free Call Back</button>
		</form>
	</div>
</section>

<section class="el-cta-banner" aria-labelledby="sl-cta">
	<div class="el-container">
		<h2 id="sl-cta">Ready to Build on Solid Legal Foundations?</h2>
		<p>Book a free 30-minute consultation with one of our commercial lawyers.</p>
		<a href="<?php echo esc_url( home_url( '/book' ) ); ?>" class="el-btn el-btn--white">Book a Free Consultation</a>
	</div>
</section>

<?php
envision_legal_page_close();
get_footer();
