<?php

namespace App\Services;

use \App\Models\Category;

class CategoryService
{
    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    public function store(Array $array)
    {
        $this->model = Category::create($array);

        $this->model->latin = latinize($this->model->title);
        $this->model->sorting = $this->calculateSorting($this->model->parent_id);
        $this->model->save();

        return $this;
    }

    public function update(int $id, Array $array)
    {
        $this->model = $this->model->findOrFail($id);
        $this->model->fill($array);
        $this->model->latin = latinize($this->model->title);

        if ($this->model->isDirty('parent_id')) {
            $this->redoSorting($this->model->getOriginal('parent_id'), $this->model->sorting);
            $this->model->sorting = $this->calculateSorting($this->model->parent_id);
        }
        $this->model->save();

        return $this;
    }

    public function destroy(int $id)
    {
        $this->model = $this->model->findOrFail($id);
        $this->redoSorting($this->model->parent_id, $this->model->sorting);
        $this->model->delete();
    }

    public function getChanges(bool $withId = true)
    {
        return ($withId) ? ['id' => $this->model->id] + $this->model->getChanges() : $this->model->getChanges();
    }

    private function calculateSorting($parentId) {
        return Category::where('parent_id', $parentId)->max('sorting') + 1;
    }

    private function redoSorting($parentId, $initialValue) {
        return Category::where('parent_id', $parentId)->where('sorting', '>', $initialValue)->decrement('sorting');
    }

}
