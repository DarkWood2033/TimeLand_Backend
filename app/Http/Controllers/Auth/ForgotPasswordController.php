<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\ForgotPasswordRequest;
use App\Services\Response\JsonResponse;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Http\JsonResponse as BaseJsonResponse;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * @param ForgotPasswordRequest $request
     * @return BaseJsonResponse
     */
    public function sendResetLinkEmail(ForgotPasswordRequest $request)
    {
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($response)
            : $this->sendResetLinkFailedResponse($response);
    }

    /**
     * @param $response
     * @return BaseJsonResponse
     */
    protected function sendResetLinkResponse($response)
    {
        return (new JsonResponse)
            ->setMessage(trans($response))
            ->send();
    }

    /**
     * @param $response
     * @return BaseJsonResponse
     */
    protected function sendResetLinkFailedResponse($response)
    {
        return (new JsonResponse)
            ->setStatus(422)
            ->setMessage('Invalid data')
            ->setErrors([ 'email' => [trans($response)] ])
            ->send();
    }

    /**
     * @param ForgotPasswordRequest $request
     * @return array
     */
    protected function credentials(ForgotPasswordRequest $request)
    {
        return $request->only('email');
    }

    /**
     * @return PasswordBroker
     */
    protected function broker()
    {
        return Password::broker();
    }
}
