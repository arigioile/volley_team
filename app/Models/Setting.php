<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Riporta il valore di una determinata chiave. Nel caso la chiave non esiste viene riportato il valore di default
     *
     * @param string $key chiave da cercare
     * @param string $defaultValue valore riportato nel caso in cui la chiave non esista
     *
     * @return string valore della chiave cercata
     */
    public static function valueForKey($key, $defaultValue = null)
    {
        $item = Setting::firstWhere('key', $key);

        if ($item == null) return $defaultValue;

        return $item->value;
    }

    /**
     * Imposta il valore di una determinata chiave.
     *
     * @param string $key chiave da inserire
     * @param string $value valore
     */
    public static function setValueForKey($key, $value)
    {
        $value = Setting::updateOrCreate([
            'key' => $key,
        ], [
            'value' => $value,
        ]);

        return $value;
    }
}
