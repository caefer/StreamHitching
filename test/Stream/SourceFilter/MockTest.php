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

/** require sources related to stream sourcefilter */
require_once dirname(__FILE__).'/../../../src/Stream/SourceFilter/Interface.php';
require_once dirname(__FILE__).'/../../../src/Stream/SourceFilter/Abstract.php';
require_once dirname(__FILE__).'/../../../src/Stream/SourceFilter/Mock.php';
/** PHPUnit Framework */
require_once 'PHPUnit/Framework.php';

/**
 * Mock Stream_SourceFilter implementation
 *
 * @package    StreamHitchingTests
 * @subpackage filter
 * @author     Christian Schaefer <caefer@ical.ly>
 */
class Stream_SourceFilter_Mock_Test extends PHPUnit_Framework_TestCase
{
  /**
   * @expectedException Exception
   */
  public function testEncodeExceptionMissingWrapperClass()
  {
    $filter = new Stream_SourceFilter_Mock(array('wrapper_class' => 'Stream_Wrapper_ReadOnlyFile_Local'));
  }

  /**
   * @expectedException Exception
   */
  public function testEncodeExceptionMissingProtocol()
  {
    $filter = new Stream_SourceFilter_Mock(array('protocol' => 'test'));
  }

  public function testEncode()
  {
    $this->assertEquals(__FILE__, $this->getFilter()->encode(__FILE__));
  }

  public function testDecode()
  {
    $this->assertEquals(__FILE__, $this->getFilter()->decode(__FILE__));
  }

  protected function getFilter()
  {
    return new Stream_SourceFilter_Mock(array(
      'protocol' => 'test',
      'wrapper_class' => 'Stream_Wrapper_ReadOnlyFile_Local'
    ));
  }
}
