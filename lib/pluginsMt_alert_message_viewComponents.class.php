<?php

class pluginsMt_alert_message_viewComponents extends sfComponents
{
  public function executeShow()
  {
    $criteria = new Criteria();
    $ids      = mtAlertConfiguration::getHideAlertInSessionAttribute($this->getUser());

    if (!empty($ids))
    {
      $criteria->add(mtAlertMessagePeer::ID, $ids, Criteria::NOT_IN);
    }

    $this->mt_alert_messages = mtAlertMessagePeer::doSelectForUser($this->getUser(), $criteria);
  }
}
