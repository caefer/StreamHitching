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
class Stream_Wrapper_ReadOnlyFile_HTTP implements Stream_Wrapper_ReadOnlyFile_Interface
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
   * file size of remote resource
   *
   * @var int
   */
  protected $filesize = 1;

  /**
   * file size of remote resource
   *
   * @var int
   */
  protected $filesize_detected = false;

  /**
   * file pointer position of remote resource
   *
   * @var int
   */
  protected $position = 0; // set to 1 initially so eof is not true

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
    return $this->position >= $this->filesize;
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
    $chunk = fread($this->resource, $count);
    $this->position = ftell($this->resource);
    $this->filesize = $this->position;
    if(strlen($chunk) >= $count)
    {
      $this->filesize++;
    }
    else
    {
      $this->filesize_detected = true;
    }
    return $chunk;
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
    switch($whence)
    {
      case SEEK_SET:
        $this->position = $offset;
        break;
      case SEEK_CUR:
        $this->position += $offset;
        break;
      case SEEK_END:
        while(!$this->filesize_detected)
        {
          $this->stream_read(8192);
        }
        $this->position = $this->filesize + $offset;
        break;
    }
    return true;
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
    $stat = array();
    $stat['dev'] = 0;
    $stat['ino'] = 0;
    $stat['mode'] = 0444;
    $stat['nlink'] = 0;
    $stat['uid'] = 0;
    $stat['gid'] = 0;
    $stat['rdev'] = 0;
    $stat['size'] = 0;
    $stat['atime'] = 0;
    $stat['mtime'] = 0;
    $stat['ctime'] = 0;
    $stat['blksize'] = 0;
    $stat['blocks'] = 0;
    $stat['size'] = $this->filesize;
    $stat['atime'] = time();
    $stat['mode'] |= 0100000;
    return $stat;
  }

  /** 
   * Retrieve the current position of a stream
   * 
   * @return int 
   */ 
  public function stream_tell()
  {
    return $this->position;
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
    $fh = fopen($path, 'r');
    while(!feof($fh))
    {
      fread($fh, 8192);
    }
    $this->filesize = ftell($fh);
    return $this->stream_stat();
  }
}
