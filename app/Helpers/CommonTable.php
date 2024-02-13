<?php


namespace App\Helpers;

/**
 * Responsible for showing data in datatable and exporting the data in administration part
 * Class EloquentQueryHelper
 * @package App\Helper
 */
class CommonTable
{

    /**
     * Simplify the query for the vuetify parameter
     * @param $model
     * @param array $search_columns
     * @param null $query
     * @param bool $start_with_or_where
     * @param array $extra
     * @return mixed
     */
    public static function table($model, $search_columns = [], $query = null, $start_with_or_where = false, $extra = [])
    {
        if ($query) {
            $model = $model->where(function ($q) use ($query, $search_columns, $start_with_or_where) {
                if ($start_with_or_where) {
                    $model = $q->orWhere($search_columns[0], 'LIKE', '%' . $query . '%');
                } else {
                    $model = $q->where($search_columns[0], 'LIKE', '%' . $query . '%');
                }
                foreach ($search_columns as $column) {
                    $model = $model->orWhere($column, 'LIKE', '%' . $query . '%');
                }

                return $model;
            });
        }
//        $filters = json_decode(request()->get('filters'));
//
//        foreach (collect($filters) as $filter => $value) {
//            if (!is_null($value)) {
//                if (method_exists(get_class($model), 'scope' . ucfirst($filter))) {
//                    $model->{$filter}($value);
//                }
//            }
//        }


        $rowsPerPage = $extra['rowsPerPage'] ?? 10;

        if (isset($extra['sortBy'])) {
            $desc = isset($extra['descending']) ? 'DESC' : 'ASC';
            $model = $model->orderBy($extra['sortBy'], $desc);
        }

        if ($rowsPerPage == -1) {
            $rowsPerPage = $model->count();
        }
        $data = $model->paginate($rowsPerPage);

        return $data;
    }
}
