<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class AuthController extends BaseController
{
    public function login(Request $request):JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {

            return $this->sendError('Validation Error.', $validator->errors());
        }

        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {

            $user = Auth::user();
            $success['token'] = $user->createToken(config('app.name'))->accessToken;
            $success['user'] = $user;

            return $this->sendResponse($success, 'Login successfully!');

        } else {

            return $this->sendError('Unauthorized.', ['error' => 'Unauthorized']);
        }
    }

    public function register(Request $request):JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        if ($validator->fails()) {

            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['user_type'] = 'customer';

        $user = User::create($input);

        $success['token'] = $user->createToken(config('app.name'))->accessToken;
        $success['user'] = $user;

        return $this->sendResponse($success, 'Registration successfully!');
    }

    public function updateAuth(Request $request):JsonResponse
    {

            $validator = Validator::make($request->all(), [
                'phone' => 'required',
                'email' => 'required|email',
                'birthday' => 'required',
                'name' => 'required',
                'gender' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }

            $data = $request->all();

            $user = auth()->user();

            User::where('id', $user->id)->update(['name' => $data['name'], 'email' => $data['email']]);

            $profile = Profile::updateOrCreate([
<<<<<<< HEAD
               	 'user_id' => $user->id,
                 'genre' => $data['gender'],
                 'phone_number'=> $data['phone'],
                 'birthday' => $data['birthday'],
=======
                'user_id' => $user->id,
                'genre' => $data['gender'],
                'phone_number'=> $data['phone'],
                'birthday' => $data['birthday'],
>>>>>>> 171b48d4aeb1c25da382406b428a932ed5a14fc6
            ]);

            $success['token'] = $user->createToken(config('app.name'))->accessToken;
            $success['user'] = $user;
            $success['profile'] = $profile;

            return $this->sendResponse($success, 'Profil mise à jour avec succès!');
    }
}