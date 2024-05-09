<?php

namespace Laraflow\Local\Http\Controllers;

use Exception;
use Fintech\Core\Exceptions\DeleteOperationException;
use Fintech\Core\Exceptions\RestoreOperationException;
use Fintech\Core\Exceptions\StoreOperationException;
use Fintech\Core\Exceptions\UpdateOperationException;
use Fintech\RestApi\Traits\ApiResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Laraflow\Local\Facades\Local;
use Laraflow\Local\Http\Requests\ImportStateRequest;
use Laraflow\Local\Http\Requests\IndexStateRequest;
use Laraflow\Local\Http\Requests\StoreStateRequest;
use Laraflow\Local\Http\Requests\UpdateStateRequest;
use Laraflow\Local\Http\Resources\StateCollection;
use Laraflow\Local\Http\Resources\StateResource;

/**
 * Class StateController
 *
 * @lrd:start
 * This class handle create, display, update, delete & restore
 * operation related to State
 *
 * @lrd:end
 */
class StateController extends Controller
{
    use ApiResponseTrait;

    /**
     * @lrd:start
     * Return a listing of the *State* resource as collection.
     *
     * *```paginate=false``` returns all resource as list not pagination*
     *
     * @lrd:end
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
     *
     * @lrd:end
     *
     * @throws StoreOperationException
     */
    public function store(StoreStateRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $state = Local::state()->create($inputs);

            if (! $state) {
                throw (new StoreOperationException)->setModel(config('fintech.local.state_model'));
            }

            return $this->created([
                'message' => __('restapi::messages.resource.created', ['model' => 'State']),
                'id' => $state->id,
            ]);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Return a specified *State* resource found by id.
     *
     * @lrd:end
     *
     * @throws ModelNotFoundException
     */
    public function show(string|int $id): StateResource|JsonResponse
    {
        try {

            $state = Local::state()->find($id);

            if (! $state) {
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
     *
     * @lrd:end
     *
     * @throws ModelNotFoundException
     * @throws UpdateOperationException
     */
    public function update(UpdateStateRequest $request, string|int $id): JsonResponse
    {
        try {

            $state = Local::state()->find($id);

            if (! $state) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.state_model'), $id);
            }

            $inputs = $request->validated();

            if (! Local::state()->update($id, $inputs)) {

                throw (new UpdateOperationException)->setModel(config('fintech.local.state_model'), $id);
            }

            return $this->updated(__('restapi::messages.resource.updated', ['model' => 'State']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Soft delete a specified *State* resource using id.
     *
     * @lrd:end
     *
     * @return JsonResponse
     *
     * @throws ModelNotFoundException
     * @throws DeleteOperationException
     */
    public function destroy(string|int $id)
    {
        try {

            $state = Local::state()->find($id);

            if (! $state) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.state_model'), $id);
            }

            if (! Local::state()->destroy($id)) {

                throw (new DeleteOperationException())->setModel(config('fintech.local.state_model'), $id);
            }

            return $this->deleted(__('restapi::messages.resource.deleted', ['model' => 'State']));

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
     *
     * @lrd:end
     *
     * @return JsonResponse
     */
    public function restore(string|int $id)
    {
        try {

            $state = Local::state()->find($id, true);

            if (! $state) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.state_model'), $id);
            }

            if (! Local::state()->restore($id)) {

                throw (new RestoreOperationException())->setModel(config('fintech.local.state_model'), $id);
            }

            return $this->restored(__('restapi::messages.resource.restored', ['model' => 'State']));

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
     */
    public function export(IndexStateRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $statePaginate = Local::state()->export($inputs);

            return $this->exported(__('restapi::messages.resource.exported', ['model' => 'State']));

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
