<?php

namespace App\Http\Controllers\Timer;

use App\Entities\Timer;
use App\Entities\User;
use App\Exceptions\Timer\NotFoundTimerException;
use App\Exceptions\User\NotFoundUserException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Timer\TimerStoreRequest;
use App\Http\Requests\Timer\TimerUpdateRequest;
use App\Http\Resources\Timer\TimerCollection;
use App\Http\Resources\Timer\TimerResource;
use App\Repositories\Timer\TimerRepository;
use App\Repositories\User\UserRepository;
use App\Services\Response\JsonResponse;
use Illuminate\Http\JsonResponse as BaseJsonResponse;

class TimerController extends Controller
{
    /**
     * @var TimerRepository
     */
    private $timerRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(TimerRepository $timerRepository, UserRepository $userRepository)
    {
        $this->timerRepository = $timerRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @return BaseJsonResponse
     * @throws NotFoundUserException
     */
    public function index()
    {
        $timers = $this->timerRepository->getAllByUser($this->getUser());

        return (new JsonResponse)
            ->setItems(new TimerCollection($timers))
            ->send();
    }

    /**
     * @param TimerStoreRequest $request
     * @return BaseJsonResponse
     * @throws NotFoundUserException
     */
    public function store(TimerStoreRequest $request)
    {
        $data = $request->all();
        $timer = $this->timerRepository->create(
            $data['name'],
            $this->getUser(),
            $data['items']->getItems(),
            $data['items']->getType(),
            $data['items']->getCommonTime()
        );

        return (new JsonResponse)
            ->setItem(new TimerResource($timer))
            ->send();
    }

    /**
     * @param $id
     * @return BaseJsonResponse
     * @throws NotFoundTimerException|NotFoundUserException
     */
    public function show($id)
    {
        $timer = $this->getTimerByUser($id);

        return (new JsonResponse)
            ->setItem(new TimerResource($timer))
            ->send();
    }

    /**
     * @param TimerUpdateRequest $request
     * @param $id
     * @return BaseJsonResponse
     * @throws NotFoundTimerException|NotFoundUserException
     */
    public function update(TimerUpdateRequest $request, $id)
    {
        $timer = $this->getTimerByUser($id);
        $data = $request->all();

        if($name = $data['name']){
            $timer->setName($name);
        }
        if($item = $data['items']){
            $timer->setItems($item->getItems());
            $timer->setCommonTime($item->getCommonTime());
        }

        $this->timerRepository->update($timer);

        return (new JsonResponse)
            ->send();
    }

    /**
     * @param $id
     * @return BaseJsonResponse
     * @throws NotFoundTimerException|NotFoundUserException
     */
    public function destroy($id)
    {
        $timer = $this->getTimerByUser($id);

        $this->timerRepository->remove($timer);

        return (new JsonResponse)
            ->send();
    }

    /**
     * @return User
     * @throws NotFoundUserException
     */
    protected function getUser()
    {
        if($user = $this->userRepository->getEdit(auth()->user()->getId())){

            return $user;
        }

        throw NotFoundUserException::byId(auth()->user()->getId());
    }

    /**
     * @param $id
     * @return Timer
     * @throws NotFoundTimerException|NotFoundUserException
     */
    protected function getTimerByUser($id)
    {
        if($timer = $this->timerRepository->getEditByUser($this->getUser(), $id)){

            return $timer;
        }

        throw NotFoundTimerException::byId($id);
    }
}
