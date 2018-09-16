<?php
/**
 * Created by PhpStorm.
 * User: Timothy
 * Date: 05/09/2018
 * Time: 10:20
 */

namespace Tools4Schools\Graph\Http\Requests;


trait QueriesResources
{
    /**
     * Transform the request into a query.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function toQuery()
    {
        $resource = $this->resource();

        return $resource::buildIndexQuery(
            $this, $this->newQuery(),$this->search,
            $this->filters()->all(),$this->ordering(),$this->trashed()
        );
    }


}