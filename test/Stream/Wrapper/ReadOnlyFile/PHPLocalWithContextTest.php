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
 * Stream wrapper for read only access of a local file.
 *
 * @package    StreamHitching
 * @subpackage wrapper
 * @author     Christian Schaefer <caefer@ical.ly>
 */
class Stream_Wrapper_ReadOnlyFile_PHPLocalWithContext_Test extends Stream_Wrapper_ReadOnlyFile_PHPLocal_Test
{
  private $notifications = 0;

  public function stream_notification_callback($notification_code, $severity, $message, $message_code, $bytes_transferred, $bytes_max)
  {
    $this->notifications++;
  }

  protected function openFile()
  {
    $context = stream_context_create();
    stream_context_set_params($context, array("notification" => array($this, 'stream_notification_callback')));
    return fopen($this->url, 'r', false, $context);
  }
}


