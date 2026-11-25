<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // CONSTANT: nilai role tetap
    public const ROLE_ADMIN    = 'admin';
    public const ROLE_CUSTOMER = 'customer';

    // PROPERTY
    protected $fillable = ['name', 'email', 'phone', 'password', 'role'];
    protected $hidden   = ['password', 'remember_token'];
    protected $casts    = ['password' => 'hashed'];

    // ===== RELASI =====
    /**
     * @return HasMany<Order>
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @return HasMany<Payment>
     */
    public function verifiedPayments(): HasMany
    {
        return $this->hasMany(Payment::class, 'verified_by');
    }

    // ===== CONSTRUCTOR =====
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        // default role jika belum diset
        if (!isset($this->attributes['role'])) {
            $this->attributes['role'] = self::ROLE_CUSTOMER;
        }
    }

    // ===== SETTER (mutator) =====
    public function setPhoneAttribute(string $value): void
    {
        $this->attributes['phone'] = preg_replace('/[^0-9+]/', '', $value);
    }

    public function setNameAttribute(string $value): void
    {
        $this->attributes['name'] = trim($value);
    }

    public function setRole(string $role): void
    {
        if (!in_array($role, [self::ROLE_ADMIN, self::ROLE_CUSTOMER], true)) {
            throw new \InvalidArgumentException("Role tidak dikenal: {$role}");
        }
        $this->attributes['role'] = $role;
    }

    // ===== GETTER (accessor) =====
    public function getRoleLabelAttribute(): string
    {
        return $this->role === self::ROLE_ADMIN ? 'Administrator' : 'Pelanggan';
    }

    public function getInitialsAttribute(): string
    {
        return strtoupper(mb_substr((string) $this->name, 0, 1));
    }

    // ===== STATIC FACTORY =====
    /**
     * @param array<string, mixed> $data
     * @return static
     */
    public static function createAdmin(array $data): static
    {
        $user = new static($data);
        $user->setRole(self::ROLE_ADMIN);
        $user->save();
        return $user;
    }

    /**
     * @param array<string, mixed> $data
     * @return static
     */
    public static function createCustomer(array $data): static
    {
        $user = new static($data);
        $user->setRole(self::ROLE_CUSTOMER);
        $user->save();
        return $user;
    }

    // ===== OBJECT METHOD =====
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isCustomer(): bool
    {
        return $this->role === self::ROLE_CUSTOMER;
    }

    // ===== SCOPE =====
    /**
     * @param Builder $q
     * @return Builder
     */
    public function scopeAdmins(Builder $q): Builder
    { 
        return $q->where('role', self::ROLE_ADMIN); 
    }

    /**
     * @param Builder $q
     * @return Builder
     */
    public function scopeCustomers(Builder $q): Builder
    { 
        return $q->where('role', self::ROLE_CUSTOMER); 
    }
}