<?php

namespace Laraflow\Local\Repositories\Mongodb;

use Fintech\Core\Repositories\MongodbRepository;
use Laraflow\Local\Interfaces\SubregionRepository as InterfacesSubregionRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use MongoDB\Laravel\Eloquent\Model;
use InvalidArgumentException;

/**
 * Class SubregionRepository
 * @package Laraflow\Local\Repositories\Mongodb
 */
class SubregionRepository extends MongodbRepository implements InterfacesSubregionRepository
{
    public function __construct()
    {
       parent::__construct(config('fintech.local.subregion_model', \Laraflow\Local\Models\Subregion::class));
    }

    /**
     * return a list or pagination of items from
     * filtered options
     *
     * @return Paginator|Collection
     */
    public function list(array $filters = [])
    {
        $query = $this->model->newQuery();

        //Searching
        if (! empty($filters['search'])) {
            if (is_numeric($filters['search'])) {
                $query->where($this->model->getKeyName(), 'like', "%{$filters['search']}%");
            } else {
                $query->where('name', 'like', "%{$filters['search']}%");
                $query->orWhere('subregion_data', 'like', "%{$filters['search']}%");
            }
        }

        //Display Trashed
        if (isset($filters['trashed']) && $filters['trashed'] === true) {
            $query->onlyTrashed();
        }

        //Handle Sorting
        $query->orderBy($filters['sort'] ?? $this->model->getKeyName(), $filters['dir'] ?? 'asc');

        //Execute Output
        return $this->executeQuery($query, $filters);

    }
}
