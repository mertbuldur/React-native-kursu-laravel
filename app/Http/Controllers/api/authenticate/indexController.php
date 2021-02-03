<?php
namespace App\Http\Controllers\api\authenticate;

use App\Http\Controllers\api\BaseController;
use App\User;
use \Illuminate\Http\Request;


class indexController extends BaseController
{
    public function register(Request $request){
        $input = $request->all();
        $control = User::where('email',$input['email'])->count();
        if($control != 0){ return $this->sendError('Bu Email Sistemde Kayıtlı');}
        $token = uniqid();
        $insertArray = [
            'name'=>$input['name'],
            'email'=>$input['email'],
            'password'=>md5($input['password']),
            'token'=>$token
        ];

        $create = User::create($insertArray);
        if($create){
            return $this->sendResponse('Kayıt Tamamlandı',[
                'token'=>$token
            ]);
        }
        else
        {
            return $this->sendError('Kayıt yapılamadı');
        }


    }

    public function login(Request  $request){
        $input = $request->all();
        $control = User::where('email',$input['email'])
            ->where('password',md5($input['password']))
            ->count();

        if($control == 0){ return $this->sendError('Kullanıcı Bilgileri Hatalı');}
        $data = User::where('email',$input['email'])
            ->where('password',md5($input['password']))
            ->first();

        return $this->sendResponse('Kullanıcı Giriş Yaptı',[
            'token'=>$data->token
        ]);

    }


}
