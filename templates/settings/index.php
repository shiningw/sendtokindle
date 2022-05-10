<?php
script("sendtokindle", "appSettings");
style("sendtokindle", "appSettings");
extract($_);
?>
<div id="sendtokindle-app-settings">
	<div class="sendtokindle-general-settings">
		<h2 class="title">
			<?php print($l->t('SendtoKindle Settings')); ?>
		</h2>
		<div id="sendtokindle-senderemail-settings">
			<label for="sendtokindle-senderemail">
				<?php print($l->t('Sender Email')); ?>
			</label>
			<input type="text" class="sendtokindle-senderemail" id="sendtokindle-senderemail" name="sendtokindle-senderemail" value="<?php print($_['sendtokindle-senderemail'] ?? 'xxx@example.com'); ?>" placeholder="<?php print($_['sendtokindle-senderemail']); ?>" />
			<input type="button" value="<?php print($l->t('Save')); ?>" path="<?php print $path; ?>" data-rel="sendtokindle-senderemail" />
		</div>
		<div id="sendtokindle-amazon-email-settings">
			<label for="sendtokindle-amazon-email">
				<?php print($l->t('Amazon Email')); ?>
			</label>
			<input type="text" class="sendtokindle-amazon-email" id="sendtokindle-amazon-email" value="<?php print($_['sendtokindle-amazon-email'] ?? 'xxx@amazon.com'); ?>" placeholder="'xxx@amazon.com'" />
			<input type="button" value="<?php print($l->t('Save')); ?>" data-rel="sendtokindle-amazon-email" path="<?php print $path; ?>" />
		</div>
		<a href="/settings/admin#mail_general_settings"><button>Email Settings</button></a>
	</div>
</div>