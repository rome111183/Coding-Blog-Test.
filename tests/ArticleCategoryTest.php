<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\ArticleCategory;
use App\User;

class ArticleCategoryTest extends TestCase
{  
	/**
     * Test Create New Article Category Page.
     *
     * @return void
     */
    public function testArticleCategoryCreate()
    {
		$name = 'cat '.rand(1,100);
		while(\DB::table('article_category')->where('name', '=', $name)->count()>0) {
			$name = 'cat '.rand(1,100);
		}
	    
		$user = new User(array('name' => 'administrator'));
		$this->be($user);

		$this->visit('/articlecategory/create')
			->see('Register new Article Category')
			->type($name, 'name')
            ->type(1, 'updated_user_id')
			->press('Create')
			->visit('/articlecategory/lists')
			->seePageIs('/articlecategory/lists')
			->see('Article Category List');
	}

	/**
     * Test Edit Article Category Page.
     *
     * @return void
     */
    public function testArticleCategoryEdit()
    {
		$user = new User(array('name' => 'administrator'));
		$this->be($user);

		$articleCategoryObj = ArticleCategory::orderBy('created_at', 'desc')->first();

		$this->visit('/articlecategory/edit/'.$articleCategoryObj->id)
            ->see('Edit Article Category')
			->type($articleCategoryObj->name.='-'.rand(1,100), 'name')
            ->type(1, 'updated_user_id')
			->press('Update')
			->visit('/articlecategory/lists')
			->seePageIs('/articlecategory/lists')
			->see('Article Category List');
	}

	/**
     * Test Soft Delete a Article Category.
     *
     * @return void
     */
    public function testArticleCategoryDelete()
    {
		$user = new User(array('name' => 'administrator'));
		$this->be($user);

		$articleCategoryObj = ArticleCategory::orderBy('created_at', 'desc')->first();

		$response = $this->call('POST', '/articlecategory/delete', ['id' => $articleCategoryObj->id]);
	}

	/**
     * Test Article Categories Listings page.
     *
     * @return void
     */
    public function testArticleCategoryAll()
    {
		$user = new User(array('name' => 'administrator'));
		$this->be($user);

		$response = $this->call('GET', '/articlecategory/lists');

    	$this->assertEquals(200, $response->status());
	}
}
