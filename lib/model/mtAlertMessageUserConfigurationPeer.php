<?php

class mtAlertMessageUserConfigurationPeer extends BasemtAlertMessageUserConfigurationPeer
{
  static public function doSelectPks($criteria = null)
  {
    $criteria = is_null($criteria)? new Criteria() : $criteria;

    $criteria->clearSelectColumns();
    $criteria->addSelectColumn(self::ID);

    $stmt = self::doSelectStmt($criteria);

    return $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
  }


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

  static public function doSelectPksByUsernames($usernames)
  {
    $c = new Criteria();
    $c->add(mtAlertMessageUserConfigurationPeer::USERNAME, $usernames, Criteria::IN);

    return self::doSelectPks($c);
  }

  static public function retrieveConfigurationFor($mt_alert_message, $username)
  {
    $c = new Criteria();
    $c->add(mtAlertMessageUserConfigurationPeer::USERNAME, $username);
    $c->add(mtAlertMessageuserConfigurationPeer::MT_ALERT_MESSAGE_ID, $mt_alert_message->getId());

    return self::doSelectOne($c);
  }
}
