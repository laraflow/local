<?php

namespace Laraflow\Local\Http\Controllers;
use Exception;
use Fintech\Core\Exceptions\StoreOperationException;
use Fintech\Core\Exceptions\UpdateOperationException;
use Fintech\Core\Exceptions\DeleteOperationException;
use Fintech\Core\Exceptions\RestoreOperationException;
use Fintech\Core\Traits\ApiResponseTrait;
use Laraflow\Local\Facades\Local;
use Laraflow\Local\Http\Resources\SubregionResource;
use Laraflow\Local\Http\Resources\SubregionCollection;
use Laraflow\Local\Http\Requests\ImportSubregionRequest;
use Laraflow\Local\Http\Requests\StoreSubregionRequest;
use Laraflow\Local\Http\Requests\UpdateSubregionRequest;
use Laraflow\Local\Http\Requests\IndexSubregionRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

/**
 * Class SubregionController
 * @package Laraflow\Local\Http\Controllers
 *
 * @lrd:start
 * This class handle create, display, update, delete & restore
 * operation related to Subregion
 * @lrd:end
 *
 */

class SubregionController extends Controller
{
    use ApiResponseTrait;

    /**
     * @lrd:start
     * Return a listing of the *Subregion* resource as collection.
     *
     * *```paginate=false``` returns all resource as list not pagination*
     * @lrd:end
     *
     * @param IndexSubregionRequest $request
     * @return SubregionCollection|JsonResponse
     */
    public function index(IndexSubregionRequest $request): SubregionCollection|JsonResponse
    {
        try {
            $inputs = $request->validated();

            $subregionPaginate = Local::subregion()->list($inputs);

            return new SubregionCollection($subregionPaginate);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a new *Subregion* resource in storage.
     * @lrd:end
     *
     * @param StoreSubregionRequest $request
     * @return JsonResponse
     * @throws StoreOperationException
     */
    public function store(StoreSubregionRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $subregion = Local::subregion()->create($inputs);

            if (!$subregion) {
                throw (new StoreOperationException)->setModel(config('fintech.local.subregion_model'));
            }

            return $this->created([
                'message' => __('core::messages.resource.created', ['model' => 'Subregion']),
                'id' => $subregion->id
             ]);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Return a specified *Subregion* resource found by id.
     * @lrd:end
     *
     * @param string|int $id
     * @return SubregionResource|JsonResponse
     * @throws ModelNotFoundException
     */
    public function show(string|int $id): SubregionResource|JsonResponse
    {
        try {

            $subregion = Local::subregion()->find($id);

            if (!$subregion) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.subregion_model'), $id);
            }

            return new SubregionResource($subregion);

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Update a specified *Subregion* resource using id.
     * @lrd:end
     *
     * @param UpdateSubregionRequest $request
     * @param string|int $id
     * @return JsonResponse
     * @throws ModelNotFoundException
     * @throws UpdateOperationException
     */
    public function update(UpdateSubregionRequest $request, string|int $id): JsonResponse
    {
        try {

            $subregion = Local::subregion()->find($id);

            if (!$subregion) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.subregion_model'), $id);
            }

            $inputs = $request->validated();

            if (!Local::subregion()->update($id, $inputs)) {

                throw (new UpdateOperationException)->setModel(config('fintech.local.subregion_model'), $id);
            }

            return $this->updated(__('core::messages.resource.updated', ['model' => 'Subregion']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Soft delete a specified *Subregion* resource using id.
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

            $subregion = Local::subregion()->find($id);

            if (!$subregion) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.subregion_model'), $id);
            }

            if (!Local::subregion()->destroy($id)) {

                throw (new DeleteOperationException())->setModel(config('fintech.local.subregion_model'), $id);
            }

            return $this->deleted(__('core::messages.resource.deleted', ['model' => 'Subregion']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Restore the specified *Subregion* resource from trash.
     * ** ```Soft Delete``` needs to enabled to use this feature**
     * @lrd:end
     *
     * @param string|int $id
     * @return JsonResponse
     */
    public function restore(string|int $id)
    {
        try {

            $subregion = Local::subregion()->find($id, true);

            if (!$subregion) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.subregion_model'), $id);
            }

            if (!Local::subregion()->restore($id)) {

                throw (new RestoreOperationException())->setModel(config('fintech.local.subregion_model'), $id);
            }

            return $this->restored(__('core::messages.resource.restored', ['model' => 'Subregion']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the *Subregion* resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     *
     * @param IndexSubregionRequest $request
     * @return JsonResponse
     */
    public function export(IndexSubregionRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $subregionPaginate = Local::subregion()->export($inputs);

            return $this->exported(__('core::messages.resource.exported', ['model' => 'Subregion']));

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the *Subregion* resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     *
     * @param ImportSubregionRequest $request
     * @return SubregionCollection|JsonResponse
     */
    public function import(ImportSubregionRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $subregionPaginate = Local::subregion()->list($inputs);

            return new SubregionCollection($subregionPaginate);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }
}
