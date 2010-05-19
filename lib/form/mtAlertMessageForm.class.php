<?php

/**
 * mtAlertMessage form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 */
class mtAlertMessageForm extends BasemtAlertMessageForm
{
  public function configure()
  {
    parent::configure();

    $this->configureWidgets();
    $this->configureValidators();
    $this->configureLabels();
    $this->configureHelp();

    $this->setDefaults(array(
      'day_list'              => mtAlertDay::getDayIds(),
    ));
  }

  public function configureLabels()
  {
    $this->getWidgetSchema()->setLabels(array(
      'day_list'    => 'Will be shown on',
      'show_to_all' => 'Show to everyone',
    ));
  }

  public function configureWidgets()
  {
    if (mtAlertConfiguration::getEnableRichText())
    {
      $this->setWidget('message', new sfWidgetFormTextareaTinyMCE(array('theme' => mtAlertConfiguration::getTinyMCETheme())));
    }
    $this->setWidget('day_list', new sfWidgetFormSelectCheckbox(array('choices' => mtAlertDay::getOptions())));
  }

  public function configureValidators()
  {
    $this->setValidator('day_list', new sfValidatorChoiceMany(array('choices' => mtAlertDay::getDayIds())));
  }

  protected function configureHelp()
  {
    $this->getWidgetSchema()->setHelps(array(
      'title'                     => 'The title of the alert will be used as subject of the corresponding mail.',
      'message'                   => 'Full description of the alert\'s purpose.',
      'can_be_hidden_permanently' => 'If this is checked, the user will be able to hide this alert permanently.',
      'condition_description'     => 'A short text that describes when the alert is shown.',
      'condition_class'           => 'Class that will be user to check the condition. If empty the alert will always be shown.',
      'condition_method'          => 'Method of previously entered class. If this method returns true, the alert will be shown. If empty the alert will always be shown.',
      'show_to_all'               => 'If checked the alert will be shown to everyone.',
      'can_be_mailed'             => 'If the alert can be mailed when runing the "sendMail" task.',
      'show_in_browser'           => 'If checked the alert will be shown in web browsers.',
      'partial'                   => 'The full path to a partial as in "module/action". Will be appended to the message of the alert.',
      'day_list'                  => 'The alert will be shown in the checked days.',
    ));
  }

  protected function doSave($con = null)
  {
    parent::doSave($con);
    $this->doSaveDayList($con);
  }

  protected function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();
    if (!$this->isNew)
    {
      $this->setDefault('day_list', $this->getObject()->getmtAlertMessageDayConstants());
    }
  }

  protected function doSaveDayList($con)
  {
    if (isset($this['day_list']))
    {
      $criteria = new Criteria();
      $criteria->add(mtAlertMessageDayPeer::MT_ALERT_MESSAGE_ID, $this->getObject()->getId());
      mtAlertMessageDayPeer::doDelete($criteria);
      foreach ($this->getValue('day_list') as $dayId)
      {
        $md = new mtAlertMessageDay();
        $md->setmtAlertMessageId($this->getObject()->getId());
        $md->setmtAlertDayId($dayId);
        $md->save($con);
      }
    }
  }
}
