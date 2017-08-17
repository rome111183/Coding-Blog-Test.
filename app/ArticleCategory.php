<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleCategory extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'article_category';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'updated_user_id', 
    ];

    /**
     * 
     *
     * 
     */
    public static function getArticleCategories($pagination = 5){

        return ArticleCategory::orderBy('created_at', 'desc')->paginate($pagination);

    }

    /**
     * 
     *
     * 
     */
    public static function getArticleCategoryById($id){
        
        return ArticleCategory::findOrFail($id);
    
    }

    /**
     * 
     *
     * 
     */
    public static function storeArticleCategory($articleCategory){
        
        $articleCategory = ArticleCategory::create($articleCategory);

        return $articleCategory;

    }

    /**
     * 
     *
     * 
     */
    public static function updateArticleCategory($articleCategory){
        
        return $articleCategory->save();

    }

    /**
     * 
     *
     * 
     */
    public static function destroy($id){
        
        $articleCategory = ArticleCategory::withTrashed()->findOrFail($id);

        return $articleCategory->delete();

    }
}
