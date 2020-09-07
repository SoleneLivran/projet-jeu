| URL | HTTP Method | Controller | Method | Title | Content | Comment | API datas
|--|--|--|--|--|--|--|--|
|`/`|`GET`|`MainController`|``|`home`|`Homepage`|Homepage receiving latest games and best rated stories|`SELECT * FROM story ORDER BY rating LIMIT 5 WHERE status '1'  + SELECT * FROM story ORDER BY updated_at LIMIT 5 WHERE status '1'`|
|`/contact`|`GET`|`MainController`|``|`Contact`|`Contact Page`|Page where you can contact the website's administrators||
|`/about`|`GET`|`MainController`|``|`About`|`About Page`|Page on which you can see info on the developpers that worked on the website, with links to our linkedIn||
|`/profil`|`GET`|`UserController`|``|`Profil`|`Profile Page`|Page on which you can see all the information regarding your profile and account (name, password, email, avatar, my created games...). You can also launch one of your created story from the page, either to edit it or play it|`SELECT * FROM user + SELECT * FROM story WHERE author_id = user_id`|
|`/login`|`GET`|`SecureController`|``|`Login`|`Login Page`|Page on which you can log into your account |``|
|`/play`|`GET`|`GameController`|``|`Game List`|`List of games/stories`|Page on which you have all the games listed, with different filters available for an easier search|`SELECT * FROM story WHERE status '1' + filtres possible (ex: ORDER BY created_at, ORDER BY rating, ORDER BY category_id, ORDER BY difficulty)`|
|`/play/id`|`GET`|`GameController`|``|`Game Detail`|`All the details of a story`|Page on which on you can consult all the details regading a story and start playing that story|`SELECT FROM story WHERE id = GET['id']`|
|`/create`|`GET`|`CreateController`|``|`Game's Editor`|`Editor's page`|Route on which the API will send all the necessary data for the Editor|``|
|`/create`|`POST`|`CreateController`|``|`Game's Editor`|`Editor's page`|Page on which you can edit or make a new story of yours using our workbench|``|
|`/`|`GET`|`MainController`|``|``|``||``|
|`/`|`GET`|`MainController`|``|``|``||``|
|`/`|`GET`|`MainController`|``|``|``||``|
|`/`|`GET`|`MainController`|``|``|``||``|
|`/`|`GET`|`MainController`|``|``|``||``|
|`/`|`GET`|`MainController`|``|``|``||``|
|`/`|`GET`|`MainController`|``|``|``||``|