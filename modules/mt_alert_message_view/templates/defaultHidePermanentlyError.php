<?php use_helper('Javascript', 'I18N') ?>
<div id="alert" class="error"><?php echo __($this->text, array(), 'mt_alert_messages') ?></div>
<?php javascript_tag() ?>
Effect.BlindUp('alert', { delay: 5.0, duration: 2.0 });
<?php end_javascript_tag() ?>
