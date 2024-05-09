<?php

namespace Laraflow\Local\Http\Controllers;

use Exception;
use Fintech\Core\Exceptions\DeleteOperationException;
use Fintech\Core\Exceptions\RestoreOperationException;
use Fintech\Core\Exceptions\StoreOperationException;
use Fintech\Core\Exceptions\UpdateOperationException;
use Fintech\Core\Traits\ApiResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Laraflow\Local\Facades\Local;
use Laraflow\Local\Http\Requests\ImportTownRequest;
use Laraflow\Local\Http\Requests\IndexTownRequest;
use Laraflow\Local\Http\Requests\StoreTownRequest;
use Laraflow\Local\Http\Requests\UpdateTownRequest;
use Laraflow\Local\Http\Resources\TownCollection;
use Laraflow\Local\Http\Resources\TownResource;

/**
 * Class TownController
 *
 * @lrd:start
 * This class handle create, display, update, delete & restore
 * operation related to Town
 *
 * @lrd:end
 */
class TownController extends Controller
{
    use ApiResponseTrait;

    /**
     * @lrd:start
     * Return a listing of the *Town* resource as collection.
     *
     * *```paginate=false``` returns all resource as list not pagination*
     *
     * @lrd:end
     */
    public function index(IndexTownRequest $request): TownCollection|JsonResponse
    {
        try {
            $inputs = $request->validated();

            $townPaginate = Local::town()->list($inputs);

            return new TownCollection($townPaginate);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a new *Town* resource in storage.
     *
     * @lrd:end
     *
     * @throws StoreOperationException
     */
    public function store(StoreTownRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $town = Local::town()->create($inputs);

            if (! $town) {
                throw (new StoreOperationException)->setModel(config('fintech.local.town_model'));
            }

            return $this->created([
                'message' => __('restapi::messages.resource.created', ['model' => 'Town']),
                'id' => $town->id,
            ]);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Return a specified *Town* resource found by id.
     *
     * @lrd:end
     *
     * @throws ModelNotFoundException
     */
    public function show(string|int $id): TownResource|JsonResponse
    {
        try {

            $town = Local::town()->find($id);

            if (! $town) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.town_model'), $id);
            }

            return new TownResource($town);

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Update a specified *Town* resource using id.
     *
     * @lrd:end
     *
     * @throws ModelNotFoundException
     * @throws UpdateOperationException
     */
    public function update(UpdateTownRequest $request, string|int $id): JsonResponse
    {
        try {

            $town = Local::town()->find($id);

            if (! $town) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.town_model'), $id);
            }

            $inputs = $request->validated();

            if (! Local::town()->update($id, $inputs)) {

                throw (new UpdateOperationException)->setModel(config('fintech.local.town_model'), $id);
            }

            return $this->updated(__('restapi::messages.resource.updated', ['model' => 'Town']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Soft delete a specified *Town* resource using id.
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

            $town = Local::town()->find($id);

            if (! $town) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.town_model'), $id);
            }

            if (! Local::town()->destroy($id)) {

                throw (new DeleteOperationException())->setModel(config('fintech.local.town_model'), $id);
            }

            return $this->deleted(__('restapi::messages.resource.deleted', ['model' => 'Town']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Restore the specified *Town* resource from trash.
     * ** ```Soft Delete``` needs to enabled to use this feature**
     *
     * @lrd:end
     *
     * @return JsonResponse
     */
    public function restore(string|int $id)
    {
        try {

            $town = Local::town()->find($id, true);

            if (! $town) {
                throw (new ModelNotFoundException)->setModel(config('fintech.local.town_model'), $id);
            }

            if (! Local::town()->restore($id)) {

                throw (new RestoreOperationException())->setModel(config('fintech.local.town_model'), $id);
            }

            return $this->restored(__('restapi::messages.resource.restored', ['model' => 'Town']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the *Town* resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     */
    public function export(IndexTownRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $townPaginate = Local::town()->export($inputs);

            return $this->exported(__('restapi::messages.resource.exported', ['model' => 'Town']));

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the *Town* resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     *
     * @return TownCollection|JsonResponse
     */
    public function import(ImportTownRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $townPaginate = Local::town()->list($inputs);

            return new TownCollection($townPaginate);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }
}
