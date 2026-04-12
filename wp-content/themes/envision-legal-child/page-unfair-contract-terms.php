<?php
/**
 * Template Name: Unfair Contract Terms
 * @package EnvisionLegal
 */
get_header();
envision_legal_page_open( 'el-page--practice' );
?>

<section class="el-page-header" aria-labelledby="uct-heading">
	<div class="el-container">
		<?php el_render_breadcrumb(); ?>
						<p class="el-hero__eyebrow"><?php esc_html_e( 'Commercial Law · Fractional Counsel', 'envision-legal' ); ?></p>
<h1 id="uct-heading">Unfair Contract Terms Lawyers</h1>
		<p>Protect your business from one-sided standard-form contracts &mdash; and ensure your own terms are compliant.</p>
		<a href="#uct-enquiry-form" class="el-btn el-btn--white" style="margin-top:1.5rem;display:inline-block;">Get a Free Call Back</a>
	</div>
</section>

<section class="el-section" aria-labelledby="uct-about-heading">
	<div class="el-container" style="max-width:820px;">
		<h2 id="uct-about-heading">Australia's Unfair Contract Terms Laws Have Changed &mdash; Is Your Business Ready?</h2>
		<p>Since November 2023, amendments to the Australian Consumer Law (ACL) significantly expanded the unfair contract terms (UCT) regime. Unfair terms in standard-form contracts are now <strong>void and prohibited</strong> &mdash; not just unenforceable &mdash; and businesses face substantial civil penalties for using them.</p>
		<p>The regime now covers businesses contracting with small businesses with up to 100 employees or an annual turnover of up to $10 million.</p>
		<p>At Envision Legal we audit standard-form contracts for compliance, advise businesses on their rights when dealing with unfair terms imposed by others, and update template contracts to reflect the new rules.</p>

		<h2 style="margin-top:2.5rem;">What Makes a Term Unfair?</h2>
		<p>A term is unfair if it causes a significant imbalance in the parties rights and obligations, is not reasonably necessary to protect the legitimate interests of the party who benefits from it, and would cause detriment if relied upon.</p>
		<ul style="line-height:2;">
			<li>Unilateral variation clauses &mdash; allowing one party to change the contract without notice</li>
			<li>Automatic rollover clauses with no or inadequate notice requirements</li>
			<li>Broad indemnity clauses that go well beyond what is reasonably necessary</li>
			<li>Terms allowing one party to terminate without cause while preventing the other from doing so</li>
			<li>Excessive cancellation fees or penalties disproportionate to actual loss</li>
			<li>Terms that limit one party's right to sue while preserving the other's</li>
		</ul>

		<h2 style="margin-top:2.5rem;">What We Do</h2>
		<ul style="line-height:2;">
			<li><strong>Contract audits</strong> &mdash; review your standard-form contracts for UCT risk and compliance</li>
			<li><strong>Contract redrafting</strong> &mdash; update terms to comply with the new regime while maintaining your commercial position</li>
			<li><strong>Advice for small businesses</strong> &mdash; understand your rights when a supplier presents you with a standard form</li>
			<li><strong>ACCC and ASIC response</strong> &mdash; if you are contacted by a regulator about your standard-form contracts</li>
		</ul>

		<h2 style="margin-top:2.5rem;">Frequently Asked Questions</h2>
		<h3 style="margin-top:1.5rem;">What are the penalties for including unfair terms?</h3>
		<p>Businesses face civil penalties of up to $50 million for bodies corporate. Individuals face penalties of up to $2.5 million. This is a significant increase from the previous regime where no penalties applied.</p>

		<h3 style="margin-top:1.5rem;">Does this apply to B2B contracts?</h3>
		<p>Yes &mdash; the UCT regime applies to standard-form contracts with small businesses up to 100 employees or $10 million turnover. If you use standard-form contracts with any of these counterparties, you need to review them.</p>

		<h3 style="margin-top:1.5rem;">What is a standard-form contract?</h3>
		<p>A standard-form contract is one prepared by one party and presented to the other on a take-it-or-leave-it basis with little opportunity to negotiate. Courts look at the substance &mdash; even if some negotiation occurred, a contract can still be standard form for UCT purposes.</p>

		<h3 style="margin-top:1.5rem;">How quickly can you audit our contracts?</h3>
		<p>For most standard-form contracts we can complete an initial risk assessment within 3&ndash;5 business days and provide a written summary of findings and recommended changes.</p>
	</div>
</section>

<section class="el-section el-section--cream" id="uct-enquiry-form" aria-labelledby="uct-form-heading">
	<div class="el-container" style="max-width:680px;">
		<header class="el-section__header">
			<h2 id="uct-form-heading">Get a Free Call Back</h2>
			<p>Tell us about your contract situation and we will be in touch within one business day &mdash; no obligation.</p>
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
			<input type="hidden" name="el_source" value="uct">
			<?php wp_nonce_field( 'el_practice_intake', 'el_practice_nonce' ); ?>
			<div class="sha-form-group">
				<label for="uct_name">Full Name *</label>
				<input type="text" id="uct_name" name="uct_name" required placeholder="Jane Smith">
			</div>
			<div class="sha-form-group">
				<label for="uct_email">Email Address *</label>
				<input type="email" id="uct_email" name="uct_email" required placeholder="jane@business.com.au">
			</div>
			<div class="sha-form-group">
				<label for="uct_phone">Phone Number *</label>
				<input type="tel" id="uct_phone" name="uct_phone" required placeholder="04xx xxx xxx">
			</div>
			<div class="sha-form-group">
				<label for="uct_need">What do you need help with? *</label>
				<select id="uct_need" name="uct_need" required>
					<option value="">&#8212; Select &#8212;</option>
					<option value="Audit my contracts for UCT compliance">Audit my contracts for UCT compliance</option>
					<option value="Redraft standard-form contracts">Redraft standard-form contracts</option>
					<option value="Review a contract presented to me">Review a contract presented to me</option>
					<option value="Regulator enquiry response">Respond to a regulator enquiry</option>
					<option value="Other">Other</option>
				</select>
			</div>
			<div class="sha-form-group">
				<label for="uct_notes">Brief description <span style="font-weight:400;color:#666;">(optional)</span></label>
				<textarea id="uct_notes" name="uct_notes" rows="4" placeholder="e.g. We use a standard service agreement across 200+ clients and want to check it complies..."></textarea>
			</div>
			<button type="submit" class="el-btn el-btn--navy" style="width:100%;margin-top:0.5rem;">Get a Free Call Back</button>
		</form>
	</div>
</section>

<section class="el-cta-banner" aria-labelledby="uct-cta">
	<div class="el-container">
		<h2 id="uct-cta">Don't Wait for a Regulator to Tell You There's a Problem</h2>
		<p>Book a free 30-minute consultation with one of our commercial lawyers.</p>
		<a href="<?php echo esc_url( home_url( '/book' ) ); ?>" class="el-btn el-btn--white">Book a Free Consultation</a>
	</div>
</section>

<?php
envision_legal_page_close();
get_footer();
