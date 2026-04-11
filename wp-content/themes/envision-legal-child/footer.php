<?php
/**
 * Theme Footer
 *
 * @package EnvisionLegal
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Render custom Envision Legal footer.
if ( function_exists( 'envision_legal_footer' ) ) {
	envision_legal_footer();
}

wp_footer();
?>
</body>
</html>
