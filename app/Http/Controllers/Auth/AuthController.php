<?php
namespace App\Http\Controllers\Auth;
use App\User;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Image;
class AuthController extends Controller
{
    public function login(Request $request) {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            //'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if(!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
                  'name' => 'required',
                  'email' => 'required|email|unique:users',
                  'password' => 'required|min:6',
                  'c_password' => 'required|same:password',
                  // 'mobile' => 'required|regex:/(01)[0-9]{9}/',
                  'mobile' => 'required|min:8',
                  'desc' => 'required',
                  'company' => 'required',
                  'socialLink' => 'required'
        ]);
        if ($validator->fails()) {
           return response()->json(['error'=>$validator->errors()], 401);
        }
        // $input = $request->all();
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->mobile = $request->mobile;
        $user->desc = $request->desc;
        $user->company = $request->company;
        $user->socialLink = $request->socialLink;
        $user->isPublic = $request->isPublic;
        $user->password = bcrypt($request->password);

        // $input['password'] = bcrypt($input['password']);
        $image = $request->image;
        if ($image == null) {
          $png_url = 'user.svg';
          $user->image = $png_url;
        }
        else{
          $image = substr($image, strpos($image, ",")+1);
          $data = base64_decode($image);
          $png_url = "user-".time().".png";
          $path = public_path().'/img/users/' . $png_url;
          $user->image = $png_url;
          $user->save();
          file_put_contents($path, $data);
          $success['token'] =  $user->createToken('AppName')->accessToken;
          return response()->json(['status'=>true,'success'=>$success,'msg'=>'Register Successful'], 200);
        }
    }
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }
    public function update(Request $request)
    {
        $user = Auth::user();
        $id = $user->id;
        $validator = Validator::make($request->all(), [
                  'name' => 'required',
                  'email' => 'required|email|unique:users,email,' . $id,
                  // 'mobile' => 'required|regex:/(01)[0-9]{9}/',
                  'mobile' => 'required|min:8',
                  'desc' => 'required',
                  'company' => 'required',
                  'socialLink' => 'required'
        ]);
        if ($validator->fails()) {
           return response()->json(['error'=>$validator->errors()], 401);
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->mobile = $request->mobile;
        $user->desc = $request->desc;
        $user->company = $request->company;
        $user->socialLink = $request->socialLink;
        $user->isPublic = $request->isPublic;
        // if($request->has('image')) {
        // $user->save();
        $image = $request->image;
        if ($image == null) {
          $png_url = 'user.svg';
          $user->image = $png_url;
        }
        else{
          $image = substr($image, strpos($image, ",")+1);
          $data = base64_decode($image);
          $png_url = "user-".time().".png";
          $path = public_path().'/img/users/' . $png_url;
          $user->image = $png_url;
          $user->save();
          file_put_contents($path, $data);
        }
        // return response()->json($user);
        // }

        return response()->json($user);
    }
    public function search(Request $request)
    {
        $user = $request->user()->name;
        $name = $request->name;
        return User::where('name', 'like', '%' . $name . '%')->where('isPublic', 1)->where('name', '!=', $user)->get();
    }
}
