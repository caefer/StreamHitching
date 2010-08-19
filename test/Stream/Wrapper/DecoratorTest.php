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
 * A Stream_Wrapper_Decorator can be registered as a stream.
 * It uses the decorator pattern to forward calls to the stream wrapper
 * interface to its $wrapper member filtering all paths using a
 * Stream_SourceFilter instance that was passed to registerWith().
 *
 * @package    StreamHitchingTests
 * @subpackage decorator
 * @author     Christian Schaefer <caefer@ical.ly>
 */
class Stream_Wrapper_Decorator_Test extends PHPUnit_Framework_TestCase
{
  public function testFileAccessIsDeligatedToStreamWrapper()
  {
    $fh = fopen('test://'.__FILE__, 'r');
    $this->assertTrue(Stream_Wrapper_ReadOnlyFile_Mock::wasCalled('stream_open'));
  }

  /**
   * @expectedException Exception
   */
  public function testUnlinkNotImplemented()
  {
    unlink('test://'.__FILE__);
  }

  public function testServiceIsRegistered()
  {
    $this->assertContains('test', stream_get_wrappers());
  }

  protected function setUp()
  {
    if (in_array('test', stream_get_wrappers()) === true) {
      stream_wrapper_unregister('test');
    }
    $sourceFilter = new Stream_SourceFilter_Mock(array(
      'protocol' => 'test',
      'wrapper_class' => 'Stream_Wrapper_ReadOnlyFile_Mock'
    ));
    Stream_Wrapper_Decorator::registerWith($sourceFilter);
  }
}
