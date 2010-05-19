<?php if ($mt_alert_message->getShowToAll()): ?>
  <h4><?php echo __('Users') ?></h4>
  <div class="list_detail">
    <?php echo __('This alert will be shown to everybody.', array(), 'mt_alert_messages') ?>
  </div>
<?php else: ?>
  <div class="credential_list"><?php include_partial('credentials', array('mt_alert_message' => $mt_alert_message)) ?></div>
  <div class="user_list"><?php include_partial('users', array('mt_alert_message' => $mt_alert_message)) ?></div>
<?php endif ?>
