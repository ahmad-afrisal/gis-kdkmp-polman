<?php

namespace Tests\Feature;

use App\Exports\ExistingCooperativeTemplateSheet;
use App\Http\Requests\ExistingCooperativeStoreRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class ExistingCooperativeCoordinatesTest extends TestCase
{
    public function test_coordinates_are_optional_but_must_be_provided_as_a_valid_pair(): void
    {
        $rules = (new ExistingCooperativeStoreRequest())->rules();
        $coordinateRules = array_intersect_key($rules, array_flip(['latitude', 'longitude']));

        $this->assertFalse(Validator::make([], $coordinateRules)->fails());
        $this->assertFalse(Validator::make([
            'latitude' => '-90',
            'longitude' => '180',
        ], $coordinateRules)->fails());
        $this->assertTrue(Validator::make([
            'latitude' => '-3.4',
        ], $coordinateRules)->fails());
        $this->assertTrue(Validator::make([
            'latitude' => '90.1',
            'longitude' => '119.3',
        ], $coordinateRules)->fails());
        $this->assertTrue(Validator::make([
            'latitude' => '-3.4',
            'longitude' => '180.1',
        ], $coordinateRules)->fails());
    }

    public function test_upload_template_includes_coordinate_columns(): void
    {
        $headings = (new ExistingCooperativeTemplateSheet())->headings();
        $addressIndex = array_search('alamat', $headings, true);

        $this->assertSame(['alamat', 'latitude', 'longitude', 'kode_pos'], array_slice($headings, $addressIndex, 4));
    }
}
