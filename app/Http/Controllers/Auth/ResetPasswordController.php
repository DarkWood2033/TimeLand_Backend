<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Repositories\User\UserRepository;
use App\Services\Response\JsonResponse;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse as BaseJsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class ResetPasswordController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function show()
    {
        return view('site.app');
    }

    /**
     * @param ResetPasswordRequest $request
     * @param UserRepository $userRepository
     * @return BaseJsonResponse
     */
    public function reset(ResetPasswordRequest $request, UserRepository $userRepository)
    {
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) use ($userRepository) {
                $this->resetPassword($user, $password, $userRepository);
            }
        );

        return $response == Password::PASSWORD_RESET
            ? $this->sendResetResponse($response)
            : $this->sendResetFailedResponse($response);
    }

    /**
     * @param $user
     * @param $password
     * @param UserRepository $userRepository
     */
    protected function resetPassword($user, $password, UserRepository $userRepository)
    {
        $user->setPassword($password);
        $userRepository->update($user);
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        return $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );
    }

    /**
     * @param $response
     * @return BaseJsonResponse
     */
    protected function sendResetResponse($response)
    {
        return (new JsonResponse)
            ->setMessage(trans($response))
            ->send();
    }

    /**
     * @param $response
     * @return BaseJsonResponse
     */
    protected function sendResetFailedResponse($response)
    {
        return (new JsonResponse)
            ->setStatus(422)
            ->setMessage('Invalid data')
            ->setErrors([ 'email' => [trans($response)] ])
            ->send();
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return PasswordBroker
     */
    protected function broker()
    {
        return Password::broker();
    }

    /**
     * Get the guard to be used during password reset.
     *
     * @return StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
