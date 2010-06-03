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

/** require sources related to stream wrapper decorator */
require_once dirname(__FILE__).'/../../../../src/Stream/Wrapper/Decorator.php';
require_once dirname(__FILE__).'/../../../../src/Stream/Wrapper/Decorator/Analyzer.php';
/** require sources related to stream wrapper */
require_once dirname(__FILE__).'/../../../../src/Stream/Wrapper/ReadOnlyFile/Interface.php';
require_once dirname(__FILE__).'/../../../../src/Stream/Wrapper/ReadOnlyFile/Mock.php';
/** require sources related to stream sourcefilter */
require_once dirname(__FILE__).'/../../../../src/Stream/SourceFilter/Interface.php';
require_once dirname(__FILE__).'/../../../../src/Stream/SourceFilter/Abstract.php';
require_once dirname(__FILE__).'/../../../../src/Stream/SourceFilter/Mock.php';
/** PHPUnit Framework */
require_once 'PHPUnit/Framework.php';

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
class Stream_Wrapper_Decorator_Analyzer_Test extends PHPUnit_Framework_TestCase
{
  public function testFileAccessIsAnalized()
  {
    ob_start();
    stat('test://'.__FILE__);
    $output = ob_get_contents();
    ob_end_clean();
    $this->assertContains('called: url_stat', $output);
    $this->assertContains('{main}', $output);
  }

  public function testServiceIsRegistered()
  {
    $this->assertContains('test', stream_get_wrappers());
  }

  protected function setUp()
  {
    $sourceFilter = new Stream_SourceFilter_Mock(array(
      'protocol' => 'test',
      'wrapper_class' => 'Stream_Wrapper_ReadOnlyFile_Mock'
    ));
    Stream_Wrapper_Decorator_Analyzer::registerWith($sourceFilter);
  }
}

