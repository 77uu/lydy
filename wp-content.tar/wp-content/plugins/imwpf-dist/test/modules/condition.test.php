<?php
 require dirname(dirname(__DIR__)) . '/autoload_for_test.php'; use \imwpf\modules\condition\Str; class SpiderTest extends \PHPUnit_Framework_TestCase { public function testStrIn() { $test = array( array( 'name' => '测试普通字符串匹配', 'params' => array( 'str' => '你好世界', 'condition' => '你好', ), 'expect' => true, 'exception' => "", ), array( 'name' => '测试and匹配', 'params' => array( 'str' => '你好世界', 'condition' => '你好,世界', ), 'expect' => true, 'exception' => "", ), array( 'name' => '测试or匹配', 'params' => array( 'str' => '你好世界', 'condition' => '你好|其他', ), 'expect' => true, 'exception' => "", ), array( 'name' => '测试and or匹配', 'params' => array( 'str' => '你好世界', 'condition' => '你好,世界|其他', ), 'expect' => true, 'exception' => "", ), array( 'name' => '测试不通过的匹配', 'params' => array( 'str' => '你好世界', 'condition' => '其他', ), 'expect' => false, 'exception' => "", ), array( 'name' => '测试不通过的or匹配', 'params' => array( 'str' => '你好世界', 'condition' => '其他|哈哈', ), 'expect' => false, 'exception' => "", ), array( 'name' => '测试不通过的and匹配', 'params' => array( 'str' => '你好世界', 'condition' => '你好,哈哈', ), 'expect' => false, 'exception' => "", ), ); foreach ($test as $t) { echo "\n{$t['name']}......"; if (Str::In($t['params']['str'], $t['params']['condition']) === $t['expect']) { echo "pass"; } else { echo "not pass"; } } } } 