<?php
 namespace imwpf\modules; class Cron { const KEY = "imwpf_cron"; const LOCK_KEY = "imwpf_cron_lock"; const MAX_EXECUTE_TIME = 300; public static function add($name, $interval = 86400) { $cron = get_option(self::KEY); if (!$cron) { $cron = array(); add_option(self::KEY, array()); } if (isset($cron[$name]) && $cron[$name]['i'] == $interval) { return $cron[$name]; } $cron[$name] = array( 'i' => $interval, 'n' => time(), ); update_option(self::KEY, $cron); return $cron[$name]; } public static function get($name) { $cron = get_option(self::KEY); if (!isset($cron[$name])) { return false; } return $cron[$name]; } public static function delete($name) { $cron = get_option(self::KEY); if (!$cron || !isset($cron[$name])) { return true; } unset($cron[$name]); update_option(self::KEY, $cron); } public static function execute() { $lock = get_option(self::LOCK_KEY); if (!$lock) { add_option(self::LOCK_KEY, time() + self::MAX_EXECUTE_TIME); } if (time() < $lock) { return true; } $cron = get_option(self::KEY); $current = array(); $hookName = ''; foreach ($cron as $hookName => $task) { if (time() > $task['n']) { $current = $task; break; } } if (!$current) { return true; } update_option(self::LOCK_KEY, time() + self::MAX_EXECUTE_TIME); do_action($hookName); $cron[$hookName]['n'] = time() + $cron[$hookName]['i']; update_option(self::KEY, $cron); update_option(self::LOCK_KEY, time()); } } 