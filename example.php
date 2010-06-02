<?php

require_once('Stream_Wrapper_ReadOnly_FileInterface.php');
require_once('Stream_Wrapper_Local_ReadOnly_File.php');
require_once('Stream_Wrapper_Filter_Decorator.php');
require_once('Stream_Wrapper_Filter_Decorator_Analyzer.php');
require_once('Stream_Source_FilterInterface.php');
require_once('Stream_Source_FilterAbstract.php');
require_once('Stream_Source_Filter.php');

$sourceFilter = new Stream_Source_Filter_Example(array('protocol' => 'new'));
#Stream_Wrapper_Filter_Decorator::registerWith($sourceFilter);
Stream_Wrapper_Filter_Decorator_Analyzer::registerWith($sourceFilter);
$url = $sourceFilter->encode(__FILE__);

stat($url);
$fh = fopen($url, 'r');
fstat($fh);
fclose($fh);
stat($url);
echo file_get_contents($url);

