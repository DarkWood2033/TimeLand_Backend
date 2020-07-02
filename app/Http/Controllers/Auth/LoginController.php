<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthRequest;
use App\Http\Resources\Auth\AuthResource;
use App\Services\Response\JsonResponse;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\JsonResponse as BaseJsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    use ThrottlesLogins;

    /**
     * @var int
     */
    protected $maxAttempts = 3;
    /**
     * @var int
     */
    protected $decayMinutes = 5;

    /**
     * @param AuthRequest $request
     * @return AuthResource|RedirectResponse|mixed|\Symfony\Component\HttpFoundation\Response|void
     * @throws ValidationException
     */
    public function login(AuthRequest $request)
    {
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($token = $this->guard()->attempt($this->credentials($request))) {
            return $this->sendLoginResponse($request, $token);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * @return BaseJsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();

        return (new JsonResponse())
            ->setMessage(trans('message.auth.logout.success'))
            ->send();
    }

    protected function credentials(AuthRequest $request)
    {
        return $request->only($this->username(), 'password');
    }

    /**
     * @param Request $request
     * @param $token
     * @return AuthResource
     */
    protected function sendLoginResponse(Request $request, $token)
    {
        $this->clearLoginAttempts($request);

        return new AuthResource(auth()->user(), $token);
    }

    /**
     * @param AuthRequest $request
     * @throws ValidationException
     */
    protected function sendFailedLoginResponse(AuthRequest $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('message.auth.login.error')],
        ]);
    }

    /**
     * @return string
     */
    protected function username()
    {
        return 'name';
    }

    /**
     * @param AuthRequest $request
     * @throws ValidationException
     */
    protected function sendLockoutResponse(AuthRequest $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        throw ValidationException::withMessages([
            $this->username() => [
                trans('message.auth.login.limit', ['seconds' => $seconds])
            ],
        ])->status(Response::HTTP_TOO_MANY_REQUESTS);
    }

    /**
     * @return Guard|StatefulGuard
     */
    protected function guard()
    {
        return auth()->guard();
    }
}
