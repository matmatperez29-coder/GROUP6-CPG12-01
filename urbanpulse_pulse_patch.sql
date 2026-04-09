-- UrbanPulse Pulse Features Patch
-- Import this AFTER your main urbanpulse_db SQL dump.

USE `urbanpulse_db`;

CREATE TABLE IF NOT EXISTS `pulse_alerts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alert_key` varchar(100) NOT NULL,
  `page_scope` varchar(255) NOT NULL DEFAULT 'home',
  `category` varchar(100) NOT NULL,
  `label` varchar(120) NOT NULL,
  `headline` varchar(255) NOT NULL,
  `summary` text NOT NULL,
  `event_time` datetime NOT NULL DEFAULT current_timestamp(),
  `transcript_id` varchar(100) DEFAULT NULL,
  `action_text` varchar(80) NOT NULL DEFAULT 'Open transcript',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `alert_key` (`alert_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE IF NOT EXISTS `article_transcripts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transcript_key` varchar(100) NOT NULL,
  `article_id` varchar(100) DEFAULT NULL,
  `page_slug` varchar(50) NOT NULL DEFAULT 'home',
  `eyebrow` varchar(120) NOT NULL,
  `headline` varchar(255) NOT NULL,
  `deck` text NOT NULL,
  `author` varchar(120) NOT NULL DEFAULT 'UrbanPulse Desk',
  `published_label` varchar(120) NOT NULL,
  `duration_label` varchar(50) NOT NULL DEFAULT '2 min read',
  `summary` text NOT NULL,
  `quote_text` text DEFAULT NULL,
  `signals_json` longtext NOT NULL,
  `transcript_json` longtext NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `transcript_key` (`transcript_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `article_transcripts` (`transcript_key`, `article_id`, `page_slug`, `eyebrow`, `headline`, `deck`, `author`, `published_label`, `duration_label`, `summary`, `quote_text`, `signals_json`, `transcript_json`)
VALUES
('tech-agentic', 'article-ai-agentic-revolution', 'technology', 'AI and Robotics', 'Transcript Lens: The Transition to Agentic AI and Autonomous Systems', 'A spoken-style newsroom transcript that turns the article into a clean sequence of anchor notes, field context, and signal checks.', 'Aris Thorne', 'February 23, 2026 · 9:00 AM PST', '3 min read', 'UrbanPulse frames the shift to agentic AI as more than a feature upgrade. The core story is about what happens when software starts making chained decisions that affect logistics, operations, and accountability.', 'The question is no longer whether AI can act. The question is how humans stay meaningfully responsible when it does.', '["Trust architecture","Human-on-the-loop","Workflow delegation"]', '[{"speaker":"ANCHOR","time":"00:00","text":"Across companies, AI is moving from assistant mode into operator mode. These systems are starting to schedule tasks, route decisions, and complete multi-step work with less direct human prompting."},{"speaker":"DESK NOTE","time":"00:28","text":"That shift sounds efficient, but it changes the risk. One fast mistake can now be repeated at scale because the machine is acting across an entire workflow instead of a single step."},{"speaker":"FIELD REPORT","time":"00:57","text":"Executives say the value is speed and consistency. Critics say the hidden issue is traceability. If an agent makes ten connected choices, teams need to know where the judgment really came from."},{"speaker":"ANCHOR","time":"01:34","text":"UrbanPulse reads this moment as a trust problem, not only a productivity story. Safety rules, escalation paths, and logging systems are becoming as important as the model itself."}]'),
('sports-eagles', 'article-superbowl-lix', 'sports', 'American Football', 'Transcript Lens: Philadelphia Eagles Triumph in Super Bowl LIX', 'A fast, readable game-call transcript built for students and fans who want the rhythm of the night without scanning a full recap.', 'Marcus Thompson', 'February 9, 2025 · 6:30 PM EST', '3 min read', 'The transcript captures the defensive tone, the scoring momentum, and why the game ended the Chiefs’ push for a three-peat.', 'The Eagles did not just win the game. They changed the emotional weather of it before halftime.', '["Defensive pressure","Momentum swing","MVP path"]', '[{"speaker":"ANCHOR","time":"00:00","text":"From the opening stretch, Philadelphia looked sharper at the line and more comfortable controlling the pace."},{"speaker":"GAME CALL","time":"00:21","text":"The turning point came when the Eagles created pressure without giving away space, forcing Kansas City into a more reactive game than usual."},{"speaker":"DESK NOTE","time":"00:49","text":"Once the score tilted, the mood of the night changed. The Chiefs were chasing stability while the Eagles were playing with conviction."},{"speaker":"ANCHOR","time":"01:10","text":"UrbanPulse reads the result as a complete-team win, with the MVP storyline fitting into a larger story about control and discipline."}]'),
('sports-kayobahala', 'submission-2', 'sports', 'Esports / Tournament Desk', 'Transcript Lens: KayoBahala eliminates Kira Seira', 'A bracket-shock transcript mode that reframes the upset like a live desk recap with momentum beats and crowd energy.', 'UrbanPulse Tournament Desk', 'March 22, 2026 · 4:57 PM PHT', '3 min read', 'This transcript converts your approved sports article into a cleaner spoken rundown so readers can follow the wildcard run faster on mobile.', 'From wildcard entry to Grand Finals, this is the kind of storyline that defines tournaments.', '["Wildcard momentum","Upset alert","Grand Finals"]', '[{"speaker":"ANCHOR","time":"00:00","text":"A wildcard team just turned the bracket upside down. KayoBahala eliminated tournament favorite Kira Seira and booked a place in the Grand Finals."},{"speaker":"MATCH DESK","time":"00:24","text":"The key pattern was confidence without panic. KayoBahala controlled early exchanges, punished mistakes, and kept the pace uncomfortable for Kira Seira all series long."},{"speaker":"ARENA NOTE","time":"00:52","text":"Each time Kira Seira looked ready to recover, KayoBahala answered with composure. The upset stopped feeling lucky and started feeling earned."},{"speaker":"ANCHOR","time":"01:18","text":"UrbanPulse reads this as a momentum story. KayoBahala is not arriving in the finals as a cute underdog. They are arriving as a threat."}]')
ON DUPLICATE KEY UPDATE
  page_slug = VALUES(page_slug),
  eyebrow = VALUES(eyebrow),
  headline = VALUES(headline),
  deck = VALUES(deck),
  author = VALUES(author),
  published_label = VALUES(published_label),
  duration_label = VALUES(duration_label),
  summary = VALUES(summary),
  quote_text = VALUES(quote_text),
  signals_json = VALUES(signals_json),
  transcript_json = VALUES(transcript_json),
  is_active = 1;

INSERT INTO `pulse_alerts` (`alert_key`, `page_scope`, `category`, `label`, `headline`, `summary`, `event_time`, `transcript_id`, `action_text`)
VALUES
('alert_agentic_shift', 'home,technology', 'AI Desk', 'New transcript lens', 'Agentic AI coverage now tracks trust, safety, and workflow ownership in one transcript lens.', 'The technology desk stitched the story into a readable timeline with anchor notes, field context, and quick signals.', '2026-03-25 08:20:00', 'tech-agentic', 'Open transcript'),
('alert_eagles_film_room', 'home,sports', 'Sports Desk', 'Film room', 'The Eagles Super Bowl story now has a play-by-play transcript mode.', 'Open the transcript lens to see the scoring swing, pressure points, and the MVP angle in sequence.', '2026-03-25 07:42:00', 'sports-eagles', 'Open recap'),
('alert_kayobahala_upset', 'home,sports', 'Tournament Wire', 'Bracket shock', 'Your approved KayoBahala story now has an AI transcript lens built for quick reading.', 'This one uses your real approved sports submission and turns it into a clean match-call transcript for mobile readers.', '2026-03-25 09:10:00', 'sports-kayobahala', 'Open upset lens')
ON DUPLICATE KEY UPDATE
  page_scope = VALUES(page_scope),
  category = VALUES(category),
  label = VALUES(label),
  headline = VALUES(headline),
  summary = VALUES(summary),
  event_time = VALUES(event_time),
  transcript_id = VALUES(transcript_id),
  action_text = VALUES(action_text),
  is_active = 1;
