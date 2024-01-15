1. Copy config_example.php and rename to config.php with your database details.
2. Setup your plugin in your database (se code below)
3. Wait for 1Relation to approve your plugin.


Publictoken is given by 1Relation once your plugin has been approved.
Blueprint is the JSON code you want 1Relation to install (can be empty).
```
INSERT INTO `plugins` (`id`, `name`, `publictoken`, `blueprint`) VALUES (NULL, 'My Awesome Widget', 'PUBLICTOKEN', '{\"sitewidgets\":{\"sitwid_calendar\":{\"siteplugin_id\":\"[sitepluginid]\",\"name\":\"Calendar\",\"keyname\":\"sitwid_calendar\",\"url\":\"https://plugins.1relation.com/Widgets/calendar/calendar.php\"}}}')
```