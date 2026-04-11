<?php
/**
 * Referral form submission handler.
 * Hooked to admin-post.php (both logged-in and guest).
 */

// Register CPT
add_action( 'init', function () {
	register_post_type( 'referral_submission', [
		'labels'   => [
			'name'          => 'Referral Submissions',
			'singular_name' => 'Referral Submission',
		],
		'public'      => false,
		'show_ui'     => true,
		'show_in_menu'=> true,
		'supports'    => [ 'title', 'custom-fields' ],
		'menu_icon'   => 'dashicons-groups',
	] );
} );

// Handle form POST (logged-in and guest)
add_action( 'admin_post_el_referral_submit',        'el_handle_referral_submit' );
add_action( 'admin_post_nopriv_el_referral_submit', 'el_handle_referral_submit' );

function el_handle_referral_submit() {

	if ( ! isset( $_POST['el_referral_nonce'] ) ||
	     ! wp_verify_nonce( $_POST['el_referral_nonce'], 'el_referral_submit' ) ) {
		wp_die( 'Security check failed. Please go back and try again.', 'Error', [ 'response' => 403 ] );
	}

	$ref_name       = sanitize_text_field( $_POST['ref_name']       ?? '' );
	$ref_company    = sanitize_text_field( $_POST['ref_company']    ?? '' );
	$ref_email      = sanitize_email(      $_POST['ref_email']      ?? '' );
	$ref_phone      = sanitize_text_field( $_POST['ref_phone']      ?? '' );
	$ref_type       = sanitize_text_field( $_POST['ref_type']       ?? '' );
	$client_name    = sanitize_text_field( $_POST['client_name']    ?? '' );
	$client_company = sanitize_text_field( $_POST['client_company'] ?? '' );
	$client_email   = sanitize_email(      $_POST['client_email']   ?? '' );
	$client_phone   = sanitize_text_field( $_POST['client_phone']   ?? '' );
	$matter_type    = sanitize_text_field( $_POST['matter_type']    ?? '' );
	$matter_notes   = sanitize_textarea_field( $_POST['matter_notes'] ?? '' );
	$consented      = ! empty( $_POST['client_consented'] );

	$errors = [];
	if ( ! $ref_name )             $errors[] = 'Your full name is required.';
	if ( ! is_email( $ref_email ) ) $errors[] = 'A valid referrer email is required.';
	if ( ! $ref_type )             $errors[] = 'Your profession is required.';
	if ( ! $client_name )          $errors[] = 'Client name is required.';
	if ( ! is_email( $client_email ) ) $errors[] = 'A valid client email is required.';
	if ( ! $client_phone )         $errors[] = 'Client phone is required.';
	if ( ! $matter_type )          $errors[] = 'Matter type is required.';
	if ( ! $consented )            $errors[] = 'Client consent confirmation is required.';

	if ( $errors ) {
		wp_die( esc_html( implode( ' ', $errors ) ), 'Validation Error', [ 'back_link' => true, 'response' => 400 ] );
	}

	$post_id = wp_insert_post( [
		'post_type'   => 'referral_submission',
		'post_title'  => "{$ref_name} -> {$client_name} ({$matter_type})",
		'post_status' => 'publish',
	] );

	if ( $post_id && ! is_wp_error( $post_id ) ) {
		foreach ( [
			'ref_name'       => $ref_name,
			'ref_company'    => $ref_company,
			'ref_email'      => $ref_email,
			'ref_phone'      => $ref_phone,
			'ref_type'       => $ref_type,
			'client_name'    => $client_name,
			'client_company' => $client_company,
			'client_email'   => $client_email,
			'client_phone'   => $client_phone,
			'matter_type'    => $matter_type,
			'matter_notes'   => $matter_notes,
			'submitted_at'   => current_time( 'mysql' ),
			'ip_address'     => $_SERVER['REMOTE_ADDR'] ?? '',
		] as $key => $value ) {
			update_post_meta( $post_id, $key, $value );
		}
	}

	// Firm notification
	wp_mail(
		'hello@envisionlegal.com.au',
		"[New Referral] {$client_name} referred by {$ref_name}",
		"New referral via the Referral Partner Portal.\n\n" .
		"-- REFERRER --\n" .
		"Name:       {$ref_name}\nCompany:    {$ref_company}\nEmail:      {$ref_email}\nPhone:      {$ref_phone}\nProfession: {$ref_type}\n\n" .
		"-- CLIENT --\n" .
		"Name:       {$client_name}\nCompany:    {$client_company}\nEmail:      {$client_email}\nPhone:      {$client_phone}\n\n" .
		"-- MATTER --\n" .
		"Type:       {$matter_type}\nNotes:\n{$matter_notes}\n\n" .
		"Admin: " . admin_url( 'edit.php?post_type=referral_submission' ) . "\n" .
		"Submitted: " . current_time( 'mysql' ),
		[
			'Content-Type: text/plain; charset=UTF-8',
			"Reply-To: {$ref_name} <{$ref_email}>",
		]
	);

	// Referrer confirmation
	wp_mail(
		$ref_email,
		'Referral received - Envision Legal',
		"Hi {$ref_name},\n\n" .
		"Thank you for referring {$client_name} to Envision Legal.\n\n" .
		"We'll be in touch with them within one business day.\n\n" .
		"Matter: {$matter_type}\n\n" .
		"Any questions? Reply to this email or reach us at hello@envisionlegal.com.au.\n\n" .
		"Kind regards,\nEnvision Legal\nhttps://envisionlegal.com.au",
		[
			'Content-Type: text/plain; charset=UTF-8',
			'From: Envision Legal <hello@envisionlegal.com.au>',
		]
	);

	wp_safe_redirect( home_url( '/referrals/intake/?ref_success=1' ) );
	exit;
}
