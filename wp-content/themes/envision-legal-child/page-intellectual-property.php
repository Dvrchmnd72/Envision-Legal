<?php
/**
 * Template Name: Intellectual Property
 *
 * @package EnvisionLegal
 */
get_header();
envision_legal_page_open( 'el-page--practice' );
?>

<section class="el-page-header" aria-labelledby="ip-heading">
	<div class="el-container">
		<?php el_render_breadcrumb(); ?>
						<p class="el-hero__eyebrow"><?php esc_html_e( 'Commercial Law · Fractional Counsel', 'envision-legal' ); ?></p>
<h1 id="ip-heading">Intellectual Property &amp; Trademark Lawyers</h1>
		<p>Protect the brand, technology and creative work that sets your business apart.</p>
		<a href="#ip-enquiry-form" class="el-btn el-btn--white" style="margin-top:1.5rem;display:inline-block;">Get a Free Call Back</a>
	</div>
</section>

<section class="el-section" aria-labelledby="ip-about-heading">
	<div class="el-container" style="max-width:820px;">
		<h2 id="ip-about-heading">Your IP Is One of Your Most Valuable Business Assets</h2>
		<p>Intellectual property — your brand name, logo, software, creative content and trade secrets — often represents the most valuable part of a business. Yet many businesses fail to protect it until something goes wrong.</p>
		<p>At Envision Legal we help businesses across South-West Sydney register, protect and commercialise their intellectual property. Whether you are launching a new brand, licensing technology or dealing with an IP dispute, we provide clear, practical advice at every stage.</p>

		<h2 style="margin-top:2.5rem;">What We Cover</h2>
		<ul style="line-height:2;">
			<li><strong>Trademark registration</strong> — Australian and international trademark applications through IP Australia</li>
			<li><strong>Trademark searches and clearance</strong> — assess risk before you launch or invest in a brand</li>
			<li><strong>IP licensing agreements</strong> — royalty structures, exclusivity, territory and sublicensing rights</li>
			<li><strong>IP assignment deeds</strong> — transferring ownership cleanly in business sales or restructures</li>
			<li><strong>Trade secret protection</strong> — confidentiality frameworks and employment provisions</li>
			<li><strong>Copyright advice</strong> — ownership, licensing and infringement issues</li>
			<li><strong>Domain name disputes</strong> — .au domain disputes and cybersquatting</li>
			<li><strong>IP audits</strong> — map and value your IP assets ahead of investment or sale</li>
		</ul>

		<h2 style="margin-top:2.5rem;">Frequently Asked Questions</h2>

		<h3 style="margin-top:1.5rem;">How much does trademark registration cost?</h3>
		<p>IP Australia's government fees start from around $250 per class for online applications. Our legal fees for a standard single-class application start from $600 + GST. We provide a fixed-fee quote after reviewing the mark and goods/services you want to protect.</p>

		<h3 style="margin-top:1.5rem;">Do I automatically own the IP my contractor creates?</h3>
		<p>No — under Australian copyright law, the creator owns copyright unless there is a written agreement transferring ownership. If you have engaged a designer, developer or consultant without an IP assignment clause, you may not own what you paid for.</p>

		<h3 style="margin-top:1.5rem;">What is the difference between a trademark and a business name?</h3>
		<p>Registering a business name with ASIC gives you the right to trade under that name — it does not give you exclusive trademark rights. A registered trademark gives you the legal right to stop others from using a confusingly similar mark in your industry.</p>

		<h3 style="margin-top:1.5rem;">How long does trademark registration take?</h3>
		<p>In Australia, a trademark application typically takes 7–9 months from filing to registration, assuming no objections. We manage the process and keep you updated at each stage.</p>
	</div>
</section>

<section class="el-section el-section--cream" id="ip-enquiry-form" aria-labelledby="ip-form-heading">
	<div class="el-container" style="max-width:680px;">
		<header class="el-section__header">
			<h2 id="ip-form-heading">Get a Free Call Back</h2>
			<p>Tell us about your IP matter and we will be in touch within one business day — no obligation.</p>
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
			<input type="hidden" name="el_source" value="ip">
			<?php wp_nonce_field( 'el_practice_intake', 'el_practice_nonce' ); ?>
			<div class="sha-form-group">
				<label for="ip_name">Full Name *</label>
				<input type="text" id="ip_name" name="ip_name" required placeholder="Jane Smith">
			</div>
			<div class="sha-form-group">
				<label for="ip_email">Email Address *</label>
				<input type="email" id="ip_email" name="ip_email" required placeholder="jane@business.com.au">
			</div>
			<div class="sha-form-group">
				<label for="ip_phone">Phone Number *</label>
				<input type="tel" id="ip_phone" name="ip_phone" required placeholder="04xx xxx xxx">
			</div>
			<div class="sha-form-group">
				<label for="ip_type">What do you need help with? *</label>
				<select id="ip_type" name="ip_type" required>
					<option value="">— Select —</option>
					<option value="Trademark registration">Trademark registration</option>
					<option value="Trademark search">Trademark search / clearance</option>
					<option value="IP licensing">IP licensing agreement</option>
					<option value="IP assignment">IP assignment deed</option>
					<option value="Copyright issue">Copyright ownership or infringement</option>
					<option value="IP audit">IP audit</option>
					<option value="Other">Other</option>
				</select>
			</div>
			<div class="sha-form-group">
				<label for="ip_notes">Brief description of your situation <span style="font-weight:400;color:#666;">(optional)</span></label>
				<textarea id="ip_notes" name="ip_notes" rows="4" placeholder="e.g. I want to register my brand name and logo before launching next month..."></textarea>
			</div>
			<button type="submit" class="el-btn el-btn--navy" style="width:100%;margin-top:0.5rem;">Get a Free Call Back</button>
		</form>
	</div>
</section>

<section class="el-cta-banner" aria-labelledby="ip-cta">
	<div class="el-container">
		<h2 id="ip-cta">Ready to Protect What You Have Built?</h2>
		<p>Book a free 30-minute consultation with one of our commercial lawyers.</p>
		<a href="<?php echo esc_url( home_url( '/book' ) ); ?>" class="el-btn el-btn--white">Book a Free Consultation</a>
	</div>
</section>

<?php
envision_legal_page_close();
get_footer();
