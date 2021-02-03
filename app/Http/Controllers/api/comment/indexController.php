<?php
namespace App\Http\Controllers\api\comment;

use App\Comment;
use App\Data;
use App\Http\Controllers\api\BaseController;
use App\User;
use \Illuminate\Http\Request;


class indexController extends BaseController
{
    public function create(Request  $request){
        $input = $request->all();
        $userId = User::getUserId($input['token']);
        $insertArray = [
          'text'=>$input['text'],
          'dataId'=>$input['dataId'],
          'userId'=>$userId
        ];

        $create = Comment::create($insertArray);
        if($create){
            return $this->sendResponse('Yorum başarı ile Eklendi.');
        }
        else
        {
            return $this->sendError('Yorum Eklenemedi');
        }

    }

    public function update(Request  $request){
        $input = $request->all();
        $userId = User::getUserId($input['token']);

        $update = Comment::where('id',$input['id'])
            ->where('userId',$userId)
            ->update([
                'text'=>$input['text']
            ]);

        if($update){
            return $this->sendResponse('Başarı ile güncellendi',[]);
        }
        else
        {
            return $this->sendError('Bir hata oluştu');
        }

    }

    public function delete(Request  $request){
        $input = $request->all();
        $userId = User::getUserId($input['token']);

        $delete = Comment::where('id',$input['id'])
            ->where('userId',$userId)
            ->delete();

        if($delete){
            return $this->sendResponse('Başarı ile Silindi',[]);
        }
        else
        {
            return $this->sendError('Bir hata oluştu');
        }

    }
}
