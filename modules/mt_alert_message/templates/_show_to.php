<?php if ($mt_alert_message->getShowToAll()): ?>
  <h4><?php echo __('Users') ?></h4>
  <div class="list_detail">
    <?php echo __('This alert will be shown to everybody.', array(), 'mt_alert_messages') ?>
  </div>
<?php elseif ($mt_alert_message->countmtAlertMessageCredentials() > 0 || $mt_alert_message->countmtAlertMessageUsers() > 0) : ?>
  <div class="credential_list"><?php include_partial('credentials', array('mt_alert_message' => $mt_alert_message)) ?></div>
  <div class="user_list"><?php include_partial('users', array('mt_alert_message' => $mt_alert_message)) ?></div>
<?php else: ?>
  <div class="show_to_warning"><?php echo __('You must asociate at least one user or one credential to this alert.', array(), 'mt_alert_messages') ?></div>
<?php endif ?>
