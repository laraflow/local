<?php

namespace Laraflow\Local\Http\Controllers;
use Exception;
use Fintech\Core\Exceptions\StoreOperationException;
use Fintech\Core\Exceptions\UpdateOperationException;
use Fintech\Core\Exceptions\DeleteOperationException;
use Fintech\Core\Exceptions\RestoreOperationException;
use Fintech\Core\Traits\ApiResponseTrait;
use Laraflow\Local\Facades\Local;
use Laraflow\Local\Http\Resources\StateResource;
use Laraflow\Local\Http\Resources\StateCollection;
use Laraflow\Local\Http\Requests\ImportStateRequest;
use Laraflow\Local\Http\Requests\StoreStateRequest;
use Laraflow\Local\Http\Requests\UpdateStateRequest;
use Laraflow\Local\Http\Requests\IndexStateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

/**
 * Class StateController
 * @package Laraflow\Local\Http\Controllers
 *
 * @lrd:start
 * This class handle create, display, update, delete & restore
 * operation related to State
 * @lrd:end
 *
 */

class StateController extends Controller
{
    use ApiResponseTrait;

    /**
     * @lrd:start
     * Return a listing of the *State* resource as collection.
     *
     * *```paginate=false``` returns all resource as list not pagination*
     * @lrd:end
     *
     * @param IndexStateRequest $request
     * @return StateCollection|JsonResponse
     */
    public function index(IndexStateRequest $request): StateCollection|JsonResponse
    {
        try {
            $inputs = $request->validated();

            $statePaginate = Local::state()->list($inputs);

            return new StateCollection($statePaginate);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a new *State* resource in storage.
     * @lrd:end
     *
     * @param StoreStateRequest $request
     * @return JsonResponse
     * @throws StoreOperationException
     */
    public function store(StoreStateRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $state = Local::state()->create($inputs);

            if (!$state) {
                throw (new StoreOperationException)->setModel(config('fintech.local.state_model'));
            }

            return $this->created([
                'message' => __('core::messages.resource.created', ['model' => 'State']),
                'id' => $state->id
             ]);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Return a specified *State* resource found by id.
     * @lrd:end
     *
     * @param string|int $id
     * @return StateResource|JsonResponse
     * @throws ModelNotFoundException
     */
    public function show(string|int $id): StateResource|JsonResponse
    {
        try {

            $state = Local::state()->find($id);

            if (!$state) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.state_model'), $id);
            }

            return new StateResource($state);

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Update a specified *State* resource using id.
     * @lrd:end
     *
     * @param UpdateStateRequest $request
     * @param string|int $id
     * @return JsonResponse
     * @throws ModelNotFoundException
     * @throws UpdateOperationException
     */
    public function update(UpdateStateRequest $request, string|int $id): JsonResponse
    {
        try {

            $state = Local::state()->find($id);

            if (!$state) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.state_model'), $id);
            }

            $inputs = $request->validated();

            if (!Local::state()->update($id, $inputs)) {

                throw (new UpdateOperationException)->setModel(config('fintech.local.state_model'), $id);
            }

            return $this->updated(__('core::messages.resource.updated', ['model' => 'State']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Soft delete a specified *State* resource using id.
     * @lrd:end
     *
     * @param string|int $id
     * @return JsonResponse
     * @throws ModelNotFoundException
     * @throws DeleteOperationException
     */
    public function destroy(string|int $id)
    {
        try {

            $state = Local::state()->find($id);

            if (!$state) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.state_model'), $id);
            }

            if (!Local::state()->destroy($id)) {

                throw (new DeleteOperationException())->setModel(config('fintech.local.state_model'), $id);
            }

            return $this->deleted(__('core::messages.resource.deleted', ['model' => 'State']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Restore the specified *State* resource from trash.
     * ** ```Soft Delete``` needs to enabled to use this feature**
     * @lrd:end
     *
     * @param string|int $id
     * @return JsonResponse
     */
    public function restore(string|int $id)
    {
        try {

            $state = Local::state()->find($id, true);

            if (!$state) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.state_model'), $id);
            }

            if (!Local::state()->restore($id)) {

                throw (new RestoreOperationException())->setModel(config('fintech.local.state_model'), $id);
            }

            return $this->restored(__('core::messages.resource.restored', ['model' => 'State']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the *State* resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     *
     * @param IndexStateRequest $request
     * @return JsonResponse
     */
    public function export(IndexStateRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $statePaginate = Local::state()->export($inputs);

            return $this->exported(__('core::messages.resource.exported', ['model' => 'State']));

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the *State* resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     *
     * @param ImportStateRequest $request
     * @return StateCollection|JsonResponse
     */
    public function import(ImportStateRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $statePaginate = Local::state()->list($inputs);

            return new StateCollection($statePaginate);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }
}
