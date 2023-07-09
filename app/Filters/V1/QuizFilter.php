<?php


namespace App\Filters\V1;

use App\Filters\APIFilter;

class QuizFilter extends APIFilter {

    protected $safeParms = [
        'id' => ['eq', 'gt', 'lt'],
        'name' => ['eq'],
        'creationType' => ['eq']
    ];

    protected $columnMap = [
        'creationType' => 'creation_type'
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'gt' => '>',
        //'lte' => '=<', 
        //'gte' => '>=',
    ];

}