<?php

namespace Laraflow\Local\Services;


use Laraflow\Local\Interfaces\CurrencyRepository;

/**
 * Class CurrencyService
 * @package Laraflow\Local\Services
 *
 */
class CurrencyService
{
    /**
     * CurrencyService constructor.
     * @param CurrencyRepository $currencyRepository
     */
    public function __construct(CurrencyRepository $currencyRepository) {
        $this->currencyRepository = $currencyRepository;
    }

    /**
     * @param array $filters
     * @return mixed
     */
    public function list(array $filters = [])
    {
        return $this->currencyRepository->list($filters);

    }

    public function create(array $inputs = [])
    {
        return $this->currencyRepository->create($inputs);
    }

    public function find($id, $onlyTrashed = false)
    {
        return $this->currencyRepository->find($id, $onlyTrashed);
    }

    public function update($id, array $inputs = [])
    {
        return $this->currencyRepository->update($id, $inputs);
    }

    public function destroy($id)
    {
        return $this->currencyRepository->delete($id);
    }

    public function restore($id)
    {
        return $this->currencyRepository->restore($id);
    }

    public function export(array $filters)
    {
        return $this->currencyRepository->list($filters);
    }

    public function import(array $filters)
    {
        return $this->currencyRepository->create($filters);
    }
}
