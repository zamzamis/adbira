<?php
if (!function_exists('getFolderSize')) {
    function getFolderSize($path) {
        $totalSize = 0;
        $files = glob($path . '/*');
        
        foreach($files as $file) {
            if(is_file($file)) {
                $totalSize += filesize($file);
            }
        }
        
        return round($totalSize / (1024 * 1024), 2); // Convert to MB
    }
}