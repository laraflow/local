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
use Laraflow\Local\Http\Requests\ImportRegionRequest;
use Laraflow\Local\Http\Requests\IndexRegionRequest;
use Laraflow\Local\Http\Requests\StoreRegionRequest;
use Laraflow\Local\Http\Requests\UpdateRegionRequest;
use Laraflow\Local\Http\Resources\RegionCollection;
use Laraflow\Local\Http\Resources\RegionResource;

/**
 * Class RegionController
 *
 * @lrd:start
 * This class handle create, display, update, delete & restore
 * operation related to Region
 *
 * @lrd:end
 */
class RegionController extends Controller
{
    use ApiResponseTrait;

    /**
     * @lrd:start
     * Return a listing of the *Region* resource as collection.
     *
     * *```paginate=false``` returns all resource as list not pagination*
     *
     * @lrd:end
     */
    public function index(IndexRegionRequest $request): RegionCollection|JsonResponse
    {
        try {
            $inputs = $request->validated();

            $regionPaginate = Local::region()->list($inputs);

            return new RegionCollection($regionPaginate);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a new *Region* resource in storage.
     *
     * @lrd:end
     *
     * @throws StoreOperationException
     */
    public function store(StoreRegionRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $region = Local::region()->create($inputs);

            if (! $region) {
                throw (new StoreOperationException)->setModel(config('fintech.local.region_model'));
            }

            return $this->created([
                'message' => __('restapi::messages.resource.created', ['model' => 'Region']),
                'id' => $region->id,
            ]);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Return a specified *Region* resource found by id.
     *
     * @lrd:end
     *
     * @throws ModelNotFoundException
     */
    public function show(string|int $id): RegionResource|JsonResponse
    {
        try {

            $region = Local::region()->find($id);

            if (! $region) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.region_model'), $id);
            }

            return new RegionResource($region);

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Update a specified *Region* resource using id.
     *
     * @lrd:end
     *
     * @throws ModelNotFoundException
     * @throws UpdateOperationException
     */
    public function update(UpdateRegionRequest $request, string|int $id): JsonResponse
    {
        try {

            $region = Local::region()->find($id);

            if (! $region) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.region_model'), $id);
            }

            $inputs = $request->validated();

            if (! Local::region()->update($id, $inputs)) {

                throw (new UpdateOperationException)->setModel(config('fintech.local.region_model'), $id);
            }

            return $this->updated(__('restapi::messages.resource.updated', ['model' => 'Region']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Soft delete a specified *Region* resource using id.
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

            $region = Local::region()->find($id);

            if (! $region) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.region_model'), $id);
            }

            if (! Local::region()->destroy($id)) {

                throw (new DeleteOperationException())->setModel(config('fintech.local.region_model'), $id);
            }

            return $this->deleted(__('restapi::messages.resource.deleted', ['model' => 'Region']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Restore the specified *Region* resource from trash.
     * ** ```Soft Delete``` needs to enabled to use this feature**
     *
     * @lrd:end
     *
     * @return JsonResponse
     */
    public function restore(string|int $id)
    {
        try {

            $region = Local::region()->find($id, true);

            if (! $region) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.region_model'), $id);
            }

            if (! Local::region()->restore($id)) {

                throw (new RestoreOperationException())->setModel(config('fintech.local.region_model'), $id);
            }

            return $this->restored(__('restapi::messages.resource.restored', ['model' => 'Region']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the *Region* resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     */
    public function export(IndexRegionRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $regionPaginate = Local::region()->export($inputs);

            return $this->exported(__('restapi::messages.resource.exported', ['model' => 'Region']));

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the *Region* resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     *
     * @return RegionCollection|JsonResponse
     */
    public function import(ImportRegionRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $regionPaginate = Local::region()->list($inputs);

            return new RegionCollection($regionPaginate);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }
}
