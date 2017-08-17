<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\Article;
use App\ArticleCategory;

class ArticlesTest extends TestCase
{
    /**
     * Test Create New Article Page.
     *
     * @return void
     */
    public function testArticleCreate()
    {
		$title = 'content '.rand(1,100);
		while(\DB::table('articles')->where('title', '=', $title)->count()>0) {
			$title = 'content '.rand(1,100);
		}

        $articleCategoryObj = ArticleCategory::inRandomOrder()->first();
        $slug = str_slug($title, '_');
        $destination = public_path('images/');
        $test_file = $destination .'no-image.png';

        $this->assertTrue(file_exists($test_file), 'Test file does not exist');
	    
		$user = new User(array('name' => 'administrator'));
		$this->be($user);

		$this->visit('/article/create')
			->see('Register new Article')
            ->type($articleCategoryObj->id, 'article_category_id')
            ->type($title, 'title')
            ->type($slug, 'slug')
            ->type('Content...', 'contents')
			->attach($test_file, 'image_path')
			->type(1, 'updated_user_id')
			->press('Create')
			->visit('/article/lists')
			->seePageIs('/article/lists')
			->see('Article List');
	}

	/**
     * Test Edit Article Page.
     *
     * @return void
     */
    public function testArticleEdit()
    {
		$user = new User(array('name' => 'administrator'));
		$this->be($user);

		$articleObj = Article::orderBy('created_at', 'desc')->first();
        $articleCategoryObj = ArticleCategory::inRandomOrder()->first();
        $destination = public_path('images/');
        $test_file = $destination .'no-image.png';

        $this->assertTrue(file_exists($test_file), 'Test file does not exist');

		$this->visit('/article/edit/'.$articleObj->id)
            ->see('Edit Article')
            ->type($articleCategoryObj->id, 'article_category_id')
            ->type($articleObj->title.='-'.rand(1,100), 'title')
            ->type(str_slug($articleObj->title, '_'), 'slug')
            ->type('Content...', 'contents')
            ->attach($test_file, 'image_path')
			->type(1, 'updated_user_id')
			->press('Update')
			->visit('/article/lists')
			->seePageIs('/article/lists')
			->see('Article List');
	}

	/**
     * Test Soft Delete a Article.
     *
     * @return void
     */
    public function testArticleDelete()
    {
		$user = new User(array('name' => 'administrator'));
		$this->be($user);

		$articleObj = Article::orderBy('created_at', 'desc')->first();

		$response = $this->call('POST', '/article/delete', ['id' => $articleObj->id]);
	}

	/**
     * Test Article Listings page.
     *
     * @return void
     */
    public function testArticleAll()
    {
		$user = new User(array('name' => 'administrator'));
		$this->be($user);

		$response = $this->call('GET', '/article/lists');

    	$this->assertEquals(200, $response->status());
	}
}
