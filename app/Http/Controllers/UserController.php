<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\AccountType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Log user in.
     *
     * @param Illuminate\Foundation\Http\FormRequest\LoginRequest $request
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
 
            return response()->noContent(Response::HTTP_OK);
        }

        
    }

    /**
     * Log out the current user.
     *
     * @param Illuminate\Foundation\Http\FormRequest\LoginRequest $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserRequest $request)
    {
        $validated = $request->validated();

        $userQuery = User::query();

        if($search = $validated['search']){
            $userQuery->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
        }

        if($orderBy = $validated['order_by']){
            $direction = (isset($validated['direction'] ) && $validated['direction'] == 'desc') ? 'desc' : 'asc';

            $userQuery->orderBy($orderBy, $direction);
        }

        return UserResource::collection($userQuery->paginate(20));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Illuminate\Foundation\Http\FormRequest\RegisterRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = new User();

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
        ]);

        $user->accounttype_id = AccountType::default();

        $user->save();

        return response()->noContent(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        $validated = $request->validated();

        if($validated['name'] !== $user->name){
            $user->name = $validated['name'];
        }

        if($validated['email'] !== $user->email){
            $user->email = $validated['email'];
        }

        if($validated['phone'] !== $user->phone){
            $user->phone = $validated['phone'];
        }

        $user->save();

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  App\Models\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $user->delete();

        return response()->noContent(Response::HTTP_NO_CONTENT);
    }
}
