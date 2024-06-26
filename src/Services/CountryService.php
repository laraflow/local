<?php

namespace Laraflow\Local\Services;

use Laraflow\Local\Interfaces\CountryRepository;

/**
 * Class CountryService
 */
class CountryService
{
    /**
     * CountryService constructor.
     */
    public function __construct(CountryRepository $countryRepository)
    {
        $this->countryRepository = $countryRepository;
    }

    public function find($id, $onlyTrashed = false)
    {
        return $this->countryRepository->find($id, $onlyTrashed);
    }

    public function update($id, array $inputs = [])
    {
        return $this->countryRepository->update($id, $inputs);
    }

    public function destroy($id)
    {
        return $this->countryRepository->delete($id);
    }

    public function restore($id)
    {
        return $this->countryRepository->restore($id);
    }

    public function export(array $filters)
    {
        return $this->countryRepository->list($filters);
    }

    /**
     * @return mixed
     */
    public function list(array $filters = [])
    {
        return $this->countryRepository->list($filters);

    }

    public function import(array $filters)
    {
        return $this->countryRepository->create($filters);
    }

    public function create(array $inputs = [])
    {
        return $this->countryRepository->create($inputs);
    }
}
