<?php
// app/Policies/AdminPolicy.php

namespace App\Policies;

use App\Models\Admin;
use Illuminate\Auth\Access\Response;

class AdminPolicy
{
    /**
     * Проверка, является ли пользователь админом.
     */
    public function isAdmin(Admin $admin): bool
    {
        return $admin->is_active && $admin->exists;
    }

    /**
     * Проверка, может ли админ управлять категориями.
     */
    public function manageCategories(Admin $admin): bool
    {
        return $this->isAdmin($admin);
    }

    /**
     * Проверка, может ли админ управлять товарами.
     */
    public function manageProducts(Admin $admin): bool
    {
        return $this->isAdmin($admin);
    }

    /**
     * Проверка, может ли админ управлять заявками.
     */
    public function manageLeads(Admin $admin): bool
    {
        return $this->isAdmin($admin);
    }

    /**
     * Проверка, может ли админ просматривать логи.
     */
    public function viewLogs(Admin $admin): bool
    {
        return $this->isAdmin($admin);
    }
}
