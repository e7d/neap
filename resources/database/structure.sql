-- Database generated with pgModeler (PostgreSQL Database Modeler).
-- pgModeler  version: 0.8.1
-- PostgreSQL version: 9.4
-- Project Site: pgmodeler.com.br
-- Model Author: ---

SET check_function_bodies = false;
-- ddl-end --

-- object: neap | type: ROLE --
-- DROP ROLE IF EXISTS neap;
CREATE ROLE neap WITH 
	LOGIN
	ENCRYPTED PASSWORD 'neap';
-- ddl-end --


-- Database creation must be done outside an multicommand file.
-- These commands were put in this file only for convenience.
-- -- object: neap | type: DATABASE --
-- -- DROP DATABASE IF EXISTS neap;
-- CREATE DATABASE neap
-- 	OWNER = neap
-- ;
-- -- ddl-end --
-- 

-- object: neap | type: SCHEMA --
-- DROP SCHEMA IF EXISTS neap CASCADE;
CREATE SCHEMA neap;
-- ddl-end --
ALTER SCHEMA neap OWNER TO neap;
-- ddl-end --

SET search_path TO pg_catalog,public,neap;
-- ddl-end --

-- object: pgcrypto | type: EXTENSION --
-- DROP EXTENSION IF EXISTS pgcrypto CASCADE;
CREATE EXTENSION pgcrypto
      WITH SCHEMA neap;
-- ddl-end --

-- object: neap.channel | type: TABLE --
-- DROP TABLE IF EXISTS neap.channel CASCADE;
CREATE TABLE neap.channel(
	channel_id uuid NOT NULL DEFAULT gen_random_uuid(),
	user_id uuid NOT NULL,
	chat_id uuid NOT NULL,
	name character varying NOT NULL,
	stream_key uuid NOT NULL DEFAULT gen_random_uuid(),
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
ALTER TABLE neap.channel OWNER TO neap;
-- ddl-end --

-- object: neap."user" | type: TABLE --
-- DROP TABLE IF EXISTS neap."user" CASCADE;
CREATE TABLE neap."user"(
	user_id uuid NOT NULL DEFAULT gen_random_uuid(),
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
ALTER TABLE neap."user" OWNER TO neap;
-- ddl-end --

-- object: neap.follow | type: TABLE --
-- DROP TABLE IF EXISTS neap.follow CASCADE;
CREATE TABLE neap.follow(
	user_id uuid NOT NULL,
	channel_id uuid NOT NULL,
	created_at timestamptz NOT NULL DEFAULT now(),
	CONSTRAINT follow_user_id_channel_id_pk PRIMARY KEY (user_id,channel_id)

);
-- ddl-end --
ALTER TABLE neap.follow OWNER TO neap;
-- ddl-end --

-- object: neap.video | type: TABLE --
-- DROP TABLE IF EXISTS neap.video CASCADE;
CREATE TABLE neap.video(
	video_id uuid NOT NULL DEFAULT gen_random_uuid(),
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
ALTER TABLE neap.video OWNER TO neap;
-- ddl-end --

-- object: neap.panel | type: TABLE --
-- DROP TABLE IF EXISTS neap.panel CASCADE;
CREATE TABLE neap.panel(
	panel_id uuid NOT NULL DEFAULT gen_random_uuid(),
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
ALTER TABLE neap.panel OWNER TO neap;
-- ddl-end --

-- object: neap.stream | type: TABLE --
-- DROP TABLE IF EXISTS neap.stream CASCADE;
CREATE TABLE neap.stream(
	stream_id uuid NOT NULL DEFAULT gen_random_uuid(),
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
ALTER TABLE neap.stream OWNER TO neap;
-- ddl-end --

-- object: neap.topic | type: TABLE --
-- DROP TABLE IF EXISTS neap.topic CASCADE;
CREATE TABLE neap.topic(
	topic_id uuid NOT NULL,
	name character varying NOT NULL,
	created_at timestamptz NOT NULL DEFAULT now(),
	CONSTRAINT topic_topic_id_fk PRIMARY KEY (topic_id),
	CONSTRAINT topic_name_uq UNIQUE (name)

);
-- ddl-end --
ALTER TABLE neap.topic OWNER TO neap;
-- ddl-end --

-- object: neap.chat | type: TABLE --
-- DROP TABLE IF EXISTS neap.chat CASCADE;
CREATE TABLE neap.chat(
	chat_id uuid NOT NULL DEFAULT gen_random_uuid(),
	channel_id uuid NOT NULL,
	name character varying NOT NULL,
	created_at timestamptz NOT NULL DEFAULT now(),
	CONSTRAINT chat_chat_id PRIMARY KEY (chat_id),
	CONSTRAINT chat_name_uq UNIQUE (name)

);
-- ddl-end --
ALTER TABLE neap.chat OWNER TO neap;
-- ddl-end --

-- object: neap.mod | type: TABLE --
-- DROP TABLE IF EXISTS neap.mod CASCADE;
CREATE TABLE neap.mod(
	user_id uuid NOT NULL,
	chat_id uuid NOT NULL,
	level character varying NOT NULL,
	created_at timestamptz NOT NULL DEFAULT now(),
	updated_at timestamptz NOT NULL DEFAULT now(),
	CONSTRAINT mod_user_id_chat_id_fk PRIMARY KEY (user_id,chat_id)

);
-- ddl-end --
ALTER TABLE neap.mod OWNER TO neap;
-- ddl-end --

-- object: neap.block | type: TABLE --
-- DROP TABLE IF EXISTS neap.block CASCADE;
CREATE TABLE neap.block(
	user_id uuid NOT NULL,
	blocked_user_id uuid NOT NULL,
	created_at timestamptz NOT NULL DEFAULT now(),
	CONSTRAINT block_user_id_blocked_user_id_pk PRIMARY KEY (user_id,blocked_user_id),
	CONSTRAINT block_user_id_blocked_user_id_uq UNIQUE (user_id,blocked_user_id)

);
-- ddl-end --
ALTER TABLE neap.block OWNER TO neap;
-- ddl-end --

-- object: neap.update_updated_at | type: FUNCTION --
-- DROP FUNCTION IF EXISTS neap.update_updated_at() CASCADE;
CREATE FUNCTION neap.update_updated_at ()
	RETURNS trigger
	LANGUAGE plpgsql
	VOLATILE 
	CALLED ON NULL INPUT
	SECURITY INVOKER
	COST 1
	AS $$
BEGIN
    NEW.updated_at = now();
    RETURN NEW;
END;
$$;
-- ddl-end --
ALTER FUNCTION neap.update_updated_at() OWNER TO neap;
-- ddl-end --

-- object: stream_trigger_updated_at | type: TRIGGER --
-- DROP TRIGGER IF EXISTS stream_trigger_updated_at ON neap.stream  ON neap.stream CASCADE;
CREATE TRIGGER stream_trigger_updated_at
	BEFORE UPDATE
	ON neap.stream
	FOR EACH ROW
	EXECUTE PROCEDURE neap.update_updated_at();
-- ddl-end --

-- object: video_trigger_updated_at | type: TRIGGER --
-- DROP TRIGGER IF EXISTS video_trigger_updated_at ON neap.video  ON neap.video CASCADE;
CREATE TRIGGER video_trigger_updated_at
	BEFORE UPDATE
	ON neap.video
	FOR EACH ROW
	EXECUTE PROCEDURE neap.update_updated_at();
-- ddl-end --

-- object: channel_trigger_updated_at | type: TRIGGER --
-- DROP TRIGGER IF EXISTS channel_trigger_updated_at ON neap.channel  ON neap.channel CASCADE;
CREATE TRIGGER channel_trigger_updated_at
	BEFORE UPDATE
	ON neap.channel
	FOR EACH ROW
	EXECUTE PROCEDURE neap.update_updated_at();
-- ddl-end --

-- object: user_trigger_updated_at | type: TRIGGER --
-- DROP TRIGGER IF EXISTS user_trigger_updated_at ON neap."user"  ON neap."user" CASCADE;
CREATE TRIGGER user_trigger_updated_at
	BEFORE UPDATE
	ON neap."user"
	FOR EACH ROW
	EXECUTE PROCEDURE neap.update_updated_at();
-- ddl-end --

-- object: panel_trigger_updated_at | type: TRIGGER --
-- DROP TRIGGER IF EXISTS panel_trigger_updated_at ON neap.panel  ON neap.panel CASCADE;
CREATE TRIGGER panel_trigger_updated_at
	BEFORE UPDATE
	ON neap.panel
	FOR EACH ROW
	EXECUTE PROCEDURE neap.update_updated_at();
-- ddl-end --

-- object: mod_trigger_updated_at | type: TRIGGER --
-- DROP TRIGGER IF EXISTS mod_trigger_updated_at ON neap.mod  ON neap.mod CASCADE;
CREATE TRIGGER mod_trigger_updated_at
	BEFORE UPDATE
	ON neap.mod
	FOR EACH ROW
	EXECUTE PROCEDURE neap.update_updated_at();
-- ddl-end --

-- object: channel_user_id_fk | type: CONSTRAINT --
-- ALTER TABLE neap.channel DROP CONSTRAINT IF EXISTS channel_user_id_fk CASCADE;
ALTER TABLE neap.channel ADD CONSTRAINT channel_user_id_fk FOREIGN KEY (user_id)
REFERENCES neap."user" (user_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION DEFERRABLE INITIALLY DEFERRED;
-- ddl-end --

-- object: channel_chat_id_fk | type: CONSTRAINT --
-- ALTER TABLE neap.channel DROP CONSTRAINT IF EXISTS channel_chat_id_fk CASCADE;
ALTER TABLE neap.channel ADD CONSTRAINT channel_chat_id_fk FOREIGN KEY (chat_id)
REFERENCES neap.chat (chat_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION DEFERRABLE INITIALLY DEFERRED;
-- ddl-end --

-- object: channel_topic_id_fk | type: CONSTRAINT --
-- ALTER TABLE neap.channel DROP CONSTRAINT IF EXISTS channel_topic_id_fk CASCADE;
ALTER TABLE neap.channel ADD CONSTRAINT channel_topic_id_fk FOREIGN KEY (topic_id)
REFERENCES neap.topic (topic_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: user_channel_id_fk | type: CONSTRAINT --
-- ALTER TABLE neap."user" DROP CONSTRAINT IF EXISTS user_channel_id_fk CASCADE;
ALTER TABLE neap."user" ADD CONSTRAINT user_channel_id_fk FOREIGN KEY (channel_id)
REFERENCES neap.channel (channel_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION DEFERRABLE INITIALLY DEFERRED;
-- ddl-end --

-- object: follow_user_id_fk | type: CONSTRAINT --
-- ALTER TABLE neap.follow DROP CONSTRAINT IF EXISTS follow_user_id_fk CASCADE;
ALTER TABLE neap.follow ADD CONSTRAINT follow_user_id_fk FOREIGN KEY (user_id)
REFERENCES neap."user" (user_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: follow_channel_id_fk | type: CONSTRAINT --
-- ALTER TABLE neap.follow DROP CONSTRAINT IF EXISTS follow_channel_id_fk CASCADE;
ALTER TABLE neap.follow ADD CONSTRAINT follow_channel_id_fk FOREIGN KEY (channel_id)
REFERENCES neap.channel (channel_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: video_stream_id_fk | type: CONSTRAINT --
-- ALTER TABLE neap.video DROP CONSTRAINT IF EXISTS video_stream_id_fk CASCADE;
ALTER TABLE neap.video ADD CONSTRAINT video_stream_id_fk FOREIGN KEY (stream_id)
REFERENCES neap.stream (stream_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: video_topic_id_fk | type: CONSTRAINT --
-- ALTER TABLE neap.video DROP CONSTRAINT IF EXISTS video_topic_id_fk CASCADE;
ALTER TABLE neap.video ADD CONSTRAINT video_topic_id_fk FOREIGN KEY (topic_id)
REFERENCES neap.topic (topic_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: panel_channel_id_fk | type: CONSTRAINT --
-- ALTER TABLE neap.panel DROP CONSTRAINT IF EXISTS panel_channel_id_fk CASCADE;
ALTER TABLE neap.panel ADD CONSTRAINT panel_channel_id_fk FOREIGN KEY (channel_id)
REFERENCES neap.channel (channel_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: stream_channel_id_fk | type: CONSTRAINT --
-- ALTER TABLE neap.stream DROP CONSTRAINT IF EXISTS stream_channel_id_fk CASCADE;
ALTER TABLE neap.stream ADD CONSTRAINT stream_channel_id_fk FOREIGN KEY (channel_id)
REFERENCES neap.channel (channel_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: stream_topic_id_fk | type: CONSTRAINT --
-- ALTER TABLE neap.stream DROP CONSTRAINT IF EXISTS stream_topic_id_fk CASCADE;
ALTER TABLE neap.stream ADD CONSTRAINT stream_topic_id_fk FOREIGN KEY (topic_id)
REFERENCES neap.topic (topic_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: chat_channel_id_fk | type: CONSTRAINT --
-- ALTER TABLE neap.chat DROP CONSTRAINT IF EXISTS chat_channel_id_fk CASCADE;
ALTER TABLE neap.chat ADD CONSTRAINT chat_channel_id_fk FOREIGN KEY (channel_id)
REFERENCES neap.channel (channel_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION DEFERRABLE INITIALLY DEFERRED;
-- ddl-end --

-- object: mod_user_id_fk | type: CONSTRAINT --
-- ALTER TABLE neap.mod DROP CONSTRAINT IF EXISTS mod_user_id_fk CASCADE;
ALTER TABLE neap.mod ADD CONSTRAINT mod_user_id_fk FOREIGN KEY (user_id)
REFERENCES neap."user" (user_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: mod_chat_id_fk | type: CONSTRAINT --
-- ALTER TABLE neap.mod DROP CONSTRAINT IF EXISTS mod_chat_id_fk CASCADE;
ALTER TABLE neap.mod ADD CONSTRAINT mod_chat_id_fk FOREIGN KEY (chat_id)
REFERENCES neap.chat (chat_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: block_user_id_fk | type: CONSTRAINT --
-- ALTER TABLE neap.block DROP CONSTRAINT IF EXISTS block_user_id_fk CASCADE;
ALTER TABLE neap.block ADD CONSTRAINT block_user_id_fk FOREIGN KEY (user_id)
REFERENCES neap."user" (user_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --

-- object: block_blocked_user_id_fk | type: CONSTRAINT --
-- ALTER TABLE neap.block DROP CONSTRAINT IF EXISTS block_blocked_user_id_fk CASCADE;
ALTER TABLE neap.block ADD CONSTRAINT block_blocked_user_id_fk FOREIGN KEY (blocked_user_id)
REFERENCES neap."user" (user_id) MATCH FULL
ON DELETE NO ACTION ON UPDATE NO ACTION;
-- ddl-end --


