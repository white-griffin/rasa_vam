<?php

namespace App\Services\Search;

use Laravel\Scout\Builder;
use Laravel\Scout\Engines\Engine;
use TeamTNT\TNTSearch\TNTSearch;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Collection;

class TNTSearchEngine extends Engine
{
    protected $tnt;

    public function __construct(TNTSearch $tnt)
    {
        $this->tnt = $tnt;
    }

    public function update($models)
    {
        if ($models->isEmpty()) {
            return;
        }

        $model = $models->first();
        $index = $model->searchableAs();
        $this->initIndex($index);

        // فقط نام فایل، نه مسیر کامل
        $this->tnt->selectIndex("{$index}.index");

        foreach ($models as $model) {
            $array = $model->toSearchableArray();
            if (empty($array)) {
                continue;
            }

            $this->tnt->getIndex()->delete($model->getScoutKey());

            $this->tnt->getIndex()->insert([
                'id' => $model->getScoutKey(),
                'content' => implode(' ', array_values($array))
            ]);
        }
    }

    public function delete($models)
    {
        if ($models->isEmpty()) {
            return;
        }

        $index = $models->first()->searchableAs();
        $this->initIndex($index);

        // فقط نام فایل
        $this->tnt->selectIndex("{$index}.index");

        foreach ($models as $model) {
            $this->tnt->getIndex()->delete($model->getScoutKey());
        }
    }

    public function search(Builder $builder)
    {
        return $this->performSearch($builder);
    }

    public function paginate(Builder $builder, $perPage, $page)
    {
        return $this->performSearch($builder, [
            'limit' => $perPage,
            'offset' => ($page - 1) * $perPage,
        ]);
    }

    protected function performSearch(Builder $builder, array $options = [])
    {
        $index = $builder->model->searchableAs();
        $this->initIndex($index);

        // فقط نام فایل
        $this->tnt->selectIndex("{$index}.index");

        $limit = $options['limit'] ?? 10000;
        $offset = $options['offset'] ?? 0;

        if ($builder->callback) {
            return call_user_func($builder->callback, $this->tnt, $builder->query, $options);
        }

        $results = $this->tnt->search($builder->query, $limit);

        return [
            'results' => array_slice($results['ids'] ?? [], $offset, $limit),
            'total' => count($results['ids'] ?? []),
        ];
    }

    public function mapIds($results)
    {
        return collect($results['results'] ?? []);
    }

    public function map(Builder $builder, $results, $model)
    {
        if (count($results['results']) === 0) {
            return Collection::make();
        }

        $keys = collect($results['results']);
        $models = $model->getScoutModelsByIds($builder, $keys->all())->keyBy($model->getScoutKeyName());

        return $keys->map(function ($key) use ($models) {
            return $models[$key] ?? null;
        })->filter()->values();
    }

    public function lazyMap(Builder $builder, $results, $model)
    {
        if (count($results['results']) === 0) {
            return LazyCollection::make();
        }

        $keys = collect($results['results']);
        $models = $model->queryScoutModelsByIds($builder, $keys->all())->cursor()->keyBy($model->getScoutKeyName());

        return $keys->map(function ($key) use ($models) {
            return $models[$key] ?? null;
        })->filter()->values();
    }

    public function getTotalCount($results)
    {
        return $results['total'] ?? 0;
    }

    public function flush($model)
    {
        $index = $model->searchableAs();
        $indexPath = storage_path("scout/{$index}.index");

        if (file_exists($indexPath)) {
            unlink($indexPath);
        }

        $this->initIndex($index);
    }

    public function deleteIndex($name)
    {
        $indexPath = storage_path("scout/{$name}.index");

        if (file_exists($indexPath)) {
            unlink($indexPath);
        }
    }

    protected function initIndex($name)
    {
        $config = [
            'driver' => 'mysql',
            'host' => config('database.connections.mysql.host'),
            'database' => config('database.connections.mysql.database'),
            'username' => config('database.connections.mysql.username'),
            'password' => config('database.connections.mysql.password'),
            'storage' => storage_path('scout/'),
            'stemmer' => \TeamTNT\TNTSearch\Stemmer\PorterStemmer::class,
        ];

        $this->tnt->loadConfig($config);

        $indexPath = storage_path("scout/{$name}.index");

        if (!file_exists($indexPath)) {
            $this->createIndex($name);
        } else {
            $this->tnt->selectIndex("{$name}.index");
        }
    }

    public function createIndex($name, array $options = [])
    {
        $modelClass = $this->getModelClass($name);
        
        if (!$modelClass || !class_exists($modelClass)) {
            throw new \Exception("Model class not found for index: {$name}");
        }

        $model = new $modelClass;

        $this->tnt->createIndex("{$name}.index");
        $this->tnt->selectIndex("{$name}.index");

        $indexer = $this->tnt->getIndex();

        // فیلدهای قابل جستجو
        $searchableFields = array_keys($model->toSearchableArray());

        if (empty($searchableFields)) {
            throw new \Exception("No searchable fields defined for model: {$modelClass}");
        }

        // ساخت کوئری
        $query = "SELECT id, " . implode(', ', $searchableFields) . " FROM {$model->getTable()}";

        // soft delete
        if (in_array(SoftDeletes::class, class_uses_recursive($model))) {
            $query .= " WHERE deleted_at IS NULL";
        }

        $indexer->query($query);
        $indexer->run();
    }

    protected function getModelClass($indexName)
    {
        $models = [
            'bank_services' => \App\Models\BankService::class,
            'blogs' => \App\Models\Blog::class,
        ];

        return $models[$indexName] ?? null;
    }
}
