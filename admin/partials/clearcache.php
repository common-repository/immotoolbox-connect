<?php
/*
 * Plugin Name: My Plugin
 * Author: Plugin Author
 * Text Domain: itbconnect
 */
?>
<div class="wrap">
	<h1><?=__('Clear cache', 'itbconnect'); ?></h1>

	<form id="itbconnect-admin-form" method="post">
		<p>
			<?=count($files); ?> <?=__( 'file(s) in cache', 'itbconnect' ); ?>
		</p>
		<button class="button button-primary" name="submit" value="1" id="itbconnect-admin-save" type="submit"><?=__( 'Clear cache', 'itbconnect' ); ?></button>
	</form>

</div>
