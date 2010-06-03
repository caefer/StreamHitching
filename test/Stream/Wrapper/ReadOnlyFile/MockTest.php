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

/** require sources related to stream wrapper */
require_once dirname(__FILE__).'/../../../../src/Stream/Wrapper/ReadOnlyFile/Interface.php';
require_once dirname(__FILE__).'/../../../../src/Stream/Wrapper/ReadOnlyFile/Mock.php';
/** PHPUnit Framework */
require_once 'PHPUnit/Framework.php';

/**
 * Stream wrapper for read only access of a local file.
 *
 * @package    StreamHitching
 * @subpackage wrapper
 * @author     Christian Schaefer <caefer@ical.ly>
 */
class Stream_Wrapper_ReadOnlyFile_Mock_Test extends PHPUnit_Framework_TestCase
{
  public function testStream_close()
  {
    $this->wrapper->stream_close();
    $this->assertTrue(Stream_Wrapper_ReadOnlyFile_Mock::wasCalled('stream_close'));
  }

  public function testStream_eof()
  {
    $this->assertFalse($this->wrapper->stream_eof());
    $this->wrapper->stream_seek(10000, SEEK_SET);
    $this->assertTrue($this->wrapper->stream_eof());
    $this->assertTrue(Stream_Wrapper_ReadOnlyFile_Mock::wasCalled('stream_eof'));
  }

  public function testStream_flush()
  {
    $this->assertTrue($this->wrapper->stream_flush());
    $this->assertTrue(Stream_Wrapper_ReadOnlyFile_Mock::wasCalled('stream_flush'));
  }

  public function testStream_open()
  {
    $this->assertTrue($this->wrapper->stream_open('test://url', 'r'));
    $this->assertTrue(Stream_Wrapper_ReadOnlyFile_Mock::wasCalled('stream_open'));
  }

  public function testStream_read()
  {
    $this->assertEquals('mocked', $this->wrapper->stream_read(8192));
    $this->assertTrue(Stream_Wrapper_ReadOnlyFile_Mock::wasCalled('stream_read'));
  }

  public function testStream_seek()
  {
    $this->assertTrue($this->wrapper->stream_seek(10000, SEEK_SET));
    $this->assertEquals(6, $this->wrapper->stream_tell());
    $this->assertTrue($this->wrapper->stream_seek(3, SEEK_SET));
    $this->assertEquals(3, $this->wrapper->stream_tell());
    $this->assertTrue($this->wrapper->stream_seek(2, SEEK_CUR));
    $this->assertEquals(5, $this->wrapper->stream_tell());
    $this->assertTrue($this->wrapper->stream_seek(-2, SEEK_END));
    $this->assertEquals(4, $this->wrapper->stream_tell());
    $this->assertTrue(Stream_Wrapper_ReadOnlyFile_Mock::wasCalled('stream_seek'));
  }

  public function testStream_stat()
  {
    $stat = $this->wrapper->stream_stat();
    $this->assertArrayHasKey('mode', $stat);
    $this->assertEquals(0555, $stat['mode']);
    $this->assertArrayHasKey('size', $stat);
    $this->assertEquals(6, $stat['size']);
    $this->assertTrue(Stream_Wrapper_ReadOnlyFile_Mock::wasCalled('stream_stat'));
  }

  public function testStream_tell()
  {
    $this->wrapper->stream_seek(3, SEEK_SET);
    $this->assertEquals(3, $this->wrapper->stream_tell());
    $this->assertTrue(Stream_Wrapper_ReadOnlyFile_Mock::wasCalled('stream_tell'));
  }

  public function testUrl_stat()
  {
    $stat = $this->wrapper->url_stat();
    $this->assertArrayHasKey('mode', $stat);
    $this->assertEquals(0555, $stat['mode']);
    $this->assertArrayHasKey('size', $stat);
    $this->assertEquals(6, $stat['size']);
    $this->assertTrue(Stream_Wrapper_ReadOnlyFile_Mock::wasCalled('url_stat'));
  }

  protected function setUp()
  {
    $this->wrapper = new Stream_Wrapper_ReadOnlyFile_Mock();
  }
}

