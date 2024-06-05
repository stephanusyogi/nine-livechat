<?php

namespace App;

class Constants
{
  const VIDEOTRON_FLAG_BACKGROUND = 'color';
  const VIDEOTRON_COLOR_CODE = 'rgb(110,110,110,1 )';
  const VISITOR_FLAG_BACKGROUND = 'color';
  const VISITOR_COLOR_CODE = 'rgba(128,128,128,1)';
  const BUBBLE_COLOR_CODE_MESSAGE_NAME = 'rgb(39,39,39, 1)';
  const BUBBLE_COLOR_CODE_MESSAGE_TIME = 'rgb(39,39,39, 1)';
  const BUBBLE_COLOR_CODE_MESSAGE_TEXT = 'rgb(119,119,119, 1)';
  const BUBBLE_COLOR_CODE_MESSAGE_BACKGROUND = 'rgba(255,255,255,1)';

  public static function getAllConstants()
  {
    return [
      'videotron_flag_background' => self::VIDEOTRON_FLAG_BACKGROUND,
      'videotron_color_code' => self::VIDEOTRON_COLOR_CODE,
      'visitor_flag_background' => self::VISITOR_FLAG_BACKGROUND,
      'visitor_color_code' => self::VISITOR_COLOR_CODE,
      'bubble_color_code_message_name' => self::BUBBLE_COLOR_CODE_MESSAGE_NAME,
      'bubble_color_code_message_time' => self::BUBBLE_COLOR_CODE_MESSAGE_TIME,
      'bubble_color_code_message_text' => self::BUBBLE_COLOR_CODE_MESSAGE_TEXT,
      'bubble_color_code_message_background' => self::BUBBLE_COLOR_CODE_MESSAGE_BACKGROUND,
    ];
  }
}
