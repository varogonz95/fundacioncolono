<?php

namespace App;

class Filter{

    private $separator = '|';

    /*
    * Descripcion: Recibe el modelo Eloquent que se quiere filtar,
                    el atributo de busqueda, y una funcion
    * Params: 
    *       $model_class <string>: The class to filter
    *
    *       $expression <string>: The expression in which to filter,
    *                    defined by a string '<attribute> [separator] <operator> [separator] <value>'
    *                    Example: 'age | > | 20' (age greater than 20)
    *                    Note: The expression string is by default trimmed
    *
    *       $as <array>: The way in which to get the processed query
    *
    */

    // CURRENTLY WORKING ON ONE-TO-ONE RELATIONSHIPS
    public function oneToOne($model_class, $expression, $as = [])
    {
        $data = [];

        // Get filtering terms
        $term = $this->trim_expression(explode($this->separator, $expression));

        // process query
        $items = $model_class::where($term[0], $term[1], $term[2])->get();

        foreach ($items as $item) {
            
            foreach ($as as $key => $value) {
                $tmp = $item->$key;

                
                
                $data[] = $tmp;
            }
        }
        
        return $data;
    }

    private function recursion($model, $key, $value){
        if(gettype($value) === 'array'){
            return recursion();
        }
        else {
            $model->$value;
            return $model;
        }

    }

    private function trim_expression($arr){
        $arr[0] = trim($arr[0]);
        $arr[1] = trim($arr[1]);
        $arr[2] = trim($arr[2]);

        return $arr;
    }

    private function post_query_processor($as){
        
        foreach ($as as $key => $value) {
            $as[$key];
        }

    }

    public function setSeparator($str){
        $this->separator = $str;
    }

    public function getSeparator($str){
        return $this->separator;
    }

}