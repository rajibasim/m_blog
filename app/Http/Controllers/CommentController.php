<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use Validator;

class CommentController extends Controller{

    public function __construct(){
        //$this->title = 'Blog';
        $this->slug = route('comment.index');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [ 
            'comment' => 'required',
        ]); 

        if ($validator->fails()) { 
            return redirect()->back()->withInput()->withErrors($validator); 
        }else{
            $data = $request->all();
            $data['comment_by'] = Auth::user()->id;
            Comment::query()->create($data);
            $flash_data = array(
                'status' => 'success',
                'message' => 'Comment successfully post.',
            );

            Session::put('flash_data', $flash_data); 
            return redirect('/');
        }
    }
}
