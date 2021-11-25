<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Security\Role;
use Illuminate\Database\Eloquent\Collection;

class RoleHasManyUsersTest extends TestCase
{
    public function test_a_role_has_many_users()
    {
        $role = new Role;
        $this->assertInstanceOf(Collection::class, $role->users);
    }
}
