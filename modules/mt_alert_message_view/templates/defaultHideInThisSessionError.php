<?php use_helper('Javascript', 'I18N') ?>
<div id="alert" class="error"><?php echo __($this->text, array(), 'mt_alert_messages') ?></div>
<?php javascript_tag() ?>
setTimeout(function() {jQuery('#alert').slideUp(2000); }, 5100);
<?php end_javascript_tag() ?>
