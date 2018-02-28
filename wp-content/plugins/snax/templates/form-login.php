<?php
/**
 * Snax Login Form
 *
 * @package snax
 * @subpackage Form
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}
?>

<h2 class="g1-alpha g1-alpha-2nd"><?php esc_html_e( 'Hey there!', 'snax' ); ?></h2>

<?php $snax_has_top_filter = has_filter( 'snax_login_form_top' ); ?>

<?php do_action( 'snax_login_form_top' ); ?>

<?php if ( snax_show_wp_login_form() ) : ?>

	<?php if ( $snax_has_top_filter ) : ?>
		<p class="snax-divider-or"><span><?php esc_html_e( 'or', 'snax' ); ?></span></p>
	<?php endif; ?>

	<h4 class="snax-form-legend snax-form-legend-sign-in"><?php esc_html_e( 'Sign in', 'snax' ); ?></h4>

	<div class="snax-login-form" data-snax-nonce="<?php echo esc_attr( wp_create_nonce( 'snax-ajax-login-nonce' ) ); ?>">
		<?php
		wp_login_form( array(
			'remember' => false,
		) );
		?>
	</div>

	<a class="snax-link-forgot-pass" href="<?php echo esc_url( wp_lostpassword_url() ); ?>"><?php esc_html_e( 'Forgot password?', 'snax' ); ?></a>

	<?php if ( get_option( 'users_can_register' ) ) : ?>
		<p class="snax-form-tip snax-form-tip-register"><?php esc_html_e( 'Don\'t have an account?', 'snax' ); ?> <a
				href="<?php echo esc_url( wp_registration_url() ); ?>"><?php esc_html_e( 'Register', 'snax' ); ?></a>
		</p>
	<?php endif; ?>

<?php endif; ?>

<?php do_action( 'snax_login_form_bottom' ); ?>
