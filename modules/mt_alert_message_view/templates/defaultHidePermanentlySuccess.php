<?php use_helper('Javascript', 'I18N') ?>
<div id="alert" class="notice"><?php echo __($text, array(), 'mt_alert_messages') ?></div>

<?php javascript_tag() ?>
jQuery('#<?php echo $container_id ?>').slideUp(1000);
jQuery('#<?php echo $container_id ?>').remove();

setTimeout(function() {
  if (jQuery('div.mt_alert_message').size() == 0)
  {
    jQuery('#mt_alert_messages').hide();
  }
  else
  {
    jQuery('#alert').slideUp(2000);
  }
}, 3000);
<?php end_javascript_tag() ?>
