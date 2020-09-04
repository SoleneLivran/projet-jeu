# Dictionnaire de données

## Lieux (`place`)

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|place ID|
| name | VARCHAR(64) | NOT NULL | place name |
| description | TEXT | NULL | place describe |
| picture_file | VARCHAR(128) | NOT NULL, DEFAULT | link to picture file about the main place (place_type) |
| sound_file | VARCHAR(128) | NOT NULL, DEFAULT | link to sound file |
| created_at | TIMESTAMP | NOT NULL, DEFAULT CURRENT_TIMESTAMP | Created time for place |
| updated_at | TIMESTAMP | NULL | Updated time for place |
| place_type_id | ENTITY | FOREIGN KEY | data about the type of place |


## Evenements (`event`)

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|event ID|
| name | VARCHAR(64) | NOT NULL | event name |
| description | TEXT | NULL | event describe |
| picture_file | VARCHAR(128) | NOT NULL, DEFAULT | link to picture file |
| sound_file | VARCHAR(128) | NOT NULL, DEFAULT | link to sound file |
| created_at | TIMESTAMP | NOT NULL, DEFAULT CURRENT_TIMESTAMP | Created time for event |
| updated_at | TIMESTAMP | NULL | Updated time for event |
| event_type_id | ENTITY | FOREIGN KEY | data about the type of event |

## Actions (`action`)

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|action ID|
| name | VARCHAR(64) | NOT NULL | action name |
| description | TEXT | NULL | action describe |
| sound_file | VARCHAR(128) | NOT NULL, DEFAULT | link to sound file |
| created_at | TIMESTAMP | NOT NULL, DEFAULT CURRENT_TIMESTAMP | Created time for action |
| updated_at | TIMESTAMP | NULL | Updated time for action |
| action_type_id | ENTITY | FOREIGN KEY | data about the type of action |

## Histoires (`story`)

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|story ID|
| status | TINYINT(1) | NOT NULL, DEFAULT 0 | story status: playable(1), editing(2) |
| rating | TINYINT(1) | NOT NULL, DEFAULT 0 | story rating out of 5 |
| synopsis | TEXT | NULL | story synopsis |
| difficulty | TINYINT(1) | NULL | story difficulty |
| created_at | TIMESTAMP | NOT NULL, DEFAULT CURRENT_TIMESTAMP | Created time for story |
| updated_at | TIMESTAMP | NULL | Updated time for story |
| author_id | ENTITY | FOREIGN KEY, NOT NULL | data about author (user)|
| category_id | ENTITY | FOREIGN KEY, NULL | data about category |

## Utilisateurs (`user`)

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|user ID|
| name | VARCHAR(64) | NOT NULL | user name |
| mail | VARCHAR(255) | NOT NULL | user mail|
| password | VARCHAR(255) | NOT NULL | user password |
| role | TINYINT(1) | NOT NULL, DEFAULT | user role (user or admin) |
| created_at | TIMESTAMP | NOT NULL, DEFAULT CURRENT_TIMESTAMP | Created time for user |
| updated_at | TIMESTAMP | NULL | Updated time for user |
| avatar_id | ENTITY | FOREIGN KEY | data about author (user)|

## Type de lieux (`place_type`)

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|place_type ID|
| name | VARCHAR(64) | NOT NULL | place_type name |
| picture_file | VARCHAR(128) | NOT NULL, DEFAULT | link to picture file. Main place |
| created_at | TIMESTAMP | NOT NULL, DEFAULT CURRENT_TIMESTAMP | Created time for place_type |
| updated_at | TIMESTAMP | NULL | Updated time for place_type |

## Type d'évenements (`event_type`)

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|event_type ID|
| name | VARCHAR(64) | NOT NULL | event_type name |
| created_at | TIMESTAMP | NOT NULL, DEFAULT CURRENT_TIMESTAMP | Created time for event_type |
| updated_at | TIMESTAMP | NULL | Updated time for event_type |

## Type d'actions (`action_type`)

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|action_type ID|
| name | VARCHAR(64) | NOT NULL | action_type name |
| created_at | TIMESTAMP | NOT NULL, DEFAULT CURRENT_TIMESTAMP | Created time for action_type |
| updated_at | TIMESTAMP | NULL | Updated time for action_type |

## Type d'histoires (`story_category`)

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|story_category ID|
| name | VARCHAR(64) | NOT NULL | story_category name |
| created_at | TIMESTAMP | NOT NULL, DEFAULT CURRENT_TIMESTAMP | Created time for story_category |
| updated_at | TIMESTAMP | NULL | Updated time for story_category |

## Avatars (`avatar`)

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|avatar ID|
| picture_file | VARCHAR(128) | NOT NULL, DEFAULT | avatar name |
| created_at | TIMESTAMP | NOT NULL, DEFAULT CURRENT_TIMESTAMP | Created time for avatar |
| updated_at | TIMESTAMP | NULL | Updated time for avatar |

## Transitions (`transition`)

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|avatar ID|
| created_at | TIMESTAMP | NOT NULL, DEFAULT CURRENT_TIMESTAMP | Created time for avatar |
| updated_at | TIMESTAMP | NULL | Updated time for avatar |
| current_scene_id | ENTITY | FOREIGN KEY | data about current scene |
| action_id | ENTITY | FOREIGN KEY | data about choosen action |
| next_scene_id | ENTITY | FOREIGN KEY | data about next scene |

## Scenes (`scene`)

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|avatar ID|
| created_at | TIMESTAMP | NOT NULL, DEFAULT CURRENT_TIMESTAMP | Created time for avatar |
| updated_at | TIMESTAMP | NULL | Updated time for avatar |
| place_id | ENTITY | FOREIGN KEY | data about place |
| event_id | ENTITY | FOREIGN KEY | data about event |
