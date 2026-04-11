<?php
/**
 * Template Name: Shareholder Agreements
 *
 * @package EnvisionLegal
 */
get_header();
envision_legal_page_open( 'el-page--practice' );
?>

<section class="el-page-header" aria-labelledby="sha-heading">
	<div class="el-container">
						<p class="el-hero__eyebrow"><?php esc_html_e( 'Commercial Law · Fractional Counsel', 'envision-legal' ); ?></p>
<h1 id="sha-heading">Shareholder &amp; Partnership Agreement Lawyers</h1>
		<p>Protect your business, your shares and your relationships before a dispute forces the issue.</p>
		<a href="#sha-enquiry-form" class="el-btn el-btn--white" style="margin-top:1.5rem;display:inline-block;">Get a Free Call Back</a>
	</div>
</section>

<section class="el-section" aria-labelledby="sha-about-heading">
	<div class="el-container" style="max-width:820px;">
		<h2 id="sha-about-heading">Why Every Multi-Shareholder Business Needs a Shareholders Agreement</h2>
		<p>If you own shares in a company alongside other people and you do not have a shareholders agreement, you are operating on the Corporations Act default rules — a generic framework that was never designed with your business in mind.</p>
		<p>A well-drafted shareholders agreement covers the things that matter most: who makes key decisions, what happens when shareholders cannot agree, how shares can be transferred or bought out, and what exit mechanisms apply when a founder leaves.</p>
		<p>At Envision Legal, we draft, review and negotiate shareholders agreements for businesses across South-West Sydney including Campbelltown, Liverpool, Parramatta and Bankstown. We write agreements in plain English that your shareholders will actually read and understand.</p>

		<h2 style="margin-top:2.5rem;">What We Cover</h2>
		<ul style="line-height:2;">
			<li><strong>Decision-making and voting rights</strong> — what requires unanimous approval vs majority</li>
			<li><strong>Deadlock resolution</strong> — Russian roulette, buy-sell or valuation mechanisms</li>
			<li><strong>Share transfer restrictions</strong> — pre-emptive rights and approved transfer processes</li>
			<li><strong>Exit events</strong> — tag-along and drag-along rights for clean business sales</li>
			<li><strong>Founder vesting</strong> — protecting the business if a co-founder leaves early</li>
			<li><strong>Restraints of trade</strong> — enforceable post-departure restrictions</li>
			<li><strong>Funding obligations</strong> — capital contribution requirements and shareholder loans</li>
			<li><strong>Partnership agreements</strong> — for unincorporated business partnerships</li>
		</ul>

		<h2 style="margin-top:2.5rem;">Frequently Asked Questions</h2>

		<h3 style="margin-top:1.5rem;">How much does a shareholders agreement cost?</h3>
		<p>A straightforward two-shareholder agreement for a small business typically starts from $1,500 + GST. More complex structures with multiple shareholders, vesting schedules or bespoke exit mechanisms will be priced accordingly. We provide a fixed-fee quote after your initial consultation.</p>

		<h3 style="margin-top:1.5rem;">Do I need one if I already have a company constitution?</h3>
		<p>Yes. A constitution is a public document that must comply with the Corporations Act. A shareholders agreement is private, flexible and can address any issue the shareholders agree is important — it sits alongside the constitution and fills the gaps.</p>

		<h3 style="margin-top:1.5rem;">When is the best time to put one in place?</h3>
		<p>Before you need it. The conversation is straightforward when all shareholders are aligned and optimistic. It becomes significantly harder and more expensive once a dispute has arisen or a shareholder wants to exit without an agreed mechanism.</p>

		<h3 style="margin-top:1.5rem;">Can you review an existing agreement?</h3>
		<p>Absolutely. We review existing shareholders agreements and partnership agreements, identify gaps or unfair terms, and advise on whether amendments are required.</p>
	</div>
</section>

<section class="el-section el-section--cream" id="sha-enquiry-form" aria-labelledby="sha-form-heading">
	<div class="el-container" style="max-width:680px;">
		<header class="el-section__header">
			<h2 id="sha-form-heading">Get a Free Call Back</h2>
			<p>Tell us about your situation and we will be in touch within one business day — no obligation.</p>
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
				Please complete all required fields and try again.
			</div>
		<?php elseif ( 'error' === $el_enquiry ) : ?>
			<div style="background:#fff5f5;border:2px solid #c0392b;border-radius:8px;text-align:center;padding:1rem;margin-bottom:1.5rem;" role="alert">
				Something went wrong — please try again.
			</div>
		<?php endif; ?>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" class="sha-intake-form">
			<input type="hidden" name="action" value="el_practice_intake">
			<input type="hidden" name="el_source" value="sha">
			<?php wp_nonce_field( 'el_practice_intake', 'el_practice_nonce' ); ?>
			<div class="sha-form-group">
				<label for="sha_name">Full Name *</label>
				<input type="text" id="sha_name" name="sha_name" required placeholder="Jane Smith">
			</div>
			<div class="sha-form-group">
				<label for="sha_email">Email Address *</label>
				<input type="email" id="sha_email" name="sha_email" required placeholder="jane@business.com.au">
			</div>
			<div class="sha-form-group">
				<label for="sha_phone">Phone Number *</label>
				<input type="tel" id="sha_phone" name="sha_phone" required placeholder="04xx xxx xxx">
			</div>
			<div class="sha-form-group">
				<label for="sha_shareholders">How many shareholders? *</label>
				<select id="sha_shareholders" name="sha_shareholders" required>
					<option value="">— Select —</option>
					<option value="2">2</option>
					<option value="3">3</option>
					<option value="4+">4 or more</option>
				</select>
			</div>
			<div class="sha-form-group">
				<label for="sha_incorporated">Is the company already incorporated?</label>
				<select id="sha_incorporated" name="sha_incorporated">
					<option value="">— Select —</option>
					<option value="Yes">Yes</option>
					<option value="No">No — we are setting up</option>
					<option value="Partnership">It is a partnership, not a company</option>
				</select>
			</div>
			<div class="sha-form-group">
				<fieldset>
					<legend>What is your main concern? (select all that apply)</legend>
					<label class="sha-checkbox"><input type="checkbox" name="sha_concerns[]" value="Protecting my shares"> Protecting my shares</label>
					<label class="sha-checkbox"><input type="checkbox" name="sha_concerns[]" value="Dispute resolution between shareholders"> Dispute resolution between shareholders</label>
					<label class="sha-checkbox"><input type="checkbox" name="sha_concerns[]" value="Exit or buyout provisions"> Exit / buyout provisions</label>
					<label class="sha-checkbox"><input type="checkbox" name="sha_concerns[]" value="Voting and decision-making rights"> Voting and decision-making rights</label>
					<label class="sha-checkbox"><input type="checkbox" name="sha_concerns[]" value="Reviewing an existing agreement"> Reviewing an existing agreement</label>
					<label class="sha-checkbox"><input type="checkbox" name="sha_concerns[]" value="Other"> Other</label>
				</fieldset>
			</div>
			<div class="sha-form-group">
				<label for="sha_notes">Anything else you would like us to know? <span style="font-weight:400;color:#666;">(optional)</span></label>
				<textarea id="sha_notes" name="sha_notes" rows="4" placeholder="Brief description of your situation..."></textarea>
			</div>
			<button type="submit" class="el-btn el-btn--navy" style="width:100%;margin-top:0.5rem;">Get a Free Call Back</button>
		</form>
	</div>
</section>

<section class="el-cta-banner" aria-labelledby="sha-cta">
	<div class="el-container">
		<h2 id="sha-cta">Ready to Protect Your Business?</h2>
		<p>Book a free 30-minute consultation with one of our commercial lawyers.</p>
		<a href="<?php echo esc_url( home_url( '/book' ) ); ?>" class="el-btn el-btn--white">Book a Free Consultation</a>
	</div>
</section>

