<?php
  
namespace App\Http\Controllers;
  
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Validator;
use App\Models\User;
use Hash;

class UserController extends Controller{

    public function __construct(){
        $this->title = 'User';
        $this->slug = route('user.index');
    }

    public function index(Request $request){
        $serach_data = [];
        $response = User::orderBy('id','DESC')->where('deleted_at', '=', NULL);
        $rows = $response->paginate(20);

        $metadata = array(
            'page_title' => $this->title,
            'page_url' => $this->slug,
            'serach_data' => $serach_data,
            'breadcumb' => array(
                array(
                    'url' => '/dashboard',
                    'title' => 'Home',  
                ),
                array(
                    'url' => '',
                    'title' => $this->title,  
                )
            ),
        );

        return view('pages.user.list', compact('rows', 'metadata'));
    }

    public function destroy($id){
        $delete = User::find($id);
        $delete->delete();
        $flash_data = array(
            'status' => 'success',
            'message' => $this->title.' successfully deleted.',
        );

        Session::put('flash_data', $flash_data); 
        return redirect($this->slug);
    }
}
