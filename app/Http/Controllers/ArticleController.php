<?php

namespace App\Http\Controllers;

use App\Helpers\Folder;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\ArticleImage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends BaseController
{
    public function index(): View
    {
        $title = \Lang::trans('labels.nav.news');
        $articles = Article::orderByDesc('created_at')->get();

        return view('news.index', compact('title', 'articles'));
    }

    public function show(Article $article): View
    {
        if (!$this->auth_user->readArticles()->where('article_id', '=', $article->id)->exists()) {
            $this->auth_user->readArticles()->attach($article->id);
        }

        return view('news.show', compact('article'));
    }

    public function create(): View
    {
        $title = \Lang::trans('labels.create_article');
        $article = new Article();

        return view('news.form', compact('title', 'article'));
    }

    public function store(ArticleRequest $request): RedirectResponse
    {
        try {
            Article::create($request->all([
                'title',
                'preview',
                'body',
            ]));
            \Flash::success(\Lang::trans('labels.article_created_success'));
        } catch (QueryException $exception) {
            \Flash::danger(\Lang::trans('labels.article_created_fail'));

            return redirect()->back();
        }

        return redirect()->route('news.index');
    }

    public function edit(Article $article): View
    {
        $title = \Lang::trans('labels.edit_article');

        return view('news.form', compact('title', 'article'));
    }

    public function update(Article $article, ArticleRequest $request): RedirectResponse
    {
        try {
            $article->update($request->all([
                'title',
                'preview',
                'body',
            ]));
            \Flash::success(\Lang::trans('labels.article_updated_success'));
        } catch (QueryException $exception) {
            \Flash::danger(\Lang::trans('labels.article_update_fail'));

            return redirect()->back();
        }

        return redirect()->route('news.show', ['article' => $article]);
    }

    public function destroy(Article $article): RedirectResponse
    {
        try {
            $article->delete();
            \Flash::success(\Lang::trans('labels.article_delete_success'));
        } catch (\Exception $exception) {
            \Flash::danger(\Lang::trans('labels.article_delete_fail'));
        }

        return redirect()->route('news.index');
    }

    public function images(): View
    {
        $title = \Lang::trans('labels.upload_image');
        $images = ArticleImage::query()->orderByDesc('id')->get();

        return view('news.images', compact('title', 'images'));
    }

    public function uploadImage(Request $request)
    {
        Folder::checkStorageDirectory(ArticleImage::FOLDER);

        try {
            $files = $request->file('file');
            if (!is_array($files)) {
                $files = [$files];
            }
            foreach ($files as $file) {
                $file_name = $file->hashName();

                $file->storeAs(ArticleImage::FOLDER, $file_name);

                ArticleImage::query()->create([
                    'name' => $file_name,
                ]);
            }

            \Flash::success(\Lang::trans('labels.image_upload_success'));
        } catch (\Exception $exception) {
            \Flash::success(\Lang::trans('labels.image_upload_fail'));
        }

        return redirect()->route('news.image');
    }

    public function deleteImage($id): JsonResponse
    {
        try {
            ArticleImage::query()->findOrFail($id)->delete();
            $status = 204;
        } catch (ModelNotFoundException $exception) {
            $status = 404;
        } catch (\Exception $exception) {
            $status = 500;
        }

        return new JsonResponse([], $status);
    }
}
