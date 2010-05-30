<?php use_stylesheet('/mtAlertPlugin/css/default.css', 'first') ?>
<?php use_helper('I18N', 'Javascript') ?>

<div id="mt_alert_messages">
  <div id="mt_alert_messages_detail" style="display: none">
    <?php echo link_to_function(__('Hide', array(), 'mt_alert_messages'), "jQuery('#mt_alert_messages_detail').fadeOut(1000);", array('id' => 'closer')) ?>
    <div id="mt_alert_messages_ajax_area"></div>
    <?php foreach ($mt_alert_messages as $mta): ?>
      <?php include_partial('mt_alert_message_view/'.mtAlertConfiguration::getTheme().'_show_mt_alert_message', array('mta' => $mta)) ?>
    <?php endforeach ?>
  </div>

  <?php if (count($mt_alert_messages) > 0): ?>
    <div id="mt_alert_messages_notification" style="display: none">
      <?php echo link_to_function(__('Hide', array(), 'mt_alert_messages'), "jQuery('#mt_alert_messages_notification').fadeOut(1000);", array('id' => 'closer')) ?>
      <?php echo mtAlertConfiguration::getNotificationText(count($mt_alert_messages)) ?>
      <?php echo link_to_function(__('Show', array(), 'mt_alert_messages'),
                      "setTimeout(function() { jQuery('#mt_alert_messages_detail').slideDown(1000); }, 1000);
                       jQuery('#mt_alert_messages_notification').slideUp(1000);",
                      array('class' => 'mt_alert_messages_detail_expander', 'id' => 'mt_alert_expander', 'style' => 'display: none')) ?>
    </div>
<?php echo javascript_tag() ?>
setTimeout(function() { jQuery('#mt_alert_messages_notification').slideDown(1000); }, 3000);
setTimeout(function() { jQuery('#mt_alert_expander').fadeIn(); }, 4100);
<?php end_javascript_tag() ?>
  <?php endif ?>
</div>
