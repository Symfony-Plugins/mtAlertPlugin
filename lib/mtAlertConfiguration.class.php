<?php

class mtAlertConfiguration
{
  static public function getCredentials()
  {
    return sfConfig::get('app_mt_alert_plugin_credentials', array());
  }

  static public function getEnableRichText()
  {
    return sfConfig::get('app_mt_alert_plugin_enable_rich_text', true);
  }

  static public function getTinyMCETheme()
  {
    return sfConfig::get('app_mt_alert_plugin_tiny_mce_theme', 'simple');
  }

  static public function getNotificationText($count)
  {
    if ($count == 0)
    {
      return __('You do not have alerts right now.', array(), 'mt_alert_messages');
    }
    elseif ($count == 1)
    {
      return __('There is an alert for you.', array(), 'mt_alert_messages');
    }
    else
    {
      return __('There are %%count%% alerts for you.', array('%%count%%' => $count), 'mt_alert_messages');
    }
  }

  static public function getMailRetrieveMailsMethod()
  {
    return sfConfig::get('app_mt_alert_plugin_mail_retrieve_mails_method', null);
  }

  static public function getMailRetrieveUserNamesByCredentialMethod()
  {
    return sfConfig::get('app_mt_alert_plugin_mail_retrieve_mails_method', null);
  }

  static public function getMailOfApplication()
  {
    return sfConfig::get('app_mt_alert_plugin_mail_retrieve_all_mails_method', null);
  }

  static public function getMailFrom()
  {
    return sfConfig::get('app_mt_alert_plugin_mail_from', 'testing@testingFake.com');
  }

  static public function getMailSubject($alert)
  {
    return str_replace(array('%%title%%'), array($alert->getTitle()), sfConfig::get('app_mt_alert_plugin_mail_subject', '%%title%%'));
  }

  static public function getHideAlertInSessionAttributeName($user)
  {
    return "mt_alert.".$user->getUsername().".hide";
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
