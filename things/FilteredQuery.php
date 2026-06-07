<?php

namespace App\Traits;

trait FilteredQuery {

    public function filteredQuery(
        $model, 
        array $sentfilters = [], 
        array $allowedFilters = [], 
        array $allowedSorts = ['id'],
        array $searchableFilters = []) {
        
        $query = $model::query();

        foreach ($allowedFilters as $filter) {
            if (array_key_exists($filter, $sentfilters) && !empty($sentfilters[$filter])) {
                $query->where($filter, $sentfilters[$filter]);
            }
        }

        if(!empty($sentfilters['search']) && !empty($searchableFilters)) {
            $query->where(function ($q) use ($sentfilters, $searchableFilters) {
                foreach($searchableFilters as $index => $filter) {
                    if($index === 0) {
                        $q->where($filter, 'like', '%' . $sentfilters['search'] . '%');
                    } else {
                        $q->orWhere($filter, 'like', '%' . $sentfilters['search'] . '%');
                    }
                }
            });
        }

        $sortBy = $sentfilters['sort_by'] ?? 'id';
        $sortDirection = $sentfilters['sort_direction'] ?? 'desc';

        $allowedDirections = ['asc', 'desc'];

        if (!in_array($sortBy, $allowedSorts)) {
            $sortBy = 'id';
        }

        if (!in_array($sortDirection, $allowedDirections)) {
            $sortDirection = 'desc';
        }

        $query->orderBy($sortBy, $sortDirection);

        return $query;
    }

    public function getFiltered($query, ?int $perPage = null) {
    
        return $perPage ? $query->paginate($perPage) : $query->get();
    }
}