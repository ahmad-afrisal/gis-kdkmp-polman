<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleStoreRequest;
use App\Http\Requests\ArticleUpdateRequest;
use App\Models\Article;
use App\Models\Cooperation;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $query = Article::orderBy('updated_at', 'desc');
            // $query = Problem::query(); // ambil data farmer + user

            return DataTables::of($query)
                ->addColumn('link', function ($item) {
                    return '<a href="' . $item->link . '" 
                    target="_blank"
                    class="text-blue-600 hover:underline">
                    ' . $item->link . '
                </a>';
                })
                ->addColumn('status', function ($item) {
                    if ($item->status == 1) {
                        return '<span class="bg-green-500 text-white text-xs font-semibold px-2 py-1 rounded">
                        Aktif
                    </span>';
                    } else {
                        return '<span class="bg-red-500 text-white text-xs font-semibold px-2 py-1 rounded">
                        Tidak Aktif
                    </span>';
                    }
                })
                ->addColumn('action', function ($item) {
                    return '
            <a href="' . route('articles.edit', $item->id) . '" 
                class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-1 px-2 rounded shadow-lg">
                Edit
            </a>
        ';
                })
                ->rawColumns(['link', 'status', 'action'])
                ->make(true);
        }


        return view('article.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cooperations = Cooperation::pluck('name', 'id');

        return view('article.create', [
            'cooperations' => $cooperations,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleStoreRequest $request)
    {
        $data = $request->validated();
        Article::create($data);

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $cooperations = Cooperation::pluck('name', 'id');

        return view(
            'article.edit',
            [
                'data' => $article,
                'cooperations' => $cooperations,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleUpdateRequest $request, Article $article)
    {
        $data = $request->validated();

        $article->update($data);
        return to_route('articles.index')->with('success', 'Artikel berhasil diupdate');
    }
}
