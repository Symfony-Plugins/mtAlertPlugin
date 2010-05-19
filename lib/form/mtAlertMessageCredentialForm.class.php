<?php

/**
 * mtAlertMessageCredential form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class mtAlertMessageCredentialForm extends BasemtAlertMessageCredentialForm
{
  public function configure()
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');

    $this->setWidget('mt_alert_message_id', new sfWidgetFormInputHidden());
    $this->setWidget('mt_alert_message_id_read_only', new mtWidgetFormReadOnly());
    $this->setupCredentialField();

    $this->setValidator('mt_alert_message_id_read_only', new sfValidatorPass());
    $this->setValidator('mt_alert_message_id', new sfValidatorInteger(array('required' => true)));

    $this->setDefault('mt_alert_message_id_read_only', strval($this->getObject()->getmtAlertMessage()));

    $this->getWidgetSchema()->setLabel('mt_alert_message_id_read_only', __('Alert'));
    $this->getWidgetSchema()->moveField('mt_alert_message_id_read_only', 'first');
  }

  protected function setupCredentialField()
  {
    $credentials = is_array(mtAlertConfiguration::getCredentials())
        ? mtAlertConfiguration::getCredentials()
        : array(mtAlertConfiguration::getCredentials());

    if (empty($credentials))
    {
      $this->setWidget('credential', new sfWidgetFormInput());
    }
    else
    {
      $this->setWidget('credential', new sfWidgetFormChoice(
        array(
          'choices' => array_merge(
                         array(null => __('Please select a credential')),
                         array_combine(mtAlertConfiguration::getCredentials(), mtAlertConfiguration::getCredentials()))
        )));
    }
    $this->setValidator('credential', new sfValidatorString(array('required' => true)));
  }
}
