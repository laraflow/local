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
use Laraflow\Local\Http\Requests\ImportCurrencyRequest;
use Laraflow\Local\Http\Requests\IndexCurrencyRequest;
use Laraflow\Local\Http\Requests\StoreCurrencyRequest;
use Laraflow\Local\Http\Requests\UpdateCurrencyRequest;
use Laraflow\Local\Http\Resources\CurrencyCollection;
use Laraflow\Local\Http\Resources\CurrencyResource;

/**
 * Class CurrencyController
 *
 * @lrd:start
 * This class handle create, display, update, delete & restore
 * operation related to Currency
 *
 * @lrd:end
 */
class CurrencyController extends Controller
{
    /**
     * @lrd:start
     * Return a listing of the *Currency* resource as collection.
     *
     * *```paginate=false``` returns all resource as list not pagination*
     *
     * @lrd:end
     */
    public function index(IndexCurrencyRequest $request): CurrencyCollection|JsonResponse
    {
        try {
            $inputs = $request->validated();

            $currencyPaginate = Local::currency()->list($inputs);

            return new CurrencyCollection($currencyPaginate);

        } catch (Exception $exception) {

            return response()->failed($exception);
        }
    }

    /**
     * @lrd:start
     * Create a new *Currency* resource in storage.
     *
     * @lrd:end
     *
     * @throws StoreOperationException
     */
    public function store(StoreCurrencyRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $currency = Local::currency()->create($inputs);

            if (! $currency) {
                throw (new StoreOperationException)->setModel(config('fintech.local.currency_model'));
            }

            return response()->created([
                'message' => __('restapi::messages.resource.created', ['model' => 'Currency']),
                'id' => $currency->id,
            ]);

        } catch (Exception $exception) {

            return response()->failed($exception);
        }
    }

    /**
     * @lrd:start
     * Return a specified *Currency* resource found by id.
     *
     * @lrd:end
     *
     * @throws ModelNotFoundException
     */
    public function show(string|int $id): CurrencyResource|JsonResponse
    {
        try {

            $currency = Local::currency()->find($id);

            if (! $currency) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.currency_model'), $id);
            }

            return new CurrencyResource($currency);

        } catch (ModelNotFoundException $exception) {

            return response()->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return response()->failed($exception);
        }
    }

    /**
     * @lrd:start
     * Update a specified *Currency* resource using id.
     *
     * @lrd:end
     *
     * @throws ModelNotFoundException
     * @throws UpdateOperationException
     */
    public function update(UpdateCurrencyRequest $request, string|int $id): JsonResponse
    {
        try {

            $currency = Local::currency()->find($id);

            if (! $currency) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.currency_model'), $id);
            }

            $inputs = $request->validated();

            if (! Local::currency()->update($id, $inputs)) {

                throw (new UpdateOperationException)->setModel(config('fintech.local.currency_model'), $id);
            }

            return response()->updated(__('restapi::messages.resource.updated', ['model' => 'Currency']));

        } catch (ModelNotFoundException $exception) {

            return response()->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return response()->failed($exception);
        }
    }

    /**
     * @lrd:start
     * Soft delete a specified *Currency* resource using id.
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

            $currency = Local::currency()->find($id);

            if (! $currency) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.currency_model'), $id);
            }

            if (! Local::currency()->destroy($id)) {

                throw (new DeleteOperationException)->setModel(config('fintech.local.currency_model'), $id);
            }

            return response()->deleted(__('restapi::messages.resource.deleted', ['model' => 'Currency']));

        } catch (ModelNotFoundException $exception) {

            return response()->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return response()->failed($exception);
        }
    }

    /**
     * @lrd:start
     * Restore the specified *Currency* resource from trash.
     * ** ```Soft Delete``` needs to enabled to use this feature**
     *
     * @lrd:end
     *
     * @return JsonResponse
     */
    public function restore(string|int $id)
    {
        try {

            $currency = Local::currency()->find($id, true);

            if (! $currency) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.currency_model'), $id);
            }

            if (! Local::currency()->restore($id)) {

                throw (new RestoreOperationException)->setModel(config('fintech.local.currency_model'), $id);
            }

            return response()->restored(__('restapi::messages.resource.restored', ['model' => 'Currency']));

        } catch (ModelNotFoundException $exception) {

            return response()->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return response()->failed($exception);
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the *Currency* resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     */
    public function export(IndexCurrencyRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $currencyPaginate = Local::currency()->export($inputs);

            return response()->exported(__('restapi::messages.resource.exported', ['model' => 'Currency']));

        } catch (Exception $exception) {

            return response()->failed($exception);
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the *Currency* resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     *
     * @return CurrencyCollection|JsonResponse
     */
    public function import(ImportCurrencyRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $currencyPaginate = Local::currency()->list($inputs);

            return new CurrencyCollection($currencyPaginate);

        } catch (Exception $exception) {

            return response()->failed($exception);
        }
    }
}
