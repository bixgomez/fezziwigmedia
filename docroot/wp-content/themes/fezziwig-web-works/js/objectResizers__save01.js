jQuery( window ).load(function($) {
  // console.log( "ready!" );
  fixContentHeight();
});

jQuery( window ).resize(function($) {
  // console.log( "resize!" );
  fixContentHeight();
});

function fixContentHeight() {

  getObjects();

  console.log( "----------------------" );
  console.log( "fixing content height!" );
  console.log( "----------------------" );

  $mastheadObject = jQuery( '#masthead' );
  $mastheadHeight = $mastheadObject.outerHeight();
  $contentHeight = $contentObject.outerHeight();
  $viewportWidth = $viewportObject.outerWidth();
  $setHeight = jQuery('#content');

  // set heights of slugs
  $headerSlugHeight = ( $viewportWidth * 0.104 );
  $segmentSlugHeight = ( ($viewportWidth/100) * 3.6 );
  $headerSlug.css('height', $headerSlugHeight);
  $segmentSlug.css('height', $segmentSlugHeight);

  $segmentHeight = $segmentSlugHeight;
  $numSegsRaw = ( $contentHeight / $segmentHeight );
  $numSegs = ( $numSegsRaw );
  $newHeight = ( $numSegs * $segmentHeight);


  // Figure this out!

  // Here are our known values.
  console.log( '$mastheadHeight ' + $mastheadHeight  );
  console.log( '$contentHeight ' + $contentHeight  );
  console.log( '$headerSlugHeight ' + $headerSlugHeight  );
  console.log( '$segmentSlugHeight ' + $segmentSlugHeight  );

  // Firts of all, wht is the combined height of header and content area?
  $heightToFooter = ( $mastheadHeight + $contentHeight );
  console.log( '$heightToFooter ' + $heightToFooter  );

  // Subtract the header "slug" value from it.
  $segsHeight = ( $heightToFooter - $headerSlugHeight );
  console.log( '$segsHeight ' + $segsHeight  );

  // Check how many segment slugs go into this remaining value.
  $numSegsRaw = ( $segsHeight / $segmentSlugHeight );
  console.log( '$numSegsRaw ' + $numSegsRaw  );

  // Round this up to determine how many slugs we should accommodate.
  $numSegsNew = Math.ceil( $numSegsRaw );
  console.log( '$numSegsNew ' + $numSegsNew  );

  // Create a new value for height to check.
  $segsHeightNew = ($numSegsNew * $segmentSlugHeight);
  console.log( '$segsHeightNew ' + $segsHeightNew  );

  // Add the header slug height to arrive at a new "height to footer" value.
  $heightToFooterNew = ( $segsHeightNew + $headerSlugHeight );
  console.log( '$heightToFooterNew ' + $heightToFooterNew  );

  // Create a new content area height by subtracting the masthead height.
  $contentHeightNew = ( $heightToFooterNew - $mastheadHeight );
  console.log( '$contentHeightNew ' + $contentHeightNew  );

  $contentObject.css('height', $contentHeightNew);

  /*
  $mastheadObject.css(    'background-size',       Math.ceil( $viewportWidth * .935 ) );
  $footerObject.css(    'background-size',       Math.ceil( $viewportWidth * .935 ) );
  $leftSideObject.css(  'background-position-y', Math.ceil( $viewportWidth * .04 ) );
  $rightSideObject.css( 'background-position-y', Math.ceil( $viewportWidth * .04 ) );
  $leftSideObject.css(  'background-size',       Math.ceil( $viewportWidth * .04 ) );
  $rightSideObject.css( 'background-size',       Math.ceil( $viewportWidth * .04 ) );
  */

}

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
