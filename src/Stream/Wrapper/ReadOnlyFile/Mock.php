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
class Stream_Wrapper_ReadOnlyFile_Mock implements Stream_Wrapper_ReadOnlyFile_Interface
{
  public $context;
  private $position = 0;
  private $content = 'mocked';
  protected static $calls = array(
    'stream_close' => false,
    'stream_eof'   => false,
    'stream_flush' => false,
    'stream_open'  => false,
    'stream_read'  => false,
    'stream_seek'  => false,
    'stream_stat'  => false,
    'stream_tell'  => false,
    'url_stat'     => false
  );

  public function stream_close()
  {
    self::$calls[__FUNCTION__] = true;
  }

  public function stream_eof()
  {
    self::$calls[__FUNCTION__] = true;
    return $this->position >= strlen($this->content);
  }

  public function stream_flush()
  {
    self::$calls[__FUNCTION__] = true;
    return true;
  }

  public function stream_open($path, $mode, $options, &$opened_path)
  {
    self::$calls[__FUNCTION__] = true;
    return true;
  }

  public function stream_read($count)
  {
    if(self::$calls[__FUNCTION__]) return false;
    self::$calls[__FUNCTION__] = true;
    return $this->content;
  }

  public function stream_seek($offset, $whence)
  {
    self::$calls[__FUNCTION__] = true;
    switch($whence)
    {
      case SEEK_SET:
        $this->position = $offset;
        break;
      case SEEK_CUR:
        $this->position += $offset;
        break;
      case SEEK_END:
        $this->position = strlen($this->content) + $offset;
        break;
    }
    $this->position = min(strlen($this->content), $this->position);
    $this->position = max(0, $this->position);
    return true;
  }

  public function stream_stat()
  {
    self::$calls[__FUNCTION__] = true;
    return array(
      'mode' => 0555,
      'size' => strlen($this->content)
    );
  }

  public function stream_tell()
  {
    self::$calls[__FUNCTION__] = true;
    return $this->position;
  }

  public function url_stat($path, $flags)
  {
    self::$calls[__FUNCTION__] = true;
    return array(
      'mode' => 0555,
      'size' => strlen($this->content)
    );
  }

  public static function wasCalled($methodName)
  {
    return self::$calls[$methodName];
  }
}
