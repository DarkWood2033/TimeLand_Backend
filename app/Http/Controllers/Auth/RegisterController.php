<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Resources\Auth\AuthResource;
use App\Repositories\User\UserRepository;
use App\Services\Response\JsonResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function registration(CreateUserRequest $request)
    {
        $user = $this->userRepository->create(
            $request->get('name'),
            $request->get('email'),
            $request->get('password')
        );

        event(new Registered($user));

        $token = $this->guard()->login($user);

        return (new JsonResponse())
            ->setMessage(trans('message.auth.registration.success'))
            ->setData((new AuthResource($this->guard()->user(), $token))->toArray($request))
            ->send();
    }

    protected function guard()
    {
        return auth()->guard();
    }
}
