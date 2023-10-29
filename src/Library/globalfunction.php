<?php

namespace Pishgaman\Pishgaman\Library;

class globalfunction
{
    public function __construct()
    {
    }

    function isEmoji($word) 
    {
        $emojiPatterns = [
            // Emoticons (اسمایلی ها)
            '/[\x{1F600}-\x{1F64F}]/u',
            // Transport and Map Symbols (نمادهای نقشه و حمل و نقل)
            '/[\x{1F680}-\x{1F6FF}]/u',
            // Miscellaneous Symbols (نمادها و نمادهای متنوع)
            '/[\x{2600}-\x{26FF}]/u',
            // Dingbats (نمادها)
            '/[\x{2700}-\x{27BF}]/u',
            // Geometric Shapes (شکل‌های هندسی)
            '/[\x{25A0}-\x{25FF}]/u',
            // هر نوع شکلک یا نماد دیگری که مد نظر شماست
            '/[\x{1F600}-\x{1F64F}]/u',
            '/[\x{1F447}-\x{1F44F}]/u', // افزودن شکلک "👇" و خانواده آن
            '/[\x{1F446}]/u', // افزودن شکلک "👈"
            '/[\x{1F4C5}-\x{1F4C9}]/u',
        ];
        
        foreach ($emojiPatterns as $pattern) {
            if (preg_match($pattern, $word)) {
                return true;
            }
        }
        
        return false;        
    }   
    
    public function isValidURL($url) {
        // استفاده از عبارت منظم برای بررسی اعتبار URL
        $pattern = '/^(https?|ftp):\/\/[^\s\/$.?#].[^\s]*$/i';
    
        // تطابق URL با الگو
        if (preg_match($pattern, $url)) {
            return true;
        } else {
            return false;
        }
    }     
}