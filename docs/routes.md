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
|||||||||
|`/api/places`|`GET`|`ApiPlaceController`|``|||Get all places||
|`/api/places/{id}`|`GET`|`ApiPlaceController`|``|||Get one place by its ID||
|`/api/place_types`|`GET`|`ApiPlaceController`|``|||Get all place types||
|`/api/place_types/{id}`|`GET`|`ApiPlaceController`|``|||Get one place type by its ID||
|`/api/events`|`GET`|`ApiEventController`|``|||Get all events||
|`/api/events/{id}`|`GET`|`ApiEventController`|``|||Get one event by its ID||
|`/api/event_types`|`GET`|`ApiEventController`|``|||Get all event types||
|`/api/event_types/{id}`|`GET`|`ApiEventController`|``|||Get one event type by its ID||
|`/api/actions`|`GET`|`ApiActionController`|``|||Get all the action||
|`/api/actions/{id}`|`GET`|`ApiActionController`|``|||Get one action by its ID||
|`/api/action_types`|`GET`|`ApiActionController`|``|||Get all the action_types||
|`/api/action_types/{id}`|`GET`|`ApiActionController`|``|||Get one action_type by its ID||
|`/api/users`|`GET`|`ApiUserController`|``|||Get all the user||
|`/api/user/{id}`|`GET`|`ApiUserController`|``|||Get one user by its ID||
|`/api/user/{id}`|`POST`|`ApiUserController`|``|||Create a user||
|`/api/user/{id}`|`PUT`|`ApiUserController`|``|||Edit a user||
|`/api/avatars`|`GET`|`ApiAvatarController`|``|||Get all the avatars||
|`/api/avatars/{id}`|`GET`|`ApiAvatarController`|``|||Get one avatar by its ID||
|`/api/stories`|`GET`|`ApiStoryController`|``|||Get all the story||
|`/api/stories/last_five`|`GET`|`ApiStoryController`|``|||Get the 5 latest story||
|`/api/stories/top_five`|`GET`|`ApiStoryController`|``|||Get the 5 top story||
|`/api/story/{id}`|`GET`|`ApiStoryController`|``|||Get a story (making available its first scene and the possibile actions & transitions for this scene)||
|`/api/story/{id}`|`POST`|`ApiStoryController`|``|||Create a story ||
|`/api/story/{id}`|`PUT`|`ApiStoryController`|``|||Edit a Story||
|`/api/transition/{id}/next_scene`|`GET`|`ApiTransitionController`|``|||From a transition specified by its ID, get the next scene (with its relative actions and transitions)||
|`/api/story_categories`|`GET`|`ApiStoryCategoryController`|``|||Get all story categories||
|`/api/story_categories`|`GET`|`ApiStoryCategoryController`|``|||Get all story categories||
|`/api/story_categories/{id}`|`GET`|`ApiStoryCategoryController`|``|||Get one story category by its ID||
|`/api/story/{id}/scene`|`POST`|`ApiSceneController`|``|||Create a scene (with a place and event)||
|`/api/story/{id}/scene/{id}`|`PUT`|`ApiSceneController`|``|||Edit a scene (with a place and event)||
|`/api/story/{id}/transition`|`POST`|`ApiTransitionController`|``|||Create a transition (with a scene and action)||
|`/api/story/{id}/transition/{id}`|`PUT`|`ApiTransitionController`|``|||Edit a transition specified by its ID (with a scene and action)||