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
 * A Stream_Wrapper_Filter_Decorator can be registered as a stream.
 * It uses the decorator pattern to forward calls to the stream wrapper
 * interface to its $wrapper member filtering all paths using a
 * Stream_Source_Filter instance that was passed to registerWith().
 *
 * @package    StreamHitching
 * @subpackage decorator
 * @author     Christian Schaefer <caefer@ical.ly>
 */
class Stream_Wrapper_Filter_Decorator
{
  /**
   * @var Stream_Wrapper_ReadOnly_FileInterface $wrapper
   */
  private $wrapper;

  /**
   * @staticVar Stream_Source_FilterInterface $filter
   */
  private static $filter;

  /**
   *
   */
  public function __call($method, $arguments)
  {
    $this->initWrapper();

    if(!method_exists($this->wrapper, $method))
    {
      throw new Exception(get_class($this->wrapper).' does not implement '.$method.'()!');
    }

    $this->filter(&$arguments);
    return call_user_func_array(array($this->wrapper, $method), $arguments);
  }

  /**
   *
   */
  private function filter($arguments)
  {
    foreach($arguments as $key => $value)
    {
      if(false !== strpos($value, '://'))
      {
        $arguments[$key] = self::$filter->decode($value);
      }
    }
  }

  /**
   *
   */
  private function initWrapper()
  {
    if(!isset($this->wrapper))
    {
      $className = self::$filter->getOption('wrapper_class');
      $this->wrapper = new $className();
    }
  }

  /**
   *
   */
  public static function registerWith(Stream_Source_FilterInterface $filter)
  {
    self::$filter = $filter;
    stream_wrapper_register($filter->getOption('protocol'), __CLASS__);
  }
}
