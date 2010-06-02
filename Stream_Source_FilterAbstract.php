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
 * Abstract class implementing the organisational parts of a Stream_Source_Filter.
 * Implements getOption() from Stream_Source_FilterInterface
 * @abstract
 *
 * @package    StreamHitching
 * @subpackage filter
 * @author     Christian Schaefer <caefer@ical.ly>
 */
abstract class Stream_Source_FilterAbstract
{
  /**
   * @var array $options Options set for the current Stream_Source_Filter implementation
   */
  protected $options = array();

  /**
   * C'tor. Setting options.
   *
   * @param  array $options Options set for the current implementation. Must contain 'wrapper_class' and 'protocol'.
   * @return void
   */
  public function __construct(array $options)
  {
    $this->options = array_merge($this->options, $options);

    if(!array_key_exists('wrapper_class', $this->options))
    {
      throw new Exception('wrapper_class option was not set!');
    }

    if(!array_key_exists('protocol', $this->options))
    {
      throw new Exception('protocol option was not set!');
    }
  }

  /**
   * Sets Stream_Source_Filter on passed Stream_Wrapper_Filter_Decorator and registers stream wrapper.
   *
   * @param  string $decoratorClassName Class name for the Stream_Wrapper_Filter_Decorator to use
   * @return void
   */
  public function registerWith($decoratorClassName)
  {
    call_user_func(array($decoratorClassName, 'setSourceFilter'), $this);
    if(in_array($this->options['protocol'], stream_get_wrappers()))
    {
      stream_wrapper_unregister($this->options['protocol']);
    }
    stream_wrapper_register($this->options['protocol'], $decoratorClassName);
  }

  /**
   * Accessor to the current objects options array.
   * @see Stream_Source_FilterInterface
   *
   * @param  string $name Name of the option
   * @return mixed        Value of the option in question
   */
  public function getOption($name)
  {
    return $this->options[$name];
  }
}
