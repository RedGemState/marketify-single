var MarketifySingle = {};

MarketifySingle.Video = ( function($) {

	var min_w = 300;
	var vid_w_orig;
	var vid_h_orig;

	var $viewport = null;
	var $video    = null;

	function videoResize() {
		var scale_h = $viewport.outerWidth()  / vid_w_orig;
		var scale_v = $viewport.outerHeight() / vid_h_orig;

		var scale   = scale_h > scale_v ? scale_h : scale_v;

		if ( scale * vid_w_orig < min_w ) {
			scale = min_w / vid_w_orig;
		};

		$video.width(scale * vid_w_orig);
		$video.height(scale * vid_h_orig);

		$viewport.scrollLeft( ( $video.width() - $viewport.outerWidth() ) / 2 );
		$viewport.scrollTop( ( $video.height() - $viewport.outerHeight() ) / 2);
	}

	return {
		init : function() {
			$viewport = $( '.video-viewport' );
			$video    = $viewport.find( 'video' );

			vid_w_orig = parseInt( $video.attr( 'width' ) );
			vid_h_orig = parseInt( $video.attr( 'height' ) );

			$(window).resize(function () { 
				videoResize(); 
			});

			$(window).trigger( 'resize' );
		}
	}
} )(jQuery);

jQuery(function($) {
	MarketifySingle.Video.init();
});