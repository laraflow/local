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
use Laraflow\Local\Http\Requests\ImportCountryRequest;
use Laraflow\Local\Http\Requests\IndexCountryRequest;
use Laraflow\Local\Http\Requests\StoreCountryRequest;
use Laraflow\Local\Http\Requests\UpdateCountryRequest;
use Laraflow\Local\Http\Resources\CountryCollection;
use Laraflow\Local\Http\Resources\CountryResource;

/**
 * Class CountryController
 *
 * @lrd:start
 * This class handle create, display, update, delete & restore
 * operation related to Country
 *
 * @lrd:end
 */
class CountryController extends Controller
{
    /**
     * @lrd:start
     * Return a listing of the *Country* resource as collection.
     *
     * *```paginate=false``` returns all resource as list not pagination*
     *
     * @lrd:end
     */
    public function index(IndexCountryRequest $request): CountryCollection|JsonResponse
    {
        try {
            $inputs = $request->validated();

            $countryPaginate = Local::country()->list($inputs);

            return new CountryCollection($countryPaginate);

        } catch (Exception $exception) {

            return response()->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a new *Country* resource in storage.
     *
     * @lrd:end
     *
     * @throws StoreOperationException
     */
    public function store(StoreCountryRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $country = Local::country()->create($inputs);

            if (! $country) {
                throw (new StoreOperationException)->setModel(config('fintech.local.country_model'));
            }

            return response()->created([
                'message' => __('restapi::messages.resource.created', ['model' => 'Country']),
                'id' => $country->id,
            ]);

        } catch (Exception $exception) {

            return response()->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Return a specified *Country* resource found by id.
     *
     * @lrd:end
     *
     * @throws ModelNotFoundException
     */
    public function show(string|int $id): CountryResource|JsonResponse
    {
        try {

            $country = Local::country()->find($id);

            if (! $country) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.country_model'), $id);
            }

            return new CountryResource($country);

        } catch (ModelNotFoundException $exception) {

            return response()->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return response()->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Update a specified *Country* resource using id.
     *
     * @lrd:end
     *
     * @throws ModelNotFoundException
     * @throws UpdateOperationException
     */
    public function update(UpdateCountryRequest $request, string|int $id): JsonResponse
    {
        try {

            $country = Local::country()->find($id);

            if (! $country) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.country_model'), $id);
            }

            $inputs = $request->validated();

            if (! Local::country()->update($id, $inputs)) {

                throw (new UpdateOperationException)->setModel(config('fintech.local.country_model'), $id);
            }

            return response()->updated(__('restapi::messages.resource.updated', ['model' => 'Country']));

        } catch (ModelNotFoundException $exception) {

            return response()->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return response()->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Soft delete a specified *Country* resource using id.
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

            $country = Local::country()->find($id);

            if (! $country) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.country_model'), $id);
            }

            if (! Local::country()->destroy($id)) {

                throw (new DeleteOperationException)->setModel(config('fintech.local.country_model'), $id);
            }

            return response()->deleted(__('restapi::messages.resource.deleted', ['model' => 'Country']));

        } catch (ModelNotFoundException $exception) {

            return response()->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return response()->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Restore the specified *Country* resource from trash.
     * ** ```Soft Delete``` needs to enabled to use this feature**
     *
     * @lrd:end
     *
     * @return JsonResponse
     */
    public function restore(string|int $id)
    {
        try {

            $country = Local::country()->find($id, true);

            if (! $country) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.country_model'), $id);
            }

            if (! Local::country()->restore($id)) {

                throw (new RestoreOperationException)->setModel(config('fintech.local.country_model'), $id);
            }

            return response()->restored(__('restapi::messages.resource.restored', ['model' => 'Country']));

        } catch (ModelNotFoundException $exception) {

            return response()->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return response()->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the *Country* resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     */
    public function export(IndexCountryRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $countryPaginate = Local::country()->export($inputs);

            return response()->exported(__('restapi::messages.resource.exported', ['model' => 'Country']));

        } catch (Exception $exception) {

            return response()->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the *Country* resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     *
     * @return CountryCollection|JsonResponse
     */
    public function import(ImportCountryRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $countryPaginate = Local::country()->list($inputs);

            return new CountryCollection($countryPaginate);

        } catch (Exception $exception) {

            return response()->failed($exception->getMessage());
        }
    }
}
