<?php

namespace Laraflow\Local\Services;

use Laraflow\Local\Interfaces\CityRepository;

/**
 * Class CityService
 */
class CityService
{
    /**
     * CityService constructor.
     */
    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function find($id, $onlyTrashed = false)
    {
        return $this->cityRepository->find($id, $onlyTrashed);
    }

    public function update($id, array $inputs = [])
    {
        return $this->cityRepository->update($id, $inputs);
    }

    public function destroy($id)
    {
        return $this->cityRepository->delete($id);
    }

    public function restore($id)
    {
        return $this->cityRepository->restore($id);
    }

    public function export(array $filters)
    {
        return $this->cityRepository->list($filters);
    }

    /**
     * @return mixed
     */
    public function list(array $filters = [])
    {
        return $this->cityRepository->list($filters);

    }

    public function import(array $filters)
    {
        return $this->cityRepository->create($filters);
    }

    public function create(array $inputs = [])
    {
        return $this->cityRepository->create($inputs);
    }
}
