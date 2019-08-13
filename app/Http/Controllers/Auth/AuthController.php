<?php
namespace App\Http\Controllers\Auth;
use App\User;
use Validator;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
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
                  'mobile' => 'required|regex:/(01)[0-9]{9}/',
        ]);
        if ($validator->fails()) {
           return response()->json(['error'=>$validator->errors()], 401);
        }
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('AppName')->accessToken;
        return response()->json(['status'=>true,'success'=>$success,'msg'=>'Register Successful'], 200);
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
        if($request->has('name')) {
        $user->name = $request->name;
        $user->save();
        }
        elseif($request->has('email')) {
        $user->email = $request->email;
        $user->save();
        }
        elseif($request->has('phone')) {
        $user->phone = $request->phone;
        $user->save();
        }
        elseif($request->has('company')) {
        $user->company = $request->company;
        $user->save();
        }
        elseif($request->has('mobile')) {
        $user->mobile = $request->mobile;
        $user->save();
        }
        elseif($request->has('desc')) {
        $user->desc = $request->desc;
        $user->save();
        }
        elseif($request->has('isPublic')) {
        $user->isPublic = $request->isPublic;
        $user->save();
        }
        return response()->json($user);
    }
    public function search(Request $request)
    {
        $user = $request->user()->name;
        $name = $request->name;
        return User::where('name', 'like', '%' . $name . '%')->where('isPublic', 1)->where('name', '!=', $user)->get();
    }
}
