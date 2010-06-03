<?php
/**
 * This file is part of the StreamHitching package.
 * (c) 2010 Christian Schaefer <caefer@ical.ly>>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package    StreamHitching
 * @author     Christian Schaefer <caefer@ical.ly>
 * @version    SVN: $Id: $
 */

/**
 * Decorator with added debugging output
 * @see Stream_Wrapper_Filter_Decorator
 *
 * @package    StreamHitching
 * @subpackage decorator
 * @author     Christian Schaefer <caefer@ical.ly>
 */
class Stream_Wrapper_Decorator_Analyzer extends Stream_Wrapper_Decorator
{
  public function __call($method, $arguments)
  {
    $e = new Exception("test");
    echo '#~ called: '.$method;
    echo '('.implode(', ', $arguments).')'.PHP_EOL;
    echo $e->getTraceAsString().PHP_EOL.PHP_EOL;

    return parent::__call($method, $arguments);
  }

  public static function registerWith(Stream_SourceFilter_Interface $filter)
  {
    parent::registerWith($filter);
    stream_wrapper_unregister($filter->getOption('protocol'));
    stream_wrapper_register($filter->getOption('protocol'), __CLASS__);
  }
}

