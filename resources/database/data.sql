SET search_path TO pg_catalog,public,"media-streaming";
-- ddl-end --

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

COMMIT;
