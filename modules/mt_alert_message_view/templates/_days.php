<?php if ($mt_alert_message->countmtAlertMessageDays()): ?>
<?php $days = $mt_alert_message->getmtAlertMessageDaysRepresentation() ?>
<h4><?php echo __('Shown on', array(), 'mt_alert_messages') ?>:</h4>
<div class="list_detail">
<?php echo implode(', ', $days instanceOf sfOutputEscaper? $days->getRawValue() : $days) ?>
</div>
<?php endif ?>
