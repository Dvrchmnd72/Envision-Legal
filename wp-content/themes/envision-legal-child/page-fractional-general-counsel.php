<?php
/**
 * Template Name: Fractional General Counsel
 * @package EnvisionLegal
 */
get_header();
envision_legal_page_open( 'el-page--practice' );
?>

<section class="el-page-header" aria-labelledby="fgc-heading">
	<div class="el-container">
		<?php el_render_breadcrumb(); ?>
						<p class="el-hero__eyebrow"><?php esc_html_e( 'Commercial Law · Fractional Counsel', 'envision-legal' ); ?></p>
<h1 id="fgc-heading">Fractional General Counsel</h1>
		<p>Senior in-house legal expertise on a flexible retainer &mdash; without the full-time cost.</p>
		<a href="#fgc-enquiry-form" class="el-btn el-btn--white" style="margin-top:1.5rem;display:inline-block;">Get a Free Call Back</a>
	</div>
</section>

<section class="el-section" aria-labelledby="fgc-about-heading">
	<div class="el-container" style="max-width:820px;">
		<h2 id="fgc-about-heading">Your Own General Counsel &mdash; Without the Overhead</h2>
		<p>A full-time General Counsel costs $200,000&ndash;$350,000 per year in salary alone. For most growing businesses, that investment only makes sense at significant scale.</p>
		<p>Our Fractional General Counsel service gives you the same calibre of senior legal advice &mdash; embedded in your business, aligned with your commercial goals &mdash; on a monthly retainer that scales with your needs.</p>
		<p>We work with scale-ups, mid-market businesses and family enterprises across South-West Sydney who need more than ad hoc legal advice but are not yet ready for a full-time hire.</p>

		<h2 style="margin-top:2.5rem;">What Is Included</h2>
		<ul style="line-height:2;">
			<li><strong>Contract review and management</strong> &mdash; all incoming and outgoing commercial agreements</li>
			<li><strong>Legal risk reviews</strong> &mdash; proactive identification of legal risk across your operations</li>
			<li><strong>Policy and procedure drafting</strong> &mdash; employment policies, privacy, compliance frameworks</li>
			<li><strong>Board and management advice</strong> &mdash; attending meetings and advising on governance</li>
			<li><strong>Vendor and supplier negotiations</strong> &mdash; representing you in commercial negotiations</li>
			<li><strong>Regulatory compliance</strong> &mdash; keeping you on the right side of your industry obligations</li>
			<li><strong>Dispute management</strong> &mdash; early-stage advice and escalation to litigation specialists if needed</li>
			<li><strong>Legal training for your team</strong> &mdash; educating staff on key legal concepts</li>
		</ul>

		<h2 style="margin-top:2.5rem;">How It Works</h2>
		<ol style="line-height:2.2;">
			<li><strong>Initial assessment</strong> &mdash; we review your business, existing contracts and current legal exposure</li>
			<li><strong>Tailored retainer</strong> &mdash; we agree on a scope and monthly retainer that fits your needs and budget</li>
			<li><strong>Embedded support</strong> &mdash; we become part of your team, available by phone, email and in-person</li>
			<li><strong>Quarterly reviews</strong> &mdash; we review the scope and adjust as your business evolves</li>
		</ol>

		<h2 style="margin-top:2.5rem;">Frequently Asked Questions</h2>
		<h3 style="margin-top:1.5rem;">How much does Fractional General Counsel cost?</h3>
		<p>Most clients start from $2,500 + GST per month on a fixed monthly fee agreed after an initial scoping conversation &mdash; no surprise bills.</p>

		<h3 style="margin-top:1.5rem;">What size business is this suited to?</h3>
		<p>Businesses with 10&ndash;200 employees or $2M&ndash;$50M annual turnover. If you are spending more than $3,000/month on ad hoc legal fees, a retainer almost certainly makes more financial sense.</p>

		<h3 style="margin-top:1.5rem;">Can I still use other lawyers for specialist matters?</h3>
		<p>Yes. We coordinate with your existing advisors and refer specialist matters &mdash; litigation, property or tax &mdash; to trusted specialists, managing those relationships on your behalf.</p>

		<h3 style="margin-top:1.5rem;">Is there a minimum commitment?</h3>
		<p>We ask for an initial three-month engagement so we can properly embed in your business. After that the arrangement continues on a rolling monthly basis with 30 days notice to end.</p>

		<!-- ── Download Info Pack (Lead Magnet) ─────────────────────────────────── -->
		<section class="el-section el-section--cream" aria-labelledby="fc-download-heading" style="margin-top:2.5rem;">
			<div class="el-container" style="max-width:820px;padding:0;">
				<header class="el-section__header" style="text-align:left;margin-bottom:1rem;">
					<h2 id="fc-download-heading">Download the Fractional Counsel Info Pack</h2>
					<p>Enter your email and we’ll send you a direct download link.</p>
				</header>

				<?php if ( isset( $_GET['download'] ) && 'ok' === $_GET['download'] ) : ?>
					<div role="status" style="margin-bottom:1rem;background:#f0faf4;border:2px solid #2e7d32;border-radius:8px;padding:1rem;">
						<strong>Success.</strong> Check your inbox for the download link.
						<div style="margin-top:.5rem;">
							<a class="el-card__link" href="https://envisionlegal.com.au/wp-content/uploads/2026/04/Fractional-Counsel_Envision-Legal-1.pdf" target="_blank" rel="noopener">Open the PDF now →</a>
						</div>
					</div>
				<?php elseif ( isset( $_GET['download'] ) && 'invalid' === $_GET['download'] ) : ?>
					<div role="alert" style="margin-bottom:1rem;background:#fff5f5;border:2px solid #c0392b;border-radius:8px;padding:1rem;">
						Please enter a valid email address.
					</div>
				<?php elseif ( isset( $_GET['download'] ) && 'error' === $_GET['download'] ) : ?>
					<div role="alert" style="margin-bottom:1rem;background:#fff5f5;border:2px solid #c0392b;border-radius:8px;padding:1rem;">
						Something went wrong — please try again.
					</div>
				<?php endif; ?>

				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="el-form el-form--download" style="margin-top:1rem;">
					<input type="hidden" name="action" value="el_fc_download_v2">
					<?php wp_nonce_field( 'el_fc_download' ); ?>

					<!-- Honeypot -->
					<div style="position:absolute;left:-9999px;top:auto;width:1px;height:1px;overflow:hidden;">
						<label>Company <input type="text" name="el_company" tabindex="-1" autocomplete="off"></label>
					</div>

					<div class="el-fgc-download-grid">
						<div class="sha-form-group">
							<label for="el_name">Full name <span style="font-weight:400;color:#666;">(optional)</span></label>
							<input id="el_name" name="el_name" type="text" autocomplete="name" placeholder="Jane Smith">
						</div>

						<div class="sha-form-group">
							<label for="el_email">Email address *</label>
							<input id="el_email" name="el_email" type="email" required autocomplete="email" placeholder="jane@business.com.au">
						</div>
					</div>

					<p style="margin-top:.75rem;font-size:.95rem;color:#666;">
						By submitting, you agree to receive the requested document and related follow-up from Envision Legal. You can opt out anytime.
					</p>

					<button type="submit" class="el-btn el-btn--navy" style="margin-top:.5rem;">Email me the PDF link</button>
				</form>
			</div>
		</section>

	</div>
</section>

<section class="el-section el-section--cream" id="fgc-enquiry-form" aria-labelledby="fgc-form-heading">
	<div class="el-container" style="max-width:680px;">
		<header class="el-section__header">
			<h2 id="fgc-form-heading">Get a Free Call Back</h2>
			<p>Tell us about your business and we will be in touch within one business day &mdash; no obligation.</p>
		</header>
		<?php
		$el_enquiry = isset( $_GET['enquiry'] ) ? sanitize_text_field( wp_unslash( $_GET['enquiry'] ) ) : '';
		if ( 'ok' === $el_enquiry ) : ?>
			<div style="background:#f0faf4;border:2px solid #2e7d32;border-radius:8px;text-align:center;padding:2.5rem;margin-bottom:1.5rem;">
				<div style="font-size:2.5rem;margin-bottom:1rem;">&#10003;</div>
				<h3 style="color:#2e7d32;margin:0 0 0.5rem;">Enquiry Received</h3>
				<p style="margin:0;">Thanks &mdash; we will be in touch within one business day.</p>
			</div>
		<?php elseif ( 'invalid' === $el_enquiry ) : ?>
			<div style="background:#fff5f5;border:2px solid #c0392b;border-radius:8px;text-align:center;padding:1rem;margin-bottom:1.5rem;" role="alert">
				Please complete all required fields and select the required options, then try again.
			</div>
		<?php elseif ( 'error' === $el_enquiry ) : ?>
			<div style="background:#fff5f5;border:2px solid #c0392b;border-radius:8px;text-align:center;padding:1rem;margin-bottom:1.5rem;" role="alert">
				Something went wrong &mdash; please try again.
			</div>
		<?php endif; ?>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<input type="hidden" name="action" value="el_practice_intake">
			<input type="hidden" name="el_source" value="fgc">
			<?php wp_nonce_field( 'el_practice_intake', 'el_practice_nonce' ); ?>
			<div class="sha-form-group">
				<label for="fgc_name">Full Name *</label>
				<input type="text" id="fgc_name" name="fgc_name" required placeholder="Jane Smith">
			</div>
			<div class="sha-form-group">
				<label for="fgc_email">Email Address *</label>
				<input type="email" id="fgc_email" name="fgc_email" required placeholder="jane@business.com.au">
			</div>
			<div class="sha-form-group">
				<label for="fgc_phone">Phone Number *</label>
				<input type="tel" id="fgc_phone" name="fgc_phone" required placeholder="04xx xxx xxx">
			</div>
			<div class="sha-form-group">
				<label for="fgc_company">Business / Company Name</label>
				<input type="text" id="fgc_company" name="fgc_company" placeholder="Acme Pty Ltd">
			</div>
			<div class="sha-form-group">
				<label for="fgc_size">Approximate number of employees *</label>
				<select id="fgc_size" name="fgc_size" required>
					<option value="">&#8212; Select &#8212;</option>
					<option value="1-10">1&ndash;10</option>
					<option value="11-50">11&ndash;50</option>
					<option value="51-200">51&ndash;200</option>
					<option value="200+">200+</option>
				</select>
			</div>
			<div class="sha-form-group">
				<label for="fgc_spend">Current monthly legal spend (approximate) *</label>
				<select id="fgc_spend" name="fgc_spend" required>
					<option value="">&#8212; Select &#8212;</option>
					<option value="Under ,000">Under $1,000</option>
					<option value=",000-,000">$1,000 &ndash; $3,000</option>
					<option value=",000-0,000">$3,000 &ndash; $10,000</option>
					<option value="Over 0,000">Over $10,000</option>
				</select>
			</div>
			<div class="sha-form-group">
				<label for="fgc_notes">What legal support do you need most? <span style="font-weight:400;color:#666;">(optional)</span></label>
				<textarea id="fgc_notes" name="fgc_notes" rows="4" placeholder="e.g. Contract review, employment issues, board-level advice, compliance..."></textarea>
			</div>
			<button type="submit" class="el-btn el-btn--navy" style="width:100%;margin-top:0.5rem;">Get a Free Call Back</button>
		</form>
	</div>
</section>

<section class="el-cta-banner" aria-labelledby="fgc-cta">
	<div class="el-container">
		<h2 id="fgc-cta">Ready for Legal Support That Grows With Your Business?</h2>
		<p>Book a free 30-minute consultation with one of our commercial lawyers.</p>
		<a href="<?php echo esc_url( home_url( '/book' ) ); ?>" class="el-btn el-btn--white">Book a Free Consultation</a>
	</div>
</section>

<?php
envision_legal_page_close();
get_footer();
