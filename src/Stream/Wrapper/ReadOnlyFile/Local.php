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
 * Stream wrapper for read only access of a local file.
 *
 * @package    StreamHitching
 * @subpackage wrapper
 * @author     Christian Schaefer <caefer@ical.ly>
 */
class Stream_Wrapper_ReadOnlyFile_Local implements Stream_Wrapper_ReadOnlyFile_Interface
{
  /**
   * resource context
   *
   * @var resource
   */
  public $context;

  /**
   * resource handle
   *
   * @var resource
   */
  protected $resource;

  /**
   * Close an resource
   *
   * @return void
   */
  public function stream_close()
  {
    return fclose($this->resource);
  }

  /**
   * Tests for end-of-file on a file pointer
   *
   * @return bool
   */
  public function stream_eof()
  {
    return feof($this->resource);
  }

  /**
   * Flushes the output
   *
   * @return bool
   */
  public function stream_flush()
  {
    return fflush($this->resource);
  }

  /**
   * Opens file or URL
   *
   * @param string $path
   * @param string $mode
   * @param int $options
   * @param string &$opened_path
   * @return bool
   */
  public function stream_open($path, $mode, $options, &$opened_path)
  {
    $this->resource = fopen($path, $mode, $options & STREAM_USE_PATH);
    return false !== $this->resource;
  }

  /**
   * Read from stream
   *
   * @param int $count
   * @return string
   */
  public function stream_read($count)
  {
    return fread($this->resource, $count);
  }

  /**
   * Seeks to specific location in a stream
   *
   * @param int  $offset
   * @param int  $whence
   * @return bool
   */
  public function stream_seek($offset, $whence = SEEK_SET)
  {
    return 0 == fseek($this->resource, $offset, $whence);
  }

  /** 
   * Retrieve information about a file resource
   * 
   * @return array 
   */ 
  /**
   * Read from stream
   *
   * @param int $count
   * @return string
   */
  public function stream_stat()
  {
    return fstat($this->resource);
  }

  /** 
   * Retrieve the current position of a stream
   * 
   * @return int 
   */ 
  public function stream_tell()
  {
    return ftell($this->resource);
  }

  /**
   * Retrieve information about a file
   *
   * @param string $path
   * @param int $flags
   * @return array
   */
  public function url_stat($path , $flags)
  {
    return stat($path);
  }
}
