<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Http\Requests\Support\SupportRequest;
use App\Repositories\Support\SupportRepository;
use App\Services\Response\JsonResponse;
use Illuminate\Http\JsonResponse as BaseJsonResponse;

class SupportController extends Controller
{
    private const REPEAT_TIME = 600;

    /**
     * @var SupportRepository
     */
    private $supportRepository;

    public function __construct(SupportRepository $supportRepository)
    {
        $this->supportRepository = $supportRepository;
    }

    /**
     * @param SupportRequest $request
     * @return BaseJsonResponse
     */
    public function store(SupportRequest $request)
    {
        if(($left_time = $this->hasTooManySupportSend($request)) !== true) {
            return (new JsonResponse)
                ->setStatus('429')
                ->setErrors([
                    'email' => $left_time
                ])
                ->send();
        }

        if (auth()->check()) {
            $this->supportRepository->create(
                auth()->user()->getName(),
                auth()->user()->getEmail(),
                $request->get('subject'),
                $request->get('message')
            );
        } else {
            $this->supportRepository->create(
                $request->get('name'),
                $request->get('email'),
                $request->get('subject'),
                $request->get('message')
            );
        }

        $this->setTimeSupportSend($request);

        return (new JsonResponse)
            ->send();
    }

    public function hasTooManySupportSend(SupportRequest $request)
    {
        $last_send_time = \Cache::get($this->getKeyCache($request));
        $left_time = time() - $last_send_time;
        if(self::REPEAT_TIME < $left_time){
            return true;
        }
        return self::REPEAT_TIME - $left_time;
    }

    public function setTimeSupportSend(SupportRequest $request)
    {
        \Cache::put($this->getKeyCache($request), time());
    }

    protected function getKeyCache(SupportRequest $request)
    {
        return 'supports.'.$request->ip();
    }
}
