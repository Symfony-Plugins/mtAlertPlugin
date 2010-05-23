<td>
  <ul class="sf_admin_td_actions">
    <?php echo $helper->linkToEdit($mt_alert_message, array(  'label' => __('Edit alert', array(), 'mt_alert_messages'),  'params' =>   array(  ),  'class_suffix' => 'edit',)) ?>
    <?php if (!$mt_alert_message->getIsActive()): ?>
    <li class="sf_admin_action_activate">
      <?php echo link_to(__('Activate', array(), 'mt_alert_messages'), 'mt_alert_message/activate?id='.$mt_alert_message->getId(), array()) ?>
    </li>
    <?php endif ?>
    <?php if ($mt_alert_message->getIsActive()): ?>
    <li class="sf_admin_action_deactivate">
      <?php echo link_to(__('Deactivate', array(), 'mt_alert_messages'), 'mt_alert_message/deactivate?id='.$mt_alert_message->getId(), array()) ?>
    </li>
    <?php endif ?>
    <?php if (!$mt_alert_message->getShowToAll()): ?>
      <li class="sf_admin_action_manageusers">
        <?php echo link_to(__('Manage users', array(), 'mt_alert_messages'), 'mt_alert_message/manageUsers?id='.$mt_alert_message->getId(), array()) ?>
      </li>
      <li class="sf_admin_action_managecredentials">
        <?php echo link_to(__('Manage credentials', array(), 'mt_alert_messages'), 'mt_alert_message/manageCredentials?id='.$mt_alert_message->getId(), array()) ?>
      </li>
    <?php endif ?>
    <?php echo $helper->linkToDelete($mt_alert_message, array(  'label' => __('Delete permanently', array(), 'mt_alert_messages'),  'params' =>   array(  ),  'confirm' => __('Are you sure?', array(), 'mt_alert_messages'),  'class_suffix' => 'delete',)) ?>
  </ul>
</td>
