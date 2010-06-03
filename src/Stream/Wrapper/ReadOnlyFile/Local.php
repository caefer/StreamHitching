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
  public $context;
  private $resource;
  public function stream_open($path, $mode, $options, &$opened_path)
  {
    $this->resource = fopen($path, $mode, $options & STREAM_USE_PATH);
    return false !== $this->resource;
  }
  public function stream_close()
  {
    return fclose($this->resource);
  }
  public function stream_flush()
  {
    return fflush($this->resource);
  }
  public function stream_stat()
  {
    return fstat($this->resource);
  }
  public function url_stat($path , $flags)
  {
    return stat($path);
  }
}
