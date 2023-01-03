<p style="text-align:right;direction:rtl;">
پس از نصب پکیج کد زیر را وارد کنید :
php artisan vendor:publish --force
</p>

<p style="text-align:right;direction:rtl;">
 در فایل کانفیگ این پکیج (config/app/azrbcaptcha.php) مقدار font_address را با دقت وارد نمایید که درواقع نوع فونت به کار رفته برای تولید کپچا می باشد.
</p>


<p style="text-align:right;direction:rtl;">
در فایل کانفیگ شما با تغییر saving_dir در واقع دارید تعیین میکنید که عکس کپچا تولید شده چگونه handel شود :

مقادیر مجاز = 1و2و3
</p>

<p style="text-align:right;direction:rtl;">

1: اگر مقدار را برابر 1 قرار دهید عکس های ساخته شده در هارد ذخیره خواهد شد 
نکته ی مهم در این حالت آن است که حتما مقدار captcha_img_address را که محل ذخیره ی عکس های کپچا در هارد می باشد را به درستی انتخاب کنید

برای استفاده از این حالت :
</p>

Route::get('/', function () {
 
  $image = Azbr::Captcha();

});

<p style="text-align:right;direction:rtl;">
این فساد تنها نام عکس ساخته شده را بر میگرداند برای استفاده از عکس کپچا ساخته شده در فرم خود باید مسیری که برای ذخیر عکس در فایل کانفیگ config/azrbcaptcha در نظر گرفته اید را به صورت prefix به نام آن اضافه کنید
</p>


<p style="text-align:right;direction:rtl;">

2:اگر مقدار برابر 2 قرار دهید عکس های کپچا در هارد قرار نمیگیرند و به صورت base64 بر میگردند

</p>

Route::get('/', function () {

    Azbr::Captcha();   
   
});

<p style="text-align:right;direction:rtl;">

3:اگر مقدار برابر 3 قرار دهید عکس های کپچا در هارد قرار نمیگیرند و به صورت base64 بر میگردند

تفاوت دو حالت 2 و 3 در آن است که در حالت 2 عکس کپچا در داخل یک متغیر base64_encode شده به کاربر برگردانده می شود

ولی در حالت 3 عکس کپچا مستقیما return می شود

</p>


Route::get('/', function () {
 
    $image = Azbr::Captcha();
    header("Content-type: image/png");
    echo base64_decode($image);

   
});


<p style="text-align:right;direction:rtl;">
بعد از تولید هر عکس کپچا یک session با نام captcha برای شما set میشود که مقدار عددی عکس کپچای ساخته شده درون آن قرار میگیرد
</p>

