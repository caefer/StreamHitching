<?php

set_include_path(get_include_path().PATH_SEPARATOR.dirname(__FILE__).'/../source/');

require_once('Stream/Wrapper/ReadOnlyFile/Interface.php');
require_once('Stream/Wrapper/ReadOnlyFile/Local.php');
require_once('Stream/Wrapper/Decorator.php');
require_once('Stream/Wrapper/Decorator/Analyzer.php');
require_once('Stream/SourceFilter/Interface.php');
require_once('Stream/SourceFilter/Abstract.php');
require_once('Stream/SourceFilter/Example.php');

$sourceFilter = new Stream_SourceFilter_Example(array('protocol' => 'new'));
#Stream_Wrapper_Decorator::registerWith($sourceFilter);
Stream_Wrapper_Decorator_Analyzer::registerWith($sourceFilter);
$url = $sourceFilter->encode(__FILE__);

stat($url);
$fh = fopen($url, 'r');
fstat($fh);
fclose($fh);
stat($url);
echo file_get_contents($url);

