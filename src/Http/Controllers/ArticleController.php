<?php

namespace GrnSpc\News\Http\Controllers;

use GrnSpc\News\Models\Article;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function show(Article $article)
    {
        return view('news::article.show', compact('article'));
    }
}
