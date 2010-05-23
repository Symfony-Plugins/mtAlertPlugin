<?php use_helper('Javascript', 'I18N') ?>
<div id="alert" class="notice"><?php echo __($text, array(), 'mt_alert_messages') ?></div>
<?php javascript_tag() ?>

Effect.BlindUp('<?php echo $container_id ?>');
Effect.BlindUp('alert', { delay: 5.0, duration: 2.0 });
$('<?php echo $container_id ?>').remove();
if ($$('.mt_alert_message').length == 0) { Effect.Fade('mt_alert_messages', { delay : 5.1 } ); }

<?php end_javascript_tag() ?>
