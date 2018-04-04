
<?php
$options = get_option('uppsite_options');

if(isset($options['fbcomment'])){
	$fb_comments_counter = 0;
	$comments_xml = mysiteapp_print_facebook_comments($fb_comments_counter); 
}


if ($comments || $fb_comments_counter>0) : ?>
	<comments comment_total="<?php echo (count($comments)+$fb_comments_counter)?>">
	<?php print $comments_xml; ?>
	
	<?php foreach ($comments as $comment) : ?>
	<?php 
	/*if (function_exists('get_the_author_meta')) {
		$avatar = get_avatar(get_the_author_meta('user_email'));
	} elseif (function_exists('get_the_author_id')) {
		$avatar = get_avatar(get_the_author_id());
	} else {
		$avatar = null;
	}
	*/
	
	if(function_exists('get_avatar') && function_exists('htmlspecialchars_decode'))
	{
		$avatar_url = htmlspecialchars_decode(mysiteapp_extract_url(get_avatar(get_comment_author_email())));
	}
	
	?>
	    <comment ID="<?php comment_ID() ?>" post_ID="<?php the_ID(); ?>"
			<?php if ($comment->comment_approved == '0') : ?>
				isApproved="false">
		    <?php else: ?>
				isApproved="true">
		    <?php endif; ?>
		   <permalink><![CDATA[<?php the_permalink() ?> ]]></permalink>
		   <time><![CDATA[<?php comment_date() ?> ]]></time>
		   <unix_time><![CDATA[<?php comment_date('U'); ?> ]]></unix_time>
		   	<?php echo mysiteapp_get_member_for_comment(); ?>
			<text><![CDATA[<?php comment_text() ?> ]]> </text>
          </comment>
	<?php endforeach; ?>
	</comments>
<?php endif; ?>
	<newcommentfields>
		<?php mysiteapp_comment_form(); ?>
	</newcommentfields>