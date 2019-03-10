create table users (
  user_id bigint not null
);

create table users_emails (
  email_id bigint not null,
  user_id bigint not null,
  email text not null,
  status_id integer,
  create_time timestamp with timezone,
  update_time timestamp with timezone
);

create table users_phones (
  phone_id bigint not null,
  user_id bigint not null,
  phone text not null,
  status_id integer,
  create_time timestamp with timezone,
  update_time timestamp with timezone
);

create table users_auth_visits (
  user_id bigint not null
  type_id integer not null, -- phone or email
  create_time timestamp with timezone
);
