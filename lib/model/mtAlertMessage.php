<?php

class mtAlertMessage extends BasemtAlertMessage
{
  public function __toString()
  {
    return $this->getTitle();
  }

  /**
   * Activates this instance so it can be shown or
   * be emailed again.
   *
   * @param PropelPDO
   */
  public function activate(PropelPDO $con = null)
  {
    $this->setIsActive(true);
    $this->save($con);
  }

  /**
   * Deactivates this instance so it cannot be shown
   * or be emailed again.
   *
   * @param PropelPDO
   */
  public function deactivate(PropelPDO $con = null)
  {
    $this->setIsActive(false);
    $this->save($con);
  }

  /**
   * Returns true if this instance can be activated.
   *
   * @return boolean
   */
  public function canBeActivated()
  {
    return !$this->getIsActive();
  }

  /**
   * Returns true if this instance can be deactivated.
   *
   * @return boolean
   */
  public function canBeDeactivated()
  {
    return $this->getIsActive();
  }

  /**
   * Returns true if this instance can have
   * credentials associated.
   *
   * @return boolean
   */
  public function canManageCredentials()
  {
    return true;
  }

  /**
   * Returns true if this instance can have
   * users associated.
   *
   * @return boolean
   */
  public function canManageUsers()
  {
    return true;
  }

  /**
   * This method calls the static method
   * 'conditionClass::conditionMethod($this)'
   *
   * This method should return true if the
   * alert can be shown.
   *
   * @return boolean
   */
  public function checkCondition()
  {
    $conditionClass  = $this->getConditionClass();
    $conditionMethod = $this->getConditionMethod();

    if (empty($conditionClass) || empty($conditionMethod))
    {
      return true;
    }
    else
    {
      return call_user_func(array($conditionClass, $conditionMethod), $this);
    }
  }

  /**
   * Obtains an already save configuration for the
   * user passed by parameter or returns a non saved
   * new instance.
   *
   * @param $sf_user a sfUser instance
   *
   * @return a mtAlertMessageUserConfiguration instance
   */
  public function getConfiguration($sf_user)
  {
    $conf = $this->retrieveConfiguration($sf_user);
    return is_null($conf)? $this->createConfiguration($sf_user) : $conf;
  }

  /**
   * Creates a mtAlertMessageUserConfiguration
   * already setup for this instance.
   *
   * @param $sf_user sfUser instance
   *
   * @return $sf_user
   */
  protected function createConfiguration($sf_user)
  {
    $conf = new mtAlertMessageUserConfiguration();
    $conf->setmtAlertMessageId($this->getId());
    $conf->setUsername($sf_user->getUsername());

    return $conf;
  }

  /**
   * Returns a saved mtAlertMessageUserConfiguration
   * instance for this alert or null
   *
   * @param $sf_user sfUser instance
   * @return $sf_user
   */
  protected function retrieveConfiguration($sf_user)
  {
    $criteria = new Criteria();
    $criteria->add(mtAlertMessageUserConfigurationPeer::USERNAME, $sf_user->getUsername());
    $criteria->add(mtAlertMessageUserConfigurationPeer::MT_ALERT_MESSAGE_ID, $this->getId());

    return mtAlertMessageUserConfigurationPeer::doSelectOne($criteria);
  }

  /**
   * Obtains the integer representation of the associated
   * days as date('w') function
   *
   * @return an array of intengers
   */
  public function getmtAlertMessageDayConstants()
  {
    $ids = array();
    foreach ($this->getmtAlertMEssageDays() as $d)
    {
      $ids[] = $d->getmtAlertDayId();
    }
    return $ids;
  }

  /**
   * Obtains the string representation of the associated 
   * days as 'monday, tuesday, sunday, etc, etc'
   *
   * @return an array of Strings
   */
  public function getmtAlertMessageDaysRepresentation()
  {
    $strs = array();
    foreach ($this->getmtAlertMessageDays() as $d)
    {
      $strs[] = mtAlertDay::getRepresentationFor($d->getmtAlertDayId());
    }
    return $strs;
  }

  /**
   * Obtains the string representation of the associated 
   * credentials.
   *
   * @return an array of Strings
   */
  public function getmtAlertMessageCredentialsRepresentation()
  {
    $strs = array();
    foreach ($this->getmtAlertMessageCredentials() as $d)
    {
      $strs[] = $d->getCredential();
    }
    return $strs;
  }

  /**
   * Obtains the associates usernames
   *
   * @return an array of Strings
   */
  public function getmtAlertMessageUsersRepresentation()
  {
    $strs = array();
    foreach ($this->getmtAlertMessageUsers() as $d)
    {
      $strs[] = $d->getUsername();
    }
    return $strs;
  }

  /**
   * Returns a string that represents the current
   * state of this instance for a certain user
   *
   * @param $user sfUser instance
   *
   * @return String
   */
  public function getState($user)
  {
    $v = mtAlertConfiguration::getHideAlertInSessionAttribute($user);
    $v = $v instanceOf sfOutputEscaper? $v->getRawValue() : $v;

    if ($this->getConfiguration($user)->getHidePermanently())
    {
      $state = 'Hidden permanently';
    }
    elseif (in_array($this->getId(), $v))
    {
      $state = 'Hidden for this session';
    }
    else
    {
      $state = 'Active';
    }

    return $state;
  }

  /**
   * Returns the body of the mail
   *
   * @return String
   */
  public function getMailBody()
  {
    if (sfContext::hasInstance())
    {
      sfContext::getInstance()->getConfiguration()->loadHelpers('Partial');
    }

    $content = 
    "<div>
       %%message%%
     </div>
     <div>
       %%partial%%
     </div>";

    $partial = $this->getPartial();

    $content = str_replace(array('%%message%%', '%%partial%%'), 
                           array($this->getMessage(), empty($partial) || !sfContext::hasInstance()? '' : get_partial($partial, array('mt_alert_message' => $this))),
                           $content);
    return $content;
  }

  public function getShownWhen()
  {
    $conditionDesc   = $this->getConditionDescription();
    $conditionClass  = $this->getConditionClass();
    $conditionMethod = $this->getConditionMethod();

    if (empty($conditionClass) || empty($conditionMethod))
    {
      return 'Always';
    }
    else
    {
      return empty($conditionDesc)? 'Not specified' : $conditionDesc;
    }
  }
}
