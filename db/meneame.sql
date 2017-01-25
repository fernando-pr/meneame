drop table if exists usuarios cascade;

create table usuarios (
    id          bigserial      constraint pk_usuarios primary key,
    nombre      varchar(15)    not null constraint uq_usuarios_nombre unique,
    email       varchar(255)   not null,
    token       varchar(32),
    activacion  varchar(32),
    password    varchar(60)    not null,
    created_at  timestamptz    default current_timestamp
);

create index idx_usuarios_activacion on usuarios (activacion);
create index idx_usuarios_created_at on usuarios (created_at);

drop table if exists tipo_noticia cascade;

create table tipo_noticia (
    id           bigserial      constraint pk_tipo_noticias primary key,
    tipo         varchar(255)   not null
);

drop table if exists noticias cascade;

create table noticias (
    id           bigserial      constraint pk_noticias primary key,
    titulo       varchar(255)   not null,
    cuerpo       text           not null,
    enlace       varchar(255)   not null,
    publicado    timestamptz    not null default current_timestamp,
    tipo_noticia bigint         not null constraint fk_noticias_tipo_noticia
                                references tipo_noticia(id) on delete no action
                                on update cascade,
    id_usuario   bigint         not null constraint fk_noticias_usuarios
                                references usuarios(id) on delete no action
                                on update cascade
);


drop table if exists comentarios cascade;

create table comentarios (
    id           bigserial      constraint pk_comentarios primary key,
    comentario   text           not null,
    fecha        timestamptz    not null default current_timestamp,
    id_usuario   bigint         not null constraint fk_comentarios_usuarios
                                references usuarios(id) on delete no action
                                on update cascade,
    id_noticia   bigint         not null constraint fk_comentarios_noticias
                                references noticias(id) on delete no action
                                on update cascade
);
