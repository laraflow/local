<?php

namespace Laraflow\Local\Http\Controllers;

use Exception;
use Fintech\Core\Exceptions\DeleteOperationException;
use Fintech\Core\Exceptions\RestoreOperationException;
use Fintech\Core\Exceptions\StoreOperationException;
use Fintech\Core\Exceptions\UpdateOperationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Laraflow\Local\Facades\Local;
use Laraflow\Local\Http\Requests\ImportSubregionRequest;
use Laraflow\Local\Http\Requests\IndexSubregionRequest;
use Laraflow\Local\Http\Requests\StoreSubregionRequest;
use Laraflow\Local\Http\Requests\UpdateSubregionRequest;
use Laraflow\Local\Http\Resources\SubregionCollection;
use Laraflow\Local\Http\Resources\SubregionResource;

/**
 * Class SubregionController
 *
 * @lrd:start
 * This class handle create, display, update, delete & restore
 * operation related to Subregion
 *
 * @lrd:end
 */
class SubregionController extends Controller
{
    /**
     * @lrd:start
     * Return a listing of the *Subregion* resource as collection.
     *
     * *```paginate=false``` returns all resource as list not pagination*
     *
     * @lrd:end
     */
    public function index(IndexSubregionRequest $request): SubregionCollection|JsonResponse
    {
        try {
            $inputs = $request->validated();

            $subregionPaginate = Local::subregion()->list($inputs);

            return new SubregionCollection($subregionPaginate);

        } catch (Exception $exception) {

            return response()->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a new *Subregion* resource in storage.
     *
     * @lrd:end
     *
     * @throws StoreOperationException
     */
    public function store(StoreSubregionRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $subregion = Local::subregion()->create($inputs);

            if (! $subregion) {
                throw (new StoreOperationException)->setModel(config('fintech.local.subregion_model'));
            }

            return response()->created([
                'message' => __('restapi::messages.resource.created', ['model' => 'Subregion']),
                'id' => $subregion->id,
            ]);

        } catch (Exception $exception) {

            return response()->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Return a specified *Subregion* resource found by id.
     *
     * @lrd:end
     *
     * @throws ModelNotFoundException
     */
    public function show(string|int $id): SubregionResource|JsonResponse
    {
        try {

            $subregion = Local::subregion()->find($id);

            if (! $subregion) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.subregion_model'), $id);
            }

            return new SubregionResource($subregion);

        } catch (ModelNotFoundException $exception) {

            return response()->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return response()->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Update a specified *Subregion* resource using id.
     *
     * @lrd:end
     *
     * @throws ModelNotFoundException
     * @throws UpdateOperationException
     */
    public function update(UpdateSubregionRequest $request, string|int $id): JsonResponse
    {
        try {

            $subregion = Local::subregion()->find($id);

            if (! $subregion) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.subregion_model'), $id);
            }

            $inputs = $request->validated();

            if (! Local::subregion()->update($id, $inputs)) {

                throw (new UpdateOperationException)->setModel(config('fintech.local.subregion_model'), $id);
            }

            return response()->updated(__('restapi::messages.resource.updated', ['model' => 'Subregion']));

        } catch (ModelNotFoundException $exception) {

            return response()->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return response()->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Soft delete a specified *Subregion* resource using id.
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

            $subregion = Local::subregion()->find($id);

            if (! $subregion) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.subregion_model'), $id);
            }

            if (! Local::subregion()->destroy($id)) {

                throw (new DeleteOperationException())->setModel(config('fintech.local.subregion_model'), $id);
            }

            return response()->deleted(__('restapi::messages.resource.deleted', ['model' => 'Subregion']));

        } catch (ModelNotFoundException $exception) {

            return response()->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return response()->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Restore the specified *Subregion* resource from trash.
     * ** ```Soft Delete``` needs to enabled to use this feature**
     *
     * @lrd:end
     *
     * @return JsonResponse
     */
    public function restore(string|int $id)
    {
        try {

            $subregion = Local::subregion()->find($id, true);

            if (! $subregion) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.subregion_model'), $id);
            }

            if (! Local::subregion()->restore($id)) {

                throw (new RestoreOperationException())->setModel(config('fintech.local.subregion_model'), $id);
            }

            return response()->restored(__('restapi::messages.resource.restored', ['model' => 'Subregion']));

        } catch (ModelNotFoundException $exception) {

            return response()->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return response()->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the *Subregion* resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     */
    public function export(IndexSubregionRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $subregionPaginate = Local::subregion()->export($inputs);

            return response()->exported(__('restapi::messages.resource.exported', ['model' => 'Subregion']));

        } catch (Exception $exception) {

            return response()->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the *Subregion* resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     *
     * @return SubregionCollection|JsonResponse
     */
    public function import(ImportSubregionRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $subregionPaginate = Local::subregion()->list($inputs);

            return new SubregionCollection($subregionPaginate);

        } catch (Exception $exception) {

            return response()->failed($exception->getMessage());
        }
    }
}
