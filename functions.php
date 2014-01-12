<?php
/**
 * Marketify Single
 *
 * @since Marketify Single 1.0
 */

/**
 * Custom scripts
 */
function marketify_single_script() {
	wp_enqueue_script( 'marketify-single', get_stylesheet_directory_uri() . '/app.js' );
}
add_action( 'wp_enqueue_scripts', 'marketify_single_script' );

/**
 * Pretend we have a custom background
 */
function marketify_single_has_header_background() {
	return is_singular( 'download' );
}
add_filter( 'marketify_has_header_background', 'marketify_single_has_header_background' );
add_filter( 'marketify_has_header_background_force', 'marketify_single_has_header_background' );

/**
 * Don't try to output the standard player
 */
function marketify_download_video_player() {

}

/**
 * Add the video background
 */
function marketify_single_video_background() {
	if ( ! is_singular( 'download' ) )
		return;

	global $post;

	$video = $post->edd_video;

	if ( ! $video )
		return;

	$videos = explode( ',', $video );
	$videos = array_map( 'trim', $videos );
	$types  = array();

	foreach ( $videos as $video ) {
		$info = wp_check_filetype( $video );

		if ( ! $info[ 'type' ] ) {
			$ext = explode( '.', $video );

			$info[ 'type' ] = end( $ext );
		}

		$types[ $info[ 'type' ] ] = $video;
	}
?>
	<div class="video-viewport">
		<video class="hip-video" autoplay="autoplay" width="640" height="360">
			<?php foreach ( $types as $type => $video ) : ?>
			<source src="<?php echo esc_url( $video ); ?>" type="video/<?php echo $type; ?>" />
			<?php endforeach; ?>
		</video>
	</div>
<?php
}
add_action( 'marketify_entry_before', 'marketify_single_video_background', 90 );