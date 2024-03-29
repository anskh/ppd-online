<?php namespace App\Controllers;

use CodeIgniter\Exceptions\PageNotFoundException;
use Config\Services;

class Kb extends BaseController
{
    public function error404()
    {
        echo view('frontend/error',[
            'locale' => $this->locale,
            'title' => lang('Client.404.title'),
            'body' => lang('Client.404.body')
        ]);
    }
    
    public function error403()
    {
        echo view('frontend/error',[
            'locale' => $this->locale,
            'title' => lang('Client.403.title'),
            'body' => lang('Client.403.body')
        ]);
    }
    
    public function error500()
    {
        echo view('frontend/error',[
            'locale' => $this->locale,
            'title' => lang('Client.500.title'),
            'body' => lang('Client.500.body')
        ]);
    }
    
	public function home()
	{
		return view('frontend/home',[
            'locale' => $this->locale,
		    'category_id' => 0
        ]);
	}
    
    public function kbHome()
	{
		return view('frontend/kb',[
            'locale' => $this->locale,
		    'category_id' => 0
        ]);
	}

	public function category($category_id=0)
    {
        $kb = Services::kb();
        if($category_id != 0){
            if(!in_array($category_id, $kb->publicCategories())){
                throw PageNotFoundException::forPageNotFound();
            }
            if(!$category = $kb->getCategory($category_id)){
                throw PageNotFoundException::forPageNotFound();
            }
        }
        return view('frontend/kb', [
            'locale' => $this->locale,
            'category_id' => $category_id,
            'category' => isset($category) ? $category : null
        ]);
    }

    public function article($article_id)
    {
        $kb = Services::kb();
        if(!$article = $kb->getArticle($article_id)){
            throw PageNotFoundException::forPageNotFound();
        }
        if($article->category != 0){
            if(!in_array($article->category, $kb->publicCategories())){
                throw PageNotFoundException::forPageNotFound();
            }
            if(!$category = $kb->getCategory($article->category)){
                throw PageNotFoundException::forPageNotFound();
            }
        }

        if($this->request->getGet('download')){
            $attachments = Services::attachments();
            if(!$file = $attachments->getRow(['id' => $this->request->getGet('download'),'article_id' => $article_id])){
                return view('frontend/error',[
                    'locale' => $this->locale,
                    'title' => lang('Client.error.fileNotFound'),
                    'body' => lang('Client.error.fileNotFoundMsg'),
                    'footer' => ''
                ]);
            }
            return $attachments->download($file);
        }
        $kb->addView($article_id);

        return view('frontend/article', [
            'locale' => $this->locale,
            'article' => $article,
            'category' => $category
        ]);
    }

    public function search()
    {
        if($this->request->getPostGet('keyword') == '' || strlen($this->request->getPostGet('keyword')) <= 3){
            return $this->home();
        }
        $kb = Services::kb();
        $result = $kb->searchArticles($this->request->getPostGet('keyword'));
        return view('frontend/search_result',[
            'locale' => $this->locale,
            'result' => $result,
            'keyword' => esc($this->request->getPostGet('keyword'))
        ]);
    }

}
