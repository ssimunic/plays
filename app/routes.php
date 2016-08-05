<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
//
Route::get('ipn', array('uses' => 'IpnController@store', 'as' => 'ipn'));

View::composer('*', function($view)
{
    $navbarclass = 'inverse';
    if(Auth::user()) {
        $data = json_decode(Auth::user()->data);
        $theme = /*$data->theme*/'theme1';
    } else {
        $theme = 'theme1';
    }
    
    if ($theme == 'theme1') {
        $navbarclass = 'default';
    } elseif ($theme == 'bootstrap') {
        $navbarclass = 'inverse';
    }

    $view->with(array(
        'theme' => $theme,
        'navbarclass' => $navbarclass,
    ));
});

// Global XSS Clear
Lop::globalXssClean();

Validator::extend('youtubevideo', 'CustomValidation@youtubevideo');
// MODEL bindings
//Route::model('profile', 'User');

Route::get('/', array(
    'as' => 'index',
    'uses' => 'HomeController@showIndex',
));

// AI for new plays
Route::get('/update/{user}', array(
    'uses' => 'HomeController@AI',
));
// START PLAY LINKS
Route::get('/play/{id}/{name?}', array(
    'as' => 'play',
    'uses' => 'PlayController@showPlay',
));

Route::get('/playreport/{id}', array(
    'uses' => 'PlayController@reportPlay',
));
Route::get('/p/{id}/{name?}', array(
    'as' => 'play',
    'uses' => 'PlayController@showPlay',
));

Route::get('{id}/{name?}', array(
    'as' => 'play',
    'uses' => 'PlayController@showPlay',
))->where(array('id' => '[0-9]+'));

// END PLAY LINKS //

Route::any('/plays', array(
    'as' => 'plays',
    'uses' => 'PlayController@plays',
));
/*
Route::post('/plays', array(
    'before' => 'csrf',
    'as' => 'plays',
    function()
    {
        return Input::all();
    }
));
*/

////////////////////
// Ajax get comments
Route::post('ajax/comments', array(
    'uses' => 'PlayController@refreshComments',
));
// Ajax check comments
Route::post('ajax/comments/check', array(
    'uses' => 'PlayController@checkComments',
));
// Ajax like comment
Route::post('ajax/comment/like', array(
    'uses' => 'PlayController@likeComment',
));
////////////////////

Route::get('registration', array(
    'as' => 'reg',
    'before' => 'guest',
    'uses' => 'HomeController@showRegistration',
));

Route::get('login', array(
    'as' => 'log',
    'before' => 'guest',
    'uses' => 'HomeController@showLogin',
));

Route::get('logout', array(
    'as' => 'logout',
    'uses' => 'UserController@Logout',
));

Route::get('contests', array(
    'as' => 'contests',
    'uses' => 'ContestController@showIndex',
));

Route::get('hof', array(
    'as' => 'hof',
    'uses' => 'HofController@showIndex',
));

Route::get('news/{id?}/{title?}', array(
    'as' => 'news',
    'uses' => 'NewsController@showIndex',
));

Route::get('faq', array(
    'as' => 'faq',
    'uses' => 'HomeController@showFAQ',
));

Route::get('tos', array(
    'as' => 'tos',
    'uses' => 'HomeController@showToS',
));

Route::get('contact', array(
    'as' => 'contact',
    'uses' => 'HomeController@showContact',
));

Route::post('contact', array(
    'uses' => 'HomeController@handleContact',
));

Route::get('about', array(
    'as' => 'faq',
    'uses' => 'HomeController@showAbout',
));

// Users only
Route::group(array('before' => 'auth'), function()
{
    // Premium
    Route::get('premium', array(
        'as' => 'premium',
        'uses' => 'HomeController@showPremium',
    ));
    
    Route::get('payment/success', array(
        'uses' => 'HomeController@paymentSuccess',
    ));
    
    Route::get('payment/cancel', array(
        'uses' => 'HomeController@paymentCancel',
    ));
    
    // Mobile Play
    Route::get('m/{id}', array(
        'before' => 'premium',
        'as' => 'mobileplay',
        'uses' => 'PlayController@mobilePlay',
    ));
    
    // Profile
    Route::get('profile/{profile?}', array(
        'as' => 'profile',
        'uses' => 'UserController@Profile',
    ));
    
    // Account
    Route::get('account', array(
        'as' => 'account',
        'uses' => 'UserController@Account',
    ));
    
    // My Plays
    Route::get('my', array(
        'as' => 'my',
        'uses' => 'HomeController@showMyPlays',
    ));
    
    // My Manager
    Route::get('my/manager/{id?}', array(
        'as' => 'manager',
        'uses' => 'HomeController@showManager',
    ));
    
    // My Stats
    Route::get('my/stats', array(
        'as' => 'mystats',
        'uses' => 'HomeController@showStats',
    ));
    
    // Submit
    Route::get('submit', array(
        'as' => 'submit',
        'uses' => 'HomeController@showSubmit',
    ));
    
    Route::post('submit', array(
        'before' => 'csrf',
        'uses' => 'PlayController@handleSubmit',
    ));
    
    // Manage
    Route::post('manage', array(
        'before' => 'csrf',
        'uses' => 'PlayController@manage',
    ));
    
    // Comment
    Route::post('comment', array(
        'before' => 'csrf',
        'uses' => 'CommentController@comment',
    ));
    
    // Delete comment
    Route::get('comment/delete/{playid}/{id}', array(
        'uses' => 'CommentController@deleteComment',
    ));
    
    // Edit comment
    Route::post('comment/edit', array(
        'uses' => 'CommentController@editComment',
    ));
    
    // Ajax Vote
    Route::post('ajax/vote', array(
        'uses' => 'PlayController@ajaxVote',
    ));
       
    // Message Read
    Route::get('messages/read/{id}', array(
        'uses' => 'MessageController@showRead',
    ));
    // Message Send
    Route::get('messages/new/{id?}/{mtitle?}', array(
        'uses' => 'MessageController@showSend',
    ));
    Route::post('messages/new', array(
        'before' => 'csrf',
        'uses' => 'MessageController@send',
    ));
    // Message Delete
    Route::get('messages/delete/{id}', array(
        'uses' => 'MessageController@delete',
    ));
    // Message Mark as read
    Route::get('messages/markasread/{id}', array(
        'uses' => 'MessageController@markasread',
    ));
    // Message Empty all
    Route::get('messages/emptyall', array(
        'uses' => 'MessageController@emptyall',
    ));
    
    // Messages
    Route::get('messages', array(
        'uses' => 'MessageController@showIndex',
    ));
    
    // Change avatar
     Route::post('profile/avatar', array(
        'before' => 'csrf',
        'uses' => 'UserController@changeAvatar',
    ));
    // Change display name
    Route::post('account/displayname', array(
        'before' => 'csrf',
        'uses' => 'UserController@changeDisplayName',
    ));
    
    // Vote history settings
    Route::post('account/votehistory', array(
        'before' => 'csrf',
        'uses' => 'UserController@votehistory',
    ));
    
    // Ignore
    Route::post('account/ignore', array(
        'before' => 'csrf',
        'uses' => 'UserController@ignore',
    ));
    
    // Remove ignore
    Route::get('account/ignore/remove/{username}', array(
        'uses' => 'UserController@removeignore',
    ));
    
    // Change password
    Route::post('account/changepassword', array(
        'before' => 'csrf',
        'uses' => 'UserController@changepassword',
    ));
    
    // Verify summoner
    Route::post('account/verifysummoner', array(
        'before' => 'csrf',
        'uses' => 'UserController@verifysummoner',
    ));
    
    // Remove summoner
    Route::get('account/removesummoner/{sname}', array(
        'uses' => 'UserController@removesummoner',
    ));
    
    // Change theme
    Route::get('account/changetheme/{name}', array(
        'uses' => 'UserController@changetheme',
    ));
});

// POST routes + CSRF protection
Route::group(array('before' => 'csrf'), function ()
{
    Route::post('registration', 'UserController@handleRegistration');
    Route::post('login', 'UserController@handleLogin');
});


// API
Route::group(array(),function()
{
    Route::get('api', array(
        'as' => 'api',
        'uses' => 'ApiController@showIndex',
    ));
    
    // latest plays
    Route::get('api/{key}/plays/latest', array(
        'uses' => 'ApiController@playslatest',
    ));
    
    // play
    Route::get('api/{key}/play/{id}', array(
        'uses' => 'ApiController@play',
    ));
    
    // user
    Route::get('api/{key}/user/{id}', array(
        'uses' => 'ApiController@user',
    ));
    
    Route::post('api/authorize', array(
        'uses' => 'ApiController@authorize',
    ));
});


// Admin only
Route::group(array('before' => 'admin'), function()
{
    Route::get('admin', array(
        'uses' => 'AdminController@showIndex',
    ));
    
    Route::get('admin/plays', array(
        'as' => 'admin_plays',
        'uses' => 'AdminController@showPlays',
    ));
     Route::get('admin/plays/restore/{id}', array(
        'uses' => 'AdminController@restorePlays',
    ));
      Route::get('admin/plays/delete/{id}', array(
        'uses' => 'AdminController@deletePlays',
    ));
    Route::get('admin/plays/validate/{id}', array(
        'uses' => 'AdminController@validatePlays',
    ));
    Route::get('admin/plays/feature/{id}', array(
        'uses' => 'AdminController@featurePlays',
    ));
    
    Route::get('admin/users', array(
        'as' => 'admin_users',
        'uses' => 'AdminController@showUsers',
    ));
    Route::get('admin/users/ban/{id}', array(
        'uses' => 'AdminController@banUsers',
    ));
    Route::get('admin/users/gift/{id}', array(
        'uses' => 'AdminController@giftUsers',
    ));
    Route::get('admin/users/unban/{id}', array(
        'uses' => 'AdminController@unbanUsers',
    ));
    Route::get('admin/users/edit/{id}', array(
        'uses' => 'admin_users_edit',
        'uses' => 'AdminController@editUsers',
    ));
    Route::post('admin/users/save', array(
        'uses' => 'AdminController@saveUsers',
    ));
    
    Route::get('admin/news', array(
        'as' => 'admin_news',
        'uses' => 'AdminController@showNews',
    ));
    Route::post('admin/news/new', array(
        'uses' => 'AdminController@newNews',
    ));
    Route::get('admin/news/show/{id}', array(
        'uses' => 'AdminController@showSingleNews',
    ));
    Route::get('admin/news/hide/{id}', array(
        'uses' => 'AdminController@hideSingleNews',
    ));
    Route::get('admin/news/delete/{id}', array(
        'uses' => 'AdminController@deleteSingleNews',
    ));
    Route::get('admin/news/edit/{id}', array(
        'as' => 'admin_news_edit',
        'uses' => 'AdminController@editSingleNews',
    ));
    Route::post('admin/news/save', array(
        'uses' => 'AdminController@saveSingleNews',
    ));
    
    Route::get('admin/payments', array(
        'uses' => 'AdminController@showPayments',
    ));
});

// Cron jobs

Route::get('cron/premium', array(
    'as' => 'cron_premium',
    'uses' => 'CronController@premium',
));
