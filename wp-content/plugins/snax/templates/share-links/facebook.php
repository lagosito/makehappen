<?php
/**
 * Facebook share link
 *
 * @package snax
 * @subpackage Share
 */

// Prevent direct script access.
if ( ! defined( 'ABSPATH' ) ) {
	die( 'No direct script access allowed' );
}

global $snax_share_args;
?>
<script type="text/javascript">
	(function () {
		var triggerOnLoad = false;

		window.quizzardShareOnFB = function() {
			jQuery('body').trigger('snaxFbNotLoaded');
			triggerOnLoad = true;
		};

		var _fbAsyncInit = window.fbAsyncInit;

		window.fbAsyncInit = function() {
			FB.init({
				appId      : '<?php echo esc_attr( snax_get_facebook_app_id() ); ?>',
				xfbml      : true,
				version    : 'v2.5'
			});

			window.quizzardShareOnFB = function() {
				var quiz 			= jQuery('.snax_quiz').data('quizzardQuiz');
				var quizTitle 		= '<?php echo esc_html( $snax_share_args['title'] ); ?>';
				var quizDescription	= '<?php echo esc_html( $snax_share_args['description'] ); ?>';

				FB.ui({
					method:		 'feed',
					link: 		 '<?php echo esc_url( $snax_share_args['url'] ); ?>',
					picture:	 '<?php echo esc_url( $snax_share_args['thumb'] ); ?>',
					name: 		 quizTitle,
					caption: 	 '<?php echo esc_url( site_url( '', 'relative' ) ); ?>',
					description: quizDescription
				}, function(t) {
					var validShare = t.post_id ? true : false;

					quiz.unlock(validShare);
				});
			};

			// Fire original callback.
			if (typeof _fbAsyncInit === 'function') {
				_fbAsyncInit();
			}

			// Open share popup as soon as possible, after loading FB SDK.
			if (triggerOnLoad) {
				setTimeout(function() {
					quizzardShareOnFB();
				}, 1000);
			}
		};

		// JS SDK loaded before we hook into it. Trigger callback now.
		if (typeof window.FB !== 'undefined') {
			window.fbAsyncInit();
		}
	})();
</script>

<a class="quizzard-share quizzard-share-facebook" onclick="quizzardShareOnFB(); return false;" href="#" title="<?php esc_attr_e( 'Share on Facebook', 'snax' ); ?>" target="_blank" rel="nofollow">
	<?php esc_html_e( 'Share on Facebook', 'snax' ); ?>
</a>
