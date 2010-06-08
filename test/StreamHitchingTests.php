<?php

/** PHPUnit Framework */
require_once 'PHPUnit/Framework.php';
/** Autoloading classes if necessary */
require_once dirname(__FILE__).'/bootstrap.php';

class StreamHitchingTests
{
  public static function suite()
  {
    $suite = new PHPUnit_Framework_TestSuite('StreamHitching');
    $suite->addTestSuite('Stream_SourceFilter_Mock_Test');
    $suite->addTestSuite('Stream_Wrapper_Decorator_Test');
    $suite->addTestSuite('Stream_Wrapper_Decorator_Analyzer_Test');
    $suite->addTestSuite('Stream_Wrapper_ReadOnlyFile_PHPLocal_Test');
    $suite->addTestSuite('Stream_Wrapper_ReadOnlyFile_PHPHTTP_Test');
    #$suite->addTestSuite('Stream_Wrapper_ReadOnlyFile_Local_Test');
    #$suite->addTestSuite('Stream_Wrapper_ReadOnlyFile_Mock_Test');
    #$suite->addTestSuite('Stream_Wrapper_ReadOnlyFile_HTTP_Test');
    return $suite;
  }
}
