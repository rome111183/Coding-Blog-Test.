<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\ArticleCategory;

class ArticleCategoryController extends Controller
{
	protected $me;

    public function __construct() {

		$this->me = \Auth::user();

    }

    /**
	 * Display a listing of the ArticleCategory
	 *
	 * @return \Illuminate\Http\Response
	 */
	protected function index(){

        $articlecategory = ArticleCategory::getArticleCategories();

        return view('articlecategory.list', ['articlecategory' => $articlecategory]);
    
	}

    /**
	 * Show the form for creating a new ArticleCategory
	 *
	 * @return \Illuminate\Http\Response
	 */
	protected function create(){

        return view('articlecategory.register');

    }
    
    /**
	 * Store a newly created ArticleCategory in database.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	protected function store(Requests\ArticleCategoryCreateRequest $request){

		$articlecategory = [

				'name' => \Input::get('name'),

				'updated_user_id' => \Input::get('updated_user_id'),

				// 'updated_user_id' => $this->me->id,

			];

		$articlecategory = ArticleCategory::storeArticleCategory($articlecategory);

        \Session::flash('flash_message','successfully saved.');

        return redirect()->route("articlecategory.lists");
    }
    /**
	 * Display the specified ArticleCategory.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	protected function read($id){

        return view('articlecategory.content');

    }

    /**
	 * Show the form for editing the specified ArticleCategory.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	protected function edit($id){
        
		$articlecategory = ArticleCategory::getArticleCategoryById($id);
        
		return view('articlecategory.edit', ['articlecategory' => $articlecategory]);
    
	}

    /**
	 * Update the specified ArticleCategory in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	protected function update(Requests\ArticleCategoryEditRequest $request, $id){

        $articlecategory = ArticleCategory::getArticleCategoryById($id);

		$articlecategory->name = \Input::get('name');

		$articlecategory->updated_user_id = \Input::get('updated_user_id');

		// $articlecategory->updated_user_id = $this->me->id;

        $articlecategory = ArticleCategory::updateArticleCategory($articlecategory);

        \Session::flash('flash_message','successfully saved.');

        return redirect()->route("articlecategory.lists");

    }

    /**
	 * Remove the specified ArticleCategory from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	protected function delete(Requests\ArticleCategoryDeleteRequest $request){

        $articlecategory = ArticleCategory::destroy($request['id']);

        \Session::flash('flash_message','successfully deleted.');
        
        return redirect()->route("articlecategory.lists");
    
	}
}
