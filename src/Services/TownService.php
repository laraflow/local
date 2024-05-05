<?php

namespace Laraflow\Local\Services;

use Laraflow\Local\Interfaces\TownRepository;

/**
 * Class TownService
 */
class TownService
{
    /**
     * TownService constructor.
     */
    public function __construct(TownRepository $townRepository)
    {
        $this->townRepository = $townRepository;
    }

    /**
     * @return mixed
     */
    public function list(array $filters = [])
    {
        return $this->townRepository->list($filters);

    }

    public function create(array $inputs = [])
    {
        return $this->townRepository->create($inputs);
    }

    public function find($id, $onlyTrashed = false)
    {
        return $this->townRepository->find($id, $onlyTrashed);
    }

    public function update($id, array $inputs = [])
    {
        return $this->townRepository->update($id, $inputs);
    }

    public function destroy($id)
    {
        return $this->townRepository->delete($id);
    }

    public function restore($id)
    {
        return $this->townRepository->restore($id);
    }

    public function export(array $filters)
    {
        return $this->townRepository->list($filters);
    }

    public function import(array $filters)
    {
        return $this->townRepository->create($filters);
    }
}
