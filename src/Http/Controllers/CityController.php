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
use Laraflow\Local\Http\Requests\IndexCityRequest;
use Laraflow\Local\Http\Requests\StoreCityRequest;
use Laraflow\Local\Http\Requests\UpdateCityRequest;
use Laraflow\Local\Http\Resources\CityCollection;
use Laraflow\Local\Http\Resources\CityResource;

/**
 * Class CityController
 *
 * @lrd:start
 * This class handle create, display, update, delete & restore
 * operation related to City
 *
 * @lrd:end
 */
class CityController extends Controller
{
    use ApiResponseTrait;

    /**
     * @lrd:start
     * Return a listing of the *City* resource as collection.
     *
     * *```paginate=false``` returns all resource as list not pagination*
     *
     * @lrd:end
     */
    public function index(IndexCityRequest $request): CityCollection|JsonResponse
    {
        try {
            $inputs = $request->validated();

            $cityPaginate = Local::city()->list($inputs);

            return new CityCollection($cityPaginate);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a new *City* resource in storage.
     *
     * @lrd:end
     *
     * @throws StoreOperationException
     */
    public function store(StoreCityRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $city = Local::city()->create($inputs);

            if (! $city) {
                throw (new StoreOperationException)->setModel(config('fintech.local.city_model'));
            }

            return $this->created([
                'message' => __('restapi::messages.resource.created', ['model' => 'City']),
                'id' => $city->id,
            ]);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Return a specified *City* resource found by id.
     *
     * @lrd:end
     *
     * @throws ModelNotFoundException
     */
    public function show(string|int $id): CityResource|JsonResponse
    {
        try {

            $city = Local::city()->find($id);

            if (! $city) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.city_model'), $id);
            }

            return new CityResource($city);

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Update a specified *City* resource using id.
     *
     * @lrd:end
     *
     * @throws ModelNotFoundException
     * @throws UpdateOperationException
     */
    public function update(UpdateCityRequest $request, string|int $id): JsonResponse
    {
        try {

            $city = Local::city()->find($id);

            if (! $city) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.city_model'), $id);
            }

            $inputs = $request->validated();

            if (! Local::city()->update($id, $inputs)) {

                throw (new UpdateOperationException)->setModel(config('fintech.local.city_model'), $id);
            }

            return $this->updated(__('restapi::messages.resource.updated', ['model' => 'City']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Soft delete a specified *City* resource using id.
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

            $city = Local::city()->find($id);

            if (! $city) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.city_model'), $id);
            }

            if (! Local::city()->destroy($id)) {

                throw (new DeleteOperationException())->setModel(config('fintech.local.city_model'), $id);
            }

            return $this->deleted(__('restapi::messages.resource.deleted', ['model' => 'City']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Restore the specified *City* resource from trash.
     * ** ```Soft Delete``` needs to enabled to use this feature**
     *
     * @lrd:end
     *
     * @return JsonResponse
     */
    public function restore(string|int $id)
    {
        try {

            $city = Local::city()->find($id, true);

            if (! $city) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.city_model'), $id);
            }

            if (! Local::city()->restore($id)) {

                throw (new RestoreOperationException())->setModel(config('fintech.local.city_model'), $id);
            }

            return $this->restored(__('restapi::messages.resource.restored', ['model' => 'City']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the *City* resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     */
    public function export(IndexCityRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $cityPaginate = Local::city()->export($inputs);

            return $this->exported(__('restapi::messages.resource.exported', ['model' => 'City']));

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the *City* resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     *
     * @return CityCollection|JsonResponse
     */
    public function import(ImportCityRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $cityPaginate = Local::city()->list($inputs);

            return new CityCollection($cityPaginate);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }
}
