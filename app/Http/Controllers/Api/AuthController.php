<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        public function store(){

            // dd(request()->all());
            $formData = request()->validate([
                
                'email'=>['required','email',Rule::unique('users','email')],
                'username'=>['required','max:255','min:3',Rule::unique('users','username'),'regex:/^[A-Za-z0-9]+$/'],
                'password' => [
                    'required',
                    'confirmed', // Make sure the password confirmation field is present and matches the password field
                    'min:8', // Require a minimum of 8 characters
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'
                    // Require at least one lowercase letter, one uppercase letter, one number, and one special character from @$!%*?&
                ],
                'userphoto' => ['required,image,mimes:jpeg,png,jpg,svg,max:2048'], 
    
            ],[
                'email.required'=>'we need your email address',
                'password.min'=>'Password should be more than 8 characters',
                
                'username.required'=>'username must be required',
                'password.password_confirmation' => "confirm password doesn't match with password"
            ]);
    
            
                if($file = request()->file('userimg')){
               
                    $image_name = md5(rand(1000, 10000));
                    $ext = strtolower($file->getClientOriginalExtension());
                    $image_full_name = $image_name.'.'.$ext;
                    $upload_path = './assets/avatars/';
                    $image_url = $upload_path.$image_full_name;
                    $file->move($upload_path, $image_full_name);
                    $formData['userphoto'] = $image_url;
                
                }else{
                    $formData['userphoto'] = "./assets/avatars/user.png";
                }
            
    
                $user = User::create($formData);
    
            
                //login 
                auth::login($user,$remember = true);
    
                return redirect('/')->with('success','Welcome Dear, '.$user->username);
        
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
