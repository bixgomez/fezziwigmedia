<sidebar>
<?php if (false == mysiteapp_is_sidebar_hide()): ?>
<categorys>
<?php wp_list_categories(); ?>
</categorys>
<archives>
<?php wp_get_archives(); ?>
</archives>
<pages>
<?php wp_list_pages(); ?>
</pages>
<links>
<?php wp_list_bookmarks(); ?>
</links>
<tags>
<?php if (function_exists('wp_tag_cloud')): ?>
	<?php wp_tag_cloud('number=100&echo=true'); ?>
<?php endif; ?>
</tags>
<?php endif; ?>
<logout>
<url>
	<?php
	echo mysiteapp_logout_url_wrapper();
	?>
</url>
</logout>
</sidebar>