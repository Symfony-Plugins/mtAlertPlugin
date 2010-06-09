<?php $mtaId       = "mt_alert_message_".$mta->getId() ?>
<?php $mtaDetailId = "mt_alert_message_detail_".$mta->getId() ?>
<?php $mtaSLinkId  = "mt_alert_message_detail_slink_".$mta->getId() ?>
<?php $mtaHLinkId  = "mt_alert_message_detail_hlink_".$mta->getId() ?>

<div class="mt_alert_message" id="<?php echo $mtaId ?>">
  <h3>
    <?php echo $mta->getTitle() ?>
    <?php echo link_to_function(__('Show'), "jQuery('#$mtaDetailId').slideDown(1000); jQuery(this).fadeOut(400); setTimeout(function() {jQuery('#$mtaHLinkId').fadeIn()}, 450);", array('id' => $mtaSLinkId, 'class' => 'mta_message_show_link')) ?>
    <?php echo link_to_function(__('Hide'), "jQuery('#$mtaDetailId').slideUp(1000); jQuery(this).fadeOut(400); setTimeout(function() {jQuery('#$mtaSLinkId').fadeIn()}, 450);", array('id' => $mtaHLinkId, 'style' => 'display: none', 'class' => 'mta_message_hide_link')) ?>
  </h3>
  <div class="content" style="display: none" id="<?php echo $mtaDetailId ?>">
    <div class="actions">
      <?php include_partial('mt_alert_message_view/'.mtAlertConfiguration::getTheme().'_show_mt_alert_message_actions', array('mta' => $mta, 'mtaId' => $mtaId, 'mtaDetailId' => $mtaDetailId)) ?>
    </div>
    <div class="message"><?php echo mtAlertConfiguration::getEnableRichText()? sfOutputEscaper::unescape($mta->getMessage()) : $mta->getMessage() ?></div>
    <?php if (strlen($mta->getPartial()) > 0): ?>
      <div class="partial"><?php include_partial($mta->getPartial(), array('mta' => $mta)) ?></div>
    <?php endif ?>
  </div>
</div>
