<?php
/**
 * @package Rolling_Stone
 * @version 1.0
 */
/*
Plugin Name: Like A Rolling Stone
Plugin URI: http://fezziwigwebworks.com/
Description: This is my silly version of Matt Mullenweg's "Hello Dolly" plugin.
Author: Richard Gilbert
Version: 1.0
Author URI: http://fezziwigwebworks.com/
*/

function rolling_stone_get_lyric() {
	/** These are the lyrics to Like A Roling Stone */
	$lyrics = "Once upon a time you dressed so fine
You threw the bums a dime in your prime, didn't you
People'd call, say, Beware doll, you're bound to fall
You thought they were all kiddin' you
You used to laugh about
Everybody that was hangin' out
Now you don't talk so loud
Now you don't seem so proud
About having to be scrounging for your next meal
You've gone to the finest school all right, Miss Lonely
But you know you only used to get juiced in it
And nobody has ever taught you how to live on the street
And now you find out you're gonna have to get used to it
You said you'd never compromise
With the mystery tramp, but know you realize
He's not selling any alibis
As you stare into the vacuum of his eyes
And say do you want to make a deal
You never turned around to see the frowns on the jugglers and the clowns
When they all come down and did tricks for you
You never understood that it ain't no good
You shouldn't let other people get your kicks for you
You used to ride on the chrome horse with your diplomat
Who carried on his shoulder a Siamese cat
Ain't it hard when you discover that
He really wasn't where it's at
After he took from you everything he could steal.
To be on your own
With no direction home
Like a complete unknown
Like a rolling stone
Princess on the steeple and all the pretty people
They're drinkin', thinkin' that they got it made
Exchanging all precious gifts
But you'd better take your diamond ring, you'd better pawn it babe
You used to be so amused
At Napoleon in rags and the language that he used
Go to him now, he calls you, you can't refuse
When you got nothing, you got nothing to lose
You're invisible now, you got no secrets to conceal.";

	// Here we split it into lines
	$lyrics = explode( "\n", $lyrics );

	// And then randomly choose a line
	return wptexturize( $lyrics[ mt_rand( 0, count( $lyrics ) - 1 ) ] );
}

// This just echoes the chosen line, we'll position it later
function rolling_stone() {
	$chosen = rolling_stone_get_lyric();
	echo "<p id='stone'>$chosen</p>";
}

// Now we set that function up to execute when the admin_notices action is called
add_action( 'admin_notices', 'rolling_stone' );

// We need some CSS to position the paragraph
function stone_css() {
	// This makes sure that the positioning is also good for right-to-left languages
	$x = is_rtl() ? 'left' : 'right';

	echo "
	<style type='text/css'>
	#stone {
		float: $x;
		padding-$x: 15px;
		padding-top: 5px;		
		margin: 0;
		font-size: 11px;
	}
	</style>
	";
}

add_action( 'admin_head', 'stone_css' );

?>
