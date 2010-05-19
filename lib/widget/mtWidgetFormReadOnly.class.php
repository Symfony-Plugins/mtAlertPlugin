<?php


/**
 *
 * Options:
 *
*/
class mtWidgetFormReadOnly extends sfWidgetForm
{
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $input_hidden = new sfWidgetFormInputHidden();
    $value.= $input_hidden->render($name, $value);

    return strval($value);
  }
}

