-- Database generated with pgModeler (PostgreSQL Database Modeler).
-- pgModeler  version: 0.8.1
-- PostgreSQL version: 9.4
-- Project Site: pgmodeler.com.br
-- Model Author: ---

-- object: "media-streaming" | type: ROLE --
-- DROP ROLE IF EXISTS "media-streaming";
CREATE ROLE "media-streaming" WITH 
	LOGIN
	ENCRYPTED PASSWORD 'media-streaming';
-- ddl-end --


-- Database creation must be done outside an multicommand file.
-- These commands were put in this file only for convenience.
-- -- object: "media-streaming" | type: DATABASE --
-- -- DROP DATABASE IF EXISTS "media-streaming";
-- CREATE DATABASE "media-streaming"
-- 	OWNER = "media-streaming"
-- ;
-- -- ddl-end --
-- 

-- object: "media-streaming" | type: SCHEMA --
-- DROP SCHEMA IF EXISTS "media-streaming" CASCADE;
CREATE SCHEMA "media-streaming";
-- ddl-end --
ALTER SCHEMA "media-streaming" OWNER TO "media-streaming";
-- ddl-end --

SET search_path TO pg_catalog,public,"media-streaming";
-- ddl-end --

-- object: "media-streaming".channel | type: TABLE --
-- DROP TABLE IF EXISTS "media-streaming".channel CASCADE;
CREATE TABLE "media-streaming".channel(
	channel_id uuid NOT NULL,
	user_id uuid NOT NULL,
	chat_id uuid NOT NULL,
	name character varying NOT NULL,
	display_name character varying NOT NULL,
	topic_id uuid,
	topic character varying NOT NULL,
	language character varying(2) NOT NULL DEFAULT 'en',
	delay smallint NOT NULL DEFAULT 0,
	logo character varying,
	banner character varying,
	video_banner character varying,
	background character varying,
	profile_banner character varying,
	views integer NOT NULL DEFAULT 0,
	followers integer NOT NULL DEFAULT 0,
	created_at timestamptz NOT NULL DEFAULT now(),
	updated_at timestamptz NOT NULL DEFAULT now(),
	CONSTRAINT channel_channel_id_pk PRIMARY KEY (channel_id)

);
-- ddl-end --
ALTER TABLE "media-streaming".channel OWNER TO "media-streaming";
-- ddl-end --

-- object: "media-streaming"."user" | type: TABLE --
-- DROP TABLE IF EXISTS "media-streaming"."user" CASCADE;
CREATE TABLE "media-streaming"."user"(
	user_id uuid NOT NULL,
	channel_id uuid NOT NULL,
	type character varying NOT NULL DEFAULT 'user',
	username character varying NOT NULL,
	email character varying NOT NULL,
	password character varying NOT NULL,
	display_name character varying NOT NULL,
	logo character varying,
	bio text,
	created_at timestamptz NOT NULL DEFAULT now(),
	updated_at timestamptz NOT NULL DEFAULT now(),
	CONSTRAINT user_user_id_pk PRIMARY KEY (user_id),
	CONSTRAINT user_user_id_uq UNIQUE (user_id),
	CONSTRAINT user_username_uq UNIQUE (username),
	CONSTRAINT user_email_uq UNIQUE (email)

);
-- ddl-end --
ALTER TABLE "media-streaming"."user" OWNER TO "media-streaming";
-- ddl-end --

-- object: "media-streaming".follow | type: TABLE --
-- DROP TABLE IF EXISTS "media-streaming".follow CASCADE;
CREATE TABLE "media-streaming".follow(
	user_id uuid NOT NULL,
	channel_id uuid NOT NULL,
	created_at timestamptz NOT NULL DEFAULT now(),
	CONSTRAINT follow_user_id_channel_id_pk PRIMARY KEY (user_id,channel_id)

);
-- ddl-end --
ALTER TABLE "media-streaming".follow OWNER TO "media-streaming";
-- ddl-end --

-- object: "media-streaming".video | type: TABLE --
-- DROP TABLE IF EXISTS "media-streaming".video CASCADE;
CREATE TABLE "media-streaming".video(
	video_id uuid NOT NULL,
	stream_id uuid NOT NULL,
	title character varying NOT NULL,
	type character varying NOT NULL DEFAULT 'record',
	description text,
	status character varying NOT NULL,
	tags json NOT NULL DEFAULT '{}',
	topic_id uuid,
	topic character varying NOT NULL,
	media_info json NOT NULL DEFAULT '{}',
	preview character varying,
	views integer NOT NULL DEFAULT 0,
	created_at timestamptz NOT NULL DEFAULT now(),
	updated_at timestamptz NOT NULL DEFAULT now(),
	CONSTRAINT video_video_id_pk PRIMARY KEY (video_id)

);
-- ddl-end --
ALTER TABLE "media-streaming".video OWNER TO "media-streaming";
-- ddl-end --

-- object: "media-streaming".panel | type: TABLE --
-- DROP TABLE IF EXISTS "media-streaming".panel CASCADE;
CREATE TABLE "media-streaming".panel(
	panel_id uuid NOT NULL,
	channel_id uuid NOT NULL,
	title character varying NOT NULL,
	"position" smallint NOT NULL DEFAULT 0,
	banner character varying,
	banner_link character varying,
	description text,
	created_at timestamptz NOT NULL DEFAULT now(),
	updated_at timestamptz NOT NULL DEFAULT now(),
	CONSTRAINT panel_panel_id_pk PRIMARY KEY (panel_id),
	CONSTRAINT panel_panel_id_position_uq UNIQUE (panel_id,"position")

);
-- ddl-end --
ALTER TABLE "media-streaming".panel OWNER TO "media-streaming";
-- ddl-end --

-- object: "media-streaming".stream | type: TABLE --
-- DROP TABLE IF EXISTS "media-streaming".stream CASCADE;
CREATE TABLE "media-streaming".stream(
	stream_id uuid NOT NULL,
	channel_id uuid NOT NULL,
	title character varying NOT NULL,
	topic_id uuid,
	topic character varying NOT NULL,
	media_info json NOT NULL DEFAULT '{}',
	viewers integer NOT NULL DEFAULT 0,
	created_at timestamptz NOT NULL DEFAULT now(),
	updated_at timestamptz NOT NULL DEFAULT now(),
	ended_at timestamptz,
	CONSTRAINT stream_stream_id_pk PRIMARY KEY (stream_id)

);
-- ddl-end --
ALTER TABLE "media-streaming".stream OWNER TO "media-streaming";
-- ddl-end --

-- object: "media-streaming".topic | type: TABLE --
-- DROP TABLE IF EXISTS "media-streaming".topic CASCADE;
CREATE TABLE "media-streaming".topic(
	topic_id uuid NOT NULL,
	name character varying NOT NULL,
	created_at timestamptz NOT NULL DEFAULT now(),
	CONSTRAINT topic_topic_id_fk PRIMARY KEY (topic_id),
	CONSTRAINT topic_name_uq UNIQUE (name)

);
-- ddl-end --
ALTER TABLE "media-streaming".topic OWNER TO "media-streaming";
-- ddl-end --

-- object: "media-streaming".chat | type: TABLE --
-- DROP TABLE IF EXISTS "media-streaming".chat CASCADE;
CREATE TABLE "media-streaming".chat(
	chat_id uuid NOT NULL,
	channel_id uuid NOT NULL,
	name character varying NOT NULL,
	created_at timestamptz NOT NULL DEFAULT now(),
	CONSTRAINT chat_chat_id PRIMARY KEY (chat_id),
	CONSTRAINT chat_name_uq UNIQUE (name)

);
-- ddl-end --
ALTER TABLE "media-streaming".chat OWNER TO "media-streaming";
-- ddl-end --

-- object: "media-streaming".mod | type: TABLE --
-- DROP TABLE IF EXISTS "media-streaming".mod CASCADE;
CREATE TABLE "media-streaming".mod(
	user_id uuid NOT NULL,
	chat_id uuid NOT NULL,
	level character varying NOT NULL,
	created_at timestamptz NOT NULL DEFAULT now(),
	updated_at timestamptz NOT NULL DEFAULT now(),
	CONSTRAINT mod_user_id_chat_id_fk PRIMARY KEY (user_id,chat_id)

);
-- ddl-end --
ALTER TABLE "media-streaming".mod OWNER TO "media-streaming";
-- ddl-end --

-- object: "media-streaming".stream_owner | type: VIEW --
-- DROP VIEW IF EXISTS "media-streaming".stream_owner CASCADE;
CREATE VIEW "media-streaming".stream_owner
AS 

SELECT
   u.user_id,
   c.channel_id,
   s.stream_id
FROM
   "media-streaming"."user" AS u,
   "media-streaming".channel AS c,
   "media-streaming".stream AS s
WHERE
   u.user_id = c.user_id   AND c.channel_id = s.channel_id;
-- ddl-end --
ALTER VIEW "media-streaming".stream_owner OWNER TO "media-streaming";
-- ddl-end --

-- object: "media-streaming".video_owner | type: VIEW --
-- DROP VIEW IF EXISTS "media-streaming".video_owner CASCADE;
CREATE VIEW "media-streaming".video_owner
AS 

SELECT
   u.user_id,
   c.channel_id,
   s.stream_id,
   v.video_id
FROM
   "media-streaming"."user" AS u,
   "media-streaming".channel AS c,
   "media-streaming".stream AS s,
   "media-streaming".video AS v
WHERE
   u.user_id = c.user_id   AND c.channel_id = s.channel_id   AND s.stream_id = v.stream_id;
-- ddl-end --
ALTER VIEW "media-streaming".video_owner OWNER TO "media-streaming";
-- ddl-end --

-- object: "media-streaming".chat_owner | type: VIEW --
-- DROP VIEW IF EXISTS "media-streaming".chat_owner CASCADE;
CREATE VIEW "media-streaming".chat_owner
AS 

SELECT
   u.user_id,
   c.channel_id,
   h.chat_id
FROM
   "media-streaming"."user" AS u,
   "media-streaming".channel AS c,
   "media-streaming".chat AS h
WHERE
   u.user_id = c.user_id   AND c.channel_id = h.channel_id;
-- ddl-end --
ALTER VIEW "media-streaming".chat_owner OWNER TO "media-streaming";
-- ddl-end --

-- object: "media-streaming".panel_owner | type: VIEW --
-- DROP VIEW IF EXISTS "media-streaming".panel_owner CASCADE;
CREATE VIEW "media-streaming".panel_owner
AS 

SELECT
   u.user_id,
   c.channel_id,
   p.panel_id
FROM
   "media-streaming"."user" AS u,
   "media-streaming".channel AS c,
   "media-streaming".panel AS p
WHERE
   u.user_id = c.user_id   AND c.channel_id = b.channel_id;
-- ddl-end --
ALTER VIEW "media-streaming".panel_owner OWNER TO "media-streaming";
-- ddl-end --

-- object: "media-streaming".block | type: TABLE --
-- DROP TABLE IF EXISTS "media-streaming".block CASCADE;
CREATE TABLE "media-streaming".block(
	user_id uuid NOT NULL,
	blocked_user_id uuid NOT NULL,
	created_at timestamptz NOT NULL DEFAULT now(),
	CONSTRAINT block_user_id_blocked_user_id_pk PRIMARY KEY (user_id,blocked_user_id),
	CONSTRAINT block_user_id_blocked_user_id_uq UNIQUE (user_id,blocked_user_id)

);
-- ddl-end --
ALTER TABLE "media-streaming".block OWNER TO "media-streaming";
-- ddl-end --

-- object: "media-streaming"."C" | type: COLLATION --
-- DROP COLLATION IF EXISTS "media-streaming"."C" CASCADE;
CREATE COLLATION "media-streaming"."C" (LOCALE = 'C.utf8');
-- ddl-end --
ALTER COLLATION "media-streaming"."C" OWNER TO "media-streaming";
-- ddl-end --

-- object: channel_user_id_fk | type: CONSTRAINT --
-- ALTER TABLE "media-streaming".channel DROP CONSTRAINT IF EXISTS channel_user_id_fk CASCADE;
ALTER TABLE "media-streaming".channel ADD CONSTRAINT channel_user_id_fk FOREIGN KEY (user_id)
REFERENCES "media-streaming"."user" (user_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION DEFERRABLE INITIALLY DEFERRED;
-- ddl-end --

-- object: channel_chat_id_fk | type: CONSTRAINT --
-- ALTER TABLE "media-streaming".channel DROP CONSTRAINT IF EXISTS channel_chat_id_fk CASCADE;
ALTER TABLE "media-streaming".channel ADD CONSTRAINT channel_chat_id_fk FOREIGN KEY (chat_id)
REFERENCES "media-streaming".chat (chat_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION DEFERRABLE INITIALLY DEFERRED;
-- ddl-end --

-- object: channel_topic_id_fk | type: CONSTRAINT --
-- ALTER TABLE "media-streaming".channel DROP CONSTRAINT IF EXISTS channel_topic_id_fk CASCADE;
ALTER TABLE "media-streaming".channel ADD CONSTRAINT channel_topic_id_fk FOREIGN KEY (topic_id)
REFERENCES "media-streaming".topic (topic_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: user_channel_id_fk | type: CONSTRAINT --
-- ALTER TABLE "media-streaming"."user" DROP CONSTRAINT IF EXISTS user_channel_id_fk CASCADE;
ALTER TABLE "media-streaming"."user" ADD CONSTRAINT user_channel_id_fk FOREIGN KEY (channel_id)
REFERENCES "media-streaming".channel (channel_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION DEFERRABLE INITIALLY DEFERRED;
-- ddl-end --

-- object: follow_user_id_fk | type: CONSTRAINT --
-- ALTER TABLE "media-streaming".follow DROP CONSTRAINT IF EXISTS follow_user_id_fk CASCADE;
ALTER TABLE "media-streaming".follow ADD CONSTRAINT follow_user_id_fk FOREIGN KEY (user_id)
REFERENCES "media-streaming"."user" (user_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: follow_channel_id_fk | type: CONSTRAINT --
-- ALTER TABLE "media-streaming".follow DROP CONSTRAINT IF EXISTS follow_channel_id_fk CASCADE;
ALTER TABLE "media-streaming".follow ADD CONSTRAINT follow_channel_id_fk FOREIGN KEY (channel_id)
REFERENCES "media-streaming".channel (channel_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: video_stream_id_fk | type: CONSTRAINT --
-- ALTER TABLE "media-streaming".video DROP CONSTRAINT IF EXISTS video_stream_id_fk CASCADE;
ALTER TABLE "media-streaming".video ADD CONSTRAINT video_stream_id_fk FOREIGN KEY (stream_id)
REFERENCES "media-streaming".stream (stream_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: video_topic_id_fk | type: CONSTRAINT --
-- ALTER TABLE "media-streaming".video DROP CONSTRAINT IF EXISTS video_topic_id_fk CASCADE;
ALTER TABLE "media-streaming".video ADD CONSTRAINT video_topic_id_fk FOREIGN KEY (topic_id)
REFERENCES "media-streaming".topic (topic_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: panel_channel_id_fk | type: CONSTRAINT --
-- ALTER TABLE "media-streaming".panel DROP CONSTRAINT IF EXISTS panel_channel_id_fk CASCADE;
ALTER TABLE "media-streaming".panel ADD CONSTRAINT panel_channel_id_fk FOREIGN KEY (channel_id)
REFERENCES "media-streaming".channel (channel_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: stream_channel_id_fk | type: CONSTRAINT --
-- ALTER TABLE "media-streaming".stream DROP CONSTRAINT IF EXISTS stream_channel_id_fk CASCADE;
ALTER TABLE "media-streaming".stream ADD CONSTRAINT stream_channel_id_fk FOREIGN KEY (channel_id)
REFERENCES "media-streaming".channel (channel_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: stream_topic_id_fk | type: CONSTRAINT --
-- ALTER TABLE "media-streaming".stream DROP CONSTRAINT IF EXISTS stream_topic_id_fk CASCADE;
ALTER TABLE "media-streaming".stream ADD CONSTRAINT stream_topic_id_fk FOREIGN KEY (topic_id)
REFERENCES "media-streaming".topic (topic_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: chat_channel_id_fk | type: CONSTRAINT --
-- ALTER TABLE "media-streaming".chat DROP CONSTRAINT IF EXISTS chat_channel_id_fk CASCADE;
ALTER TABLE "media-streaming".chat ADD CONSTRAINT chat_channel_id_fk FOREIGN KEY (channel_id)
REFERENCES "media-streaming".channel (channel_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION DEFERRABLE INITIALLY DEFERRED;
-- ddl-end --

-- object: mod_user_id_fk | type: CONSTRAINT --
-- ALTER TABLE "media-streaming".mod DROP CONSTRAINT IF EXISTS mod_user_id_fk CASCADE;
ALTER TABLE "media-streaming".mod ADD CONSTRAINT mod_user_id_fk FOREIGN KEY (user_id)
REFERENCES "media-streaming"."user" (user_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: mod_chat_id_fk | type: CONSTRAINT --
-- ALTER TABLE "media-streaming".mod DROP CONSTRAINT IF EXISTS mod_chat_id_fk CASCADE;
ALTER TABLE "media-streaming".mod ADD CONSTRAINT mod_chat_id_fk FOREIGN KEY (chat_id)
REFERENCES "media-streaming".chat (chat_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: block_user_id_fk | type: CONSTRAINT --
-- ALTER TABLE "media-streaming".block DROP CONSTRAINT IF EXISTS block_user_id_fk CASCADE;
ALTER TABLE "media-streaming".block ADD CONSTRAINT block_user_id_fk FOREIGN KEY (user_id)
REFERENCES "media-streaming"."user" (user_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: block_blocked_user_id_fk | type: CONSTRAINT --
-- ALTER TABLE "media-streaming".block DROP CONSTRAINT IF EXISTS block_blocked_user_id_fk CASCADE;
ALTER TABLE "media-streaming".block ADD CONSTRAINT block_blocked_user_id_fk FOREIGN KEY (blocked_user_id)
REFERENCES "media-streaming"."user" (user_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --


