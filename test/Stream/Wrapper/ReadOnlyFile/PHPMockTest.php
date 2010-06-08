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
 * Stream wrapper for read only access of a local file.
 *
 * @package    StreamHitching
 * @subpackage wrapper
 * @author     Christian Schaefer <caefer@ical.ly>
 */
class Stream_Wrapper_ReadOnlyFile_PHPMock_Test extends Stream_Wrapper_ReadOnlyFile_Abstract_Test
{
  protected $url = '/../../../fixtures/10100bytes.txt';
  protected $basename = '10100bytes.txt';
  protected $dirname = 'moo:///home/caefer/projects/StreamHitching/test/Stream/Wrapper/ReadOnlyFile';
  protected $pathinfo = array(
    'dirname' => 'moo:///home/caefer/projects/StreamHitching/test/Stream/Wrapper/ReadOnlyFile',
    'basename' => '10100bytes.txt',
    'extension' => 'txt',
    'filename' => '10100bytes'
  );
  protected $fake_url = "moo://does/not.exist";

  protected function setUp()
  {
    ini_set('display_errors',1);
    error_reporting(E_ALL|E_STRICT);
    if(in_array('moo', stream_get_wrappers()))
    {
      stream_wrapper_unregister('moo');
    }
    $sourceFilter = new Stream_SourceFilter_Mock(array(
      'protocol' => 'moo',
      'wrapper_class' => 'Stream_Wrapper_ReadOnlyFile_Mock'
    ));
    Stream_Wrapper_Decorator::registerWith($sourceFilter);
    #Stream_Wrapper_Decorator_Analyzer::registerWith($sourceFilter);
    $this->url = dirname(__FILE__).'/../../../fixtures/10100bytes.txt';
    $this->dirname = 'moo://'.dirname($this->url);
    $this->pathinfo['dirname'] = $this->dirname;
    $this->url = $sourceFilter->encode($this->url);
  }
}

