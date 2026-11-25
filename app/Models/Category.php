<?php

namespace App\Models;

class Category extends BaseModel
{
    protected $fillable = ['name', 'description', 'is_active'];
    protected $casts    = ['is_active' => 'boolean'];

    // CONSTRUCTOR: set default is_active
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        if (!isset($this->attributes['is_active'])) {
            $this->attributes['is_active'] = true;
        }
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    // OBJECT METHOD
    public function isUsedByOrders(): bool
    {
        return $this->menus()->whereHas('orderItems')->exists();
    }

    /**
     * OVERRIDING: override delete() bawaan Eloquent
     * Kategori yang sudah dipakai menu TIDAK dihapus permanen,
     * hanya dinonaktifkan (sesuai PRD Bab 4.2).
     */
    public function delete(): bool
    {
        if ($this->menus()->exists()) {
            $this->is_active = false;
            return $this->save();
        }
        return parent::delete();
    }

    // STATIC SCOPE
    public static function active()
    {
        return self::where('is_active', true)->orderBy('name');
    }
}