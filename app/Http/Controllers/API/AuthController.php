<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

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

            $userAuth = Auth::user();

            $user = User::join('profiles', 'users.id', '=', 'profiles.user_id')
                        ->select('users.*', 'profiles.photo', 'profiles.genre', 'profiles.phone_number', 'profiles.birthday')
                        ->where('users.id', $userAuth->id)
                        ->get();

            $success['token'] = $userAuth->createToken(config('app.name'))->accessToken;
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

        $userAuth = User::create($input);

        Profile::updateOrInsert(
            ['user_id' => $userAuth->id,]
        );

        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {

            $userAuth = Auth::user();

            $user = User::join('profiles', 'users.id', '=', 'profiles.user_id')
                        ->select('users.*', 'profiles.photo', 'profiles.genre', 'profiles.phone_number', 'profiles.birthday')
                        ->where('users.id', $userAuth->id)
                        ->get();

            $success['token'] = $userAuth->createToken(config('app.name'))->accessToken;
            $success['user'] = $user;


            return $this->sendResponse($success, 'Registration successfully!');

        } else {

            return $this->sendError('Unauthorized.', ['error' => 'Unauthorized']);
        }
    }

    public function uploadProfile(Request $request):JsonResponse
    {
        $path = $request->file('file')->store('public/profile');
        $userAuth = auth()->user();

        Profile::where('user_id', $userAuth->id)->update(['photo' => $path]);


        $user = User::join('profiles', 'users.id', '=', 'profiles.user_id')
                    ->select('users.*', 'profiles.photo', 'profiles.genre', 'profiles.phone_number', 'profiles.birthday')
                    ->where('users.id', $userAuth->id)
                    ->get();

        $success['token'] = $userAuth->createToken(config('app.name'))->accessToken;
        $success['user'] = $user;
        $success['path'] = $path;

        return $this->sendResponse($success, 'Profil mise à jour avec succès!');
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

            $userAuth = auth()->user();

            User::where('id', $userAuth->id)->update(['name' => $data['name'], 'email' => $data['email']]);
            Profile::updateOrInsert(
                ['user_id' => $userAuth->id,],
                [
                'genre' => $data['gender'],
                'phone_number'=> $data['phone'],
                'birthday' => $data['birthday'],
                ]
            );

            $user = User::join('profiles', 'users.id', '=', 'profiles.user_id')
                        ->select('users.*', 'profiles.photo', 'profiles.genre', 'profiles.phone_number', 'profiles.birthday')
                        ->where('users.id', $userAuth->id)
                        ->get();

            $success['token'] = $userAuth->createToken(config('app.name'))->accessToken;
            $success['user'] = $user;

            return $this->sendResponse($success, 'Profil mise à jour avec succès!');
    }

    public function changePassword(Request $request):JsonResponse {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = $request->user();

        if(Hash::check($request->old_password, $user->password)){
            $user->update([
                'password' => Hash::make($request->password)
            ]);


            return $this->sendResponse([], 'Mot de passe mise à jour avec succès!');
        }
        else{
            return $this->sendError('Validation Error.', 'Mot de passe incorrect');
        }
    }
}
