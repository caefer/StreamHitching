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
 * Interface for Stream_Source_Filter to be used in Stream_Wrapper_Filter_Decorator
 *
 * @package    StreamHitching
 * @subpackage filter
 * @author     Christian Schaefer <caefer@ical.ly>
 */
interface Stream_Source_FilterInterface
{
  /**
   * Accessor to the current objects options array.
   *
   * @param  string $name Name of the option
   * @return mixed        Value of the option in question
   */
  public function getOption($name);

  /**
   * Accessor to the current objects options array.
   *
   * @param  string $url Real url to be encoded
   * @return string      Stream URL (custom://...)
   */
  public function encode($url);

  /**
   * Accessor to the current objects options array.
   *
   * @param  string $url Stream URL (custom://...) to be decoded
   * @return string      Real url
   */
  public function decode($url);
}
