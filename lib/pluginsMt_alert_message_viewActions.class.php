<?php

/**
 * autoMt_alert_message_view actions.
 *
 * @subpackage mt_alert_message
 * @author     mtorres <matias.torres@coresystems.com.ar>
 */
class pluginsMt_alert_message_viewActions extends  autoMt_alert_message_viewActions
{
  protected function setHidePermanently($mt_alert_message, $val, $con = null)
  {
    $this->configuration = $this->mt_alert_message->getConfiguration($this->getUser());
    $this->configuration->setHidePermanently($val);
    $this->configuration->save($con);
  }

  public function buildCriteria()
  {
    $criteria = parent::buildCriteria();
    $in       = array();

    /* This adds conditions for USER filtering */
    mtAlertMessagePeer::doSelectActiveCriteria($criteria);
    mtAlertMessagePeer::doSelectCredentialsUsersCriteria($this->getUser()->listCredentials(), array(mtAlertUserHelper::getUsername($this->getUser())), $criteria);

    /* This filter alerts that are not beign shown because of the condition is false */
    foreach (mtAlertMessagePeer::doSelect($criteria) as $o)
    {
      if ($o->checkCondition($this->getUser())) $in[] = $o->getId();
    }

    $criteria->add(mtAlertMessagePeer::ID, $in, Criteria::IN);

    return $criteria;
  }

  public function executeDoShow(sfWebRequest $request)
  {
    $this->getContext()->getConfiguration()->loadHelpers('I18N');

    $this->mt_alert_message = $this->getRoute()->getObject();

    try
    {
      if (mtAlertUserHelper::canHideAlertsPermanently($this->getUser()))
      {
        $this->setHidePermanently($this->mt_alert_message, false);
      }
      mtAlertUserHelper::showAlertInSession($this->getUser(), $this->mt_alert_message);

      $this->getUser()->setFlash('notice', __("The alert '%%title%%' will be shown again.", array('%%title%%' => $this->mt_alert_message->getTitle(), 'mt_alert_messages')));
    } catch (Exception $e) {
      $this->getUser()->setFlash('error', __("Could not process the request", array(), 'mt_alert_messages'));
    }

    $this->redirect('@mt_alert_message_view');
  }

  public function executeDoShowAgain(sfWebRequest $request)
  {
    $this->getContext()->getConfiguration()->loadHelpers('I18N');

    $this->mt_alert_message = $this->getRoute()->getObject();

    if (mtAlertUserHelper::canHideAlertsPermanently($this->getUser()))
    {
      try
      {
        $this->setHidePermanently($this->mt_alert_message, false);
        $this->getUser()->setFlash('notice', __("The alert '%%title%%' will be shown again.", array('%%title%%' => $this->mt_alert_message->getTitle()), 'mt_alert_messages'));
      } catch (Exception $e) {
        $this->getUser()->setFlash('error', __("Could not process the request", array(), 'mt_alert_messages'));
      }
    }
    else
    {
      $this->getUser()->setFlash('error', __("You cannot hide alerts permanently.", array(), 'mt_alert_messages'));
    }

    $this->redirect('@mt_alert_message_view');
  }

  public function executeDoHidePermanently(sfWebRequest $request)
  {
    $this->getContext()->getConfiguration()->loadHelpers('I18N');

    if (mtAlertUserHelper::canHideAlertsPermanently($this->getUser()))
    {
      $this->mt_alert_message = $this->getRoute()->getObject();

      try
      {
        $this->setHidePermanently($this->mt_alert_message, true);
        $this->getUser()->setFlash('notice', __("The alert '%%title%%' won't be shown again.", array('%%title%%' => $this->mt_alert_message->getTitle()), 'mt_alert_messages'));
      } catch (Exception $e) {
        $this->getUser()->setFlash('error', __("Could not process the request", array(), 'mt_alert_messages'));
      }
    }
    else
    {
      $this->getUser()->setFlash('error', __("You cannot hide alerts permanently.", array(), 'mt_alert_messages'));
    }

    $this->redirect('@mt_alert_message_view');
  }

  /**
   * This function handles the 'Hide permanently' button.
   */
  public function executeHidePermanently(sfWebRequest $request)
  {
    $this->getContext()->getConfiguration()->loadHelpers('I18N');
    $ret = sfView::SUCCESS;

    $this->text                = '';
    $this->mt_alert_message_id = $this->getRequest()->getParameter('id');
    $this->container_id        = $this->getRequest()->getParameter('container_id');
    $this->mt_alert_message    = mtAlertMessagePeer::retrieveByPk($this->mt_alert_message_id);

    if (mtAlertUserHelper::canHideAlertsPermanently($this->getUser()))
    {
      if (is_null($this->mt_alert_message))
      {
        $this->text = __("Could not process the request. The alert with ID '%%id%%' does not exists.", array('%%id%%' => $this->mt_alert_message_id), 'mt_alert_messages');
        $ret = sfView::ERROR;
      }
      else
      {
        try
        {
          $this->setHidePermanently($this->mt_alert_message, true);
          $this->text = __("The alert '%%title%%' will not be showed again.", array('%%title%%' => $this->mt_alert_message->getTitle()), 'mt_alert_messages');
          $ret = sfView::SUCCESS;
        } catch (Exception $e) {
          $this->text = __("Could not process the request", array(), 'mt_alert_messages');
          $ret = sfView::ERROR;
        }
      }
    }
    else
    {
      $this->getUser()->setFlash('error', __("You cannot hide alerts permanently.", array(), 'mt_alert_messages'));
    }

    $this->setTemplate(mtAlertConfiguration::getTheme().'HideInThisSession');
    return $ret;
  }

  /**
   * This function handles the 'Do not show again in this session' button.
   */
  public function executeHideInThisSession(sfWebRequest $request)
  {
    $this->getContext()->getConfiguration()->loadHelpers('I18N');

    $this->text                = '';
    $this->mt_alert_message_id = $this->getRequest()->getParameter('id');
    $this->container_id        = $this->getRequest()->getParameter('container_id');
    $this->mt_alert_message    = mtAlertMessagePeer::retrieveByPk($this->mt_alert_message_id);

    if (is_null($this->mt_alert_message))
    {
      $this->text = __("Could not process the request. The alert with ID '%%id%%' does not exists.", array('%%id%%' => $this->mt_alert_message_id), 'mt_alert_messages');
      $ret = sfView::ERROR;
    }
    else
    {
      mtAlertUserHelper::hideAlertInSession($this->getUser(), $this->mt_alert_message);
      $this->text = __("The alert '%%title%%' will not be shown again in this session.", array('%%title%%' => $this->mt_alert_message->getTitle()), 'mt_alert_messages');
      $ret = sfView::SUCCESS;
    }

    $this->setTemplate(mtAlertConfiguration::getTheme().'HideInThisSession');

    return $ret;
  }

  public function executeDoShowInSession(sfWebRequest $request)
  {
    $this->getContext()->getConfiguration()->loadHelpers('I18N');

    $this->mt_alert_message = $this->getRoute()->getObject();
    mtAlertUserHelper::showAlertInSession($this->getUser(), $this->mt_alert_message);
    $this->getUser()->setFlash('notice', __("The alert '%%title%%' will be shown again in this session.", array('%%title%%' => $this->mt_alert_message->getTitle()), 'mt_alert_messages'));

    $this->redirect('@mt_alert_message_view');
  }

  public function executeDoHideInSession(sfWebRequest $request)
  {
    $this->getContext()->getConfiguration()->loadHelpers('I18N');

    $this->mt_alert_message = $this->getRoute()->getObject();
    mtAlertUserHelper::hideAlertInSession($this->getUser(), $this->mt_alert_message);
    $this->getUser()->setFlash('notice', __("The alert '%%title%%' won't be shown again in this session.", array('%%title%%' => $this->mt_alert_message->getTitle()), 'mt_alert_messages'));

    $this->redirect('@mt_alert_message_view');
  }

  public function executeBatchDelete(sfWebRequest $request)
  {
    $this->forward404();
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->forward404();
  }

  public function executeDelete(sfWebRequest $request)
  {
    $this->forward404();
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404();
  }
}
