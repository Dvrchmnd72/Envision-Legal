<?php
/**
 * Template Name: Business Sales & Acquisitions
 *
 * @package EnvisionLegal
 */
get_header();
envision_legal_page_open( 'el-page--practice' );
?>

<section class="el-page-header" aria-labelledby="bsa-heading">
	<div class="el-container">
						<p class="el-hero__eyebrow"><?php esc_html_e( 'Commercial Law · Fractional Counsel', 'envision-legal' ); ?></p>
<h1 id="bsa-heading">Business Sales &amp; Acquisitions Lawyers</h1>
		<p>Expert legal guidance from heads of agreement through to settlement — so your deal gets done right.</p>
		<a href="#bsa-enquiry-form" class="el-btn el-btn--white" style="margin-top:1.5rem;display:inline-block;">Get a Free Call Back</a>
	</div>
</section>

<section class="el-section" aria-labelledby="bsa-about-heading">
	<div class="el-container" style="max-width:820px;">
		<h2 id="bsa-about-heading">Buying or Selling a Business? Get the Right Legal Team.</h2>
		<p>Buying or selling a business is one of the most significant transactions you will ever undertake. Without the right legal advice, small oversights in due diligence, contract structure or settlement mechanics can have serious financial consequences.</p>
		<p>At Envision Legal we guide buyers and sellers through every stage of the transaction — from initial term sheets to final settlement — with clear, commercially-minded advice that keeps your deal on track.</p>
		<p>We act for business owners, investors and acquirers across South-West Sydney including Campbelltown, Liverpool, Parramatta and Bankstown.</p>

		<h2 style="margin-top:2.5rem;">What We Cover</h2>
		<ul style="line-height:2;">
			<li><strong>Due diligence</strong> — legal, contractual and regulatory risk review</li>
			<li><strong>Asset vs share sale structuring</strong> — advice on tax and liability implications</li>
			<li><strong>Heads of agreement / term sheets</strong> — binding and non-binding terms</li>
			<li><strong>Business sale and purchase agreements</strong> — comprehensive, negotiated contracts</li>
			<li><strong>Vendor and purchaser warranties</strong> — disclosure schedules and indemnity provisions</li>
			<li><strong>Restraint of trade clauses</strong> — protecting goodwill post-settlement</li>
			<li><strong>Lease assignments and novations</strong> — retail and commercial premises</li>
			<li><strong>Settlement and completion</strong> — conditions precedent, adjustments and handover</li>
		</ul>

		<h2 style="margin-top:2.5rem;">5 Legal Red Flags That Kill Business Deals</h2>
		<ol style="line-height:2.2;">
			<li>Undisclosed liabilities not surfaced during due diligence</li>
			<li>Lease terms that cannot be assigned or renewed</li>
			<li>Key employees or customers with no binding agreements in place</li>
			<li>Intellectual property owned by a third party, not the business</li>
			<li>Warranty and indemnity terms that expose the buyer to unlimited risk</li>
		</ol>

		<h2 style="margin-top:2.5rem;">Frequently Asked Questions</h2>

		<h3 style="margin-top:1.5rem;">How long does a business sale take?</h3>
		<p>A straightforward asset sale typically completes in 4–8 weeks from execution of the sale agreement. More complex transactions or those involving regulatory approvals can take longer. Early legal involvement speeds up the process significantly.</p>

		<h3 style="margin-top:1.5rem;">What is the difference between an asset sale and a share sale?</h3>
		<p>In an asset sale, the buyer acquires specific business assets. In a share sale, the buyer acquires the company itself including all its history and liabilities. Each has different tax, risk and stamp duty implications — we advise on the right structure for your situation.</p>

		<h3 style="margin-top:1.5rem;">Do I need a lawyer if I am using a business broker?</h3>
		<p>Yes. A broker manages the commercial negotiation and marketing — a lawyer reviews and drafts the legal documents that bind you. The two roles are complementary, not interchangeable.</p>
	</div>
</section>

<section class="el-section el-section--cream" id="bsa-enquiry-form" aria-labelledby="bsa-form-heading">
	<div class="el-container" style="max-width:680px;">
		<header class="el-section__header">
			<h2 id="bsa-form-heading">Get a Free Call Back</h2>
			<p>Tell us about your transaction and we will be in touch within one business day — no obligation.</p>
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
			<input type="hidden" name="el_source" value="bsa">
			<?php wp_nonce_field( 'el_practice_intake', 'el_practice_nonce' ); ?>
			<div class="sha-form-group">
				<label for="bsa_name">Full Name *</label>
				<input type="text" id="bsa_name" name="bsa_name" required placeholder="Jane Smith">
			</div>
			<div class="sha-form-group">
				<label for="bsa_email">Email Address *</label>
				<input type="email" id="bsa_email" name="bsa_email" required placeholder="jane@business.com.au">
			</div>
			<div class="sha-form-group">
				<label for="bsa_phone">Phone Number *</label>
				<input type="tel" id="bsa_phone" name="bsa_phone" required placeholder="04xx xxx xxx">
			</div>
			<div class="sha-form-group">
				<label for="bsa_role">Are you buying or selling? *</label>
				<select id="bsa_role" name="bsa_role" required>
					<option value="">— Select —</option>
					<option value="Buying a business">Buying a business</option>
					<option value="Selling a business">Selling a business</option>
					<option value="Both / Joint venture">Both / Joint venture</option>
					<option value="Due diligence review only">Due diligence review only</option>
				</select>
			</div>
			<div class="sha-form-group">
				<label for="bsa_value">Approximate deal value *</label>
				<select id="bsa_value" name="bsa_value" required>
					<option value="">— Select —</option>
					<option value="Under $250k">Under $250,000</option>
					<option value="$250k–$1m">$250,000 – $1,000,000</option>
					<option value="$1m–$5m">$1,000,000 – $5,000,000</option>
					<option value="Over $5m">Over $5,000,000</option>
				</select>
			</div>
			<div class="sha-form-group">
				<label for="bsa_notes">Brief description of the transaction <span style="font-weight:400;color:#666;">(optional)</span></label>
				<textarea id="bsa_notes" name="bsa_notes" rows="4" placeholder="e.g. Looking to acquire a cafe in Campbelltown, settlement expected in 6 weeks..."></textarea>
			</div>
			<button type="submit" class="el-btn el-btn--navy" style="width:100%;margin-top:0.5rem;">Get a Free Call Back</button>
		</form>
	</div>
</section>

<section class="el-cta-banner" aria-labelledby="bsa-cta">
	<div class="el-container">
		<h2 id="bsa-cta">Ready to Move Forward on Your Transaction?</h2>
		<p>Book a free 30-minute consultation with one of our commercial lawyers.</p>
		<a href="<?php echo esc_url( home_url( '/book' ) ); ?>" class="el-btn el-btn--white">Book a Free Consultation</a>
	</div>
</section>

<?php
envision_legal_page_close();
get_footer();
