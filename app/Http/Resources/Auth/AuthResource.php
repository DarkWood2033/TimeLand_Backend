<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthResource extends JsonResource
{
    private $token;

    public function __construct($resource, $token)
    {
        parent::__construct($resource);
        $this->token = $token;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'user' => [
                'name' => $this->resource->getName(),
                'email' => $this->resource->getEmail(),
                'verified' => $this->resource->hasVerifiedEmail()
            ],
            'token' => $this->token,
            'expired' => config('jwt.ttl')
        ];
    }
}
