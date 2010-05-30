<ul class="mt_alert_message_actions">
  <?php if (mtAlertUserHelper::canHideAlertsPermanently($sf_user) && $mta->getCanBeHiddenPermanently()): ?>
    <li class="never_show_again">
      <?php $url = url_for('mt_alert_message_view/hidePermanently') ?>
      <?php echo link_to_function(__('Hide permanently', array(), 'mt_alert_messages'), 
                                "jQuery('#mt_alert_messages_ajax_area').load('$url', { 'id' : ".$mta->getId().", 'container_id' : '$mtaId' })") ?>
    </li>
  <?php endif ?>
  <li class="hide_for_this_session">
    <?php $url = url_for('mt_alert_message_view/hideInThisSession') ?>
    <?php echo link_to_function(__('Hide for this session', array(), 'mt_alert_messages'), 
                              "jQuery('#mt_alert_messages_ajax_area').load('$url', { 'id' : ".$mta->getId().", 'container_id' : '$mtaId' })") ?>
  </li>
</ul>
