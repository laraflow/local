<?php

namespace Laraflow\Local\Services;

use Laraflow\Local\Interfaces\RegionRepository;

/**
 * Class RegionService
 */
class RegionService
{
    /**
     * RegionService constructor.
     */
    public function __construct(RegionRepository $regionRepository)
    {
        $this->regionRepository = $regionRepository;
    }

    /**
     * @return mixed
     */
    public function list(array $filters = [])
    {
        return $this->regionRepository->list($filters);

    }

    public function create(array $inputs = [])
    {
        return $this->regionRepository->create($inputs);
    }

    public function find($id, $onlyTrashed = false)
    {
        return $this->regionRepository->find($id, $onlyTrashed);
    }

    public function update($id, array $inputs = [])
    {
        return $this->regionRepository->update($id, $inputs);
    }

    public function destroy($id)
    {
        return $this->regionRepository->delete($id);
    }

    public function restore($id)
    {
        return $this->regionRepository->restore($id);
    }

    public function export(array $filters)
    {
        return $this->regionRepository->list($filters);
    }

    public function import(array $filters)
    {
        return $this->regionRepository->create($filters);
    }
}
