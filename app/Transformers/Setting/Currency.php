<?php
namespace App\Transformers\Setting;

use App\Models\Setting\Currency as Model;
use League\Fractal\TransformerAbstract;

class Currency extends TransformerAbstract
{
    /**
     * @param Model $model
     * @return array
     */
    public function transform(Model $model)
    {
        return [
          'id' => $model->id,
          'company_id' => $model->company_id,
          'name' => $model->name,
          'code' => $model->code,
          'rate' => $model->rate,
          'enabled' => $model->enabled,
          'created_at' => $model->created_at->toIso8601String(),
          'updated_at' => $model->updated_at->toIso8601String(),
        ];
    }
}
