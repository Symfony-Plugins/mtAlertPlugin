<?php use_stylesheet('/mtAlertPlugin/css/mtAlertPlugin.css', 'first') ?>
<?php use_helper('I18N', 'Javascript') ?>

<div id="mt_alert_messages">
  <div id="mt_alert_messages_detail" style="display: none">
    <?php echo link_to_function(__('Hide', array(), 'mt_alert_messages'), "Effect.Fade('mt_alert_messages_detail');", array('id' => 'closer')) ?>
    <div id="mt_alert_messages_ajax_area"></div>
    <?php foreach ($mt_alert_messages as $mta): ?>
      <?php include_partial('mt_alert_message_view/'.mtAlertConfiguration::getTheme().'_show_mt_alert_message', array('mta' => $mta)) ?>
    <?php endforeach ?>
  </div>

  <?php if (count($mt_alert_messages) > 0): ?>
    <div id="mt_alert_messages_notification" style="display: none">
      <?php echo link_to_function(__('Hide', array(), 'mt_alert_messages'), "Effect.Fade('mt_alert_messages_notification');", array('id' => 'closer')) ?>
      <?php echo mtAlertConfiguration::getNotificationText(count($mt_alert_messages)) ?>
      <?php echo link_to_function(__('Show', array(), 'mt_alert_messages'), 
                      "Effect.BlindDown('mt_alert_messages_detail', { delay: 1.0 }); Effect.BlindUp('mt_alert_messages_notification', { duration: 1.0 });" ,
                      array('class' => 'mt_alert_messages_detail_expander', 'id' => 'mt_alert_expander', 'style' => 'display: none')) ?>
    </div>
    <?php echo javascript_tag("Effect.BlindDown('mt_alert_messages_notification', {delay: 3, duration: 1.0}); Effect.Appear('mt_alert_expander', { delay: 4.1 });") ?>
  <?php endif ?>
</div>
