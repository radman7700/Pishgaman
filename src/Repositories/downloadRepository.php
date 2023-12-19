<?php

namespace Pishgaman\Pishgaman\Repositories;

use Pishgaman\Pishgaman\Database\Models\Download;

class downloadRepository
{
    protected $model;

    public function __construct(Download $model)
    {
        $this->model = $model;
    }

    public function Get(array $options, $perPage = 10)
    {
        $query = Download::query();
    
        // اضافه کردن 'orderby' اختیاری
        if (isset($options['sortings']) && is_array($options['sortings'])) {
            foreach ($options['sortings'] as $sorting) {
                if (isset($sorting['column'])) {
                    $order = isset($sorting['order']) && strtolower($sorting['order']) === 'desc' ? 'desc' : 'asc';
                    $query->orderBy($sorting['column'], $order);
                }
            }
        }
    
        // اضافه کردن 'groupby' اختیاری
        if (isset($options['groupby'])) {
            $query->groupBy($options['groupby']);
        }
    
        // اضافه کردن شروط اضافی اختیاری
        if (isset($options['conditions']) && is_array($options['conditions'])) {
            foreach ($options['conditions'] as $condition) {
                if (isset($condition['column']) && isset($condition['operator']) && isset($condition['value'])) {
                    if ($condition['column'] === 'name' || $condition['column'] === 'last_name' || $condition['column'] === 'username') {
                        $query->orWhere($condition['column'], 'like', '%' . $condition['value'] . '%');
                    } else {
                        $query->where($condition['column'], $condition['operator'], $condition['value']);
                    }
                }
            }
        }
    
        // اضافه کردن مشخصات برای select
        if (isset($options['select']) && is_array($options['select'])) {
            $query->select($options['select']);
        }
    
        // اضافه کردن شمارش رکوردها
        $count = isset($options['count']) && $options['count'] ? true : false;
    
        if ($count) {
            return $query->count();
        }
    
        $get = isset($options['get']) && $options['get'] ? true : false;
    
        if (isset($options['with']) && is_array($options['with'])) {
            $query->with($options['with']);
        }
    
        if (isset($options['take']) && is_numeric($options['take'])) {
            $query->take((int)$options['take']);
        }

        if ($get) {
            return $query->get();
        }
    
        // اضافه کردن صفحه‌بندی
        $page = isset($options['page']) ? $options['page'] : 1;
        return $query->paginate($perPage, ['*'], 'page', (int) $page);
    }
   

    public function create(array $attributes)
    {
        $query = Download::query();
        return $query->create($attributes);
    }

    public function update(Download $Download, array $attributes)
    {
        return $Download->update($attributes);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function delete(User $user)
    {
        return $user->delete();
    }

    // دیگر متدها و عملیات‌های مرتبط با کار با مدل User
}
