<?php

namespace Laraflow\Local\Services;


use Laraflow\Local\Interfaces\SubregionRepository;

/**
 * Class SubregionService
 * @package Laraflow\Local\Services
 *
 */
class SubregionService
{
    /**
     * SubregionService constructor.
     * @param SubregionRepository $subregionRepository
     */
    public function __construct(SubregionRepository $subregionRepository) {
        $this->subregionRepository = $subregionRepository;
    }

    /**
     * @param array $filters
     * @return mixed
     */
    public function list(array $filters = [])
    {
        return $this->subregionRepository->list($filters);

    }

    public function create(array $inputs = [])
    {
        return $this->subregionRepository->create($inputs);
    }

    public function find($id, $onlyTrashed = false)
    {
        return $this->subregionRepository->find($id, $onlyTrashed);
    }

    public function update($id, array $inputs = [])
    {
        return $this->subregionRepository->update($id, $inputs);
    }

    public function destroy($id)
    {
        return $this->subregionRepository->delete($id);
    }

    public function restore($id)
    {
        return $this->subregionRepository->restore($id);
    }

    public function export(array $filters)
    {
        return $this->subregionRepository->list($filters);
    }

    public function import(array $filters)
    {
        return $this->subregionRepository->create($filters);
    }
}
