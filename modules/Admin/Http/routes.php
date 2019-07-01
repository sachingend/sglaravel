<?php

Route::group(['prefix' => 'admin', 'namespace' => 'Modules\Admin\Http\Controllers', 'before' => 'auth'], function() {
    Route::get('/', ['uses' => 'DashboardController@index', 'permission' => 'index']);
    Route::get('/dashboard', ['uses' => 'DashboardController@index', 'permission' => 'index']);

// user management
    Route::get('user/data', ['as' => 'admin.user.apilist', 'uses' => 'UserController@getData', 'permission' => 'index']);
    Route::get('user/trashed', ['as' => 'admin.user.trashedlisting.index', 'uses' => 'UserController@trashed', 'permission' => 'index']);
    Route::get('user/trashed-data', ['as' => 'admin.user.apitrashedlist.index', 'uses' => 'UserController@getTrashedData', 'permission' => 'index']);
    Route::get('user/links', ['as' => 'admin.user.apiuserlinks.index', 'uses' => 'UserController@getUserLinks', 'permission' => 'index']);
    Route::post('user/group-action', ['as' => 'admin.user.groupaction', 'uses' => 'UserController@groupAction', 'permission' => 'update']);
    Route::post('user/check-avalability', ['as' => 'admin.user.checkfieldavalability.update', 'uses' => 'UserController@checkAvalability', 'permission' => 'update']);
    Route::resource('user', 'UserController');

// link category
    Route::get('link-category/data', ['as' => 'admin.link-category.apilist', 'uses' => 'LinkCategoryController@getData', 'permission' => 'index']);
    Route::post('link-category/group-action', ['as' => 'admin.link-category.groupaction', 'uses' => 'LinkCategoryController@groupAction', 'permission' => 'update']);
    Route::resource('link-category', 'LinkCategoryController');

// Permission Link Management
    Route::get('links/linkData/{lid}', ['as' => 'admin.links.linkList', 'uses' => 'LinksController@getLinksData', 'permission' => 'index']);
    Route::get('links/data', ['as' => 'admin.links.apilist', 'uses' => 'LinksController@getData', 'permission' => 'index']);
    Route::post('links/group-action', ['as' => 'admin.links.groupaction', 'uses' => 'LinksController@groupAction', 'permission' => 'update']);
    Route::resource('links', 'LinksController');

// Login Process
    Route::post('auth/authenticate', ['as' => 'admin.auth.authenticate', 'uses' => 'Auth\AuthController@authUsername', 'permission' => 'index']);

//manage ipadresses
    Route::get('ipaddress/data', ['as' => 'admin.ipaddress.apilist', 'uses' => 'IpAddressController@getData', 'permission' => 'index']);
    Route::post('ipaddress/group-action', ['as' => 'admin.ipaddress.groupaction', 'uses' => 'IpAddressController@groupAction', 'permission' => 'update']);
    Route::resource('ipaddress', 'IpAddressController');

// Configuration setting management
    Route::get('config-settings/data', ['as' => 'admin.config-settings.list', 'uses' => 'ConfigSettingController@getData', 'permission' => 'index']);
    Route::resource('config-settings', 'ConfigSettingController');

// Configuration Categories Management
    Route::get('config-categories/data', ['as' => 'admin.config-categories.list', 'uses' => 'ConfigCategoryController@getData', 'permission' => 'index']);
    Route::resource('config-categories', 'ConfigCategoryController');

// User Types Management
    Route::get('user-type/data', ['as' => 'admin.user-type.list', 'uses' => 'UserTypeController@getData', 'permission' => 'index']);
    Route::resource('user-type', 'UserTypeController');

// System emails
    Route::resource('system-emails', 'SystemEmailController');

// Pages Management
    Route::get('manage-pages/data', ['as' => 'admin.manage-pages.apilist', 'uses' => 'ManagePagesController@getData', 'permission' => 'index']);
    Route::post('manage-pages/group-action', ['as' => 'admin.manage-pages.groupaction', 'uses' => 'ManagePagesController@groupAction', 'permission' => 'update']);
    Route::resource('manage-pages', 'ManagePagesController');

// User Type Links
    Route::resource('usertype-links', 'UserTypeLinksController');

//manage faq category

    Route::get('faq-categories/data', ['as' => 'admin.faq-categories.list', 'uses' => 'FaqCategoryController@getData', 'permission' => 'index']);
    Route::resource('faq-categories', 'FaqCategoryController');

//manage faq
    Route::get('faqs/data', ['as' => 'admin.faqs.list', 'uses' => 'FaqController@getData', 'permission' => 'index']);
    Route::post('faqs/group-action', ['as' => 'admin.faqs.groupaction', 'uses' => 'FaqController@groupAction', 'permission' => 'update']);
    Route::resource('faqs', 'FaqController');

//admin myprofile
    Route::put('myprofile/update-avatar', ['as' => 'admin.myprofile.update-avatar', 'uses' => 'MyProfileController@updateAvatar', 'permission' => 'update']);
    Route::put('myprofile/change-password', ['as' => 'admin.myprofile.change-password', 'uses' => 'MyProfileController@changePassword', 'permission' => 'update']);
    Route::resource('myprofile', 'MyProfileController');

//manage country category
    Route::get('countries/data', ['as' => 'admin.countries.list', 'uses' => 'CountryController@getData', 'permission' => 'index']);
    Route::resource('countries', 'CountryController');

//manage State
    Route::get('states/data', ['as' => 'admin.states.list', 'uses' => 'StateController@getData', 'permission' => 'index']);
    Route::resource('states', 'StateController');

//manage cities category
    Route::get('cities/stateData/{cid}', ['as' => 'admin.cities.stateList', 'uses' => 'CityController@getStateData', 'permission' => 'index']);
    Route::get('cities/data', ['as' => 'admin.cities.list', 'uses' => 'CityController@getData', 'permission' => 'index']);
    Route::resource('cities', 'CityController');

//manage locations category
    Route::get('locations/stateData/{cid}', ['as' => 'admin.locations.stateList', 'uses' => 'LocationsController@getStateData', 'permission' => 'index']);
    Route::get('locations/cityData/{cid}', ['as' => 'admin.locations.cityList', 'uses' => 'LocationsController@getCityData', 'permission' => 'index']);
    Route::get('locations/data', ['as' => 'admin.locations.list', 'uses' => 'LocationsController@getData', 'permission' => 'index']);
    Route::resource('locations', 'LocationsController');

//View User Login Logs
    Route::get('login-logs/data', ['as' => 'admin.login-logs.apilist', 'uses' => 'LoginLogsController@getData', 'permission' => 'index']);
    Route::post('login-logs/group-action', ['as' => 'admin.login-logs.groupaction', 'uses' => 'LoginLogsController@groupAction', 'permission' => 'update']);
    Route::resource('login-logs', 'LoginLogsController');

//file management
    Route::get('filemanager/show', ['as' => 'admin.filemanager.show', 'uses' => 'FilemanagerLaravelController@getShow']);
    Route::get('filemanager/connectors', ['as' => 'admin.filemanager', 'uses' => 'FilemanagerLaravelController@getConnectors']);
    Route::post('filemanager/connectors', ['as' => 'admin.filemanager', 'uses' => 'FilemanagerLaravelController@postConnectors']);
    Route::resource('medias', 'MediasController');

// menu groups
    Route::get('menu-group/data', ['as' => 'admin.menu-group.apilist', 'uses' => 'MenuGroupController@getData', 'permission' => 'index']);
    Route::post('menu-group/group-action', ['as' => 'admin.menu-group.groupaction', 'uses' => 'MenuGroupController@groupAction', 'permission' => 'update']);
    Route::resource('menu-group', 'MenuGroupController');

    //manage Blogs
    Route::get('blogs/data', ['as' => 'admin.blogs.index', 'uses' => 'BlogsController@getData', 'permission' => 'index']);
    Route::resource('blogs', 'BlogsController');

//manage blog comments
    Route::get('blog-comments/get-data/{blog_id}', ['as' => 'admin.blog_comments.get_data', 'uses' => 'BlogCommentsController@getData', 'permission' => 'index']);
    Route::get('blog-comments/show/{blog_id}',['as' => 'admin.blog_comments.index', 'uses' => 'BlogCommentsController@show', 'permission' => 'index']);
    Route::get('blog-comments/create/{blog_id}',['as' => 'admin.blog_comments.create', 'uses' => 'BlogCommentsController@create', 'permission' => 'create']);
    Route::post('blog-comments/store',['as' => 'admin.blog_comments.store', 'uses' => 'BlogCommentsController@store', 'permission' => 'update']);
    Route::get('blog-comments/edit/{comment_id}',['as' => 'admin.blog_comments.edit', 'uses' => 'BlogCommentsController@edit', 'permission' => 'edit']);
    Route::put('blog-comments/update/{comment_id}',['as' => 'admin.blog_comments.update', 'uses' => 'BlogCommentsController@update', 'permission' => 'update']);
    Route::delete('blog-comments/delete',['as' => 'admin.blog_comments.delete', 'uses' => 'BlogCommentsController@destroy', 'permission' => 'delete']);

    ################ PLEASE WRITE YOUR ROUTES ABOVE THIS CODE ##################################
    Route::controllers([
        'auth' => 'Auth\AuthController',
        'password' => 'Auth\PasswordController',
    ]);
});
