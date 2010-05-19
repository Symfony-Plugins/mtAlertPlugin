<?php

class mtAlertDay
{
  const
    SUNDAY      = 0,
    MONDAY      = 1,
    TUESDAY     = 2,
    WEDNESDAY   = 3,
    THURSDAY    = 4,
    FRIDAY      = 5,
    SATURDAY    = 6;

  static protected
    $days = array(
      self::SUNDAY        => 'Sunday',
      self::MONDAY        => 'Monday',
      self::TUESDAY       => 'Tuesday',
      self::WEDNESDAY     => 'Wednesday',
      self::THURSDAY      => 'Thursday',
      self::FRIDAY        => 'Friday',
      self::SATURDAY      => 'Saturday',
    );

  static public function translate($string)
  {
    if (sfContext::hasInstance())
    {
      sfContext::getInstance()->getConfiguration()->loadHelpers('I18N');
      return __($string, array(), 'mt_alert_messages');
    }
    return $string;
  }

  static public function getDays()
  {
    return self::$days;
  }

  static public function getDaysRepresentation()
  {
    return array_values(self::$days);
  }

  static public function getDayIds()
  {
    return array_keys(self::$days);
  }

  static public function getRepresentationFor($id)
  {
    return isset(self::$days[$id])? self::translate(self::$days[$id]) : '';
  }

  static public function getOptions()
  {
    $opts = array();

    foreach (self::$days as $t => $s)
    {
      $opts[$t] = self::translate($s);
    }

    return $opts;
  }
}
