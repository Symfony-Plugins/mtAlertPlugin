<?php

/**
 * mtAlertMessage filter form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage filter
 * @author     ##AUTHOR_NAME##
 */
class mtAlertMessageFormFilter extends BasemtAlertMessageFormFilter
{
  public function configure()
  {
    sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');

    foreach (array('title', 'message', 'condition_description') as $f)
    {
      $this->getWidget($f)->setOption('empty_label', __('is empty', array(), 'mt_alert_message'));
    }

    foreach (array('is_active', 'can_be_hidden_permanently', 'show_to_all', 'can_be_mailed', 'show_in_browser') as $name)
    {
      $this->getWidget($name)->setOption('choices', array('' => __('yes or no', array(), 'mt_alert_messages'),
                                                           1 => __('yes', array(), 'mt_alert_messages'),
                                                           0 => __('no', array(), 'mt_alert_messages')));
    }


    $this->getWidgetSchema()->setLabels(array(
      'will_be_shown_when' => 'Shown when'
    ));
    unset($this['partial'], $this['condition_class'], $this['condition_method']);
  }
}
