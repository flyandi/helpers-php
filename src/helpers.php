<?php
/**
 * flyandi:php-helper
 *
 * A useful collection of global PHP helpers.
 *
 * @version: v1.1.0
 * @author: Andy Schwarz
 *
 * Copyright (c) 2017 flyandi (http://github.com/flyandi/php-helpers)
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
 * NON INFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */

/**
 * (Constants).
 */
define('RAW_VAR', '@RAW___VAR');


/***
 **
 ** Helpers: Environment
 **
 **/

/**
 * Evaluates if a variable has a value otherwise returns a default value.
 * @example $value = DefaultValue(@$booleanValue, false);
 * @param mixed $value The variable to evaluate.
 * @param mixed $default A default value that is returned if the variable doesn't contain a valid value. Returns null as default.
 * @return mixed Returns the original value or the default value.
 */
function DefaultValue($value, $default = null)
{
    if (empty($value) || (is_string($value) && strlen(trim($value)) == 0) || $value === null) {
        return $default;
    }
    // return value
    return $value;
}

/**
 * Returns the internal PHP variable stack in the order of REQUEST, COOKIE, GET, POST and GLOBALS.
 * @example $stack = GetVarStack();
 * @return array
 */
function GetVarStack()
{
    return Extend($_REQUEST, $_COOKIE, $_GET, $_POST, $GLOBALS);
}

/**
 * Returns a variable from the variable stack.
 * @example $myVariable = GetVar("post-method");
 * @param string $name A string identifying the variable name.
 * @param mixed $default A default value if the variable doesn't exists in the stack.
 * @return mixed|null
 */
function GetVar($name, $default = null)
{
    // cycle environment buckets
    foreach (array($_REQUEST, $_COOKIE, $_GET, $_POST, $GLOBALS) as $x => $n) {
        if (isset($n[$name])) {
            return $x == 2 ? urldecode($n[$name]) : $n[$name];
        }
    }
    // parse raw stream
    return GetRawVar($name, $default);
}

/**
 * Returns the stack or a specific variable from the PHP raw stream (php://input).
 * @example $jsonPayload = GetRawVar();
 * @example $myVar = GetRawVar("postName");
 * @param boolean|string $name If passed, this function will return a specific variable from the raw stream.
 * @param mixed|null $default A default value if the variable doesn't exists in the stack.
 * @return mixed|null
 */
function GetRawVar($name = false, $default = null)
{
    if (!isset($GLOBALS[RAW_VAR])) {
        parse_str(file_get_contents('php://input'), $GLOBALS[RAW_VAR]);
    }

    return is_array($GLOBALS[RAW_VAR]) ? ($name === false ? $GLOBALS[RAW_VAR] : ($name !== false && isset($GLOBALS[RAW_VAR][$name]) ? $GLOBALS[RAW_VAR][$name] : $default)) : $default;
}

/**
 * Sets a value in the global variable stack.
 * @example SetVar("postId", 28);
 * @param string $name A string identifying the variable name.
 * @param mixed|null $value The value. If none passed, the value will be set to null.
 * @return void
 */
function SetVar($name, $value = null)
{
    $GLOBALS[$name] = $value;
}

/**
 * Returns a value from a variable stack. This function is similar to GetVar however it searches first in the custom variable stack.
 * @example $value = GetVarEx("lastname", ["firstname" => "Han", "lastname" => "Solo"], "Skywalker");
 * @param string $name A string identifying the variable name.
 * @param array|bool $variables A array of custom variables.
 * @param mixed|null $default A default value if the variable doesn't exists in the stack.
 * @return mixed|null
 */
function GetVarEx($name, $variables = false, $default = null)
{
    return $variables ? DefaultValue(@$variables[$name], $default) : GetVar($name, $default);
}


/**
 * Returns a variable only from the GLOBALS stack which can not be modified from outside.
 * @warning This function might not be safe at this point and is for backwards compatibility included here.
 * @example $value = GetSecureVar("secret-password");
 * @param string $name A string identifying the variable name.
 * @param mixed $default A default value if the variable doesn't exists in the stack.
 * @return mixed|null
 */
function GetSecureVar($name, $default = null)
{
    if (isset($GLOBALS[$name])) {
        return @$GLOBALS[$name];
    }

    return $default;
}

/**
 * Returns a variable from a request URI string by it's position index. Each slash identifies a position index where the root is index 0.
 * @example Request URI: /api/xwing/set/lasers
 * @example $vehicle = GetDirVar(2);
 * @example $vehicle is now "xwing".
 * @param int $index The position index.
 * @param mixed|null $default A default value if the index doesn't exists.
 * @param string|bool $path A custom path to be considered instead of the server variable REQUEST_URI.
 * @return mixed|null
 */
function GetDirVar($index = 0, $default = null, $path = false)
{
    // read defaults
    $path = $path ? $path : GetServerVar('REQUEST_URI');
    // verify
    if (strlen($path) != 0) {
        // prepare the path
        $r = explode('?', $path);
        // split
        $d = explode('/', $r[0]);
        // return value
        return DefaultValue(@strtolower(@$d[$index + 1]), $default);
    }
    return $default;
}

/**
 * (macro) GetRequest
 * returns the full current request.
 *
 * @param start         The beginning index
 * @param prepend       If set to true, will add a slash before the path
 */
function GetRequest($index = 0, $prepend = true, $removequery = true)
{
    // initialize
    $result = false;
    // parse request
    if ($request = GetServerVar('REQUEST_URI', false)) {
        // adjust index
        $index += 1;
        // prepare
        $d = explode('/', $request, $index + 1); // < 1 ? 1 : $index);
        // check
        if (is_array($d) && isset($d[$index])) {
            $result = $d[$index];
        }

        // removequery
        if ($removequery) {
            $pos = stripos($result, '?');
            if ($pos !== false) {
                $result = substr($result, 0, stripos($result, '?'));
            }
        }
    }
    // finalize result
    return ($prepend && substr($result, 0, 1) != '/' ? '/' : '').$result;
}

/**
 * (macro) ParseRequest
 * Parses a request.
 *
 * @param request          The request string
 */
function ParseRequest($request, $asobject = true)
{
    $parts = explode('/', $request);

    // shift
    if ($parts[0] == '/' || $parts[0] == '') {
        array_shift($parts);
    }

    // initialize
    $result = array(
        'parts' => $parts,
        'root' => $parts[0],
        'action' => DefaultValue(@$parts[1], false),
        'value' => DefaultValue(@$parts[2], false),
    );

    // return
    return $asobject ? (object) $result : $result;
}

/**
 * (macro) GetServerVar
 * returns a variable from the server variable stack.
 *
 * @param name              The name of the variable
 * @param default           A default value
 */
function GetServerVar($name = REQUEST_URI, $default = null)
{
    return isset($_SERVER[$name]) ? $_SERVER[$name] : $default;
}

function ServerVar($name = REQUEST_URI, $default = null)
{
    return GetServerVar($name, $default);
}

/**
 * (macro) SetServerVar
 * sets a variable in the server variable stack.
 *
 * @param name              The name of the variable
 * @param value             The new value
 */
function SetServerVar($name, $value)
{
    $_SERVER[$name] = $value;
}

/**
 * (macro) GetHTTPHeaderVar
 * returns a variable from the incoming HTTP header.
 *
 * @param name              The name of the variable
 * @param default           A default value
 */
function GetHTTPHeaderVar($name, $default = null)
{
    if (function_exists('getallheaders')) {
        $headers = getallheaders();

        return isset($headers[$name]) ? $headers[$name] : $default;
    }

    return $default;
}

/**
 * (macro) AppVar
 * returns a variable from the app stack.
 *
 * @param name              The name of the variable
 * @param default           A default value
 */
function AppVar($name, $default = null)
{
    return defined($name) ? constant($name) : $default;
}

/**
 * (macro) EnvVar
 * returns a environment variable.
 *
 * @param name              The name of the variable
 * @param default           A default value
 */
function EnvVar($name, $default = null)
{
    $result = getenv($name);

    return $result === false ? $default : $result;
}

/**
 * (macro) IfAppVar
 * If condition to check for an app stack variable.
 *
 * @param name              The name of the variable
 * @param is                Check against
 */
function IfAppVar($name, $is = null)
{
    // get var
    $d = StringToBool(AppVar($name, false));
    // check
    return $d && $d == $is;
}

/**
 * (macro) ClearVar
 * Clears off a variable if possible.
 *
 * @param name              The name of the variable
 */
function ClearVar($name)
{
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
 * Converts a string to it's boolean representation.
 *
 * @param s                 A boolean string
 */
function GetQueryString($asarray = true, $withqm = false, $default = '', $fromstring = false)
{
    $q = $fromstring !== false ? $fromstring : GetServerVar('QUERY_STRING', false);
    if ($q !== false && strlen($q) > 0) {
        if ($asarray) {
            //return array_explodevalues(str_replace("&amp;", "&", $q), "&", "=");
        }

        return sprintf('%s%s', $withqm ? '?' : '', $q);
    }

    return $default;
}

/**
 * (macro) GetRemoteAddress
 * Tries to find the true remote address and returns it.
 *
 * @param void              None required
 */
function GetRemoteAddress()
{
    $rm = array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED', 'HTTP_FORWARDED_FOR', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_CLUSTER_CLIENT_IP');
    foreach ($rm as $r) {
        if (isset($_SERVER[$r])) {
            return @$_SERVER[$r];
        }
    }

    return @$_SERVER['REMOTE_ADDR'];
}

/**
 * (macro) ReverseDNSLookup
 * Performs a reverse lookup on an IP Address.
 *
 * @param ip                The IP address.
 */
function ReverseDNSLookup($ip)
{
    // get hostname and ip
    $hostname = GetHostByAddr($ip);
    $hostip = GetHostByName($hostname);
    // return result
    return array(
        'hostname' => $hostname,
        'hostip' => $hostip,
        'sourceip' => $ip,
        'match' => $ip == $hostip,
    );
}

/**
 * (macro) DetectBasePath
 * Tries to detect the basepath less protocol.
 *
 * @param includeFullPath   If set to true it also includes the path without protocol
 * @param default           The default is returned if no path could be detected, e.g. CLI.
 */
function DetectBasePath($includeFullPath = false, $default = false)
{
    return GetServerVar('REQUEST_URI', $default);
}

/***
 **
 ** Helpers: JSON/JavaScript
 **
 **/

/**
 * (macro) JSJSONDecode
 * Decodes a javascript like JSON string.
 *
 * @param s                 Any JSON strin
 * @param assoc             Set true to return a object
 */
function JSJSONDecode($json, $assoc = false)
{

    // parse json string
    return json_decode((preg_replace('/\n\s*\n/', "\n", preg_replace('!/\*.*?\*/!s', '', $json))), $assoc);
}

/**
 * (macro) PrepareScript
 * Prepares a script for transfer.
 */
function PrepareScript($source, $type = false)
{

    // strip white space
    $source = StripWhitespace($source, true, true);

    // remove anchors
    $source = str_replace(array('  ', "\t", "\r\n", "\r", "\n"), '', $source);

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
 * Replaces all a variable string with values.
 *
 * @param string            Any JSON strin
 * @param assoc             Set true to return a object
 */
function FillVariableString($string, $data, $simplematch = false, $st = '{', $et = '}', $suffix = false, $max = 3, $__level = 0)
{
    $__level++;

    // cycle data
    foreach(Extend($data) as $name => $value) {

        if($suffix) $name = $suffix . "." . $name;

        if (!is_array($value) && !is_object($value)) {

            // template field
            $string = str_replace($simplematch ? $name : sprintf('%s%s%s', $st, $name, $et), $value, $string);

        } else {

            if($__level <= $max) {

                $string = FillVariableString($string, $value, $simplematch, $st, $et, $name, $suffix, $max, $__level);

            }
        }

    }

    return $string;
}

/**
 * (macro) ResetVariableString
 * Removes all variable strings from the string
 */
function ResetVariableString($string, $st = '{', $et = '}')
{
    $matches = Inbetween($string, $st, $et, false);

    $matches = DefaultValue(@$matches[1], false);

    if($matches) {

        $perform = [];

        foreach(Extend($matches) as $match) {

            if(preg_match('/^[\w.]+$/', $match)) {
                $perform[] = sprintr("{0}{1}{2}", $st, $match, $et);
            }

        }

        $string = str_replace($perform, "", $string);
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
 * reflection.
 *
 * @param source            The source
 * @param value             An optional query value
 */
function ReverseConstant($source, $value = null)
{
    switch (true) {
        case interface_exists($source) :
        case class_exists($source):
            return DefaultValue(@array_flip((new \ReflectionClass($source))->getConstants())[$value], null);
            break;
    }

    return false;
}


/***
 **
 ** Helpers: HTML
 **
 **/


function Tag ($tag, $attributes = false, $content=false) {

    $result = [];

    foreach(Extend($attributes) as $key => $value) {

        $key = is_integer($key) ? $value : $key;

        $value = is_integer($key) ? false : $value;

        if($key) {
            $result[] = $key . ($value ? sprintr("=\"{0}\"", $value) : "");
        }
    }

    return sprintr("<{0} {1} {2}>{3} {4}",
        $tag,
        implode(" ", $result),
        empty($content) ? "/" : "",
        implode("", is_array($content) ? $content : [$content]),
        $content !== false && $content  !== null ? sprintr("</{0}>", $tag) : ""
    );
}

/***
 **
 ** Helpers: Arrays
 **
 **/

/**
 * (macro) Extend
 * Extends an array like the jQuery $.extend function.
 *
 * @param <multiple>    As many arrays
 */
function Extend()
{
    // initialize result
    $result = array();

    // cycle
    foreach (func_get_args() as $arr) {

        if(is_array($arr) || (is_object($arr) && (!@get_class($arr) || $arr instanceof stdclass))) {
            $result = array_merge($result, (array) $arr);
        }
    }

    // return result
    return $result;
}


/**
 * (macro) Combine
 * Same as Extend however empty values are not being overwritten.
 *
 * @param <multiple>    As many arrays
 */
function Combine()
{
    // initialize result
    $result = array();

    // cycle
    foreach (func_get_args() as $arr) {
        if (is_array($arr) || is_object($arr)) {

            $item = [];

            foreach((array) $arr as $key => $value) {
                if(!empty($value)) {
                    $item[$key] = $value;
                }
            }

            $result = array_merge($result, $item);
        }
    }

    // return result
    return $result;
}

/**
 * (macro) TraverseArray
 * Traverses an array with filters.
 *
 * @param input             Any array
 * @param handler           The handling function
 */
function TraverseArray($input, $handler)
{
    // prepre array
    if (is_object($input)) {
        $input = (array) $input;
    }
    // sanity check
    if (!is_array($input)) {
        return false;
    }

    $result = $input;

    // cycle
    foreach ($input as $key => $value) {
        // prepare
        switch (true) {
            case is_object($key) || is_array($key):
                $result[$key] = TraverseArray($key, $handler);
                break;
            case is_object($value) || is_array($value):
                $result = Extend($result, TraverseArray($value, $handler));
                break;
            default:
                if (is_callable($handler)) {
                    $result[$key] = $handler($key, $value);
                }
                break;
        }
    }

    return $result;
}

/**
 * (ChangeKeyCase)
 * Changes the case of an array. Also automatically detects object and sub objects / arrays and traverses them as well
 *
 * @param input        Any array
 * @param case         CASE_LOWER or CASE_UPPER
 */

function ChangeArrayKeyCase($input, $case = CASE_LOWER)
{
    $input = is_object($input) ? (array) $input : $input;

    $result = [];
    foreach($input as $key => $value)
    {
        if(is_object($value)) $value = (array) $value;

        $result[strtolower($key)] = is_array($value) ? ChangeArrayKeyCase($value, $case) : $value;
    }

    return $result;
}


/**
 * (macro) StringArray
 * Converts an array to a request string.
 *
 * @param input             Any array
 * @param recursive
 */
function StringArray($input, $pairlimiter = '&', $valuelimiter = '=')
{
    // initialize
    $result = array();

    // cycle
    foreach ($input as $key => $value) {
        // connect
        $result[] = $key.$valuelimiter.$value;
    }

    return implode($pairlimiter, $result);
}

/**
 * (macro) ObtainArray
 * Converts an mixed array/object to an array.
 *
 * @param input             Any object
 */
function ObtainArray($input)
{
    $result = [];

    foreach ($input as $key => $value) {
        if (is_object($value)) {
            $value = ObtainArray($value);
        }

        $result[$key] = $value;
    }

    return (array) $result;
}

/**
 * (macro) ObtainObject
 * Converts an mixed array/object to an object.
 *
 * @param input             Any array
 */
function ObtainObject($input)
{
    $result = [];

    foreach ($input as $key => $value) {
        if (is_array($value)) {
            $value = ObtainObject($value);
        }

        $result[$key] = $value;
    }

    return (object) $result;
}

/**
 * (macro) TranslateArray
 * Converts keys from one to another.
 */
function TranslateArray($array, $keyMap, $includeOriginal = true)
{
    $result = [];

    foreach ($array as $key => $value) {

        if(is_array($value)) {
            $result = Extend($result, TranslateArray($value, $keyMap, $includeOriginal));
        } else if (isset($keyMap[$key])) {
            $result[$keyMap[$key]] = $value;
        }
    }

    if ($includeOriginal) {
        $result = Extend($array, $result);
    }

    return $result;
}

/**
 * (macro) HasElements
 * Allows to check if an array if multiple elements
 */

function HasElements($array, $elements, $match = false, $noempty = false)
{
    if(is_string($elements)) $elements = explode(",", $elements);

    foreach(Extend($elements) as $key => $value) {

        $key = is_numeric($key) ? $value : $key;

        if(!isset($array[$key])) return false;

        if($noempty && empty($array[$key])) return false;

        if($match && !Compare($array[$key], $value)) return false;

    }

    return true;
}


/**
 * [TrimArray description]
 * @param [type] $array [description]
 */
function TrimArray($array) {

    $array = Extend($array);

    foreach($array as $key => $value) {

        if(is_array($value) || is_object($value)) {
            $array[$key] = TrimArray($value);
        } else {
            $array[$key] = trim($value);
        }
    }

    return $array;
}


/**
 * [Pick description]
 * @param [type] $array  [description]
 * @param [type] $fields [description]
 */
function Pick($array, $fields) {

    $result = [];

    if(is_string($fields)) $fields = explode(",", $fields);

    $fields = Extend($fields);

    foreach(Extend($array) as $key => $value) {

        if(!is_numeric($key) && in_array($key, $fields)) {
            $result[$key] = $value;
        }
    }

    return $result;
}

/**
 * (macro) FromArrayObject
 * Retruns a matching key-name-value from an array object [{}]
 *
 * @param array         The array
 * @param key           The name of the key
 * @param value         The value of the key
 * @param returnKey     Return a specific key once matched
 */

function FromArrayObject($array, $key, $value, $returnKey = false)
{
    foreach(Extend($array) as $index => $item) {

        $item = Extend($item);

        if(isset($item[$key]) && Compare($item[$key], $value)) {

            return $returnKey ? DefaultValue(@$item[$returnKey], false) : $item;
        }
    }

    return false;
}


/***
 **
 ** Helpers: Strings
 **
 **/

/**
 * (macro) Compare
 * compares two strings.
 *
 * @param a                 The first string
 * @param b                 The second string
 * @param strict            Needs to match exactly
 */
function Compare($a, $b, $strict = false)
{
    return $strict ? $a === $b : (strtolower($a) == strtolower($b));
}

/**
 * (macro) StringToBool
 * Converts a string to it's boolean representation.
 *
 * @param s                 A boolean string
 */
function StringToBool($s)
{
    return in_array(strtolower($s), array('1', 'true', 'on', '+')) ? true : false;
}

/**
 * (macro) StripWhitespace
 * Removes all whitespace from the file.
 *
 * @param source            The source text
 * @param stripbreaklines   Set true to remove breaklines as well
 * @param stripcomments     Set true to remove comments as well
 */
function StripWhitespace($source, $stripbreaklines = true, $stripcomments = false)
{
    // replace
    foreach (array(
        "/\" \"(?=[^\]]*?(?:\"|$))/",
        $stripbreaklines ? "/\r\n\t/" : false,
        $stripcomments ? "!/\*[^*]*\*+([^/][^*]*\*+)*/!" : false,
    ) as $pr) {
        if ($pr) {
            $source = preg_replace($pr, '', $source);
        }
    }
    // return
    return $source;
}

/**
 * (macro) IsLowerCase
 * Checks if the string is all lower case.
 *
 * @param s                 The source string
 */
function IsLowerCase($s)
{
    return strtolower($s) === $s;
}

/**
 * (macro) Inbetween
 * Returns a string between two strings.
 *
 * @param start             The start mark string
 * @param end               The end mark string
 * @param str               The string
 */
function Inbetween($string, $start, $end, $single = true)
{
    $matches = array();
    $regex = "/$start(.*?)$end/";
    preg_match_all($regex, $string, $matches);

    return $single && isset($matches[1][0]) ? $matches[1][0] : $matches;
}

/**
 * (macro) Guid
 * Creates a generic UID.
 */
function Guid($length = 32)
{
    switch (true) {
        case function_exists('openssl_random_pseudo_bytes'):
            $value = substr(bin2hex(openssl_random_pseudo_bytes($length / 2)), 0, $length);

            break;

        default:
            $value = '';

            while (strlen($value) < $length) {
                $value .= hash('SHA256', uniqid(rand(), true));
            }

            $value = substr($value, 0, $length);
            break;
    }

    return $value;
}

/**
 * (sprintr) C# style sprintf.
 */
function sprintr()
{

    // prepare
    $arguments = func_get_args();
    $string = DefaultValue(@$arguments[0], false);

    // sanity check
    if ($string === false) {
        return;
    }

    // fill string baed on index
    foreach (array_slice($arguments, 1) as $index => $value) {
        switch (true) {
            case is_array($value) || is_object($value):
                $string = FillVariableString($string, (array) $value);

                break;

            default:
                $string = str_replace('{'.$index.'}', (string) $value, $string);

                break;
        }
    }

    return $string;
}

/**
 * (aprintp) array pattern print.
 */
function aprintp()
{

    // prepare
    $arguments = func_get_args();
    $string = DefaultValue(@$arguments[0], false);
    $result = array();

    // sanity check
    if ($string === false) {
        return;
    }

    // fill string baed on index
    $params = array_slice($arguments, 1);

    foreach ($params as $index => $value) {
        switch (true) {
            case is_array($value) || is_object($value):
                $tmp = $string;

                foreach ((array) $value as $i => $v) {
                    $tmp = str_replace('{'.$i.'}', (string) $v, $tmp);
                }

                $result[] = $tmp;

                break;

            default:
                $result[] = str_replace('{0}', (string) $value, $string);
                break;
        }
    }

    return $result;
}

/**
 * (sprintp) string pattern print.
 */
function sprintp()
{
    return implode('', call_user_func_array('aprintp', func_get_args()));
}

/**
 * Checks if a string starts with a certain string
 * @example $match = startsWith("HelloFoo", "Hello");
 * @param $haystack
 * @param $needle
 * @return bool
 */
if(!function_exists("startsWith")) {
    function startsWith($haystack, $needle)
    {
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== FALSE;
    }
}

/**
 * Serializes a string
 * @proxyfor serialize
 * @deprecated
 * @param $o
 * @return string
 */
function Inflate($o)
{
    return serialize($o);
}

/**
 * Deserializes a variable
 * @proxyfor unserialize
 * @deprecated
 * @param $o
 * @return mixed
 */
function Deflate($o)
{
    return unserialize($o);
}

/**
 * Substracts a string from another string
 * @example $justFoo = SubstractString("HelloFoo", "Hello"); // returns Foo
 * @param $source
 * @param $part
 * @return mixed
 */
function SubstractString($source, $part)
{
    return str_replace($part, "", $source);
}

/* EOF (helpers.php) */
