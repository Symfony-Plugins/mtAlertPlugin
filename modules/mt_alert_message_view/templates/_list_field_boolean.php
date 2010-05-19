<?php if ($value): ?>
  <?php echo image_tag('/mtAlertPlugin/images/tick.png', array('alt' => __('Checked', array(), 'sf_admin'), 'title' => __('Checked', array(), 'mt_alert_messages'))) ?>
<?php else: ?>
  <?php echo image_tag('/mtAlertPlugin/images/cross-small.png', array('alt' => __('Not checked', array(), 'mt_alert_messages'), 'title' => __('Not checked', array(), 'mt_alert_messages'))) ?>
<?php endif; ?>
