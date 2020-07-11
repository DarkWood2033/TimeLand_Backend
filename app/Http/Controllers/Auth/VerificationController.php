<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Repositories\User\UserRepository;
use App\Services\Response\JsonResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\JsonResponse as BaseJsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class VerificationController extends Controller
{
    /**
     * VerificationController constructor.
     */
    public function __construct()
    {
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * @return Application|Factory|View
     */
    public function show()
    {
        return view('site.app');
    }

    /**
     * @param Request $request
     * @param UserRepository $userRepository
     * @return BaseJsonResponse
     * @throws AuthorizationException
     */
    public function verify(Request $request, UserRepository $userRepository)
    {
        if (! hash_equals((string) $request->get('id'), (string) $request->user()->getKey())) {
            throw new AuthorizationException;
        }

        if (! hash_equals((string) $request->get('hash'), sha1($request->user()->getEmailForVerification()))) {
            throw new AuthorizationException;
        }

        if ($request->user()->hasVerifiedEmail()) {
            return $this->responseAlreadyVerified();
        }

        $request->user()->markEmailAsVerified();
        $userRepository->update($request->user());
        event(new Verified($request->user()));

        return $this->responseConfirmed();
    }

    /**
     * @param Request $request
     * @return BaseJsonResponse
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->responseAlreadyVerified();
        }

        $request->user()->sendEmailVerificationNotification();

        return $this->responseResendEmail();
    }

    /**
     * @return BaseJsonResponse
     */
    protected function responseAlreadyVerified()
    {
        return (new JsonResponse)
            ->setStatus(204)
            ->send();
    }

    /**
     * @return BaseJsonResponse
     */
    protected function responseResendEmail()
    {
        return (new JsonResponse)
            ->setStatus(202)
            ->send();
    }

    /**
     * @return BaseJsonResponse
     */
    protected function responseConfirmed()
    {
        return (new JsonResponse)
            ->setStatus(202)
            ->send();
    }
}
