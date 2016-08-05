<?php

class NewsController extends BaseController
{
    public function showIndex($id=null)
    {
        if($id)
        {
            $news = News::find($id);
            $title = $news->title;
            
            return View::make('site.news_single', array(
                'title' => $title,
                'new' => $news,
            ));
        }
        
        $title = 'News';
        
        $news = News::where('active', '=', '1')
                ->orderBy('date', 'desc')
                ->paginate(5);
        
        return View::make('site.news', array(
            'title' => $title,
            'news' => $news,
        ));
    }
}