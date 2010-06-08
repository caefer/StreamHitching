<?php

function autoload($className)
{
  $path = str_replace('_', '/', $className).'.php';
  $path = str_replace('/Test', 'Test', $path);
  list($file) = glob(getcwd().'/src/'.$path) + glob(getcwd().'/test/'.$path);
  if(!empty($file))
  {
    require_once($file);
    return true;
  }
  else
  {
    echo $className.' could not be found..'.PHP_EOL;
    return false;
  }
}

spl_autoload_register('autoload');
