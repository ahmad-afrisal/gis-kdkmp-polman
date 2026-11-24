<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Article;
use App\Models\BussinessAssistant;
use App\Models\Cooperation;
use App\Models\District;
use App\Models\ExistingCooperative;
use App\Models\Village;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $cooperations = Cooperation::with([
            'images',
            'village:id,name,district_id',
            'village.district:id,name',
        ])->get();

        $existingCooperatives = ExistingCooperative::with([
            'images',
            'village:id,name,district_id',
            'district:id,name',
            'cooperativeStatus:id,name',
            'businessActivity:id,name',
        ])->get();

        $cooperationPoints = $cooperations->map(fn ($cooperation) => [
            'name' => $cooperation->name,
            'latitude' => $cooperation->latitude,
            'longitude' => $cooperation->longtitude,
            'address' => $cooperation->full_address,
            'village' => $cooperation->village->name ?? null,
            'district' => $cooperation->village->district->name ?? null,
            'leader' => $cooperation->leader_name,
            'photos' => $cooperation->images
                ->map(fn ($image) => asset('storage/' . $image->path))
                ->values(),
        ])->values();

        $existingCooperativePoints = $existingCooperatives->map(fn ($cooperative) => [
            'name' => $cooperative->name,
            'latitude' => $cooperative->latitude,
            'longitude' => $cooperative->longitude,
            'photos' => $cooperative->images
                ->map(fn ($image) => asset('storage/' . $image->path))
                ->values(),
            'chairperson' => $cooperative->chairperson_name,
            'status' => $cooperative->cooperativeStatus->name ?? 'Belum diisi',
            'type' => $cooperative->type_of_cooperative,
            'members' => $cooperative->number_of_members,
            'businessActivity' => $cooperative->businessActivity->name ?? 'Belum diisi',
            'address' => $cooperative->address,
            'village' => $cooperative->village->name ?? null,
            'district' => $cooperative->district->name ?? null,
        ])->values();

        $hasCoordinates = static function ($latitude, $longitude): bool {
            return is_numeric($latitude)
                && is_numeric($longitude)
                && $latitude >= -90
                && $latitude <= 90
                && $longitude >= -180
                && $longitude <= 180;
        };

        $cooperationStats = [
            'total' => $cooperations->count(),
            'mapped' => $cooperations->filter(
                fn ($item) => $hasCoordinates($item->latitude, $item->longtitude)
            )->count(),
            'districts' => $cooperations->pluck('village.district_id')->filter()->unique()->count(),
            'villages' => $cooperations->pluck('village_id')->filter()->unique()->count(),
        ];

        $statusCategory = static function (?string $status): string {
            $status = mb_strtolower($status ?? '');

            if (
                str_contains($status, 'tidak aktif')
                || str_contains($status, 'tidak aktfi')
                || str_contains($status, 'nonaktif')
            ) {
                return 'inactive';
            }

            if (str_contains($status, 'sehat')) {
                return 'healthy';
            }

            return str_contains($status, 'aktif') ? 'active' : 'other';
        };

        $existingCooperativeStats = [
            'total' => $existingCooperatives->count(),
            'mapped' => $existingCooperatives->filter(
                fn ($item) => $hasCoordinates($item->latitude, $item->longitude)
            )->count(),
            'members' => (int) $existingCooperatives->sum('number_of_members'),
            'districts' => $existingCooperatives->pluck('district_id')->filter()->unique()->count(),
            'healthy' => $existingCooperatives->filter(
                fn ($item) => $statusCategory($item->cooperativeStatus->name ?? null) === 'healthy'
            )->count(),
            'active' => $existingCooperatives->filter(
                fn ($item) => $statusCategory($item->cooperativeStatus->name ?? null) === 'active'
            )->count(),
            'inactive' => $existingCooperatives->filter(
                fn ($item) => $statusCategory($item->cooperativeStatus->name ?? null) === 'inactive'
            )->count(),
        ];

        $businessActivityStats = $existingCooperatives
            ->groupBy(fn ($item) => $item->businessActivity->name ?? 'Belum diisi')
            ->map(fn ($items, $name) => ['name' => $name, 'count' => $items->count()])
            ->sortByDesc('count')
            ->take(6)
            ->values();

        $villages = Village::select('id', 'type', 'name', 'geojson')->get();
        $districts = District::select('id', 'name', 'geojson')->get();

        return view('welcome', compact(
            'cooperationPoints',
            'existingCooperativePoints',
            'cooperationStats',
            'existingCooperativeStats',
            'businessActivityStats',
            'villages',
            'districts'
        ));
    }

    public function filter(Request $request)
    {
        $type = $request->type;
        $id = $request->id;

        $data = [];

        if ($type === 'kecamatan') {
            $district = District::find($id);
            if ($district && $district->geojson) {
                $data = json_decode($district->geojson);
            }
        } elseif ($type === 'desa') {
            $village = Village::find($id);
            if ($village && $village->geojson) {
                $data = json_decode($village->geojson);
            }
        } elseif ($type === 'ba') {
            $villages = Village::where('business_assistant_id', $id)->get();
            $features = [];
            foreach ($villages as $village) {
                if ($village->geojson) {
                    $features[] = json_decode($village->geojson);
                }
            }
            $data = [
                'type' => 'FeatureCollection',
                'features' => $features,
            ];
        }

        return response()->json($data);
    }

    public function articles()
    {
        // Mengambil data artikel dengan relasi koperasi, diurutkan dari yang terbaru
        $articles = Article::with('cooperation')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('articles', compact('articles'));
    }

    public function announcements()
    {
        // Mengambil pengumuman terbaru beserta data koperasi
        $announcements = Announcement::orderBy('created_at', 'desc')
            ->get();

        return view('announcements', compact('announcements'));
    }

    public function gallery()
    {
        return view('gallery');
    }

    public function contact()
    {
        return view('contact');
    }

    public function performance($id)
    {
        $assistant = BussinessAssistant::findOrFail($id);
        return view('performance', compact('assistant'));
    }
}
