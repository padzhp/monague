<?php

namespace App\Traits;
use Illuminate\Database\Eloquent\Builder;

trait ReturnsDatatable
{
    /**
     * Returns the query to process
     */
    public function dtQuery()
    {
        return null;
    }

    /**
     * Returns the table offset
     */
    public function dtOffset()
    {
        $request = request();
        return $request->start ? intval($request->start) : 0;
    }

    /**
     * Returns the table limit
     * @return [type] [description]
     */
    public function dtLimit()
    {
        $request = request();
        return $request->length ? intval($request->length) : 30;
    }

    /**
     * Returns the sort order and direction
     * @return mixed  Returns array ['sort' => , 'dir' => ] or null
     */
    public function dtSort()
    {
        return null;
    }

    /**
     * Returns the datatable output for browser consumption
     * @return [type] [description]
     */
    public function dtOutput()
    {
        $total = 0;
        $data = [];
        $limit = $this->dtLimit();
        $offset = $this->dtOffset();
        $sort = $this->dtSort();

        $query = $this->dtQuery();

        if ($query) {

            $total = $this->dtTotal($query);

            $query->take($limit)->skip($offset);

            if ($sort && is_array($sort) && array_key_exists('dir', $sort) && array_key_exists('sort', $sort)) {
                $query->orderBy($sort['sort'], $sort['dir']);
            }

            $results = $query->get();

            foreach($results as $result) {
                $data[] = $this->dtRowData($result);
            }
        }

        return [
            'recordsTotal' => $total,
            'recordsFiltered' => $total,
            'data' => $data,
        ];
    }

    /**
     * Process the datatable row
     * @return [type] [description]
     */
    public function dtRowData($data)
    {
        return $data;
    }

    /**
     * Returns the query count
     * @param  Illuminate\Database\Eloquent\Builder $query [description]
     * @return integer        [description]
     */
    public function dtTotal(Builder $query)
    {
        return $query->count();
    }
}
