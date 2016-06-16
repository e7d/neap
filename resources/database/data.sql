SET search_path TO pg_catalog, public, "neap";

TRUNCATE "public"."oauth_clients" CASCADE;
TRUNCATE "neap"."block" CASCADE;
TRUNCATE "neap"."channel" CASCADE;
TRUNCATE "neap"."chat" CASCADE;
TRUNCATE "neap"."editor" CASCADE;
TRUNCATE "neap"."emoji" CASCADE;
TRUNCATE "neap"."favorite" CASCADE;
TRUNCATE "neap"."follow" CASCADE;
TRUNCATE "neap"."ingest" CASCADE;
TRUNCATE "neap"."member" CASCADE;
TRUNCATE "neap"."mod" CASCADE;
TRUNCATE "neap"."outage" CASCADE;
TRUNCATE "neap"."panel" CASCADE;
TRUNCATE "neap"."stream" CASCADE;
TRUNCATE "neap"."team" CASCADE;
TRUNCATE "neap"."topic" CASCADE;
TRUNCATE "neap"."user" CASCADE;
TRUNCATE "neap"."video" CASCADE;

INSERT INTO "public"."oauth_clients" (client_id, client_secret, redirect_uri)
VALUES ('testclient', '$2y$14$f3qml4G2hG6sxM26VMq.geDYbsS089IBtVJ7DlD05BoViS9PFykE2', '/oauth/receivecode');
INSERT INTO "public"."oauth_clients" (client_id, client_secret, redirect_uri)
VALUES ('neap', '$2a$04$5/P4ffJYWYOPvYERc9qdgOjDRM3pvFi3fjcgdp6.1dzd/jb3BpeEC', '/oauth/receivecode');
INSERT INTO "public"."oauth_clients" (client_id, client_secret, redirect_uri)
VALUES ('postman', '$2y$14$Fz3BBwXpVi2OZz7AUoXzlOpUKgrgC9unWUgqGAnFkGdEUM96CFsda', 'https://www.getpostman.com/oauth2/callback');
INSERT INTO "public"."oauth_access_tokens" (access_token, client_id, user_id, expires, scope)
VALUES ('78870440483965eabbdb53210937b5242387b63d', 'neap', 'bd71ac6c-5fbd-4767-b9d5-6ddea02d8fc6', '2050-01-01 00:00:00', '');

BEGIN;
SET CONSTRAINTS ALL DEFERRED;

INSERT INTO "neap"."user" (user_id, channel_id, type, username, email, password, display_name)
VALUES ('a976df64-6925-457e-81ab-e6d683c8a25d', '0700a07f-9f82-4dc2-bb03-7217e2cc8b74', 'admin', 'admin', 'admin@localhost', '$2y$10$xQeAtGJ6snEjr.Oqgt74KuWtu2QUoLjH1j75e7RJVUPckU8CNR5BO', 'Admin');

INSERT INTO "neap"."channel" (channel_id, user_id, chat_id, name, title, topic, language, views, followers)
VALUES ('0700a07f-9f82-4dc2-bb03-7217e2cc8b74', 'a976df64-6925-457e-81ab-e6d683c8a25d', '960f686c-d101-4125-8457-014f2a26c842', 'admin', 'Admin Channel', '', 'en', 0, 0);

INSERT INTO "neap"."chat" (chat_id, channel_id, name)
VALUES ('960f686c-d101-4125-8457-014f2a26c842', '0700a07f-9f82-4dc2-bb03-7217e2cc8b74', 'admin');

COMMIT;
