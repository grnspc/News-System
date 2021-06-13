<?php

namespace GrnSpc\News\View\Components;

use GrnSpc\News\Models\Article;
use Illuminate\View\Component;

class FrontFeed extends Component
{

    public $articles = [];


    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->articles = Article::with('category', 'tags', 'author:id,name')
            ->latest()
            ->take(6)
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('news::front-feed');
    }
}
