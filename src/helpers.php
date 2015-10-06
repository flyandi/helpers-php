<?php
/**
 * flyandi:helpers-php library for PHP
 * 
 * A useful collection of global PHP helpers
 * 
 * @version: v1.0.2
 * @author: Andy Schwarz
 *
 * Created by Andy Schwarz. Please report any bug at http://github.com/flyandi/helpers-php
 *
 * Copyright (c) 2015 Andy Schwarz http://github.com/flyandi
 *
 * The MIT License (http://www.opensource.org/licenses/mit-license.php)
 *
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */


/** 
 * (Constants) 
 */
	
define("RAW_VAR", "@RAW___VAR");


/*** 
 **
 ** Helpers: Environment
 **
 **/

/** 
 * (macro) DefaultValue 
 * Checks the given value and returns an alternative if not passed
 *
 * @param value 			The value to check
 * @param default 			A default value
 */ 

function DefaultValue($value, $default = null){
	if (empty($value) || (is_string($value)&&strlen(trim($value))==0) || $value===null) return $default;
	// return value
	return $value;
}

/**
 * (macro) GetVarStack
 * returns all variables one stack
 *
 * @param void
 */

function GetVarStack() {
	return Extend($_REQUEST, $_COOKIE, $_GET, $_POST, $GLOBALS);
}


/** 
 * (macro) GetVar 
 * returns a variable from the environment stack
 *
 * @param name 			 	The name of the variable
 * @param default 			A default value
 */ 

function GetVar($name, $default = null) {

	// cycle environment buckets
	foreach(array($_REQUEST, $_COOKIE, $_GET, $_POST, $GLOBALS) as $x=>$n) {
		if(isset($n[$name])) return $x == 2 ? urldecode($n[$name]) : $n[$name];
	}
	// parse raw stream
	return GetRawVar($name, $default);
}	


/**
 * (macro) GetRawVar
 * returns a variable from the raw input 
 *
 * @param name 				If given it returns only the variable for it
 */

function GetRawVar($name = false, $default = null) {

	if(!isset($GLOBALS[RAW_VAR])) {
		parse_str(file_get_contents("php://input"), $GLOBALS[RAW_VAR]);
	}

	return is_array($GLOBALS[RAW_VAR]) ? ($name === false ? $GLOBALS[RAW_VAR] : ($name !== false && isset($GLOBALS[RAW_VAR][$name]) ? $GLOBALS[RAW_VAR][$name] : $default)) : $default;
}


/** 
 * (macro) SetVar 
 * returns a variable from the environment stack
 *
 * @param name 			 	The name of the variable
 * @param value 			The value
 */ 

function SetVar($name, $value = null) {
	$GLOBALS[$name] = $value;
}		


/** 
 * (macro) GetVarEx
 * returns a variable from a variable stack and then environment
 *
 * @param name 			 	The name of the variable
 * @param variables 		A stack of variables
 * @param default 			A default value
 */ 

function GetVarEx($name, $variables = false, $default = null) {
	return $variables?DefaultValue(@$variables[$name], $default):GetVar($name, $default);
}


/** 
 * (macro) GetSecureVar 
 * reads a variable only from the globals which can't be modified from outside.
 *
 * @param name 			 	The name of the variable to read
 * @param default 			A default value
 */ 

function GetSecureVar($name, $default = "") {
	if (isset($GLOBALS[$name])) return @$GLOBALS[$name];
	return $default;
}		


/** 
 * (macro) GetDirVar 
 * reads the index name of the request URL
 *
 * @param index 			Index/Position of Location
 * @param default 			A default value
 * @param path 				An alternative path
 */ 
function GetDirVar($index=0, $default = null, $path = false) {
	// read defaults
	$path = $path ? $path : GetServerVar("REQUEST_URI");
	// verify
	if(strlen($path) != 0) {
		// prepare the path
		$r = explode("?", $path);
		// split
		$d = explode("/", $r[0]);
		// return value
		return @DefaultValue(strtolower(@$d[$index+1]), $default);
	}
	return $default;
}

/** 
 * (macro) GetRequest
 * returns the full current request
 *
 * @param start 		The beginning index
 * @param prepend 		If set to true, will add a slash before the path
 */ 

function GetRequest($index = 0, $prepend = true, $removequery = true){
	// initialize
	$result = false;
	// parse request
	if($request = GetServerVar("REQUEST_URI", false)) {
		// adjust index
		$index += 1;
		// prepare
		$d = explode("/", $request, $index + 1); // < 1 ? 1 : $index);
		// check 
		if(is_array($d) && isset($d[$index])) {
			$result = $d[$index];
		}

		// removequery
		if($removequery) {
			$pos = stripos($result, "?");
			if($pos !== false) {
				$result = substr($result, 0, stripos($result, "?"));
			}
		}

	}
	// finalize result
	return ($prepend && substr($result, 0, 1) != "/" ? "/" : "") . $result;
}


/**
  * (macro) ParseRequest
  * Parses a request
  *
  * @param request 			The request string
  */

function ParseRequest($request, $asobject = true) {

	$parts = explode("/", $request);

	// shift
	if($parts[0] == "/" || $parts[0] == "") array_shift($parts);


	// initialize
	$result = array(
		"parts" => $parts,
		"root" => $parts[0],
		"action" => DefaultValue(@$parts[1], false),
		"value" => DefaultValue(@$parts[2], false)
	);

	// return
	return $asobject ? (object) $result : $result;
}


/** 
 * (macro) GetServerVar
 * returns a variable from the server variable stack
 *
 * @param name 			 	The name of the variable
 * @param default 			A default value
 */ 

function GetServerVar($name = REQUEST_URI, $default = null) {
	return isset($_SERVER[$name])?$_SERVER[$name]:$default;
}

function ServerVar($name = REQUEST_URI, $default = null) {
	return GetServerVar($name, $default);
}

/** 
 * (macro) SetServerVar
 * sets a variable in the server variable stack
 *
 * @param name 			 	The name of the variable
 * @param value 			The new value
 */

function SetServerVar($name, $value) {
	$_SERVER[$name] = $value;
}

/** 
 * (macro) GetHTTPHeaderVar
 * returns a variable from the incoming HTTP header
 *
 * @param name 			 	The name of the variable
 * @param default 			A default value
 */

function GetHTTPHeaderVar($name, $default = null) {
	if(function_exists("getallheaders")) {
		$headers = getallheaders();
		return isset($headers[$name])?$headers[$name]:$default;	
	}
	return $default;
}

/** 
 * (macro) AppVar
 * returns a variable from the app stack
 *
 * @param name 			 	The name of the variable
 * @param default 			A default value
 */

function AppVar($name, $default = null) {
	return defined($name)?constant($name):$default;
}


/**
 * (macro) EnvVar 
 * returns a environment variable
 *
 * @param name 				The name of the variable
 * @param default 			A default value
 */

function EnvVar($name, $default = null) {
	$result = getenv($name);

	return $result === false ? $default : $result;
}


/** 
 * (macro) IfAppVar
 * If condition to check for an app stack variable
 *
 * @param name 			 	The name of the variable
 * @param is  				Check against
 */

function IfAppVar($name, $is = null) {
	// get var
	$d = StringToBool(AppVar($name, false));
	// check
	return $d&&$d==$is;
}

/** 
 * (macro) ClearVar
 * Clears off a variable if possible
 *
 * @param name 			 	The name of the variable
 */

function ClearVar($name){
	unset($_COOKIE[$name]);
	unset($_GET[$name]);
	unset($_POST[$name]);
}	




/*** 
 **
 ** Helpers: Network/HTTP
 **
 **/


/** 
 * (macro) GetQueryString
 * Converts a string to it's boolean representation
 *
 * @param s 				A boolean string
 */ 

function GetQueryString($asarray = true, $withqm = false, $default = "", $fromstring = false) {
	$q = $fromstring!==false?$fromstring:GetServerVar("QUERY_STRING", false);
	if($q!==false&&strlen($q)>0) {
		if($asarray) {
			//return array_explodevalues(str_replace("&amp;", "&", $q), "&", "=");
		}
		return sprintf("%s%s", $withqm?"?":"", $q);
	}
	return $default;
}


/** 
 * (macro) GetRemoteAddress
 * Tries to find the true remote address and returns it.
 *
 * @param void				None required
 */ 

function GetRemoteAddress(){
	$rm=Array("HTTP_CLIENT_IP", "HTTP_X_FORWARDED", "HTTP_FORWARDED_FOR", "HTTP_X_FORWARDED_FOR", "HTTP_X_CLUSTER_CLIENT_IP");
	foreach($rm as $r){if(isset($_SERVER[$r])){return @$_SERVER[$r];}}
	return @$_SERVER["REMOTE_ADDR"];
}


/** 
 * (macro) ReverseDNSLookup
 * Performs a reverse lookup on an IP Address.
 *
 * @param ip				The IP address.
 */ 

function ReverseDNSLookup($ip) {
	// get hostname and ip
	$hostname = GetHostByAddr($ip);
	$hostip = GetHostByName($hostname);
	// return result
	return Array(
		"hostname"=>$hostname,
		"hostip"=>$hostip,
		"sourceip"=>$ip,
		"match"=>$ip==$hostip
	);
}


/**
 * (macro) DetectBasePath
 * Tries to detect the basepath less protocol
 *
 * @param includeFullPath 	If set to true it also includes the path without protocol
 * @param default 			The default is returned if no path could be detected, e.g. CLI.

 */

function DetectBasePath($includeFullPath = false, $default = false) {

	return GetServerVar("REQUEST_URI", $default);
}


/*** 
 **
 ** Helpers: JSON/JavaScript
 **
 **/

/** 
 * (macro) JSJSONDecode
 * Decodes a javascript like JSON string
 *
 * @param s 				Any JSON strin
 * @param assoc 			Set true to return a object
 */ 

function JSJSONDecode($json, $assoc = false) {
	return json_decode(preg_replace('/([{,])(\s*)([^"]+?)\s*:/','$1"$3":',str_replace(array("\n","\r"),"",$json)), $assoc);
}


/** 
 * (macro) PrepareScript
 * Prepares a script for transfer
 */

function PrepareScript($source, $type = false) {

	// strip white space
	$source = StripWhitespace($source, true, true);

	// remove anchors
	$source = str_replace(array("  ", "\t", "\r\n", "\r", "\n"), "", $source);

	// return 
	return base64_encode($source);
}


/*** 
 **
 ** Helpers: Variables 
 **
 **/

/** 
 * (macro) FillVariableString
 * Replaces all a variable string with values
 *
 * @param string 			Any JSON strin
 * @param assoc 			Set true to return a object
 */ 

function FillVariableString($string, $data, $simplematch = false, $st = "{", $et = "}") {
	// cycle data
	foreach(is_array($data)?$data:Array() as $name=>$value) {
		if(is_string($value)) {
			// template field
			$string = str_replace($simplematch ? $name : sprintf("%s%s%s", $st, $name, $et), $value, $string);
		}
	}

	return $string;
}

/***
 ** 
 ** Helpers: Classes and Constants
 **
 **/


/**
 * (macro) ReverseConstant
 * Returns the return name of the constant. Also can process classes and interface through
 * reflection
 *
 * @param source 			The source
 * @param value 			An optional query value
 * 
 */

function ReverseConstant($source, $value = null) {

	switch(true) {
		case interface_exists($source):
		case class_exists($source):
			return DefaultValue(@array_flip((new \ReflectionClass($source))->getConstants())[$value], null);
			break;
	}

	return false;
}


/*** 
 **
 ** Helpers: Arrays 
 **
 **/


/** 
 * (macro) Extend
 * Extends an array like the jQuery $.extend function 
 *
 * @param <multiple>	As many arrays
 */ 

function Extend() {
	// initialize result
	$result = array();

	// cycle
	foreach(func_get_args() as $arr) {
		if(is_array($arr) || is_object($arr)) {
			$result = array_merge($result, (array)$arr);
		}
	}

	// return result
	return $result;
}


/** 
 * (macro) TraverseArray
 * Traverses an array with filters
 *
 * @param input 			Any array
 * @param handler 			The handling function
 */ 

function TraverseArray($input, $handler) {	
	// prepre array
	if(is_object($input)) $input = (array) $input;
	// sanity check
	if(!is_array($input)) return false;

	// cycle
	foreach($input as $key=>$value) {
		// prepare
		switch(true) {
			case is_object($key) || is_array($key): 
				TraverseArray($key, $handler);
				break;
			case is_object($value) || is_array($value): 
				TraverseArray($value, $handler);
				break;
			default:
				if(is_callable($handler)) {
					$handler($key, $value);
				}
				break;
		}
	}
}


/** 
 * (macro) StringArray
 * Converts an array to a request string
 *
 * @param input 			Any array
 * @param recursive
 */ 

function StringArray($input, $pairlimiter = "&", $valuelimiter = "=") {
	// initialize
	$result = array();

	// cycle
	foreach($input as $key => $value) {

		// connect
		$result[] = $key . $valuelimiter . $value;
	}

	return implode($pairlimiter, $result);
}


/** 
 * (macro) ObtainArray
 * Obtains an array from different data sources
 *
 * @param input 			Any array
 * @param recursive
 */ 

function ObtainArray($input) {
	// initialize result
	$result = array();


	// return result
	return $result;
}


/*** 
 **
 ** Helpers: Strings 
 **
 **/


/** 
 * (macro) Compare
 * compares two strings
 *
 * @param a 				The first string
 * @param b 				The second string
 * @param strict 			Needs to match exactly 
 */ 

function Compare($a, $b, $strict = false) {
	return $strict ? $a === $b : (strtolower($a) == strtolower($b));
}


/** 
 * (macro) StringToBool
 * Converts a string to it's boolean representation
 *
 * @param s 				A boolean string
 */ 

function StringToBool($s) {
	return in_array(strtolower($s), array("1", "true", "on", "+")) ? true : false;
}


/** 
 * (macro) StripWhitespace
 * Removes all whitespace from the file
 *
 * @param source 			The source text
 * @param stripbreaklines	Set true to remove breaklines as well
 * @param stripcomments		Set true to remove comments as well
 */ 

function StripWhitespace($source, $stripbreaklines = true, $stripcomments = false) {
	// replace
	foreach(array(
		"/\" \"(?=[^\]]*?(?:\"|$))/",
		$stripbreaklines ? "/\r\n\t/" : false,
		$stripcomments ? "!/\*[^*]*\*+([^/][^*]*\*+)*/!" : false,
	) as $pr) {
		if($pr) 
			$source = preg_replace($pr, "", $source);

	}
	// return
	return $source;
}


/** 
 * (macro) IsLowerCase
 * Checks if the string is all lower case
 *
 * @param s 				The source string
 */ 

function IsLowerCase($s) {
	return strtolower($s)===$s;
}


/** 
 * (macro) Inbetween
 * Returns a string between two strings
 *
 * @param start 			The start mark string
 * @param end 				The end mark string
 * @param str 				The string
 */

function Inbetween($start, $end, $str, $single = true){
    $matches = array();
    $regex = "/$start(.*?)$end/";
    preg_match_all($regex, $str, $matches);
    return $single && isset($matches[1][0]) ? $matches[1][0] : $matches;
}


/** 
 * (macro) Guid
 * Creates a generic UID
 *
 */

function Guid() {
	return md5(uniqid(rand(), true));
}	


/**
 * (sprintr) C# style sprintf
 */

function sprintr() {

	// prepare
	$arguments = func_get_args();
	$s = DefaultValue(@$arguments[0], false);

	// sanity check
	if($s === false) return null;

	// build message
	foreach(array_slice($arguments, 1) as $index => $value) {

		switch(true) {

			case is_array($value) || is_object($value):

				$values = array();

				foreach((array) $value as $key => $v) {
					$values[] = sprintf("[%s=%s]", $key, is_array($v) || is_object($v) ? serialize($v) : $v);
				}
				
				$value = implode(" ", $values);

				break;
		}

		$message = str_replace("{" . $index . "}", (string) $value, $message);
	}

	return $message;
}


/* EOF (helpers.php) */