<?php

namespace App\services;

class EgyptPostPuppeteerService
{
    public function trackShipment(string $barcode): string
    {
        $nodeScriptPath = base_path('node_scripts/track.js');

        // تهرب من barcode لمنع مشاكل في shell
        $escapedBarcode = escapeshellarg($barcode);

        // الأمر لتشغيل السكربت مع تمرير رقم التتبع
        $command = "node {$nodeScriptPath} {$escapedBarcode}";

        // تنفيذ الأمر وجلب الناتج
        $output = null;
        $return_var = null;
        exec($command, $output, $return_var);

        if ($return_var !== 0) {
            return 'حدث خطأ أثناء جلب بيانات التتبع.';
        }

        // دمج الأسطر في نص واحد (في حالة كان الإخراج متعدد الأسطر)
        return implode("\n", $output);
    }
}
