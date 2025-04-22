<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class ArchivoHistoria extends Model {
    protected $fillable = ['historia_id', 'archivado_en'];

    public function historia(): BelongsTo {
        return $this->belongsTo(Formatohistoria::class, 'historia_id');
    }
}
