create table users (
  user_id bigint not null,
  login text,
  status_id integer,
  create_time timestamp with timezone,
  update_time timestamp with timezone
);

create table users_statuses (
  status_id integer,
  title text
);

create table users_emails (
  email_id bigint not null,
  user_id bigint not null,
  email text not null,
  status_id integer,
  create_time timestamp with timezone,
  update_time timestamp with timezone
);

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
