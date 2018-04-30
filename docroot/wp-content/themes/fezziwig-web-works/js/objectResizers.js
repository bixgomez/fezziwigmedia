jQuery( window ).load(function($) {
  // console.log( "ready!" );
});

jQuery( window ).resize(function($) {
  // console.log( "resize!" );
});

function getObjects() {

  $mastheadObject = jQuery( '#masthead' );
  $footerObject = jQuery( '#colophon' );
  $leftSideObject = jQuery( '.site-container' );
  $rightSideObject = jQuery( '#page' );

  $contentObject = jQuery( '#content' );
  $viewportObject = jQuery( window );

  $headerSlug = jQuery( '#header-tester' );
  $segmentSlug = jQuery( '#segment-tester' );

}
