<?php

declare(strict_types=1);

namespace Tests\Unit\Helpers;

use Tests\TestCase;

class FileTest extends TestCase
{
    public function testFileGetClassNames() : void
    {
        $this->assertContains('UserModel', file_get_class_names(app_path('Models')));
        $this->assertCount(0, file_get_class_names(storage_path()));
    }
}
