<?php

/**
 * pluginsMt_alert_message_userActions actions.
 *
 * @subpackage mt_alert_message
 * @author     mtorres <matias.torres@coresystems.com.ar>
 */
class pluginsMt_alert_message_userActions extends  autoMt_alert_message_userActions 
{
  public function preExecute()
  {
    parent::preExecute();
    $this->getContext()->getConfiguration()->loadHelpers(array('I18N'));

    $this->mt_alert_message_id = $this->getUser()->getAttribute('mt_alert_message_id');
    $this->mt_alert_message    = mtAlertMessagePeer::retrieveByPk($this->mt_alert_message_id);

    if (is_null($this->mt_alert_message))
    {
      $this->getUser()->setFlash('error', __('You must specify an mt_alert_message instance', array(), 'mt_alert_messages'));
      $this->redirect('@mt_alert_message');
    }
  }

  public function buildCriteria()
  {
    $criteria = parent::buildCriteria();
    $criteria->add(mtAlertMessageUserPeer::MT_ALERT_MESSAGE_ID, $this->mt_alert_message_id);

    return $criteria;
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->mt_alert_message_user = new mtAlertMessageUser();
    $this->mt_alert_message_user->setmtAlertMessageId($this->mt_alert_message_id);
    $this->form = $this->configuration->getForm($this->mt_alert_message_user);
  }

  public function executeGoToAlertList(sfWebRequest $request)
  {
    $this->redirect('@mt_alert_message');
  }

}
