<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Article;
use App\ArticleCategory;

class ArticleController extends Controller
{
	protected $categories;
	protected $me;

    public function __construct() {

		$this->categories = ArticleCategory::select('id', 'name')->get()->toArray();
		
		$results = array();

		foreach ($this->categories as $value) {

			$results[$value['id']] = $value['name'];

		}

		$this->categories = $results;

		unset($results); 

		$this->me = \Auth::user();

    }

    /**
	 * Display a listing of the Articles
	 *
	 * @return \Illuminate\Http\Response
	 */
	protected function index(){

        $articles = Article::getArticles();

        return view('article.list', ['articles' => $articles]);

    }

    /**
	 * Show the form for creating a new Article
	 *
	 * @return \Illuminate\Http\Response
	 */
	protected function create(){

        return view('article.register',['categories' => $this->categories]);
    
	}
    
    /**
	 * Store a newly created Article in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	protected function store(Requests\ArticleCreateRequest $request){

		$destination = public_path('uploads/photos/'); // your upload folder

		$image = $request->file('image_path');

		$filename = '';

		if(\Input::hasFile('image_path')){

			// $filename    = $image->getClientOriginalName(); 

			$filename = time().'.'.$image->getClientOriginalExtension();

			$image->move($destination, $filename);

		}

		$article = [

				'article_category_id' => \Input::get('article_category_id'),

				'title' => \Input::get('title'),

				'slug' => str_slug(\Input::get('slug'), '_'),

				'contents' => \Input::get('contents'),

				'image_path' => $filename ? $destination.$filename : $filename,

				'updated_user_id' => \Input::get('updated_user_id'),

				// 'updated_user_id' => $this->me->id,

			];

		$article = Article::storeArticle($article);

        \Session::flash('flash_message','successfully saved.');

        return redirect()->route("article.lists");

    }
    /**
	 * Display the specified Article.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	protected function read($id){

        return view('article.content');

    }

    /**
	 * Show the form for editing the specified Article.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	protected function edit($id){

        $article = Article::getArticleById($id);

        return view('article.edit', ['article' => $article, 'categories' => $this->categories]);
    
	}

    /**
	 * Update the specified Article in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	protected function update(Requests\ArticleEditRequest $request, $id){

		$article = Article::getArticleById($id);

		$destination = public_path('uploads/photos/'); // your upload folder

		$image = $request->file('image_path');

		$filename = '';

		if(\Input::hasFile('image_path')){

			// $filename    = $image->getClientOriginalName(); 

			$filename = time().'.'.$image->getClientOriginalExtension();

			$image->move($destination, $filename);

		}
		
		$article->article_category_id = \Input::get('article_category_id');

		$article->title = \Input::get('title');

		$article->slug = str_slug(\Input::get('slug'), '_');

		$article->contents = \Input::get('contents');

		$article->image_path = $filename ? $destination.$filename : $article->image_path;

		$article->updated_user_id = \Input::get('updated_user_id');

		// $article->updated_user_id = $this->me->id;

		$user = Article::updateArticle($article);

        \Session::flash('flash_message','successfully saved.');

        return redirect()->route("article.lists");
    }

    /**
	 * Remove the specified Article from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	protected function delete(Requests\ArticleDeleteRequest $request){

        $article = Article::destroy($request['id']);

        \Session::flash('flash_message','successfully deleted.');
        
        return redirect()->route("article.lists");

    }
}
