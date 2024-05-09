<?php

namespace Laraflow\Local\Services;

use Laraflow\Local\Interfaces\StateRepository;

/**
 * Class StateService
 */
class StateService
{
    /**
     * StateService constructor.
     */
    public function __construct(StateRepository $stateRepository)
    {
        $this->stateRepository = $stateRepository;
    }

    public function find($id, $onlyTrashed = false)
    {
        return $this->stateRepository->find($id, $onlyTrashed);
    }

    public function update($id, array $inputs = [])
    {
        return $this->stateRepository->update($id, $inputs);
    }

    public function destroy($id)
    {
        return $this->stateRepository->delete($id);
    }

    public function restore($id)
    {
        return $this->stateRepository->restore($id);
    }

    public function export(array $filters)
    {
        return $this->stateRepository->list($filters);
    }

    /**
     * @return mixed
     */
    public function list(array $filters = [])
    {
        return $this->stateRepository->list($filters);

    }

    public function import(array $filters)
    {
        return $this->stateRepository->create($filters);
    }

    public function create(array $inputs = [])
    {
        return $this->stateRepository->create($inputs);
    }
}
