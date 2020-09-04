# Dictionnaire de données

## Lieux (`place`)

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|Place ID|
| name | VARCHAR(64) | NOT NULL | Place name |
| description | TEXT | NULL | Place describe |
| picture_file | VARCHAR(128) | NOT NULL, DEFAULT | Link to picture file |
| sound_file | VARCHAR(128) | NOT NULL, DEFAULT | Link to sound file |
| created_at | TIMESTAMP | NOT NULL, DEFAULT CURRENT_TIMESTAMP | Created time for place |
| updated_at | TIMESTAMP | NULL | Updated time for place |

## Evenements (`event`)

|Champ|Type|Spécificités|Description|
|-|-|-|-|
|id|INT|PRIMARY KEY, NOT NULL, UNSIGNED, AUTO_INCREMENT|Place ID|
| name | VARCHAR(64) | NOT NULL | Place name |
| description | TEXT | NULL | Place describe |
| picture_file | VARCHAR(128) | NOT NULL, DEFAULT | Link to picture file |
| sound_file | VARCHAR(128) | NOT NULL, DEFAULT | Link to sound file |
| created_at | TIMESTAMP | NOT NULL, DEFAULT CURRENT_TIMESTAMP | Created time for place |
| updated_at | TIMESTAMP | NULL | Updated time for place |

