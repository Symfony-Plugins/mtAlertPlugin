<?php

class mtAlertMessageUserConfigurationPeer extends BasemtAlertMessageUserConfigurationPeer
{
  /**
   * Returns the usernames that disabled the notification
   * permanently
   *
   * @param $mt_alert_message mtAlertMessage instance
   *
   * @return an array of strings (usernames)
   */
  static public function getDisabledUsers($mt_alert_message)
  {
    $criteria = new Criteria();
    $criteria->add(mtAlertMessageUserConfigurationPeer::MT_ALERT_MESSAGE_ID, $mt_alert_message->getId());
    $criteria->add(mtAlertMessageUserConfigurationPeer::HIDE_PERMANENTLY, true);

    $usernames = array();
    foreach (self::doSelect($criteria) as $c)
    {
      $usernames[] = $c->getUsername();
    }

    return $usernames;
  }
}
