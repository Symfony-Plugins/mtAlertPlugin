<?php use_helper('I18N', 'Date') ?>
<?php include_partial('mt_alert_message_credential/assets') ?>

<div id="sf_admin_container">
  <h1><?php echo __('Credentials of "%%mt_alert_message%%"', array('%%mt_alert_message%%' => strval($mt_alert_message)), 'mt_alert_messages') ?></h1>

  <?php include_partial('mt_alert_message_credential/flashes') ?>

  <div id="sf_admin_header">
    <?php include_partial('mt_alert_message_credential/list_header', array('pager' => $pager)) ?>
  </div>


  <div id="sf_admin_content">
    <?php include_partial('mt_alert_message_credential/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
    <ul class="sf_admin_actions">
      <?php include_partial('mt_alert_message_credential/list_batch_actions', array('helper' => $helper)) ?>
      <?php include_partial('mt_alert_message_credential/list_actions', array('helper' => $helper)) ?>
    </ul>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('mt_alert_message_credential/list_footer', array('pager' => $pager)) ?>
  </div>
</div>
