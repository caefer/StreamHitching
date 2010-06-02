<?php

interface Stream_Wrapper_ReadOnly_FileInterface
{
  //public $context;

  public function stream_open($path, $mode, $options, &$opened_path);
  public function stream_close();
  public function stream_flush();
  public function stream_stat();
  public function url_stat($path , $flags);
}
