<td>
  <ul class="sf_admin_td_actions">

    <?php if (!$mt_alert_message->getConfiguration($sf_user)->getHidePermanently() && !mtAlertConfiguration::isHiddenInSession($sf_user->getRawValue(), $mt_alert_message)): ?>
    <li class="sf_admin_action_nevershowagain">
      <?php echo link_to(__('Disable permanently', array(), 'mt_alert_messages'), 'mt_alert_message_view/doHidePermanently?id='.$mt_alert_message->getId(), array()) ?>
    </li>
    <?php endif ?>
    <?php if ($mt_alert_message->getConfiguration($sf_user)->getHidePermanently()): ?>
    <li class="sf_admin_action_showagain">
      <?php echo link_to(__('Enable', array(), 'mt_alert_messages'), 'mt_alert_message_view/doShowAgain?id='.$mt_alert_message->getId(), array()) ?>
    </li>
    <?php endif ?>

    <?php if (mtAlertConfiguration::isHiddenInSession($sf_user->getRawValue(), $mt_alert_message) && !$mt_alert_message->getConfiguration($sf_user)->getHidePermanently()): ?>
    <li class="sf_admin_action_showagain">
      <?php echo link_to(__('Enable', array(), 'mt_alert_messages'), 'mt_alert_message_view/doShowInSession?id='.$mt_alert_message->getId(), array()) ?>
    </li>
    <?php endif ?>

    <?php if (!mtAlertConfiguration::isHiddenInSession($sf_user->getRawValue(), $mt_alert_message) && !$mt_alert_message->getConfiguration($sf_user)->getHidePermanently()): ?>
    <li class="sf_admin_action_hideinsession">
      <?php echo link_to(__('Disable for this session', array(), 'mt_alert_messages'), 'mt_alert_message_view/doHideInSession?id='.$mt_alert_message->getId(), array()) ?>
    </li>
    <?php endif ?>
  </ul>
</td>
