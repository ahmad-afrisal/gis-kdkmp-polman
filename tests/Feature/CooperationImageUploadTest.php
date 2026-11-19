<?php

namespace Tests\Feature;

use App\Http\Requests\CooperationImageStoreRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class CooperationImageUploadTest extends TestCase
{
    public function test_multiple_supported_images_can_be_uploaded_together(): void
    {
        $rules = (new CooperationImageStoreRequest())->rules();
        $validator = Validator::make([
            'images' => [
                UploadedFile::fake()->image('front.jpg'),
                UploadedFile::fake()->image('inside.png'),
            ],
        ], $rules);

        $this->assertFalse($validator->fails());
    }

    public function test_at_least_one_image_is_required(): void
    {
        $rules = (new CooperationImageStoreRequest())->rules();

        $this->assertTrue(Validator::make([], $rules)->fails());
    }
}
