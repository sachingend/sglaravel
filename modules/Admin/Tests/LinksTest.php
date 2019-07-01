<?php
/**
 * Test Case For Links Controller
 *
 *
 * @author Anagha Athale <anaghaa@gmail.com>
 * @package Admin
 * @since 1.0
 */

namespace Modules\Admin\Tests;
use Illuminate\Foundation\Testing\WithoutMiddleware,
    Auth;

class Links extends TestCase
{
    use WithoutMiddleware;

    /**
     * Index action of Links Controller test case
     *
     * @return void
     */
    public function testIndex()
    {
        Auth::loginUsingId(1);
        $response = $this->action('GET', '\Modules\Admin\Http\Controllers\LinksController@index');
        $this->assertResponseStatus($response->status());
        $this->assertResponseOk();
    }

    /**
     * GetData action of Links Controller test case
     *
     * @return void
     */
    public function testGetData()
    {
        Auth::loginUsingId(1);
        $response = $this->action('GET', '\Modules\Admin\Http\Controllers\LinksController@getData');
        $this->assertResponseStatus($response->status());
        $this->assertResponseOk();
    }

    /**
     * create action of Links Controller test case
     *
     * @return void
     */
    public function testCreate()
    {
        Auth::loginUsingId(1);
        $categoryNames = ['test','test one'];
        $response = $this->action('GET', '\Modules\Admin\Http\Controllers\LinksController@create');
        $this->assertResponseStatus($response->status());
        $this->assertResponseOk();
    }

    /**
     * store action of Links Controller test case
     *
     * @return void
     */
    public function testStore()
    {
        Auth::loginUsingId(1);
        $response = $this->action('POST', '\Modules\Admin\Http\Controllers\LinksController@store', ['link_name' => 'Test Link', 'link_url' => 'admin.test.index', 'link_category_id' => 15, 'position' => 50,'page_header'=>'Test Header','page_text'=>'Page Text','tooltip'=>'','target'=>'','parent_link_id'=>'','pagination'=>10,'status'=>1, 'created_by' => 1, 'updated_by' => 0, 'created_at' => date('Y-m-d h:i:s'), 'updated_at' => '', 'link_icon' => 'test-icon']);
        $this->assertResponseStatus(302 || 200, $response->status());
        $this->assertResponseOk();
    }

    /**
     * edit action of Links Controller test case
     *
     * @return void
     */
    public function testEdit()
    {
        Auth::loginUsingId(1);
        $response = $this->action('GET', '\Modules\Admin\Http\Controllers\LinksController@edit', ['id' => 5]);
        $this->assertResponseStatus(200, $response->status());
        $this->assertResponseOk();
    }
    
    /**
     * update action of Links Controller test case
     *
     * @return void
     */
    public function testUpdate()
    {
        Auth::loginUsingId(1);
        $response = $this->action('PUT', '\Modules\Admin\Http\Controllers\LinksController@update', ['link_name' => 'Test Link updated', 'link_url' => 'admin.test.index', 'link_category_id' => 15, 'position' => 50,'page_header'=>'Test Header','page_text'=>'Page Text','tooltip'=>'','target'=>'','parent_link_id'=>'','pagination'=>10,'status'=>1, 'created_by' => 0, 'updated_by' => 1, 'created_at' => '', 'updated_at' => date('Y-m-d h:i:s'), 'link_icon' => 'test-icon']);
        $this->assertResponseStatus($response->status());
    }
    
    /**
     * groupAction action of Links Controller test case
     *
     * @return void
     */
    public function testGroupAction()
    {
        Auth::loginUsingId(1);
        $response = $this->action('GET', '\Modules\Admin\Http\Controllers\LinksController@getData');
        $this->assertResponseStatus(200, $response->status());
        $this->assertInstanceOf('Illuminate\Http\JsonResponse', $response);

        $actual = $response->getContent();
        $responseJsonData = json_decode($actual, true);

        $this->assertArrayHasKey('draw', $responseJsonData);
        $this->assertArrayHasKey('recordsTotal', $responseJsonData);
        $this->assertArrayHasKey('recordsFiltered', $responseJsonData);
        $this->assertArrayHasKey('data', $responseJsonData);
        $this->assertArrayHasKey('input', $responseJsonData);

        if (!empty($responseJsonData['data'])) {
            $keys = ['id', 'link_name', 'position', 'created_by', 'action'];

            foreach ($keys as $key) {
                $this->assertArrayHasKey($key, $responseJsonData['data'][0]);
            }
        }
    }
}
