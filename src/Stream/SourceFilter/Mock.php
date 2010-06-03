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
 * Mock Stream_Source_Filter implementation
 *
 * @package    StreamHitching
 * @subpackage filter
 * @author     Christian Schaefer <caefer@ical.ly>
 */
class Stream_SourceFilter_Mock extends Stream_SourceFilter_Abstract
  implements Stream_SourceFilter_Interface
{
  /**
   * Accessor to the current objects options array.
   * @see Stream_SourceFilter_Interface
   *
   * @param  string $url Real url to be encoded
   * @return string      Stream URL (custom://...)
   */
  public function encode($url)
  {
    return $url;
  }

  /**
   * Accessor to the current objects options array.
   * @see Stream_SourceFilter_Interface
   *
   * @param  string $url Stream URL (custom://...) to be decoded
   * @return string      Real url
   */
  public function decode($url)
  {
    return $url;
  }
}
