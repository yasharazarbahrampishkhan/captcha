<?php

namespace Azarbahram\Captcha;

use Azarbahram\Captcha\Helpers\Lib\FarsiGD;
use Azarbahram\Captcha\Helpers\Number2Word;


class Azbrcaptcha {


    private function image_gradientrect($img,$x,$y,$x1,$y1,$start,$end) {

        if($x > $x1 || $y > $y1) {
            return false;
        }
        $s = array(
            hexdec(substr($start,0,2)),
            hexdec(substr($start,2,2)),
            hexdec(substr($start,4,2))
        );
        $e = array(
            hexdec(substr($end,0,2)),
            hexdec(substr($end,2,2)),
            hexdec(substr($end,4,2))
        );
        $steps = $y1 - $y;
        for($i = 0; $i < $steps; $i++) {
            $r = $s[0] - ((($s[0]-$e[0])/$steps)*$i);
            $g = $s[1] - ((($s[1]-$e[1])/$steps)*$i);
            $b = $s[2] - ((($s[2]-$e[2])/$steps)*$i);
            $color = imagecolorallocate($img,$r,$g,$b);
            imagefilledrectangle($img,$x,$y+$i,$x1,$y+$i+1,$color);
        }
        return true;
    }

    public function Captcha(){

        $captcha_img_address = config('azrbcaptcha.captcha_img_address');
        
        $time=round(microtime(true)*1000);

        $Number2Word = new Number2Word;
        $gd = new FarsiGD();

        $number = rand(1000,9999);
        
        $word = $Number2Word->numberToWords($number);
        @$fa_word= $gd->persianText($word, 'fa', 'normal');
        

        $fontsize = config('azrbcaptcha.fontsize');
        $degree = 0;
        $x = 5;
        $y = 40;
        $font= config('azrbcaptcha.font_address');

        $size = imagettfbbox($fontsize,$degree,$font,$fa_word);
        $width = abs($size[2] - $size[0])+20;
        $height = abs($size[5] - $size[3])+20;


        $image=imagecreatetruecolor($width,$height);
        
        imagealphablending($image, false);

        $this->image_gradientrect($image,0,0,$width,$height,config('azrbcaptcha.image_gradientrect_color_1'),config('azrbcaptcha.image_gradientrect_color_2'));

        $text_color=imagecolorallocate($image,config('azrbcaptcha.text_color.red'),config('azrbcaptcha.text_color.green'),config('azrbcaptcha.text_color.blue'));
        
        $line_color=imagecolorallocate($image,config('azrbcaptcha.line_color.red'),config('azrbcaptcha.line_color.green'),config('azrbcaptcha.line_color.blue'));
        
        $pixel_color=imagecolorallocate($image,config('azrbcaptcha.pixel_color.red'),config('azrbcaptcha.pixel_color.green'),config('azrbcaptcha.pixel_color.blue'));
        

        for($i=0;$i<config('azrbcaptcha.line_numbers');$i++){
            
            imageline($image,0,rand(0,$height),$width,rand(0,$height),$line_color);     
            
        }
            
        for($i=0;$i<config('azrbcaptcha.pixel_numbers');$i++){
                
            imagesetpixel($image,rand(0,$width),rand(0,$height),$pixel_color);
                
        }
        

        imagettftext($image,$fontsize,$degree,$x,$y,$text_color,$font,$fa_word);
        
        session()->put('captcha', $number);

        $array=glob($captcha_img_address.'*.png');
        
        foreach( $array as  $x  ){
            
            $create_time=str_replace('.png','',$x);
            $create_time=str_replace($captcha_img_address,'',$create_time);

            if($time-$create_time>300000){
            
                unlink($x);
            
            }
            
        }

        
        if(config('azrbcaptcha.saving_dir') == 1){

            imagepng($image,$captcha_img_address.$time.".png");
            return $time.".png";

        }elseif(config('azrbcaptcha.saving_dir') == 2){
            
            ob_start();
            imagepng($image);
            $data = ob_get_contents();
            ob_end_clean();
            return $data = base64_encode($data);

        }elseif(config('azrbcaptcha.saving_dir') == 3){

            header ('Content-Type: image/png');
            $r = imagepng($image); 
            return $r;

        }
        
        
    }
        

    
}