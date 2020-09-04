# Dictionnaire de données

## Lieux (`place`)

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|place ID|
| name | VARCHAR(64) | NOT NULL | place name |
| description | TEXT | NULL | place describe |
| picture_file | VARCHAR(128) | NOT NULL, DEFAULT | link to picture file |
| sound_file | VARCHAR(128) | NOT NULL, DEFAULT | link to sound file |
| created_at | TIMESTAMP | NOT NULL, DEFAULT CURRENT_TIMESTAMP | Created time for place |
| updated_at | TIMESTAMP | NULL | Updated time for place |

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

## Actions (`action`)

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|action ID|
| name | VARCHAR(64) | NOT NULL | action name |
| description | TEXT | NULL | action describe |
| sound_file | VARCHAR(128) | NOT NULL, DEFAULT | link to sound file |
| created_at | TIMESTAMP | NOT NULL, DEFAULT CURRENT_TIMESTAMP | Created time for action |
| updated_at | TIMESTAMP | NULL | Updated time for action |