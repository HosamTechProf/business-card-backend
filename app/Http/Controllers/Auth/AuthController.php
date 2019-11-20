<?php
namespace App\Http\Controllers\Auth;
use App\User;
use App\Codes;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Image;
use Propaganistas\LaravelPhone\PhoneNumber;

class AuthController extends Controller
{
    public function login(Request $request) {
        $countryCode = $request->countryCode;
        $request->validate([
            'mobile'   => 'phone:'.$countryCode,
            'password' => 'required|string'
        ]);
        $mobile = PhoneNumber::make($request->mobile, $countryCode);
        // $credentials = request(['mobile', 'password']);
        $credentials = ['mobile'=>$mobile, 'password'=>$request->password];
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
        if($user->code != null){
            $code = rand(1234,9876);
            $user->code = $code;
            $user->save();
            return response()->json([
                'message' => 'Active Account',
                'access_token' => $tokenResult->accessToken,
                'mobile' => $mobile,
                'code' => $code
            ]);
        }
        return response()->json([
            'message'=>'Authorized',
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }
    public function register(Request $request)
    {
        $countryCode = $request->countryCode;
        $validator = Validator::make($request->all(), [
                  'name' => 'required',
                  'password' => 'required|min:6',
                  'c_password' => 'required|same:password',
                  'mobile'       => 'phone:'.$countryCode
        ]);
        if ($validator->fails()) {
           return response()->json(['error'=>$validator->errors()], 401);
        }

        $user = new User;
        $user->name = $request->name;
        $user->mobile = PhoneNumber::make($request->mobile, $countryCode);
        $user->isPublic = $request->isPublic;
        $user->password = bcrypt($request->password);
        $code = rand(1234,9876);
        $user->code = $code;
        $image = $request->image;

        if ($image == null) {
          $png_url = 'user.svg';
          $user->image = $png_url;
          $user->save();
          $success['token'] =  $user->createToken('AppName')->accessToken;
          return response()->json(['status'=>true,'success'=>$success,'msg'=>'Register Successful','mobile'=>PhoneNumber::make($request->mobile, $countryCode),'code'=>$code], 200);
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
          return response()->json(['status'=>true,'success'=>$success,'msg'=>'Register Successful','mobile'=>PhoneNumber::make($request->mobile, $countryCode),'code'=>$code], 200);
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
        $countryCode = PhoneNumber::make($request->mobile)->getCountry();
        $validator = Validator::make($request->all(), [
                  'name' => 'required',
                  'email' => 'nullable|email|unique:users,email,' . $id,
                  // 'mobile' => 'required|regex:/(01)[0-9]{9}/',
                  'mobile' => 'min:8',
                  'mobile'       => 'phone:'.$countryCode
                  // 'socialLink' => 'required'
        ]);
        if ($validator->fails()) {
           return response()->json(['error'=>$validator->errors()], 401);
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->mobile = PhoneNumber::make($request->mobile, $countryCode);
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
          $user->save();
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
        $type = $request->type;
        switch ($type) {
          case 'name':
            return User::where('name', 'like', '%' . $name . '%')->where('isPublic', 1)->where('name', '!=', $user)->get();
            break;
          case 'mobile':
            return User::where('mobile', 'like', '%' . $name . '%')->where('isPublic', 1)->where('name', '!=', $user)->get();
            break;
          case 'email':
            return User::where('email', 'like', '%' . $name . '%')->where('isPublic', 1)->where('name', '!=', $user)->get();
            break;
          case 'desc':
            return User::where('desc', 'like', '%' . $name . '%')->where('isPublic', 1)->where('name', '!=', $user)->get();
            break;
          case 'company':
            return User::where('company', 'like', '%' . $name . '%')->where('isPublic', 1)->where('name', '!=', $user)->get();
            break;
          default:
            return User::where('name', 'like', '%' . $name . '%')->where('isPublic', 1)->where('name', '!=', $user)->get();
            break;
        }
    }

    public function getCodes()
    {
      $codes = Codes::all();
      return response()->json($codes);
    }

    public function verifyCode(Request $request)
    {
      $user = User::where('mobile', $request->mobile)->first();
      if ($user->code == $request->code) {
        User::where('mobile', $request->mobile)->update(['code' => null]);
        return response()->json(['status'=>true]);
      }
      return response()->json(['status'=>false]);
    }
}
