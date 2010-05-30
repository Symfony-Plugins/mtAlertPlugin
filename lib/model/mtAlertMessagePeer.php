<?php

class mtAlertMessagePeer extends BasemtAlertMessagePeer
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
   * Returns a criteria that will only selected
   * those alerts that are active.
   *
   * @param $criteria
   *
   * @return a Criteria instance
   */
  static public function doSelectActiveCriteria($criteria = null)
  {
    $criteria = is_null($criteria)? new Criteria() : $criteria;
    $criteria->add(mtAlertMessagePeer::IS_ACTIVE, true);
    return $criteria;
  }

  /**
   * Returns a criteria that will only select those 
   * mtAlertMessages that can be showed in a web browser
   *
   * @param Criteria
   *
   * @return a Criteria instance
   */
  static public function doSelectBrowserCriteria($criteria = null)
  {
    $criteria = is_null($criteria)? new Criteria() : $criteria;
    $criteria->add(mtAlertMessagePeer::SHOW_IN_BROWSER, true);
    return $criteria;
  }

  /**
   * Returns a criteria that will only select those
   * mtAlertMessages that can be emailed.
   *
   * @param $criteria
   *
   * @return a Criteria instance
   */
  static public function doSelectMailCriteria($criteria = null)
  {
    $criteria = is_null($criteria)? new Criteria() : $criteria;
    $criteria->add(mtAlertMessagePeer::CAN_BE_MAILED, true);
    return $criteria;
  }

  /**
   * Returns a criteria instance that adds the credentials
   * and user conditions.
   *
   * The criteria will select all the mtAlertMessages that
   * matches with at least one $credential or at least one 
   * $user or are set to be shown to everyone.
   *
   * @param $credentials an array of credentials (strings)
   * @param $usernames   an array of usernames (strings)
   * @param $criteria    a Criteria instance
   *
   * @return a Criteria instance
   */
  static public function doSelectCredentialsUsersCriteria($credentials, $usernames, $criteria = null)
  {
    $criteria = is_null($criteria)? new Criteria() : $criteria;
    $criteria->setDistinct(true);

    $criteria->addJoin(mtAlertMessagePeer::ID, mtAlertMessageCredentialPeer::MT_ALERT_MESSAGE_ID, Criteria::LEFT_JOIN);
    $criteria->addJoin(mtAlertMessagePeer::ID, mtAlertMessageUserPeer::MT_ALERT_MESSAGE_ID, Criteria::LEFT_JOIN);

    $criterion1 = $criteria->getNewCriterion(mtAlertMessageCredentialPeer::CREDENTIAL, $credentials, Criteria::IN);
    $criterion3 = $criteria->getNewCriterion(mtAlertMessageUserPeer::USERNAME, $usernames, Criteria::IN);

    $criterion5 = $criteria->getNewCriterion(mtAlertMessagePeer::SHOW_TO_ALL, true);
    $criterion1->addOr($criterion3);
    $criterion1->addOr($criterion5);

    $criteria->addOr($criterion1);

    return $criteria;
  }

  /**
   * Returns a criteria that is filtered by the configuration
   * that a certain user has setup for the alerts.
   *
   * A certain user can hide those alerts that are botter him
   * for example.
   *
   * @param $usernames filter by the configuration of this users
   * @param $criteria
   *
   * @return a Criteria instance
   */
  static public function doSelectConfigurationCriteria($usernames, $criteria = null)
  {
    $pks = mtAlertMessageUserConfigurationPeer::doSelectPksByUsernames($usernames);

    if (!empty($pks))
    {
      $criteria = is_null($criteria)? new Criteria() : $criteria;
      $criteria = new Criteria();
      $criteria->addJoin(mtAlertMessagePeer::ID, mtAlertMessageUserConfigurationPeer::MT_ALERT_MESSAGE_ID, Criteria::LEFT_JOIN);

      $criterion1 = $criteria->getNewCriterion(mtAlertMessageUserConfigurationPeer::ID, null, Criteria::ISNULL);
      $criterion2 = $criteria->getNewCriterion(mtAlertMessageUserConfigurationPeer::HIDE_PERMANENTLY, false);
      $criterion3 = $criteria->getNewCriterion(mtAlertMessageUserConfigurationPeer::USERNAME, $usernames, Criteria::IN);
      $criterion4 = $criteria->getNewCriterion(mtAlertMessageUserConfigurationPeer::ID, $pks, Criteria::IN);

      $criterion2->addAnd($criterion3);
      $criterion2->addAnd($criterion4);
      $criterion1->addOr($criterion2);
      $criteria->addAnd($criterion1);
    }
    return $criteria;
  }

  /**
   * Returns a criteria that filters mtAlertMessages
   * according to the current day name.
   *
   * @param $criteria
   *
   * @return a Criteria instance
   */
  static public function doSelectDayCriteria($criteria = null)
  {
    $criteria = is_null($criteria)? new Criteria() : $criteria;
    $criteria->addJoin(mtAlertMessagePeer::ID, mtAlertMessageDayPeer::MT_ALERT_MESSAGE_ID);
    $criteria->add(mtAlertMessageDayPeer::MT_ALERT_DAY_ID, date('w'));

    return $criteria;
  }

  /**
   * Returns a criteria that filters by
   *  - username
   *  - day
   *  - active-
   *  - only alerts that can be shown in a web browser
   *  - etc.
   *
   * @param $sf_user a sfUser instance
   * @param $criteria
   *
   * @return $criteria
   */
  static public function doSelectForAuthenticatedUser($sf_user, $criteria = null)
  {
    $criteria = self::doSelectCredentialsUsersCriteria($sf_user->listCredentials(),
                             array(mtAlertUserHelper::getUsername($sf_user)),
                             self::doSelectConfigurationCriteria(array(mtAlertUserHelper::getUsername($sf_user)),
                                                                 self::doSelectDayCriteria(self::doSelectActiveCriteria(self::doSelectBrowserCriteria($criteria)))));
    $mtAlerts   = array();
    $tmpAlerts  = self::doSelect($criteria);

    /* Check for static condition */
    foreach ($tmpAlerts as $a)
    {
      if ($a->checkCondition())
      {
        $mtAlerts[] = $a;
      }
    }

    return $mtAlerts;
  }

  /**
   * Returns the appropiate criteria for retrieving alerts
   * from database.
   *
   * @param $sf_user a sfUser instance
   * @param $criteria
   *
   * @return $criteria
   */
  static public function doSelectForUser($sf_user, $criteria = null)
  {
    if ($sf_user->isAuthenticated())
    {
      return self::doSelectForAuthenticatedUser($sf_user, $criteria);
    }
    else
    {
      return self::doSelectForNonAuthenticatedUser($sf_user, $criteria);
    }
  }

  /**
   * Returns a criteria that filters by
   *  - day
   *  - is_active
   *  - browser_only
   *
   * @param $sf_user a sfUser instance
   * @param $criteria
   *
   * @return $criteria
   */
  static public function doSelectForNonAuthenticatedUser($sf_user, $criteria = null)
  {
    $criteria   = self::doSelectDayCriteria(self::doSelectActiveCriteria(self::doSelectBrowserCriteria($criteria)));
    $mtAlerts   = array();
    $tmpAlerts  = self::doSelect($criteria);

    /* Check for static condition */
    foreach ($tmpAlerts as $a)
    {
      if ($a->checkCondition())
      {
        $mtAlerts[] = $a;
      }
    }

    return $mtAlerts;
  }
}
