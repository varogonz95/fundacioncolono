<?php

namespace App;

class Filter{

    const ASC = 'asc';
    const DESC = 'desc';

    public $cachedQuery;

    /*
    * Description:
    * Params:
    *
    */
    public function badassFunction($model, $with = null, $filter = [], $input = [], $order = []){
    
        $table_name = (new $model)->getTable();
    
        $builder = !is_null($with)? $model::query()->with($with) : $model::query();
        
        /* 
         *  FOR FILTER...
         *
         */
        if (!empty($filter)) {
            if($table_name === $filter['relationship']){
                $builder = $builder->where($filter['property'], $filter['comparator'], $filter['value']);
            }
            else{
                $builder = $builder->whereHas(
                    $filter['relationship'], 
                    function($query) use ($filter){
                        $query->where($filter['property'], $filter['comparator'], $filter['value']);
                    }
                );
            }
        }

        /* 
         *  FOR INPUT...
         *
         */
        if (!empty($input)) {
            if($table_name === $input['relationship']){
                 $builder = $builder->where($input['property'], $input['comparator'], $input['value']);
            }
            else{
                $builder = $builder->whereHas(
                    $input['relationship'], 
                    function($query) use ($input){
                        $query->where($input['property'], $input['comparator'], $input['value']);
                    }
                );
            }
        }

        /* 
         *  FOR ORDER...
         *
         */
        if (!empty($order)) {
            if($table_name === $order['relationship']){
                 $builder = $builder->orderBy($order['property'], $order['order']);
            }
            else{
                $this->cachedQuery = $builder->get();
                return $this;
            }
        }
        else {
            // $this->cachedQuery = $builder->get();
            // return $this;
        }

        return $builder;
    }

    public function sortBy($by, $order){
        if ($order === self::ASC) {
            return $this->cachedQuery->sortBy(
                function($array, $key) use($by) {
                    return $array[$by[0]][$by[1]];
                }
            );
        }
        else if ($order === self::DESC){
            return $this->cachedQuery->sortByDesc(
                function($array, $key) use($by) {
                    return $array[$by[0]][$by[1]];
                }
            );
        }
        
    }
        
}
    
