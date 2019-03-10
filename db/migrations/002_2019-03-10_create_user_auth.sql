create table users (
  user_id bigint not null,
  status_id integer,
  create_time timestamp with timezone,
  update_time timestamp with timezone
);

-- dictionary (0 - not confirmed, 1 - confirmed, 2 - blocked)
create table users_statuses (
  status_id integer,
  title text
);

create table users_login (
  user_id bigint not null,
  login text,
  status_id integer,
  create_time timestamp with timezone,
  update_time timestamp with timezone
);

create table users_emails (
  email_id bigint not null,
  user_id bigint not null,
  email text not null,
  status_id integer,
  create_time timestamp with timezone,
  update_time timestamp with timezone
);

-- dictionary (0 - not verified, 1 - verified)
create table users_emails_statuses (
  status_id integer,
  title text
);

create table users_phones (
  phone_id bigint not null,
  user_id bigint not null,
  phone text not null,
  status_id integer,
  create_time timestamp with timezone,
  update_time timestamp with timezone
);

-- dictionary (0 - not verified, 1 - verified)
create table users_phones_statuses (
  status_id integer,
  title text
);

create table users_auth_visits (
  user_id bigint not null
  type_id integer not null, -- phone or email or login
  create_time timestamp with timezone
);

-- dictionary (example: 1 - email; 2 - phone; 3 - login)
create table users_auth_visits_type (
  type_id integer,
  title text
);

create table users_auth_credentials (
  user_id bigint not null,
  password_hash text,
  password_salt text,
  create_time timestamp with timezone,
  update_time timestamp with timezone
);

create table users_auth_deny_phones (
  phone_id bigint not null,
  create_time timestamp with timezone
);

create table users_auth_deny_emails (
  email_id bigint not null,
  create_time timestamp with timezone
);
