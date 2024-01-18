<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class finix_external_links extends Model
{
    use HasFactory;
    protected $table="finix_external_links";
    protected $guarded=['id'];


public static function fromArray(array $array)
{
    foreach ($array as $data) {
        $data = (object)$data;

        $found = self::where('finix_id', $data->id)->first();

        if ($found == null) {
            $found = self::create([
                'finix_id' => $data->id ?? null,
                'link_id' => $data->id ?? null, // assuming 'id' is the link_id
                'expires_at' => $data->expires_at ?? null,
                'file_id' => $data->file_id ?? null,
                'type' => $data->type ?? null,
                'url' => $data->url ?? null,
                'user_id' => $data->user_id ?? null,
            ]);
        } else {
            $found->update([
                'finix_id' => $data->id ?? null,
                'link_id' => $data->id ?? null, // assuming 'id' is the link_id
                'expires_at' => $data->expires_at ?? null,
                'file_id' => $data->file_id ?? null,
                'type' => $data->type ?? null,
                'url' => $data->url ?? null,
                'user_id' => $data->user_id ?? null,
            ]);
        }

        // Save and refresh the model
        $found->save();
        $found->refresh();
    }
}
}
