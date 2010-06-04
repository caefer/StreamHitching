<?php

require_once 'PHPUnit/Framework.php';
require_once dirname(__FILE__).'/Stream/SourceFilter/MockTest.php';
require_once dirname(__FILE__).'/Stream/Wrapper/DecoratorTest.php';
require_once dirname(__FILE__).'/Stream/Wrapper/Decorator/AnalizerTest.php';
require_once dirname(__FILE__).'/Stream/Wrapper/ReadOnlyFile/LocalTest.php';
require_once dirname(__FILE__).'/Stream/Wrapper/ReadOnlyFile/MockTest.php';
require_once dirname(__FILE__).'/Stream/Wrapper/ReadOnlyFile/RemoteTest.php';

class StreamHitchingTests
{
  public static function suite()
  {
    $suite = new PHPUnit_Framework_TestSuite('StreamHitching');
    $suite->addTestSuite('Stream_SourceFilter_Mock_Test');
    $suite->addTestSuite('Stream_Wrapper_Decorator_Test');
    $suite->addTestSuite('Stream_Wrapper_Decorator_Analyzer_Test');
    $suite->addTestSuite('Stream_Wrapper_ReadOnlyFile_Local_Test');
    $suite->addTestSuite('Stream_Wrapper_ReadOnlyFile_Mock_Test');
    $suite->addTestSuite('Stream_Wrapper_ReadOnlyFile_Remote_Test');
    return $suite;
  }
}
