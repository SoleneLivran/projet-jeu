# Routes Front

| URL | HTTP Method | Controller | Method | Title | Content | Comment | API datas
|--|--|--|--|--|--|--|--|
|`/`|`GET`|`MainController`|``|`home`|`Homepage`|Homepage receiving latest games and best rated stories|`SELECT * FROM story ORDER BY rating LIMIT 5 WHERE status '1'  + SELECT * FROM story ORDER BY updated_at LIMIT 5 WHERE status '1'`|
|`/contact`|`GET`|`MainController`|``|`Contact`|`Contact Page`|Page where you can contact the website's administrators||
|`/about`|`GET`|`MainController`|``|`About`|`About Page`|Page on which you can see info on the developpers that worked on the website, with links to our linkedIn||
|`/profil`|`GET`|`UserController`|``|`Profil`|`Profile Page`|Page on which you can see all the information regarding your profile and account (name, password, email, avatar, my created games...). You can also launch one of your created story from the page, either to edit it or play it|`SELECT * FROM user + SELECT * FROM story WHERE author_id = user_id`|
|`/login`|`GET`|`SecureController`|``|`Login`|`Login Page`|Page on which you can log into your account ||
|`/play`|`GET`|`GameController`|``|`Game List`|`List of games/stories`|Page on which you have all the games listed, with different filters available for an easier search|`SELECT * FROM story WHERE status '1' + filtres possible (ex: ORDER BY created_at, ORDER BY rating, ORDER BY category_id, ORDER BY difficulty)`|
|`/play/id`|`GET`|`GameController`|``|`Game Detail`|`All the details of a story`|Page on which on you can consult all the details regading a story and start playing that story|`SELECT FROM story WHERE id = GET['id']`|
|`/create`|`GET`|`CreateController`|``|`Game's Editor`|`Editor's page`|Route on which the API will send all the necessary data for the Editor||
|`/create`|`POST`|`CreateController`|``|`Game's Editor`|`Editor's page`|Page on which you can edit or make a new story of yours using our workbench||

# Routes API

| URL | HTTP Method | Controller | Method | Title | Content | Comment | API datas
|--|--|--|--|--|--|--|--|
|`/api/places`|`GET`|`PlaceController`|`list`|||Get all places. Use query params for filters.||
|`/api/places/{id}`|`GET`|`PlaceController`|`view`|||Get one place by its ID||
|`/api/place_types`|`GET`|`PlaceTypeController`|`list`|||Get all place types||
|`/api/events`|`GET`|`EventController`|`list`|||Get all events||
|`/api/events/{id}`|`GET`|`EventController`|`view`|||Get one event by its ID||
|`/api/event_types`|`GET`|`EventTypeController`|`list`|||Get all event types||
|`/api/actions`|`GET`|`ActionController`|`list`|||Get all actions||
|`/api/actions/{id}`|`GET`|`ActionController`|`view`|||Get one action by its ID||
|`/api/action_types`|`GET`|`ActionTypeController`|`list`|||Get all the action_types||
|`/api/app_users`|`GET`|`AppUserController`|`list`|||Get all users||
|`/api/app_users/{id}`|`GET`|`AppUserController`|`view`|||Get one user by its ID||
|`/api/app_users/{id}/stories`|`GET`|`AppUserController`|`viewStories`|||Get one user by its ID||
|`/api/account/{id}`|`PUT`|`AppUserController`|`updateAccount`|||Edit a user||
|`/api/account/{id}`|`DELETE`|`UserAccountController`|`deleteAccount`|||Delete the user's account||
|`/api/register`|`POST`|`SecurityController`|`createAccount`|||Create a user||
|`/api/login`|`POST`|`SecurityController`|``|||Login validation||
|`/api/avatars`|`GET`|`AvatarController`|`list`|||Get all avatars||
|`/api/avatars/{id}`|`GET`|`AvatarController`|`view`|||Get one avatar by its ID||
|`/api/public/stories`|`GET`|`StoryController`|`list`|||Get all stories||
|`/api/public/stories/latest_five`|`GET`|`StoryController`|`listLatestFive`|||Get the 5 latest published stories||
|`/api/public/stories/top_five`|`GET`|`StoryController`|`listTopFive`|||Get the 5 best rated stories||
|`/api/public/stories/{id}`|`GET`|`StoryController`|`view`|||Get one story by its ID||
|`/api/transitions/{id}/next_scene`|`GET`|`SceneController`|`getNextScene`|||Get next scene from a transition||
|`/api/stories`|`POST`|`StoryController`|`create`|||Create a story ||
|`/api/stories/{id}`|`PUT`|`StoryController`|`update`|||Edit a Story||
|`/api/stories/{id}`|`DELETE`|`StoryController`|`delete`|||Delete a Story||
|`/api/stories/{id}/publish`|`PATCH`|`StoryController`|`publish`|||Publish a Story (status from draft to published)||
|`/api/stories/{id}/editable`|`GET`|`StoryController`|`editableStory`|||Get editable version of a Story||
|`/api/stories/{id}/rating`|`POST`|`StoryController`|`storyRating`|||Post a rating for a Story||
|`/api/public/story_categories`|`GET`|`StoryCategoryController`|`list`|||Get all story categories||
