<?php

Route::get('/','Admin\DashboardController@index')->middleware('login');
Route::post('/statistical','Admin\DashboardController@statistical')->middleware('login');

Route::get('/video','Admin\VideoController@index')->middleware('login');

Route::get('/login','Admin\AuthController@login');
Route::post('/login','Admin\AuthController@postLogin');
Route::get('/logout','Admin\AuthController@Logout')->middleware('login');

//======================= route channel ============================================

Route::get('/channel','Admin\ChannelController@index')->middleware('login');
Route::post('/channel','Admin\ChannelController@AddChannel')->middleware('login');

Route::post('/sortVideoChannel','Admin\ChannelController@Sort_Video_Channel')->middleware('login');
Route::post('/sortSubscribeChannel','Admin\ChannelController@Sort_Subscribe_Channel')->middleware('login');
Route::post('/sortViewChannel','Admin\ChannelController@Sort_View_Channel')->middleware('login');
Route::post('/sortLikeChannel','Admin\ChannelController@Sort_Like_Channel')->middleware('login');
Route::post('/sortDislikeChannel','Admin\ChannelController@Sort_Dislike_Channel')->middleware('login');
Route::post('/sortCommentChannel','Admin\ChannelController@Sort_Comment_Channel')->middleware('login');


Route::post('/filterChannel','Admin\ChannelController@Filter_Channel')->middleware('login');
Route::post('/refresh','Admin\ChannelController@Refresh')->middleware('login');
Route::post('/search','Admin\ChannelController@Search')->middleware('login');

//======================= end route channel =================================

//======================== route video ======================================
//Route::get('/test','Admin\ChannelController@Cron_Job_Channel');
Route::get('/sortViewVideo','Admin\VideoController@sortViewVideo')->middleware('login');
Route::get('/sortLikeVideo','Admin\VideoController@sortLikeVideo')->middleware('login');
Route::get('/sortDislikeVideo','Admin\VideoController@sortDislikeVideo')->middleware('login');
Route::get('/sortCommentVideo','Admin\VideoController@sortCommentVideo')->middleware('login');
Route::get('/filterVideo','Admin\VideoController@filterVideo')->middleware('login');

//======================= END route video ====================================