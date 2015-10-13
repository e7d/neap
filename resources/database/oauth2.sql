SET search_path TO pg_catalog,public,"neap";
-- ddl-end --

-- object: public.oauth_access_tokens | type: TABLE --
-- DROP TABLE IF EXISTS public.oauth_access_tokens CASCADE;
CREATE TABLE public.oauth_access_tokens(
	access_token character varying(40) NOT NULL,
	client_id character varying(80) NOT NULL,
	user_id character varying(255),
	expires timestamp(0) without time zone NOT NULL,
	scope character varying(2000),
	CONSTRAINT access_token_pk PRIMARY KEY (access_token)

);
-- ddl-end --
ALTER TABLE public.oauth_access_tokens OWNER TO "neap";
-- ddl-end --

-- object: public.oauth_authorization_codes | type: TABLE --
-- DROP TABLE IF EXISTS public.oauth_authorization_codes CASCADE;
CREATE TABLE public.oauth_authorization_codes(
	authorization_code character varying(40) NOT NULL,
	client_id character varying(80) NOT NULL,
	user_id character varying(255),
	redirect_uri character varying(2000),
	expires timestamp(0) without time zone NOT NULL,
	scope character varying(2000),
	id_token character varying(2000),
	CONSTRAINT auth_code_pk PRIMARY KEY (authorization_code)

);
-- ddl-end --
ALTER TABLE public.oauth_authorization_codes OWNER TO "neap";
-- ddl-end --

-- object: public.oauth_clients | type: TABLE --
-- DROP TABLE IF EXISTS public.oauth_clients CASCADE;
CREATE TABLE public.oauth_clients(
	client_id character varying(80) NOT NULL,
	client_secret character varying(80) NOT NULL,
	redirect_uri character varying(2000) NOT NULL,
	grant_types character varying(80),
	scope character varying(2000),
	user_id character varying(255),
	CONSTRAINT clients_client_id_pk PRIMARY KEY (client_id)

);
-- ddl-end --
ALTER TABLE public.oauth_clients OWNER TO "neap";
-- ddl-end --

-- object: public.oauth_jwt | type: TABLE --
-- DROP TABLE IF EXISTS public.oauth_jwt CASCADE;
CREATE TABLE public.oauth_jwt(
	client_id character varying(80) NOT NULL,
	subject character varying(80),
	public_key character varying(2000),
	CONSTRAINT jwt_client_id_pk PRIMARY KEY (client_id)

);
-- ddl-end --
ALTER TABLE public.oauth_jwt OWNER TO "neap";
-- ddl-end --

-- object: public.oauth_refresh_tokens | type: TABLE --
-- DROP TABLE IF EXISTS public.oauth_refresh_tokens CASCADE;
CREATE TABLE public.oauth_refresh_tokens(
	refresh_token character varying(40) NOT NULL,
	client_id character varying(80) NOT NULL,
	user_id character varying(255),
	expires timestamp(0) without time zone NOT NULL,
	scope character varying(2000),
	CONSTRAINT refresh_token_pk PRIMARY KEY (refresh_token)

);
-- ddl-end --
ALTER TABLE public.oauth_refresh_tokens OWNER TO "neap";
-- ddl-end --

-- object: public.oauth_scopes | type: TABLE --
-- DROP TABLE IF EXISTS public.oauth_scopes CASCADE;
CREATE TABLE public.oauth_scopes(
	type character varying(255) NOT NULL DEFAULT 'supported'::character varying,
	scope character varying(2000),
	client_id character varying(80),
	is_default smallint

);
-- ddl-end --
ALTER TABLE public.oauth_scopes OWNER TO "neap";
-- ddl-end --
