<?php

/**
 * mtAlertMessageUser form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class mtAlertMessageUserForm extends BasemtAlertMessageUserForm
{
  public function configure()
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');

    $this->setWidget('mt_alert_message_id', new sfWidgetFormInputHidden());
    $this->setWidget('mt_alert_message_id_read_only', new mtWidgetFormReadOnly());

    $this->setValidator('mt_alert_message_id_read_only', new sfValidatorPass());
    $this->setValidator('mt_alert_message_id', new sfValidatorInteger(array('required' => true)));

    $this->setDefault('mt_alert_message_id_read_only', strval($this->getObject()->getmtAlertMessage()));

    $this->setWidget('username', new sfWidgetFormInput());
    $this->setValidator('username', new sfValidatorString(array('required' => true)));

    $this->getWidgetSchema()->setLabel('mt_alert_message_id_read_only', __('Alert'));
    $this->getWidgetSchema()->moveField('mt_alert_message_id_read_only', 'first');
  }
}
