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

/** PHPUnit Framework */
require_once 'PHPUnit/Framework.php';
/** class autoloading if necessary */
require_once dirname(__FILE__).'/../../../bootstrap.php';

/**
 * This abstract test class includes most calls to PHPs filesystem functions.
 * All of these tests are expected to pass for StreamHitching streams and therefor are
 * inherited by the according test cases.
 *
 * @package    StreamHitchingTests
 * @subpackage filter
 * @author     Christian Schaefer <caefer@ical.ly>
 */
abstract class Stream_Wrapper_ReadOnlyFile_Abstract_Test extends PHPUnit_Framework_TestCase
{
  // -- filename operations ------

  public function testBasename()
  {
    $basename = basename($this->url);
    $this->assertType(PHPUnit_Framework_Constraint_IsType::TYPE_STRING, $basename, 'basename - Returns filename component of path');
    $this->assertEquals($this->basename, $basename, 'basename - Returns filename component of path');
  }

  public function testDirname()
  {
    $dirname = dirname($this->url);
    $this->assertType(PHPUnit_Framework_Constraint_IsType::TYPE_STRING, $dirname, 'dirname — Returns directory name component of path');
    $this->assertEquals($this->dirname, $dirname, 'dirname — Returns directory name component of path');
  }

  public function testPathinfo()
  {
    $info = pathinfo($this->url);
    $this->assertType(PHPUnit_Framework_Constraint_IsType::TYPE_ARRAY, $info, 'pathinfo — Returns information about a file path');
    $this->assertTrue(array_key_exists('dirname', $info), 'pathinfo — Returns information about a file path');
    $this->assertEquals($this->pathinfo['dirname'], $info['dirname'], 'pathinfo — Returns information about a file path');
    $this->assertTrue(array_key_exists('basename', $info), 'pathinfo — Returns information about a file path');
    $this->assertEquals($this->pathinfo['basename'], $info['basename'], 'pathinfo — Returns information about a file path');
    $this->assertTrue(array_key_exists('extension', $info), 'pathinfo — Returns information about a file path');
    $this->assertEquals($this->pathinfo['extension'], $info['extension'], 'pathinfo — Returns information about a file path');
    $this->assertTrue(array_key_exists('filename', $info), 'pathinfo — Returns information about a file path');
    $this->assertEquals($this->pathinfo['filename'], $info['filename'], 'pathinfo — Returns information about a file path');
  }

  // -- read only file access ----

  public function testFclose()
  {
    $fh = fopen($this->url, 'r');
    $this->assertTrue(fclose($fh), 'fclose — Closes an open file pointer');
  }

  public function testFeof()
  {
    $fh = fopen($this->url, 'r');
    $this->assertFalse(feof($fh), 'feof — Tests for end-of-file on a file pointer');
    fclose($fh);
  }

  public function testFgetc()
  {
    $fh = fopen($this->url, 'r');
    $character = fgetc($fh);
    $this->assertType(PHPUnit_Framework_Constraint_IsType::TYPE_STRING, $character, 'fgetc — Gets character from file pointer');
    $this->assertEquals('0', $character, 'fgetc — Gets character from file pointer');
    fclose($fh);
  }

  public function testFgets()
  {
    $fh = fopen($this->url, 'r');
    $line = fgets($fh);
    $this->assertType(PHPUnit_Framework_Constraint_IsType::TYPE_STRING, $line, 'fgets — Gets line from file pointer');
    fclose($fh);
  }

  public function testFgetss()
  {
    $fh = fopen($this->url, 'r');
    $line = fgetss($fh);
    $this->assertType(PHPUnit_Framework_Constraint_IsType::TYPE_STRING, $line, 'fgetss — Gets line from file pointer and strip HTML tags');
    $this->assertEquals('001 : 0000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000000'.PHP_EOL, $line, 'fgetss — Gets line from file pointer and strip HTML tags');
    fclose($fh);
  }

  public function testFile_get_contents()
  {
    $content = file_get_contents($this->url);
    $this->assertType(PHPUnit_Framework_Constraint_IsType::TYPE_STRING, $content, 'file_get_contents — Reads entire file into a string');
  }

  public function testFopen()
  {
    $fh = fopen($this->url, 'r');
    $this->assertFalse(false === $fh, 'fopen — Opens file or URL');
    fclose($fh);
  }

  public function testFpassthru()
  {
    $fh = fopen($this->url, 'r');
    ob_start();
    $size = fpassthru($fh);
    ob_end_clean();
    $this->assertType(PHPUnit_Framework_Constraint_IsType::TYPE_INT, $size, 'fpassthru — Output all remaining data on a file pointer');
    fclose($fh);
  }

  public function testFread()
  {
    $fh = fopen($this->url, 'r');
    $line = fread($fh, 10);
    $this->assertType(PHPUnit_Framework_Constraint_IsType::TYPE_STRING, $line, 'fread — Binary-safe file read');
    $this->assertEquals(10, strlen($line), 'fread — Binary-safe file read');
    fclose($fh);
  }

  public function testFscanf()
  {
    $fh = fopen($this->url, 'r');
    $info = fscanf($fh, '%3s : %s');
    $this->assertType(PHPUnit_Framework_Constraint_IsType::TYPE_ARRAY, $info, 'fscanf — Parses input from a file according to a format');
    $this->assertEquals('001', $info[0], 'fscanf — Parses input from a file according to a format');
    fclose($fh);
  }

  public function testFseek()
  {
    $fh = fopen($this->url, 'r');
    rewind($fh);
    $this->assertEquals(0, fseek($fh, 313, SEEK_SET), 'fseek — Seeks on a file pointer');
    $this->assertEquals(313, ftell($fh), 'fseek — Seeks on a file pointer');
    fclose($fh);
  }

  public function testFtell()
  {
    $fh = fopen($this->url, 'r');
    rewind($fh);
    $this->assertEquals(0, ftell($fh), 'ftell — Returns the current position of the file read/write pointer');
    fseek($fh, 313, SEEK_SET);
    $this->assertEquals(313, ftell($fh), 'ftell — Returns the current position of the file read/write pointer');
    fclose($fh);
  }

  public function testRewind()
  {
    $fh = fopen($this->url, 'r');
    rewind($fh);
    $this->assertFalse(feof($fh), 'rewind — Rewind the position of a file pointer');
    $this->assertEquals(0, ftell($fh), 'rewind — Rewind the position of a file pointer');
    fclose($fh);
  }

  // -- stat related operations --

  public function testFile_exists()
  {
    $this->assertTrue(file_exists($this->url), 'file_exists — Checks whether a file or directory exists');
  }

  public function testFile()
  {
    $lines = file($this->url);
    $this->assertType(PHPUnit_Framework_Constraint_IsType::TYPE_ARRAY, $lines, 'file — Reads entire file into an array');
  }

  public function testFileatime()
  {
    $time = fileatime($this->url);
    $this->assertType(PHPUnit_Framework_Constraint_IsType::TYPE_INT, $time, 'fileatime — Gets last access time of file');
  }

  public function testFilectime()
  {
    $time = filectime($this->url);
    $this->assertType(PHPUnit_Framework_Constraint_IsType::TYPE_INT, $time, 'filectime — Gets inode change time of file');
  }

  public function testFilegroup()
  {
    $group = filegroup($this->url);
    $this->assertType(PHPUnit_Framework_Constraint_IsType::TYPE_INT, $group, 'filegroup — Gets file group');
  }

  public function testFileinode()
  {
    $inode = fileinode($this->url);
    $this->assertType(PHPUnit_Framework_Constraint_IsType::TYPE_INT, $inode, 'fileinode — Gets file inode');
  }

  public function testFilemtime()
  {
    $time = filemtime($this->url);
    $this->assertType(PHPUnit_Framework_Constraint_IsType::TYPE_INT, $time, 'filemtime — Gets file modification time');
  }

  public function testFileowner()
  {
    $owner = fileowner($this->url);
    $this->assertType(PHPUnit_Framework_Constraint_IsType::TYPE_INT, $owner, 'fileowner — Gets file owner');
  }

  public function testFileperms()
  {
    $perms = fileperms($this->url);
    $this->assertType(PHPUnit_Framework_Constraint_IsType::TYPE_INT, $perms, 'fileperms — Gets file permissions');
  }

  public function testFilesize()
  {
    $size = filesize($this->url);
    $this->assertType(PHPUnit_Framework_Constraint_IsType::TYPE_INT, $size, 'filesize — Gets file size');
  }

  public function testFiletype()
  {
    $type = filetype($this->url);
    $this->assertType(PHPUnit_Framework_Constraint_IsType::TYPE_STRING, $type, 'filetype — Gets file type');
  }

  public function testFstat()
  {
    $fh = fopen($this->url, 'r');
    $stat = fstat($fh);
    $this->assertType(PHPUnit_Framework_Constraint_IsType::TYPE_ARRAY, $stat, 'fstat — Gets information about a file using an open file pointer');
    $this->assertTrue(array_key_exists('dev', $stat), 'fstat — Gets information about a file using an open file pointer');
    $this->assertTrue(array_key_exists('ino', $stat), 'fstat — Gets information about a file using an open file pointer');
    $this->assertTrue(array_key_exists('mode', $stat), 'fstat — Gets information about a file using an open file pointer');
    $this->assertTrue(array_key_exists('nlink', $stat), 'fstat — Gets information about a file using an open file pointer');
    $this->assertTrue(array_key_exists('uid', $stat), 'fstat — Gets information about a file using an open file pointer');
    $this->assertTrue(array_key_exists('gid', $stat), 'fstat — Gets information about a file using an open file pointer');
    $this->assertTrue(array_key_exists('rdev', $stat), 'fstat — Gets information about a file using an open file pointer');
    $this->assertTrue(array_key_exists('size', $stat), 'fstat — Gets information about a file using an open file pointer');
    $this->assertTrue(array_key_exists('atime', $stat), 'fstat — Gets information about a file using an open file pointer');
    $this->assertTrue(array_key_exists('mtime', $stat), 'fstat — Gets information about a file using an open file pointer');
    $this->assertTrue(array_key_exists('ctime', $stat), 'fstat — Gets information about a file using an open file pointer');
    $this->assertTrue(array_key_exists('blksize', $stat), 'fstat — Gets information about a file using an open file pointer');
    $this->assertTrue(array_key_exists('blocks', $stat), 'fstat — Gets information about a file using an open file pointer');
    fclose($fh);
  }

  public function testIs_dir()
  {
    $this->assertFalse(is_dir($this->url), 'is_dir — Tells whether the filename is a directory');
  }

  public function testIs_executable()
  {
    $this->assertFalse(is_executable($this->url), 'is_executable — Tells whether the filename is executable');
  }

  public function testIs_file()
  {
    $this->assertTrue(is_file($this->url), 'is_file — Tells whether the filename is a regular file');
  }

  public function testIs_link()
  {
    $this->assertFalse(is_link($this->url), 'is_link — Tells whether the filename is a symbolic link');
  }

  public function testIs_readable()
  {
    $this->assertTrue(is_readable($this->url), 'is_readable — Tells whether a file exists and is readable');
  }

  public function testIs_uploaded_file()
  {
    $this->assertFalse(is_uploaded_file($this->url), 'is_uploaded_file — Tells whether the file was uploaded via HTTP POST');
  }

  public function testIs_writable()
  {
    $this->assertFalse(is_writable($this->url), 'is_writable — Tells whether the filename is writable');
  }

  public function testStat()
  {
    $stat = stat($this->url);
    $this->assertType(PHPUnit_Framework_Constraint_IsType::TYPE_ARRAY, $stat, 'stat — Gives information about a file');
    $this->assertTrue(array_key_exists('dev', $stat), 'stat — Gives information about a file');
    $this->assertTrue(array_key_exists('ino', $stat), 'stat — Gives information about a file');
    $this->assertTrue(array_key_exists('mode', $stat), 'stat — Gives information about a file');
    $this->assertTrue(array_key_exists('nlink', $stat), 'stat — Gives information about a file');
    $this->assertTrue(array_key_exists('uid', $stat), 'stat — Gives information about a file');
    $this->assertTrue(array_key_exists('gid', $stat), 'stat — Gives information about a file');
    $this->assertTrue(array_key_exists('rdev', $stat), 'stat — Gives information about a file');
    $this->assertTrue(array_key_exists('size', $stat), 'stat — Gives information about a file');
    $this->assertTrue(array_key_exists('atime', $stat), 'stat — Gives information about a file');
    $this->assertTrue(array_key_exists('mtime', $stat), 'stat — Gives information about a file');
    $this->assertTrue(array_key_exists('ctime', $stat), 'stat — Gives information about a file');
    $this->assertTrue(array_key_exists('blksize', $stat), 'stat — Gives information about a file');
    $this->assertTrue(array_key_exists('blocks', $stat), 'stat — Gives information about a file');
  }

  // -- writing operations -------

  public function testCopy()
  {
    $this->assertTrue(copy($this->url, tempnam('/tmp', get_class($this))), 'copy — Copies file');
  }

  /**
   * @expectedException Exception
   */
  public function testFflush()
  {
    $fh = fopen($this->url, 'r');
    rewind($fh);
    fwrite($fh, 'Foo');
    $this->assertFalse(fflush($fh), 'fflush — Flushes the output to a file');
    fclose($fh);
  }

  /**
   * @expectedException Exception
   */
  public function testRename()
  {
    $this->assertFalse(rename($this->url, $this->fake_url), 'rename — Renames a file or directory');
  }

  /**
   * @expectedException PHPUnit_Framework_Error
   */
  public function testTouch()
  {
    touch($this->url);
  }

  /**
   * @expectedException Exception
   */
  public function testUnlink()
  {
    $this->assertFalse(unlink($this->url), 'unlink — Deletes a file');
  }

  /**
   * @expectedException Exception
   */
  public function testFlock()
  {
    $fh = fopen($this->url, 'r');
    $this->assertFalse(flock($fh, LOCK_SH), 'flock — Portable advisory file locking');
    fclose($fh);
  }

  /**
   * @expectedException Exception
   */
  public function testFile_put_contents()
  {
    $this->assertFalse(file_put_contents($this->url, 'Foo'), 'file_put_contents — Write a string to a file');
  }
}

