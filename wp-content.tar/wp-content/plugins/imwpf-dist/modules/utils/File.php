<?php
 namespace imwpf\modules\utils; class File { public static function tail($filePath, $rows = 20) { if (!file_exists($filePath)) { return array(); } $fp = fopen($filePath, 'r'); if (!$fp) { return array(); } $fileSize = filesize($filePath); $sampleSize = 0; for ($i=0; $i<3; $i++) { $sampleSize += strlen(fgets($fp)); } $readSize = $sampleSize * $rows; $start = $fileSize - $readSize; if ($start > 0) { fseek($fp, $start); } $content = array_filter(explode("\n", fread($fp, $readSize))); $count = count($content); if ($count < $rows) { $rows = $count; } $content = array_reverse(array_slice($content, -$rows+1)); return $content; } } 