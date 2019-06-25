<?php
/**
 * The template part for displaying a message that posts cannot be found.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Silk Lite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'silk-lite' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">

		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) { ?>

			<p><?php
				/* translators: %s: THe new post URL. */
				printf( wp_kses_post( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'silk-lite' ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php } elseif ( is_search() ) { ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'silk-lite' ); ?></p>
			<?php
			get_search_form();

		} else { ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'silk-lite' ); ?></p>
			<?php
			get_search_form();

		} ?>

	</div><!-- .page-content -->
</section><!-- .no-results -->
