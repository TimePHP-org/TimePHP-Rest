<?php

namespace TimePHP\Rest;

use TimePHP\Rest\Exception\RestException;
use Illuminate\Database\Eloquent\Collection;

abstract class AbstractRestController {

   /**
    * Render json from a given variable
    *
    * @param Collection|array $elements
    * @return void
    */
   public function renderJson($elements) {
      header('Content-Type: application/json');
      if(is_a($elements, Collection::class)){
         return $this->renderFromCollection($elements);
      } elseif(is_array($elements)) {
         return $this->renderFromArray($elements);
      } else {
         if($_ENV["APP_ENV"] == 0) {
            header('HTTP/1.1 500 Internal Server Error');
         } elseif($_ENV["APP_ENV"] == 1) {
            $type = gettype($elements);
            throw new RestException("You must provide either an array or a Illuminate\Database\Eloquent\Collection variable, $type given", 5001);
         }
      }
   }

   /**
    * Return json format from a ELoquent collection
    *
    * @param Collection $collection
    * @return void
    */
   private function renderFromCollection(Collection $collection): void {
      echo json_encode($collection->toArray());
   }

   /**
    * Return json format from an array
    *
    * @param array $array
    * @return void
    */
   private function renderFromArray(array $array): void {
      echo json_encode($array);
   }


}