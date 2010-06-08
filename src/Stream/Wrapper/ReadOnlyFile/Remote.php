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
class Stream_Wrapper_ReadOnlyFile_Remote implements Stream_Wrapper_ReadOnlyFile_Interface
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
  protected $filesize = 0;

  /**
   * file pointer position of remote resource
   *
   * @var int
   */
  protected $position = 1; // set to 1 initially so eof is not true

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
    #$headers = get_headers($path, 1);
    #$this->filesize = $headers['Content-Length'];
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
    $this->position += strlen($chunk);
    #$this->filesize += strlen($chunk);
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
        $this->position = $this->filesize + $offset;
        break;
    }
    $this->position = min($this->filesize, $this->position);
    $this->position = max(0, $this->position);
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
    $stat['mode'] = 0777;
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
    $headers = get_headers($path, 1);
    if(array_key_exists('Content-Length', $headers))
    {
      $this->filesize = $headers['Content-Length'];
    }
    else
    {
      $this->filesize = -1;
    }
    return $this->stream_stat();
  }
}
