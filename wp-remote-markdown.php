<?php
/**
 * Remote Markdown
 *
 * This plugin adds a shortcode that allows to include contents in your posts
 * and pages from a remote markdown-formatted file. It supports Github Flavored
 * Markdown and is meant to synchronize your app documentation from your GitHub
 * or Bitbucket repo to your website, without having the need to update both.
 *
 * @package   WP_Remote_Markdown
 * @version   1.0
 * @author    Andrés Villarreal <andrezrv@gmail.com>
 * @license   GPL-2.0
 * @link      http://github.com/andrezrv/wp-remote-markdown
 * @copyright 2014 Andrés Villarreal
 *
 * @wordpress-plugin
 * Plugin Name: Remote Markdown
 * Description: This plugin adds a shortcode that allows to include contents in your posts and pages from a remote markdown-formatted file. It supports Github Flavored Markdown and is meant to synchronize your app documentation from your GitHub or Bitbucket repo to your website, without having the need to update both.
 * Author: Andr&eacute;s Villarreal
 * Author URI: http://www.andrezrv.com
 * Version: 1.0
 *
 * @attribution (Credit where credit is due)
 * This plugin makes use of the Emanuil Rusev's Parsedown PHP library
 * (https://github.com/erusev/parsedown) for Markdown parsing, and Google Code
 * Prettify (https://code.google.com/p/google-code-prettify/) for language
 * syntax highlighting.
 */

add_action( 'wp_enqueue_scripts', 'remote_markdown_google_prettify_scripts' );
/**
 * Add Google Code Prettify script where needed.
 *
 * @return void
 * @since  1.0
 */
function remote_markdown_google_prettify_scripts() {

	global $post;

	// Check if shortcode is used within post content or post excerpt.
	$prettify_condition = has_shortcode( $post->post_excerpt, 'remote-markdown' ) || has_shortcode( $post->post_content, 'remote-markdown' );
	$prettify_condition = apply_filters( 'remote_markdown_prettify_condition', $prettify_condition, $post );

	// Enqueue scripts.
	if ( $prettify_condition ) {
		do_action( 'remote_markdown_enqueue_scripts' );
	}

}

add_action( 'remote_markdown_enqueue_scripts', 'remote_markdown_enqueue_scripts' );
/**
 * Register scripts used within this plugin.
 *
 * @return void
 * @since  1.0
 */
function remote_markdown_enqueue_scripts() {
	// Load Google Code Prettify directly from Google's SVN repo.
	$url = 'https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js';
	$url = apply_filters( 'remote_markdown_prettify_script', $url );
	wp_enqueue_script( 'prettify', $url, array(), '1.0', false );
}

add_shortcode( 'remote-markdown', 'remote_markdown_process' );
/**
 * Process a markdown remote file as HTML.
 *
 * @param array  $atts
 * @param string $content
 *
 * @return string
 * @since  1.0
 */
function remote_markdown_process( $atts, $content = '' ) {

	// Make sure $atts['refresh'] is an integer.
	$atts = shortcode_atts( array(
		'refresh' => 0,
	), $atts, 'remote-markdown' );
	$atts['refresh'] = ( int ) $atts['refresh'];

	// Construct the transient name we're gonna look for.
	$transient = 'remote_markdown_' . md5( $content . $atts['refresh'] );

	// If the transient exists, just return its content.
	if ( $transient_content = get_transient( $transient ) ) {
		$content = $transient_content;
	} else {
		// Make an HTTP request with the content of the shortcode. It will fail if it's not a URL.
		$request = new WP_Http;
		$result = $request->request( $content );

		// If the request returns some content, parse its markdown as HTML.
		if ( isset( $result['body'] ) && $result['body'] ) {

			require_once dirname( __FILE__ ) . '/inc/parsedown/Parsedown.php';
			$parsedown = new Parsedown;
			$content = $parsedown->text( $result['body'] );

			// Prepare for Prettyprint.
			$content = str_replace( '<code class="', '<code class="prettyprint ', $content );

			// Save transient if $atts['refresh'] is > 0.
			if ( $atts['refresh'] ) {
				set_transient( $transient, $content, $atts['refresh'] );
			}

		} else {
			// Return empty content if a proper URL wasn't provided.
			$content = '';
		}
	}

	return $content;
}
