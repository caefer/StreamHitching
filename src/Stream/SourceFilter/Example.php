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
 * Example Stream_Source_Filter implementation
 *
 * @package    StreamHitching
 * @subpackage filter
 * @author     Christian Schaefer <caefer@ical.ly>
 */
class Stream_SourceFilter_Example extends Stream_SourceFilter_Abstract
  implements Stream_SourceFilter_Interface
{
  /**
   * @var array $options Options set for the current Stream_SourceFilter implementation
   */
  protected $options = array(
    'wrapper_class' => 'Stream_Wrapper_ReadOnlyFile_Local',
    'protocol'      => 'example'
  );

  /**
   * Accessor to the current objects options array.
   * @see Stream_SourceFilter_Interface
   *
   * @param  string $url Real url to be encoded
   * @return string      Stream URL (custom://...)
   */
  public function encode($url)
  {
    return $this->options['protocol'].'://'.$url;
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
    return str_replace($this->options['protocol'].'://', 'file://', $url);
  }
}
