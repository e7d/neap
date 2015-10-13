SET search_path TO pg_catalog,public,"media-streaming";
-- ddl-end --

TRUNCATE oauth_clients CASCADE;
TRUNCATE "media-streaming"."user" CASCADE;
TRUNCATE "media-streaming".channel CASCADE;
TRUNCATE "media-streaming".chat CASCADE;
TRUNCATE "media-streaming".stream CASCADE;
TRUNCATE "media-streaming".video CASCADE;

-- Clients
INSERT INTO oauth_clients (
    client_id,
    client_secret,
    redirect_uri)
VALUES (
    'public',
    '',
    '/oauth/receivecode'
);

BEGIN;

INSERT INTO "media-streaming"."user"(
		user_id,
		channel_id,
		type,
		username,
		email,
		password,
		display_name)
    VALUES (
		'a976df64-6925-457e-81ab-e6d683c8a25d',
		'0700a07f-9f82-4dc2-bb03-7217e2cc8b74',
		'admin',
		'admin',
		'admin@localhost',
		'$2y$10$xQeAtGJ6snEjr.Oqgt74KuWtu2QUoLjH1j75e7RJVUPckU8CNR5BO',
		'Admin');

INSERT INTO "media-streaming".channel(
		channel_id,
		user_id,
		chat_id,
		name,
		display_name,
		topic,
		language,
		views,
		followers)
    VALUES (
		'0700a07f-9f82-4dc2-bb03-7217e2cc8b74',
		'a976df64-6925-457e-81ab-e6d683c8a25d',
		'960f686c-d101-4125-8457-014f2a26c842',
		'admin',
		'Admin Channel',
		'',
		'en',
		0,
		0);

INSERT INTO "media-streaming".chat(
        chat_id,
		channel_id,
		name)
    VALUES (
		'960f686c-d101-4125-8457-014f2a26c842',
		'0700a07f-9f82-4dc2-bb03-7217e2cc8b74',
		'admin');

INSERT INTO "media-streaming".stream(
        stream_id,
        channel_id,
        title,
        topic_id,
        topic,
        media_info,
        viewers)
    VALUES (
        '7132dc5d-aba3-4494-976d-aad2423f062a',
        '0700a07f-9f82-4dc2-bb03-7217e2cc8b74',
        'Testing the demo channel with a demo stream!',
        null,
        'Demo',
        '{}',
        173);

INSERT INTO "media-streaming".video(
        video_id,
        stream_id,
        title,
        description,
        status,
        tags,
        topic,
        media_info,
        views)
    VALUES (
        'dacd1de6-c145-4ce6-88a0-f6fbe1640fc7',
        '7132dc5d-aba3-4494-976d-aad2423f062a',
        'Demo stream',
        'This is a test stream on Admin channel',
        'recorded',
        '["demo"]',
        'Demo',
        '{}',
        1291);

        COMMIT;
