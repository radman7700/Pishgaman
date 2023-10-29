<?php

namespace Pishgaman\Pishgaman\Library\Virastyar;;

use Pishgaman\Pishgaman\Library\Virastyar\VirastyarInterface;
// use Pishgaman\News\Models\Dictionary;

class Virastyar implements VirastyarInterface
{
    public function __construct()
    {
    }

    public function bultanReplace($text)
    {
        
        $text = str_replace('( - )', '' , $text);   
        $text = str_replace('- )', '' , $text);        
        return $text; 
    }

    public function replace($text)
    {
        $txt = explode(' ',$text);
        // foreach ($txt as $value) {
        //     if(Dictionary::where('mistake',$value)->count())
        //     {
        //         $Dictionary = Dictionary::where('mistake',$value)->first();
        //         if($value != $Dictionary->words)
        //         {
        //             $search = $Dictionary->mistake;
        //             $replace = $Dictionary->words;
        //             $text = str_replace($search,$replace,$text);
        //         }
        //     }
        // }
        $text = preg_replace('/(\x{200e}|\x{200f})/u', '‌' , $text);
        $text = preg_replace('/(\x{200E}|\x{200F})/u', '‌' , $text);
        $text = str_replace('ي', 'ی‌' , $text);
        return $text;
    }

    public function halfSpace($text,$replace=false)
    {
        if($replace)
        {
            $text = $this->replace($text);
        }

        $check1 = false;
        $new_text = explode(' ',$text);

        $edit_text = '';
        foreach ($new_text as $key => $value) {
            if($check1)
            {
                if(substr($value,0,2) == 'م') 
                {
                    $edit_text = mb_substr($edit_text,0,-1,'utf-8');
                    $edit_text = $edit_text .' هم‌'. $value .' ';                    
                }  
                else if(substr($value,0,2) == 'ا') 
                {
                    $edit_text = mb_substr($edit_text,0,-1,'utf-8');
                    $edit_text = $edit_text .' هم‌'. $value .' ';                    
                }   
                else
                {
                    $edit_text = $edit_text . ' هم' .$value .' ';                    
                }
                $check1 = false;
            }
            else{
                switch ($value) {
                    case 'هم':
                        $check1=true;
                        break;                 
                    case 'ی':
                        $edit_text = $edit_text . $value .'‌';
                        break;                
                    case 'می':
                        $edit_text = $edit_text . $value .'‌';
                        break;
                    case 'بی':
                        $edit_text = $edit_text . $value .'‌';
                        break;                    
                    case 'ای':
                        $edit_text = mb_substr($edit_text,0,-1,'utf-8');
                        $edit_text = $edit_text .'‌'. $value .' ';
                        break;
                    case 'ها':
                        $edit_text = mb_substr($edit_text,0,-1,'utf-8');
                        $edit_text = $edit_text .'‌'. $value .' ';
                        break; 
                    case 'اند':
                        $edit_text = mb_substr($edit_text,0,-1,'utf-8');
                        $edit_text = $edit_text .'‌'. $value .' ';
                        break;                         
                    case 'های':
                        $edit_text = mb_substr($edit_text,0,-1,'utf-8');
                        $edit_text = $edit_text .'‌'. $value .' ';
                        break;                         
                    case 'ترین':
                        $edit_text = mb_substr($edit_text,0,-1,'utf-8');
                        $edit_text = $edit_text .'‌'. $value .' ';
                        break;   
                    case 'تر':
                        $edit_text = mb_substr($edit_text,0,-1,'utf-8');
                        $edit_text = $edit_text .'‌'. $value .' ';
                        break;    
                    case '.':
                        $edit_text = mb_substr($edit_text,0,-1,'utf-8');
                        $edit_text = $edit_text . $value .' ';
                        break;     
                    case '،':
                        $edit_text = mb_substr($edit_text,0,-1,'utf-8');
                        $edit_text = $edit_text . $value .' ';
                        break;     
                    case '؛':
                        $edit_text = mb_substr($edit_text,0,-1,'utf-8');
                        $edit_text = $edit_text . $value .' ';
                        break;     
                    case ':':
                        $edit_text = mb_substr($edit_text,0,-1,'utf-8');
                        $edit_text = $edit_text . $value .' ';
                        break;  
                    case '...':
                        $edit_text = mb_substr($edit_text,0,-1,'utf-8');
                        $edit_text = $edit_text . $value .' ';
                        break; 
                    case '؟':
                        $edit_text = mb_substr($edit_text,0,-1,'utf-8');
                        $edit_text = $edit_text . $value .' ';
                        break;   
                    case '(':
                        $edit_text = mb_substr($edit_text,0,-1,'utf-8');
                        $edit_text = $edit_text . $value ;
                        break;   
                    case ')':
                        $edit_text = mb_substr($edit_text,0,-1,'utf-8');
                        $edit_text = $edit_text . $value . ' ';
                        break;
                    case '':
                        break;                                                                                                                                                                                                                                         
                    default:
                        $edit_text = $edit_text .$value .' ';
                        break;
                }
            }
        }

        return $edit_text;
    }
}
