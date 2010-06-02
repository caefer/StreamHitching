<?php

class Stream_Wrapper_Local_ReadOnly_File implements Stream_Wrapper_ReadOnly_FileInterface
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
    var_dump($this->context);
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
