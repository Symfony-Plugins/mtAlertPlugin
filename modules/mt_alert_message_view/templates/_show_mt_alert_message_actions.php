<ul class="mt_alert_message_actions">
<?php if ($mta->getCanBeHiddenPermanently()): ?>
  <li class="never_show_again">
    <?php echo link_to_remote(__('Hide permanently', array(), 'mt_alert_messages'),
                              array('update' => 'mt_alert_messages_ajax_area',
                                    'url'    => 'mt_alert_message_view/hidePermanently',
                                    'script' => true,
                                    'with'   => "'id=".$mta->getId()."&container_id=$mtaId'"
                              )) ?>
  </li>
<?php endif ?> 
  <li class="hide_for_this_session">
    <?php echo link_to_remote(__('Hide for this session', array(), 'mt_alert_messages'),
                              array('update' => 'mt_alert_messages_ajax_area',
                                    'url'    => 'mt_alert_message_view/hideInThisSession',
                                    'script' => true,
                                    'with'   => "'id=".$mta->getId()."&container_id=$mtaId'"
                              )) ?>
  </li>
</ul>
