<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

abstract class Repository
{
    protected $query;
    protected $model;
    protected $search;
    protected $reset = ['find', 'first', 'get'];

    public function __call($name, $arguments)
    {
        $return = $this->query->{$name}(...$arguments);

        if(in_array($name, $this->reset)) {
            $this->query = $this->model->newQuery();

            return $return;
        }

        return $this;
    }

    public function relatedOne(Model $model)
    {
        $this->query = $model->hasOne(get_class($this->model))->newQuery();

        return $this;
    }

    public function relatedMany(Model $model)
    {
        $this->query = $model->hasMany(get_class($this->model))->newQuery();

        return $this;
    }

    public function join(string $table, string $tableId = null, string $thisId = null)
    {
        $tableId = $tableId ?? $table . '.' . $this->model->getForeignKey();
        $thisId = $thisId ?? $this->model->getQualifiedKeyName();
        $this->query->join($table, $tableId, '=', $thisId);

        return $this;
    }

    public function where(string $column, string $value = 'true', string $operator = '=')
    {
        $this->query->where($column, $operator, $value);

        return $this;
    }

    public function search(string $string)
    {
        if(empty($string)) return $this;

        $string = trim( preg_replace('/[^+A-Za-z0-9- ]/', '', $string) );
        $this->search = pg_escape_string( str_replace(' ', '|', $string) );

        $this->query->whereRaw("search @@ to_tsquery('" . $this->search . "')");

        return $this;
    }

    public function orderByRelevance()
    {
        $this->query->orderByRaw("ts_rank(search, to_tsquery('" . $this->search . "')) DESC");

        return $this;
    }

    public function builder()
    {
        return $this->query;
    }

    public function paginate(int $perPage = 15)
    {
        $perPage = config($this->model->getName() . '.per_page') ?? $perPage;
        $return = $this->query->simplePaginate($perPage);
        $this->query = $this->model->newQuery();

        return $return;
    }

}
