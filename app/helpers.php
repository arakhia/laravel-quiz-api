<?php

use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Cast\Bool_;
use PhpParser\Node\Expr\Cast\Object_;

/**
 * To avoid conflicts between my helper and other Laravel/Libraries helpers, I use functions Suffix as name_local_helper 
 */

 /**
  * This function is responsible for parsing the request for index/show methods, it handles 
  * 1) URL include relations such as api/V1/quiz?include=answers,vocabularies or so
  * @todo 2) URL parameter filters such as id=5 or any other allowed parameter from App/Filters [Move it from Controllers]
  */
function load_query_include_parm_local_helper($include, $safeIncludes, $model, $modelFilter = null) : Object {
    
    $include = explode(',', $include);

    foreach($include as $relation){
        if(in_array($relation, $safeIncludes)){
            // https://stackoverflow.com/questions/26005994/laravel-with-method-versus-load-method
            if(isset($modelFilter)){ // for index function
                $model = $model->with($relation);
            } else { // for show function
                $model = $model->loadMissing($relation);
            }
        }
    }

    return $model;
}

// function check_player_answer_local_helper() : bool {
//     return false;
// }
