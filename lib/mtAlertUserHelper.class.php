<?php

class mtAlertUserHelper
{
  const NON_AUTHENTICATED_USERNAME = 'non_authenticated';

  static public function getUsername($sf_user)
  {
    if ($sf_user->isAuthenticated())
    {
      return $sf_user->getUsername();
    }
    else
    {
      return self::NON_AUTHENTICATED_USERNAME;
    }
  }

  static public function canHideAlertsPermanently($user)
  {
    return $user->isAuthenticated();
  }

  static public function getHideAlertInSessionAttributeName($user)
  {
    return "mt_alert.".mtAlertUserHelper::getUsername($user).".hide";
  }

  static public function getHideAlertInSessionAttribute($user)
  {
    return $user->getAttribute(self::getHideAlertInSessionAttributeName($user), array());
  }

  static public function isHiddenInSession($user, $mt_alert_message)
  {
    return in_array($mt_alert_message->getId(), self::getHideAlertInSessionAttribute($user));
  }

  static public function hideAlertInSession($user, $mt_alert_message)
  {
    $user->setAttribute(self::getHideAlertInSessionAttributeName($user),
                        array_unique(array_merge(self::getHideAlertInSessionAttribute($user), array($mt_alert_message->getId()))));
  }

  static public function showAlertInSession($user, $mt_alert_message)
  {
    $user->setAttribute(self::getHideAlertInSessionAttributeName($user),
                        array_unique(array_diff(self::getHideAlertInSessionAttribute($user), array($mt_alert_message->getId()))));
  }

}
