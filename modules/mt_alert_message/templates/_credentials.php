<?php if ($mt_alert_message->countmtAlertMessageCredentials() > 0): ?>
<?php $credentials = $mt_alert_message->getmtAlertMessageCredentialsRepresentation() ?>
<h4><?php echo __('Credentials', array(), 'mt_alert_messages') ?></h4>
<div class="list_detail">
<?php echo implode(', ', $credentials instanceOf sfOutputEscaper? $credentials->getRawValue() : $credentials) ?>
</div>
<?php endif ?>
