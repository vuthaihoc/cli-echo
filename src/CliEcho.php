<?php
/**
 * User: hocvt
 * Date: 11/28/17
 */

namespace Vuh\CliEcho;


class CliEcho {
	const WARNING='warning';
	const INFO='info';
	const SUCCESS='success';
	const ERROR='error';
	
	private static $flush_enable = false;
	
	/**
	 * Enable flush mode
	 * @param  [type] $enabled [description]
	 * @return [type]          [description]
	 */
	public static function enable_flush($enabled = null){
		if($enabled !== null && php_sapi_name() != 'cli'){
			self::$flush_enable = (bool)$enabled;
		}
		return self::$flush_enable;
	}
	
	/**
	 * Base function to show message with all options can be modified
	 * @param  string  $message Message content
	 * @param  string  $type    Type of message
	 * @param  boolean $newline Append new line charracter after show message
	 * @param  boolean $return  return string or print immediately
	 * @return string|void      
	 */
	public static function comment($message, $type = 'info', $newline = false, $return = false){
		if(self::$flush_enable && ob_get_level() == 0){
			ob_start();
		}
		if(php_sapi_name() == 'cli'){
			list($out, $end) = self::getCliOE($type);
		}else{
			list($out, $end) = self::getWebOE($type);
		}
		$out = $out . $message . $end;
		if($newline){
			$out = "$out" . "\n";
		}
		if($return){
			return $out;
		}else{
			echo $out;
			if(self::$flush_enable){
				ob_flush();
				flush();
			}
		}
	}
	
	/**
	 * Show info message
	 * @param  string  $message Message content
	 * @param  boolean $return  return string or print immediately
	 * @return string|void      
	 */
	public static function info($message, $return = false){
		return self::comment($message, self::INFO, false, $return);
	}


	/**
	 * Show info message and append new line
	 * @param  string  $message Message content
	 * @param  boolean $return  return string or print immediately
	 * @return string|void      
	 */
	public static function infonl($message, $return = false){
		return self::comment($message, self::INFO, true, $return);
	}

	/**
	 * Show success message
	 * @param  string  $message Message content
	 * @param  boolean $return  return string or print immediately
	 * @return string|void      
	 */
	public static function success($message, $return = false){
		return self::comment($message, self::SUCCESS, false, $return);
	}

	/**
	 * Show success message and append new line 
	 * @param  string  $message Message content
	 * @param  boolean $return  return string or print immediately
	 * @return string|void      
	 */
	public static function successnl($message, $return = false){
		return self::comment($message, self::SUCCESS, true, $return);
	}

	/**
	 * Show warning message
	 * @param  string  $message Message content
	 * @param  boolean $return  return string or print immediately
	 * @return string|void      
	 */
	public static function warning($message, $return = false){
		return self::comment($message, self::WARNING, false, $return);
	}

	/**
	 * Show warning message and append new line
	 * @param  string  $message Message content
	 * @param  boolean $return  return string or print immediately
	 * @return string|void      
	 */
	public static function warningnl($message, $return = false){
		return self::comment($message, self::WARNING, true, $return);
	}

	/**
	 * Show error message
	 * @param  string  $message Message content
	 * @param  boolean $return  return string or print immediately
	 * @return string|void      
	 */
	public static function error($message, $return = false){
		return self::comment($message, self::ERROR, false, $return);
	}

	/**
	 * Show error message and append new line
	 * @param  string  $message Message content
	 * @param  boolean $return  return string or print immediately
	 * @return string|void      
	 */
	public static function errornl($message, $return = false){
		return self::comment($message, self::ERROR, true, $return);
	}
	
	/**
	 * Get style bounder when showing on terminal
	 * @param  string $type Type of error
	 * @return array        Struct [$out, $end]
	 */
	private static function getCliOE($type){
		switch($type) {
			case "success":
				$out = "\033[34m"; //Green background
				$end = "\033[0m";
				break;
			case "error":
				$out = "\033[31m"; //Red background
				$end = "\033[0m";
				break;
			case "warning":
				$out = "\033[33m"; //Yellow background
				$end = "\033[0m";
				break;
			case "info":
				$out = ""; //Blue background
				$end = "";
				break;
			default:
				throw new \Exception("Invalid status: " . $type);
		}
		return [$out, $end];
	}

	/**
	 * Get style bounder when showing on browser
	 * @param  string $type Type of error
	 * @return array        Struct [$out, $end]
	 */
	private static function getWebOE($type){
		switch($type) {
			case "success":
				$out = "<p style='color: green;'>"; //Green background
				$end = "</p>";
				break;
			case "error":
				$out = "<p style='color: red;'>"; //Red background
				$end = "</p>";
				break;
			case "warning":
				$out = "<p style='color: yellow;'>"; //Yellow background
				$end = "</p>";
				break;
			case "info":
				$out = "<p style='color: #333333;'>"; //Gray background
				$end = "</p>";
				break;
			default:
				throw new \Exception("Invalid status: " . $type);
		}
		return [$out, $end];
	}
	
}