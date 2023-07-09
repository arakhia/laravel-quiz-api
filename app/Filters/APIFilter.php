<?php

namespace App\Filters;

use Illuminate\Http\Request;

class APIFilter {

    protected $safeParms = [];

    protected $columnMap = [];

    protected $operatorMap = [];

    public function transform(Request $request)
    {
        
        $userQuery = [];

        foreach($this->safeParms as $parm => $operators){
            $query = $request->query($parm);
            if (!isset($query)){
                continue;
            }

            $column = $this->columnMap[$parm] ?? $parm;

            

            foreach ($operators as $operatore) {
                if(isset($query[$operatore])){
                    $userQuery[] = [$column, $this->operatorMap[$operatore], $query[$operatore]];
                }
            }
        }

        
        
        return $userQuery;
    }

}