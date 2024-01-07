<?php
  
namespace App\Http\Controllers;
  
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use Validator;
use App\Models\User;
use App\Models\Blog;
use App\Models\Location;
use Hash;
  
class AdminController extends Controller{

    ### Index
    public function index($location_id = ''){
        $metadata = array(
            'page_title' => 'Home',
            'page_url' => '/',
            'serach_data' => [],
            'breadcumb' => array(
                array(
                    'url' => '/',
                    'title' => 'Home',  
                ),
            ),
        );
        $ip = $this->get_client_ip();
        if($ip){
            $get_location = Location::where('deleted_at', '=', NULL)->where('is_active', '=', 1)->where('ip_address', '=', $ip)->first();
            if($get_location){
                $location_id = $get_location->id;
            }
        }
        $rows = Blog::where('deleted_at', '=', NULL)->where('is_active', '=', 1)->get();
        if($location_id > 0){
            $rows = Blog::where('deleted_at', '=', NULL)->where('is_active', '=', 1)->where('location_id', '=', $location_id)->get();
        }
        return view('pages.home.index', compact('rows', 'metadata'));
    }  
   
    ### Login
    public function login(){
        if(Auth::check()){
            return redirect()->intended('/');
        }
        return view('pages.login.login');
    }  
      
    ### Registration
    public function registration(){
        return view('pages.login.registration');
    }
      
    ### Process Login
    public function processLogin(Request $request){
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/')->withSuccess('You have Successfully loggedin');
        }

        $error_responce = array(
            'status' => 'error',
            'message' => 'Invalid Login Credentials.',
        );
        Session::put('flash_data', $error_responce);
        return redirect()->back();
    }
      
    ### Process Registration
    public function postRegistration(Request $request){  
        $validator = Validator::make($request->all(), [ 
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        if ($validator->fails()) { 
            return redirect()->back()->withInput()->withErrors($validator); 
        }else{
            $data = $request->all();
            $data['password'] = Hash::make($request->password);
            $data['is_admin'] = '2';
            $data['email_verified_at'] = now();
            $create = User::create($data);

             $error_responce = array(
                'status' => 'success',
                'message' => 'Great! You have Successfully Completed Registration.',
            );
            Session::put('flash_data', $error_responce);
            return redirect("login");
        }
    }
    
    ### Dashboard
    public function dashboard(){
        $metadata = array(
            'page_title' => 'Dashboard'
        );
        if(Auth::check()){
            return view('pages.dashboard.dashboard')->with('metadata', $metadata);
        }
        $error_responce = array(
            'status' => 'error',
            'message' => 'Invalid Login Credentials.',
        );
        Session::put('flash_data', $error_responce);
        return redirect("login");
    }
    
    ### Save User Data
    public function create(array $data){
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }
    
    ### Logout
    public function logout() {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }

    // Function to get the client IP address
    function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}