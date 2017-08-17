<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'articles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'article_category_id', 'title', 'slug', 'contents', 'image_path', 'updated_user_id', 
    ];

    /**
     * 
     *
     * 
     */
    public static function getArticles($pagination = 5){

        return Article::orderBy('created_at', 'desc')->paginate($pagination);

    }

    /**
     * 
     *
     * 
     */
    public static function getArticleById($id){
        
       return Article::findOrFail($id);
    
    }

    /**
     * 
     *
     * 
     */
    public static function storeArticle($article){
        
        $article = Article::create($article);

        return $article;
    }

    /**
     * 
     *
     * 
     */
    public static function updateArticle($article){

        return $article->save();
    }

    /**
     * 
     *
     * 
     */
    public static function destroy($id){
        
        $article = Article::withTrashed()->findOrFail($id);

        return $article->delete();

    }

}
