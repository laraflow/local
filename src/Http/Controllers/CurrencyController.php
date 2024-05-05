<?php

namespace Laraflow\Local\Http\Controllers;
use Exception;
use Fintech\Core\Exceptions\StoreOperationException;
use Fintech\Core\Exceptions\UpdateOperationException;
use Fintech\Core\Exceptions\DeleteOperationException;
use Fintech\Core\Exceptions\RestoreOperationException;
use Fintech\Core\Traits\ApiResponseTrait;
use Laraflow\Local\Facades\Local;
use Laraflow\Local\Http\Resources\CurrencyResource;
use Laraflow\Local\Http\Resources\CurrencyCollection;
use Laraflow\Local\Http\Requests\ImportCurrencyRequest;
use Laraflow\Local\Http\Requests\StoreCurrencyRequest;
use Laraflow\Local\Http\Requests\UpdateCurrencyRequest;
use Laraflow\Local\Http\Requests\IndexCurrencyRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

/**
 * Class CurrencyController
 * @package Laraflow\Local\Http\Controllers
 *
 * @lrd:start
 * This class handle create, display, update, delete & restore
 * operation related to Currency
 * @lrd:end
 *
 */

class CurrencyController extends Controller
{
    use ApiResponseTrait;

    /**
     * @lrd:start
     * Return a listing of the *Currency* resource as collection.
     *
     * *```paginate=false``` returns all resource as list not pagination*
     * @lrd:end
     *
     * @param IndexCurrencyRequest $request
     * @return CurrencyCollection|JsonResponse
     */
    public function index(IndexCurrencyRequest $request): CurrencyCollection|JsonResponse
    {
        try {
            $inputs = $request->validated();

            $currencyPaginate = Local::currency()->list($inputs);

            return new CurrencyCollection($currencyPaginate);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a new *Currency* resource in storage.
     * @lrd:end
     *
     * @param StoreCurrencyRequest $request
     * @return JsonResponse
     * @throws StoreOperationException
     */
    public function store(StoreCurrencyRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $currency = Local::currency()->create($inputs);

            if (!$currency) {
                throw (new StoreOperationException)->setModel(config('fintech.local.currency_model'));
            }

            return $this->created([
                'message' => __('core::messages.resource.created', ['model' => 'Currency']),
                'id' => $currency->id
             ]);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Return a specified *Currency* resource found by id.
     * @lrd:end
     *
     * @param string|int $id
     * @return CurrencyResource|JsonResponse
     * @throws ModelNotFoundException
     */
    public function show(string|int $id): CurrencyResource|JsonResponse
    {
        try {

            $currency = Local::currency()->find($id);

            if (!$currency) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.currency_model'), $id);
            }

            return new CurrencyResource($currency);

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Update a specified *Currency* resource using id.
     * @lrd:end
     *
     * @param UpdateCurrencyRequest $request
     * @param string|int $id
     * @return JsonResponse
     * @throws ModelNotFoundException
     * @throws UpdateOperationException
     */
    public function update(UpdateCurrencyRequest $request, string|int $id): JsonResponse
    {
        try {

            $currency = Local::currency()->find($id);

            if (!$currency) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.currency_model'), $id);
            }

            $inputs = $request->validated();

            if (!Local::currency()->update($id, $inputs)) {

                throw (new UpdateOperationException)->setModel(config('fintech.local.currency_model'), $id);
            }

            return $this->updated(__('core::messages.resource.updated', ['model' => 'Currency']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Soft delete a specified *Currency* resource using id.
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

            $currency = Local::currency()->find($id);

            if (!$currency) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.currency_model'), $id);
            }

            if (!Local::currency()->destroy($id)) {

                throw (new DeleteOperationException())->setModel(config('fintech.local.currency_model'), $id);
            }

            return $this->deleted(__('core::messages.resource.deleted', ['model' => 'Currency']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Restore the specified *Currency* resource from trash.
     * ** ```Soft Delete``` needs to enabled to use this feature**
     * @lrd:end
     *
     * @param string|int $id
     * @return JsonResponse
     */
    public function restore(string|int $id)
    {
        try {

            $currency = Local::currency()->find($id, true);

            if (!$currency) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.currency_model'), $id);
            }

            if (!Local::currency()->restore($id)) {

                throw (new RestoreOperationException())->setModel(config('fintech.local.currency_model'), $id);
            }

            return $this->restored(__('core::messages.resource.restored', ['model' => 'Currency']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the *Currency* resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     *
     * @param IndexCurrencyRequest $request
     * @return JsonResponse
     */
    public function export(IndexCurrencyRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $currencyPaginate = Local::currency()->export($inputs);

            return $this->exported(__('core::messages.resource.exported', ['model' => 'Currency']));

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the *Currency* resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     *
     * @param ImportCurrencyRequest $request
     * @return CurrencyCollection|JsonResponse
     */
    public function import(ImportCurrencyRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $currencyPaginate = Local::currency()->list($inputs);

            return new CurrencyCollection($currencyPaginate);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }
}
