<?php
/**
 * Template Name: Business Contracts
 *
 * @package EnvisionLegal
 */
get_header();
envision_legal_page_open( 'el-page--practice' );
?>

<section class="el-page-header" aria-labelledby="bc-heading">
	<div class="el-container">
						<p class="el-hero__eyebrow"><?php esc_html_e( 'Commercial Law · Fractional Counsel', 'envision-legal' ); ?></p>
<h1 id="bc-heading">Business Contract Lawyers</h1>
		<p>Contracts that are clear, enforceable and built around your commercial reality — not boilerplate.</p>
		<a href="#bc-enquiry-form" class="el-btn el-btn--white" style="margin-top:1.5rem;display:inline-block;">Get a Free Call Back</a>
	</div>
</section>

<section class="el-section" aria-labelledby="bc-about-heading">
	<div class="el-container" style="max-width:820px;">
		<h2 id="bc-about-heading">Contracts That Protect Your Business</h2>
		<p>Every commercial relationship — with a supplier, customer, employee or partner — starts with an agreement. When that agreement is poorly drafted or missing entirely, disputes become expensive and outcomes become uncertain.</p>
		<p>At Envision Legal we draft, review and negotiate commercial contracts for businesses across South-West Sydney including Campbelltown, Liverpool, Parramatta and Bankstown. We write contracts in plain English that both sides actually understand, while ensuring your legal position is airtight.</p>
		<p>Whether you need a one-page NDA or a complex multi-party supply agreement, we tailor every document to your specific situation — not a generic template.</p>

		<h2 style="margin-top:2.5rem;">Contract Types We Handle</h2>
		<ul style="line-height:2;">
			<li><strong>Supply and procurement agreements</strong> — terms of trade, purchase orders and supplier contracts</li>
			<li><strong>Service agreements</strong> — scope of work, payment terms, IP ownership and liability</li>
			<li><strong>Distribution and agency agreements</strong> — exclusivity, territory and commission structures</li>
			<li><strong>Non-disclosure agreements (NDAs)</strong> — mutual and one-way confidentiality</li>
			<li><strong>Licensing agreements</strong> — software, brand, IP and franchise-style licences</li>
			<li><strong>Employment contracts</strong> — tailored offers, restraints and IP assignment clauses</li>
			<li><strong>Contractor and consultant agreements</strong> — sham contracting protection and clear deliverables</li>
			<li><strong>Joint venture agreements</strong> — structure, contribution, profit-sharing and exit</li>
		</ul>

		<h2 style="margin-top:2.5rem;">Frequently Asked Questions</h2>

		<h3 style="margin-top:1.5rem;">How much does a commercial contract cost?</h3>
		<p>Simple NDAs and standard service agreements typically start from $500 + GST on a fixed-fee basis. More complex contracts are quoted after a brief consultation. We are transparent about costs upfront — no surprises.</p>

		<h3 style="margin-top:1.5rem;">Can you review a contract someone else has sent me?</h3>
		<p>Yes. Contract review is one of our most common services. We read the full document, flag any terms that expose you to risk, and advise on what to push back on before you sign.</p>

		<h3 style="margin-top:1.5rem;">What if the other side uses their own standard terms?</h3>
		<p>We negotiate on your behalf. We identify the clauses that matter most — liability caps, indemnities, termination rights — and work to get you better terms without blowing up the deal.</p>

		<h3 style="margin-top:1.5rem;">Do you handle ongoing contract management?</h3>
		<p>Yes — through our Fractional General Counsel service, we can manage your contract library, run renewals and flag risk across your entire agreement portfolio on a retainer basis.</p>
	</div>
</section>

<section class="el-section el-section--cream" id="bc-enquiry-form" aria-labelledby="bc-form-heading">
	<div class="el-container" style="max-width:680px;">
		<header class="el-section__header">
			<h2 id="bc-form-heading">Get a Free Call Back</h2>
			<p>Tell us about your contract matter and we will be in touch within one business day — no obligation.</p>
		</header>
		<?php
		if ( isset( $_POST['bc_form_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['bc_form_nonce'] ) ), 'bc_intake_form' ) ) {
			$name    = sanitize_text_field( wp_unslash( $_POST['bc_name'] ?? '' ) );
			$email   = sanitize_email( wp_unslash( $_POST['bc_email'] ?? '' ) );
			$phone   = sanitize_text_field( wp_unslash( $_POST['bc_phone'] ?? '' ) );
			$type    = sanitize_text_field( wp_unslash( $_POST['bc_type'] ?? '' ) );
			$notes   = sanitize_textarea_field( wp_unslash( $_POST['bc_notes'] ?? '' ) );
			$to      = 'hello@envisionlegal.com.au';
			$subject = 'New Business Contracts Enquiry — ' . $name;
			$body    = "New business contracts enquiry from the website:\n\n"
				. "Name: $name\n"
				. "Email: $email\n"
				. "Phone: $phone\n"
				. "Contract type needed: $type\n"
				. "Additional notes:\n$notes\n";
			$headers = array( 'Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $name . ' <' . $email . '>' );
			wp_mail( $to, $subject, $body, $headers );
			?>
			<div style="background:#f0faf4;border:2px solid #2e7d32;border-radius:8px;text-align:center;padding:2.5rem;">
				<div style="font-size:2.5rem;margin-bottom:1rem;">&#10003;</div>
				<h3 style="color:#2e7d32;margin:0 0 0.5rem;">Enquiry Received</h3>
				<p style="margin:0;">Thanks <?php echo esc_html( $name ); ?> — we will be in touch within one business day.</p>
			</div>
			<?php
		} else { ?>
		<form method="post" action="#bc-enquiry-form" novalidate>
			<?php wp_nonce_field( 'bc_intake_form', 'bc_form_nonce' ); ?>
			<div class="sha-form-group">
				<label for="bc_name">Full Name *</label>
				<input type="text" id="bc_name" name="bc_name" required placeholder="Jane Smith">
			</div>
			<div class="sha-form-group">
				<label for="bc_email">Email Address *</label>
				<input type="email" id="bc_email" name="bc_email" required placeholder="jane@business.com.au">
			</div>
			<div class="sha-form-group">
				<label for="bc_phone">Phone Number *</label>
				<input type="tel" id="bc_phone" name="bc_phone" required placeholder="04xx xxx xxx">
			</div>
			<div class="sha-form-group">
				<label for="bc_type">What type of contract do you need help with? *</label>
				<select id="bc_type" name="bc_type" required>
					<option value="">— Select —</option>
					<option value="Draft a new contract">Draft a new contract</option>
					<option value="Review a contract">Review a contract sent to me</option>
					<option value="Negotiate contract terms">Negotiate contract terms</option>
					<option value="Employment contract">Employment contract</option>
					<option value="NDA">Non-disclosure agreement</option>
					<option value="Other">Other</option>
				</select>
			</div>
			<div class="sha-form-group">
				<label for="bc_notes">Brief description of your situation <span style="font-weight:400;color:#666;">(optional)</span></label>
				<textarea id="bc_notes" name="bc_notes" rows="4" placeholder="e.g. I need a service agreement reviewed before signing next week..."></textarea>
			</div>
			<button type="submit" class="el-btn el-btn--navy" style="width:100%;margin-top:0.5rem;">Get a Free Call Back</button>
		</form>
		<?php } ?>
	</div>
</section>

<section class="el-cta-banner" aria-labelledby="bc-cta">
	<div class="el-container">
		<h2 id="bc-cta">Ready to Protect Your Business?</h2>
		<p>Book a free 30-minute consultation with one of our commercial lawyers.</p>
		<a href="<?php echo esc_url( home_url( '/book' ) ); ?>" class="el-btn el-btn--white">Book a Free Consultation</a>
	</div>
</section>

<?php
envision_legal_page_close();
get_footer();
