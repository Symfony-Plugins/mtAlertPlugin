<?php if ($mt_alert_message->countmtAlertMessageUsers()): ?>
<?php $users = $mt_alert_message->getmtAlertMessageUsersRepresentation() ?>
<h4><?php echo __('Will be shown to the following users', array(), 'mt_alert_messages') ?></h4>
<div class="list_detail">
<?php echo implode(', ', $users instanceOf sfOutputEscaper? $users->getRawValue() : $users) ?>
</div>
<?php endif ?>
