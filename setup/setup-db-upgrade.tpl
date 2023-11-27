
ALTER TABLE {$db_prefix}_user ADD COLUMN agent TEXT NOT NULL DEFAULT 'empty';;
ALTER TABLE {$db_prefix}_user ADD COLUMN sig TEXT;;

UPDATE {$db_prefix}_dtree SET icon='i20_utl', parent_id=10 WHERE path='fm/index.php' OR path='backup/index.php';;
DELETE FROM {$db_prefix}_dtree WHERE id=12;;
DELETE FROM {$db_prefix}_dtree_role WHERE dtree_id=12;;

DELETE FROM {$db_prefix}_config WHERE param='site_dir';;

# --
UPDATE {$db_prefix}_dtree SET parent_id=1 WHERE parent_id=10;;
DELETE FROM {$db_prefix}_dtree WHERE parent_id=10;;
DELETE FROM {$db_prefix}_dtree_role WHERE dtree_id=10;;
DELETE FROM {$db_prefix}_user_profile WHERE param like 'mdl_%';;
UPDATE {$db_prefix}_config SET value='1' WHERE param='entry_id_default';;

UPDATE {$db_prefix}_dtree SET priority=200 WHERE prefix='cfg';;
UPDATE {$db_prefix}_dtree SET priority=201 WHERE prefix='acc';;
UPDATE {$db_prefix}_dtree SET priority=202 WHERE prefix='lgn';;
UPDATE {$db_prefix}_dtree SET priority=203 WHERE prefix='lgt';;

# --
ALTER TABLE {$db_prefix}_menu ADD COLUMN createnick TEXT NOT NULL DEFAULT 'none';;
ALTER TABLE {$db_prefix}_guestbook ADD COLUMN createnick TEXT NOT NULL DEFAULT 'none';;
ALTER TABLE {$db_prefix}_news ADD COLUMN createnick TEXT NOT NULL DEFAULT 'none';;
ALTER TABLE {$db_prefix}_galery ADD COLUMN createnick TEXT NOT NULL DEFAULT 'none';;
ALTER TABLE {$db_prefix}_calendar ADD COLUMN createnick TEXT NOT NULL DEFAULT 'none';;
# --
ALTER TABLE {$db_prefix}_news ADD COLUMN priority INTEGER NOT NULL DEFAULT 0;;
# --
ALTER TABLE {$db_prefix}_galery ADD COLUMN crop REAL NOT NULL DEFAULT 0;;
ALTER TABLE {$db_prefix}_galery ADD COLUMN priority INTEGER NOT NULL DEFAULT 0;;
# --
INSERT INTO {$db_prefix}_config (dtree_id, param, value, description, tip) VALUES (1, 'usr_def_role', 'Viewer', 'Vorlage f&uuml;r neue User', 'Viewer, Anonymous');;
# --
UPDATE {$db_prefix}_dtree SET path='index.php' WHERE path='core/index.php';;

UPDATE cms_config SET tip='w3-theme-black.css w3-theme-orange.css w3-theme-teal.css' where param='cms_theme';;

# -- newsletter
DELETE FROM cms_dtree WHERE prefix='nwl';;
DELETE FROM cms_dtree WHERE prefix='nws';;
DELETE FROM cms_dtree WHERE prefix='nwe';;
DELETE FROM cms_dtree WHERE prefix='nwj';;
INSERT INTO cms_dtree (id, prefix, parent_id, priority, icon, title, path, active) VALUES
(113,  'nwl', 1,   113, 'i20_mdl',   'Beiträge & News', 'index.php', '1'),
(130,  'nws', 113, 130, 'i20_close', 'Beiträge', 'news/index_news.php', '1'),
(131,  'nwe', 113, 131, 'i20_close', 'E-Mails', 'news/index_email.php', '1'),
(132,  'nwj', 113, 132, 'i20_close', 'Newsletter', 'news/index_job.php', '1');;
DELETE FROM cms_config WHERE param='nwl_email';;
DELETE FROM cms_config WHERE param='nwl_items';;
DELETE FROM cms_config WHERE param='nwl_status';;
INSERT INTO cms_config (dtree_id, param, value, description, tip) VALUES
(113, 'nwj_email', 'support@domain.de', 'Newsletter Post', 'support@domain.de'),
(113, 'nwj_status', '0=---; 1=Neu; 2=Bearbeitet', 'Newsletter Status', 'id=Status');;
INSERT INTO cms_user_profile (user_id, param, value) VALUES
('1', 'nwl_sort', ''),
('1', 'nwe_sort', ''),
('1', 'nwj_sort', ''),
('2', 'nwl_sort', ''),
('2', 'nwe_sort', ''),
('2', 'nwj_sort', ''),
('3', 'nwl_sort', ''),
('3', 'nwe_sort', ''),
('3', 'nwj_sort', ''),
('4', 'nwl_sort', ''),
('4', 'nwe_sort', ''),
('4', 'nwj_sort', ''),
('5', 'nwl_sort', ''),
('5', 'nwe_sort', ''),
('5', 'nwj_sort', '');;
DELETE FROM cms_dtree_role WHERE dtree_id=116;;
DELETE FROM cms_dtree_role WHERE dtree_id=130;;
DELETE FROM cms_dtree_role WHERE dtree_id=131;;
INSERT INTO cms_dtree_role (dtree_id, role_id, attr) VALUES
('130', '1', '3'),
('131', '1', '3'),
('132', '1', '3'),
('130', '2', '3'),
('131', '2', '3'),
('132', '2', '3'),
('130', '3', '2'),
('131', '3', '2'),
('132', '3', '2'),
('130', '4', '1'),
('131', '4', '1'),
('132', '4', '1'),
('130', '5', '0'),
('131', '5', '0'),
('132', '5', '0');;
DROP TABLE IF EXISTS cms_news_email;;
CREATE TABLE cms_news_email (
  id           INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  priority     INTEGER NOT NULL DEFAULT 0,
  menu_id      INTEGER NOT NULL DEFAULT 0,
  email        TEXT,
  name         TEXT,
  surname      TEXT,
  title        TEXT,
  firm         TEXT,
  enabled      INTEGER NOT NULL DEFAULT 0,
  validetime   INTEGER NOT NULL DEFAULT 0,
  modifytime   INTEGER NOT NULL DEFAULT 0,
  createnick   TEXT NOT NULL DEFAULT 'none',
  UNIQUE (menu_id, email)
);;
DROP TABLE IF EXISTS cms_news_job;;
CREATE TABLE cms_news_job (
  id           INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT,
  menu_id      INTEGER NOT NULL DEFAULT 0,
  news_id      INTEGER NOT NULL DEFAULT 0,
  email        TEXT,
  reference    TEXT,
  descr        TEXT,
  status       INTEGER NOT NULL DEFAULT 0,
  modifytime   INTEGER NOT NULL DEFAULT 0,
  createnick   TEXT NOT NULL DEFAULT 'none',
  UNIQUE (menu_id, news_id, email)
);;































