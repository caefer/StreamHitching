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
 * Stream wrapper interface for read only access of a file.
 *
 * @package    StreamHitching
 * @subpackage wrapper
 * @author     Christian Schaefer <caefer@ical.ly>
 */
interface Stream_Wrapper_ReadOnlyFile_Interface
{
  //public $context;

  /**
   *
   *
   * @param  
   * @return void
   */
  public function stream_open($path, $mode, $options, &$opened_path);

  /**
   *
   *
   * @param  
   * @return void
   */
  public function stream_close();

  /**
   *
   *
   * @param  
   * @return void
   */
  public function stream_flush();

  /**
   *
   *
   * @param  
   * @return void
   */
  public function stream_stat();

  /**
   *
   *
   * @param  
   * @return void
   */
  public function url_stat($path , $flags);
}
