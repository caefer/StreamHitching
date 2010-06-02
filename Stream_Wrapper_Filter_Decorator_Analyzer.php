<?php

class Stream_Wrapper_Filter_Decorator_Analyzer extends Stream_Wrapper_Filter_Decorator
{
  public function __call($method, $arguments)
  {
    $e = new Exception("test");
    echo '#~ called: '.$method;
    echo '('.implode(', ', $arguments).')'.PHP_EOL;
    echo $e->getTraceAsString().PHP_EOL.PHP_EOL;

    return parent::__call($method, $arguments);
  }

  public static function registerWith(Stream_Source_FilterInterface $filter)
  {
    parent::registerWith($filter);
    stream_wrapper_unregister($filter->getOption('protocol'));
    stream_wrapper_register($filter->getOption('protocol'), __CLASS__);
  }
}

