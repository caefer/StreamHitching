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

/*
  public void stream_close();
  public bool stream_eof();
  public bool stream_flush();
  public bool stream_lock($operation);
  public bool stream_open($path, $mode, $options, &$opened_path);
  public string stream_read($count);
  public bool stream_seek($offset, $whence);
  public bool stream_set_option($option, $arg1, $arg2);
  public array stream_stat();
  public int stream_tell();
*/

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
