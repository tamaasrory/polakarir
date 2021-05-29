<?php

namespace App\Traits;

use App\SelfModel;
use App\Supports\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait Searchable
{
    /**
     * @param Request $request
     * @param SelfModel|Model $model
     * @param \Closure|null $customSearch
     * @return array
     */
    public static function search(Request $request, Model $model,
                                  \Closure $customSearch = null)
    {
        $data = $model::select();
        // keyword
        $keyword = $request->input('search');
        if (strstr($keyword, ':')) {
            $keyword = explode(':', $keyword);
            $data = $data->whereRaw("({$keyword[0]} LIKE '%{$keyword[1]}%')");
        } else {
            if ($keyword) {
                $search = [];
                foreach ($model->searchable as $column) {
                    $search[] = "{$column} LIKE '%{$keyword}%'";
                }

                $search = implode(' OR ', $search);
                $data = $data->whereRaw("({$search})");
            }
        }

        if($customSearch){
            $data = $customSearch($data);
        }

        $data = self::simplePaginate($request, $data, $model);

        if ($data->count() > 0) {
            return $data;
        } else {
            return [];
        }
    }

    /**
     * @param Request $request
     * @param SelfModel $data
     * @return mixed
     */
    static function simplePaginate(Request $request, $data, $model)
    {
        if ($request->input('per_page') &&
            $request->input('per_page') != 'false') {
            $sorted = self::sorting($request, $data, $model);
            $data = $sorted['data']->paginate($request->input('per_page'));

//            /** @var Collection $data */
//            $data = (new Collection($data));
//
//            foreach ($sorted['appendsSort'] as $value) {
//                $func = null;
//                eval('$func=$value[0];');
//                $data = $data->sortBy($func,SORT_REGULAR,$value[1]);
//            }

        } else {
            $data = self::sorting($request, $data, $model)->get();
        }
        return $data;
    }

    /**
     * @param Request $request
     * @param SelfModel $data
     * @return mixed
     */
    static function sorting(Request $request, $data, $model)
    {
        $appendsSort = [];
        if ($request->input('sortBy')) {
            $sortBy = json_decode($request->input('sortBy'));
            $sortDesc = json_decode($request->input('sortDesc'));

            foreach ($sortBy as $key => $value) {
                $direction = ($sortDesc[$key] == 'true') ? 'DESC' : 'ASC';
                if (!in_array($value, $model->appends)) {
                    $data = $data->orderBy($value, $direction);
                } else {
                    $appendsSort[] = ['function($data){return $data->get' . htmlspecialchars(ucwords($value), ENT_QUOTES) . 'Attribute();}',($sortDesc[$key] == 'true')];
                }
            }
        }

        return compact('data', 'appendsSort');
    }
}
