<?php
/**
 * Template Name: Referral Intake Form
 */
get_header();

$submitted = false;
$errors    = [];

if ( isset( $_GET['ref_success'] ) && $_GET['ref_success'] === '1' ) {
	$submitted = true;
}
?>

<main>

<!-- HERO -->
<section class="el-hero el-hero--compact" aria-labelledby="intake-hero-heading">
	<div class="el-container">
		<div class="el-hero__inner">
			<p class="el-hero__eyebrow">Referral Partner Program</p>
			<h1 id="intake-hero-heading">Refer a Client</h1>
			<p class="el-hero__sub" style="margin-bottom:0">Complete the form below and we'll take it from there. Takes under 2 minutes.</p>
		</div>
	</div>
</section>

<!-- FORM SECTION -->
<section class="el-section">
	<div class="el-container el-intake-wrap">

		<?php if ( $submitted ) : ?>
		<div class="el-intake-success">
			<div class="el-intake-success__icon">
				<svg viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/></svg>
			</div>
			<h2>Referral received — thank you!</h2>
			<p>We'll be in touch with your client within one business day. You'll receive a confirmation email shortly.</p>
			<a href="<?php echo esc_url( home_url( '/referrals/' ) ); ?>" class="el-btn el-btn--navy">Back to Referral Portal &rarr;</a>
		</div>
		<?php else : ?>

		<div class="el-intake-intro">
			<h2>Referral details</h2>
			<p>Fields marked <span class="el-intake-required">*</span> are required.</p>
		</div>

		<form class="el-intake-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" novalidate>
			<?php wp_nonce_field( 'el_referral_submit', 'el_referral_nonce' ); ?>
			<input type="hidden" name="action" value="el_referral_submit">

			<!-- YOUR DETAILS -->
			<fieldset class="el-intake-fieldset">
				<legend class="el-intake-legend">Your details <span class="el-intake-legend-sub">(the referrer)</span></legend>
				<div class="el-intake-row">
					<div class="el-intake-field">
						<label for="ref_name">Full name <span class="el-intake-required">*</span></label>
						<input type="text" id="ref_name" name="ref_name" autocomplete="name" required placeholder="Jane Smith">
					</div>
					<div class="el-intake-field">
						<label for="ref_company">Company / Practice</label>
						<input type="text" id="ref_company" name="ref_company" autocomplete="organization" placeholder="Smith Accounting">
					</div>
				</div>
				<div class="el-intake-row">
					<div class="el-intake-field">
						<label for="ref_email">Email <span class="el-intake-required">*</span></label>
						<input type="email" id="ref_email" name="ref_email" autocomplete="email" required placeholder="jane@smithaccounting.com.au">
					</div>
					<div class="el-intake-field">
						<label for="ref_phone">Phone</label>
						<input type="tel" id="ref_phone" name="ref_phone" autocomplete="tel" placeholder="0400 000 000">
					</div>
				</div>
				<div class="el-intake-field">
					<label for="ref_type">Your profession <span class="el-intake-required">*</span></label>
					<select id="ref_type" name="ref_type" required>
						<option value="" disabled selected>Select your profession…</option>
						<option value="Accountant">Accountant</option>
						<option value="Finance Broker">Finance Broker</option>
						<option value="Business Broker">Business Broker</option>
						<option value="Buyers Agent">Buyers Agent</option>
						<option value="Financial Planner">Financial Planner</option>
						<option value="Migration Agent">Migration Agent</option>
						<option value="Insurance Broker">Insurance Broker</option>
						<option value="Business Coach">Business Coach</option>
						<option value="Other">Other</option>
					</select>
				</div>
			</fieldset>

			<!-- CLIENT DETAILS -->
			<fieldset class="el-intake-fieldset">
				<legend class="el-intake-legend">Client details <span class="el-intake-legend-sub">(the person being referred)</span></legend>
				<div class="el-intake-row">
					<div class="el-intake-field">
						<label for="client_name">Client full name <span class="el-intake-required">*</span></label>
						<input type="text" id="client_name" name="client_name" required placeholder="John Doe">
					</div>
					<div class="el-intake-field">
						<label for="client_company">Client company <span class="el-intake-legend-sub">(if applicable)</span></label>
						<input type="text" id="client_company" name="client_company" placeholder="Doe Holdings Pty Ltd">
					</div>
				</div>
				<div class="el-intake-row">
					<div class="el-intake-field">
						<label for="client_email">Client email <span class="el-intake-required">*</span></label>
						<input type="email" id="client_email" name="client_email" required placeholder="john@doeholdings.com.au">
					</div>
					<div class="el-intake-field">
						<label for="client_phone">Client phone <span class="el-intake-required">*</span></label>
						<input type="tel" id="client_phone" name="client_phone" required placeholder="0411 000 000">
					</div>
				</div>
			</fieldset>

			<!-- MATTER DETAILS -->
			<fieldset class="el-intake-fieldset">
				<legend class="el-intake-legend">Matter details</legend>
				<div class="el-intake-field">
					<label for="matter_type">Type of matter <span class="el-intake-required">*</span></label>
					<select id="matter_type" name="matter_type" required>
						<option value="" disabled selected>Select matter type…</option>
						<option value="Business Purchase">Business Purchase</option>
						<option value="Business Sale">Business Sale</option>
						<option value="Commercial Lease (Tenant)">Commercial Lease (Tenant)</option>
						<option value="Commercial Lease (Landlord)">Commercial Lease (Landlord)</option>
						<option value="Shareholders Agreement">Shareholders Agreement</option>
						<option value="Partnership Agreement">Partnership Agreement</option>
						<option value="Employment Agreement">Employment Agreement</option>
						<option value="Contract Review / Drafting">Contract Review / Drafting</option>
						<option value="Debt Recovery">Debt Recovery</option>
						<option value="Business Structuring">Business Structuring</option>
						<option value="SMSF / Property">SMSF / Property</option>
						<option value="Visa / Migration">Visa / Migration</option>
						<option value="Other">Other</option>
					</select>
				</div>
				<div class="el-intake-field">
					<label for="matter_notes">Brief description <span class="el-intake-legend-sub">(optional — the more context the better)</span></label>
					<textarea id="matter_notes" name="matter_notes" rows="4" placeholder="e.g. Client is purchasing a café in Parramatta, settlement expected in 6 weeks…"></textarea>
				</div>
				<div class="el-intake-field el-intake-field--checkbox">
					<label class="el-intake-checkbox-label">
						<input type="checkbox" name="client_consented" value="1" required disabled id="client_consented_cb">
						<span>My client has consented to sharing my details with Envision Legal and I agree to the Referral T&amp;C's. <a href="/referral-partner-terms" target="_blank" id="tc-link" style="color:inherit;text-decoration:underline;font-weight:600;">View T&amp;Cs</a> <span class="el-intake-required">*</span><br><small id="tc-hint" style="color:#b45309;font-size:12px;margin-top:4px;display:inline-block;">Please open the T&amp;Cs above before ticking this box.</small></span>
					</label>
				</div>
			</fieldset>

			<div class="el-intake-footer">
				<button type="submit" class="el-btn el-btn--navy el-intake-submit">Submit referral &rarr;</button>
				<p class="el-intake-privacy">Your details are kept confidential and used only to process this referral. See our <a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>">Privacy Policy</a>.</p>
			</div>

		</form>
		<?php endif; ?>

	</div>
</section>

</main>

<style>
/* Compact hero */
.el-hero--compact { padding-top: var(--el-space-md); padding-bottom: var(--el-space-md); }

/* Form container */
.el-intake-wrap { max-width: 780px; }

/* Intro */
.el-intake-intro { margin-bottom: 2rem; }
.el-intake-intro h2 { font-size: 1.5rem; color: var(--el-navy); margin-bottom: 0.375rem; }
.el-intake-intro p  { font-size: 0.875rem; color: var(--el-text-muted); margin: 0; }
.el-intake-required { color: var(--el-navy); font-weight: 700; }

/* Fieldsets */
.el-intake-fieldset {
	border: 1px solid var(--el-border);
	border-radius: 8px;
	padding: 0 1.75rem 1.5rem;
	margin-bottom: 1.75rem;
	background: var(--el-cream);
}
.el-intake-legend {
	font-size: 0.8rem;
	font-weight: 700;
	color: var(--el-navy);
	text-transform: uppercase;
	letter-spacing: 0.08em;
	padding: 0.875rem 1rem 0.875rem 0;
	margin-bottom: 1.25rem;
	border-bottom: 1px solid var(--el-border);
	width: 100%;
}
.el-intake-legend-sub {
	font-weight: 400;
	color: var(--el-text-muted);
	font-size: 0.8rem;
	text-transform: none;
	letter-spacing: 0;
}

/* Field rows */
.el-intake-row {
	display: grid;
	grid-template-columns: 1fr 1fr;
	gap: 1.125rem;
	margin-bottom: 1.125rem;
}
.el-intake-field {
	display: flex;
	flex-direction: column;
	gap: 0.375rem;
	margin-bottom: 1.125rem;
}
.el-intake-field:last-child { margin-bottom: 0; }

/* Labels */
.el-intake-field label {
	font-size: 0.8rem;
	font-weight: 600;
	color: var(--el-text);
	letter-spacing: 0.01em;
}

/* Inputs */
.el-intake-form input[type="text"],
.el-intake-form input[type="email"],
.el-intake-form input[type="tel"],
.el-intake-form select,
.el-intake-form textarea {
	width: 100%;
	padding: 0.7rem 0.875rem;
	border: 1.5px solid var(--el-border);
	border-radius: var(--el-radius);
	font-size: 0.95rem;
	color: var(--el-text);
	background: var(--el-white);
	transition: border-color var(--el-trans), box-shadow var(--el-trans);
	font-family: var(--el-font-body);
	box-sizing: border-box;
}
.el-intake-form input:focus,
.el-intake-form select:focus,
.el-intake-form textarea:focus {
	outline: none;
	border-color: var(--el-navy);
	box-shadow: 0 0 0 3px rgba(17,24,39,0.1);
}
.el-intake-form textarea { resize: vertical; min-height: 100px; }
.el-intake-form select  { cursor: pointer; min-height: 48px; line-height: 1.5; }

/* Checkbox */
.el-intake-field--checkbox { margin-top: 0.5rem; }
.el-intake-checkbox-label {
	display: flex;
	align-items: flex-start;
	gap: 0.625rem;
	cursor: pointer;
	font-size: 0.875rem;
	color: var(--el-text);
	line-height: 1.5;
}
.el-intake-checkbox-label input[type="checkbox"] {
	width: 18px; height: 18px; min-width: 18px;
	margin-top: 2px;
	accent-color: var(--el-navy);
	cursor: pointer;
}

/* Footer */
.el-intake-footer { margin-top: 0.5rem; }
.el-intake-submit  { font-size: 1rem; }
.el-intake-privacy {
	font-size: 0.75rem;
	color: var(--el-text-muted);
	margin-top: 0.875rem;
	margin-bottom: 0;
}
.el-intake-privacy a { color: var(--el-text-muted); text-decoration: underline; }

/* Success box */
.el-intake-success {
	text-align: center;
	padding: 4rem 2.5rem;
	background: #f0fdf4;
	border: 1px solid #bbf7d0;
	border-radius: 8px;
	max-width: 560px;
	margin: 0 auto;
}
.el-intake-success__icon {
	width: 56px; height: 56px;
	background: #16a34a;
	border-radius: 50%;
	display: flex; align-items: center; justify-content: center;
	margin: 0 auto 1.25rem;
	color: var(--el-white);
}
.el-intake-success__icon svg { width: 32px; height: 32px; }
.el-intake-success h2 { color: #15803d; font-size: 1.375rem; margin-bottom: 0.625rem; }
.el-intake-success p  { color: var(--el-text-muted); font-size: 0.95rem; margin-bottom: 1.75rem; }

@media (max-width: 600px) {
	.el-intake-row     { grid-template-columns: 1fr; }
	.el-intake-fieldset { padding: 1.25rem 1rem 1rem; }
}
.el-intake-submit:disabled { opacity: 0.45; cursor: not-allowed; }
</style>
<script>
document.addEventListener("DOMContentLoaded", function () {
  var cb   = document.getElementById("client_consented_cb");
  var btn  = document.querySelector(".el-intake-submit");
  var link = document.getElementById("tc-link");
  var hint = document.getElementById("tc-hint");
  if (!cb || !btn) return;
  // Submit button always mirrors checkbox
  function toggleBtn() { btn.disabled = !cb.checked; }
  toggleBtn();
  cb.addEventListener("change", toggleBtn);
  // Unlock checkbox only after T&Cs link is clicked
  if (link) {
    link.addEventListener("click", function () {
      cb.disabled = false;
      if (hint) { hint.textContent = "You may now tick to confirm your consent."; hint.style.color = "#15803d"; }
    });
  }
});
</script>

<?php get_footer(); ?>
