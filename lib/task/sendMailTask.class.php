<?php

class sendMail extends sfBaseTask
{
  const MESSAGE_LONG = 80;

  protected function configure()
  {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment'),
    ));

    $this->namespace        = 'mtAlertPlugin';
    $this->name             = 'sendMail';
    $this->briefDescription = 'Send alerts via mail';
    $this->detailedDescription = "";
  }

  /**
   * Creates a context instance since symfony tasks run without one.
   */
  protected  function createContextInstance($application, $enviroment = 'prod', $debug = false)
  {
    $configuration = ProjectConfiguration::getApplicationConfiguration($application, $enviroment, $debug);

    sfContext::createInstance($configuration);
    sfContext::switchTo($application);
  }

  /**
   * Retrieves the mails for a mtAlertMessage
   *
   * @param $a mtAlertMessage
   *
   * @return an array of strings
   */
  protected function getMails($a)
  {
    $mails             = array();
    $mailClassMethod   = mtAlertConfiguration::getMailRetrieveMailsMethod();
    $credClassMethod   = mtAlertConfiguration::getMailRetrieveUserNamesByCredentialMethod();

    if ($a->checkCondition())
    {
      if ($a->getShowToAll())
      {
        $mails       = call_user_func(mtAlertConfiguration::getMailForAll());
      }
      else
      {
        $users       = array();
        foreach ($a->getmtAlertMessageCredentialsRepresentation() as $c)
        {
          $users = array_merge($users, array());
        }
        $users       = array_unique(array_merge($users, $a->getmtAlertMessageUsersRepresentation()));
        $usersNot    = array_diff($users, mtAlertMessageUserConfigurationPeer::getDisabledUsers($a));
        $mails       = call_user_func($mailClassMethod, $users);
      }
    }

    $res = array();
    $validator = new sfValidatorEmail(array('required' => true));
    foreach ($mails as $m)
    {
      try {
        $validator->clean($m);
        $res[] = $m;
      } catch (sfValidatorError $e) {
      }
    }

    return $res;
  }

  /**
   * Returns the mail subject of a mtAlertMessage
   *
   * @param $a mtAlertMessage
   *
   * @return String
   */
  protected function getMailSubject($a)
  {
    return mtAlertConfiguration::getMailSubject($a);
  }

  /**
   * Sends one mail.
   *
   * @param $from
   * @param $recipients
   * @param $subject
   * @param $body
   */
  protected function sendAlertMail($from, $recipients, $subject, $body)
  {
    $mail = dcMailer::getMail();
    $mail->setFrom($from);
    $mail->setBody($body, 'text/html');
    $mail->setSubject($subject);

    foreach ($recipients as $m)
    {
      $mail->addTo($m);
    }

    $mail->send();
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection      = $databaseManager->getDatabase('propel')->getConnection();

    $this->createContextInstance($options['application'], $options['env']);

    $criteria = mtAlertMessagePeer::doSelectDayCriteria(mtAlertMessagePeer::doSelectActiveCriteria(mtAlertMessagePeer::doSelectMailCriteria()));
    foreach (mtAlertMessagePeer::doSelect($criteria) as $a)
    {
      $mailSubject = $this->getMailSubject($a);
      $mailCcos    = $this->getMails($a);
      $mailBody    = $a->getMailBody();
      $mailFrom    = mtAlertConfiguration::getMailFrom();

      $this->sendAlertMail($mailFrom, $mailCcos, $mailSubject, $mailBody);
    }
  }
}
