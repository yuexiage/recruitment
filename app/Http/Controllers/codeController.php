<?php
/** 
 * PHP是世界上最好的语言！
 * @Author yuexiage
 * @Date 2018年5月24日 下午9:31:26 
 * @Email 418221610@qq.com
 * 验证码
*/ 
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;
use Session;
class codeController extends Controller
{
    public function captcha(Request $request,$temp)
    {
        $builder = new CaptchaBuilder(3);
        $builder->build(110,32);
        $phrase = $builder->getPhrase();
        //把内容存入session
        Session::flash('milkcaptcha', $phrase); //存储验证码
        ob_clean(); //清除缓存
        return response($builder->output())->header('Content-type','image/jpeg'); //把验证码数据以jpeg图片的格式输出
    }
}
