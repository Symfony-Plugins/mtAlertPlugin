<?php

/**
 * autoMtAlertAdmin actions.
 *
 * @subpackage mt_alert_message
 * @author     mtorres <matias.torres@coresystems.com.ar>
 */
class pluginsMt_alert_messageActions extends  autoMt_alert_messageActions 
{
  public function executeDeactivate(sfWebRequest $request)
  {
    $this->mt_alert_message = $this->getRoute()->getObject();

    if ($this->mt_alert_message->canBeDeactivated())
    {
      try
      {
        $this->mt_alert_message->deactivate();
        $this->getUser()->setFlash('notice', __('The alert was deactivated.', array(), 'mt_alert_messages'));
      } catch (Exception $e) {
        $this->getUser()->setFlash('error', __('The alert could not be deactivated.', array(), 'mt_alert_messages'));
      }
    }
    else
    {
      $this->getUser()->setFlash('error', __('You cannot deactivate the seledted alert.', array(), 'mt_alert_messages'));
    }

    $this->redirect('@mt_alert_message');
  }

  public function executeActivate(sfWebRequest $request)
  {
    $this->mt_alert_message = $this->getRoute()->getObject();

    if ($this->mt_alert_message->canBeActivated())
    {
      try
      {
        $this->mt_alert_message->activate();
        $this->getUser()->setFlash('notice', __('The alert was activated.', array(), 'mt_alert_messages'));
      } catch (Exception $e) {
        $this->getUser()->setFlash('error', __('The alert could not be activated.', array(), 'mt_alert_messages'));
      }
    }
    else
    {
      $this->getUser()->setFlash('error', __('You cannot activate the selected alert.', array(), 'mt_alert_messages'));
    }

    $this->redirect('@mt_alert_message');
  }

  public function executeManageUsers()
  {
    $this->mt_alert_message = $this->getRoute()->getObject();

    $this->getUser()->setAttribute('mt_alert_message_id', $this->mt_alert_message->getId());
    $this->forwardIf($this->mt_alert_message->canManageUsers(), 'mt_alert_message_user', 'index');
    $this->getUser()->setFlash('error', __('Cannot execute desired action.', array(), 'mt_alert_messages'));

    $this->redirect('@mt_alert_message');
  }

  public function executeManageCredentials()
  {
    $this->mt_alert_message = $this->getRoute()->getObject();

    $this->getUser()->setAttribute('mt_alert_message_id', $this->mt_alert_message->getId());
    $this->forwardIf($this->mt_alert_message->canManageCredentials(), 'mt_alert_message_credential', 'index');
    $this->getUser()->setFlash('error', __('Cannot execute desired action.', array(), 'mt_alert_messages'));

    $this->redirect('@mt_alert_message');
  }
}
