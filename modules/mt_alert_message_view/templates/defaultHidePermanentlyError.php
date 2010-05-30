<?php use_helper('JavascriptBase', 'I18N') ?>
<div id="alert" class="error"><?php echo __($this->text, array(), 'mt_alert_messages') ?></div>

<?php javascript_tag() ?>
setTimeout(function () { jQuery('#alert').slideUp(2000); } , 5000);
<?php end_javascript_tag() ?>
