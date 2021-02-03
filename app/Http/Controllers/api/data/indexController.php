<?php
namespace App\Http\Controllers\api\data;

use App\Comment;
use App\Data;
use App\Http\Controllers\api\BaseController;
use App\User;
use \Illuminate\Http\Request;


class indexController extends BaseController
{
    public function create(Request  $request){
        $input = $request->all();
        // token : ae35abfa
        $userId = User::getUserId($input['token']);
        $insertArray = [
          'userId'=>$userId,
          'name'=>$input['name'],
          'text'=>$input['text']
        ];
        $create = Data::create($insertArray);
        if($create){
            return $this->sendResponse('Eklendi',[
                'id'=>$create->id
            ]);
        }
        else
        {
            return $this->sendError('Ekleme Başarısız');
        }


    }

    public function list($token){
        $userId = User::getUserId($token);
        $data = Data::where('userId',$userId)->get();

        return $this->sendResponse('',[
            'data'=>$data
        ]);
    }

    public function update(Request  $request){
        $input = $request->all();
        $userId = User::getUserId($input['token']);
        $updateArray = [
            'name'=>$input['name'],
            'text'=>$input['text']
        ];
        $update = Data::where('id',$input['id'])->where('userId',$userId)->update($updateArray);
        if($update){
            return $this->sendResponse('Bilgiler Güncellendi');
        }
        else
        {
            return $this->sendError('Bilgiler güncellenemedi');
        }


    }

    public function delete(Request  $request){
        $input = $request->all();
        $userId = User::getUserId($input['token']);
        $delete = Data::where('id',$input['id'])->where('userId',$userId)->delete();
        if($delete){
            return $this->sendResponse('Not Silindi');
        }
        else {
            return $this->sendError('Not Silinemedi');
        }
    }

    public function detail($token,$id){
        $userId = User::getUserId($token);
        $c = Data::where('userId',$userId)->where('id',$id)->count();
        if($c == 0){ return $this->sendError('Auth Hatalı');}
        $data = Data::where('id',$id)->first();
        $comments = Comment::where('dataId',$id)->get();
        return $this->sendResponse('',[
            'comments'=>$comments,
            'data'=>$data
        ]);
    }

}
