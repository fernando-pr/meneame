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
    publicado    timestamptz    default current_timestamp,
    tipo_noticia bigint         not null constraint fk_noticias_tipo_noticia
                                references tipo_noticia(id) on delete cascade
                                on update cascade,
    id_usuario   bigint         not null constraint fk_noticias_usuarios
                                references usuarios(id) on delete cascade
                                on update cascade
);


drop table if exists comentarios cascade;

create table comentarios (
    id           bigserial      constraint pk_comentarios primary key,
    comentario   text           not null,
    fecha        timestamptz    default current_timestamp,
    id_usuario   bigint         not null constraint fk_comentarios_usuarios
                                references usuarios(id) on delete cascade
                                on update cascade,
    id_noticia   bigint         not null constraint fk_comentarios_noticias
                                references noticias(id) on delete cascade
                                on update cascade
);

--insert en tipo noticias
insert into tipo_noticia(tipo)
values ('Actualidad');
insert into tipo_noticia(tipo)
values ('Tecnologia');
insert into tipo_noticia(tipo)
values ('Futbol');

--Insert en usuarios
insert into usuarios(nombre, email, password)
values ('pepe','pepe@pepe.com', crypt('pepe', gen_salt('bf', 13)));

insert into usuarios(nombre, email, password)
values ('juan','juan@juan.com', crypt('juan', gen_salt('bf', 13)));

insert into usuarios(nombre, email, password)
values ('manolo','manolo@manolo.com', crypt('manolo', gen_salt('bf', 13)));

insert into usuarios(nombre, email, password)
values ('admin','admin@admin.com', crypt('admin', gen_salt('bf', 13)));

--Insert noticias
insert into noticias(titulo, cuerpo, enlace, tipo_noticia, id_usuario)
values ('noticia 1', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et
magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis,
 ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis
 enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.
In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum
 felis eu pede mollis pretium. Integer tincidunt. Cras dapibus.', 'enlace noticia 1', 1, 1);

 insert into noticias(titulo, cuerpo, enlace, tipo_noticia, id_usuario)
 values ('noticia 2', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
 Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et
 magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis,
  ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis
  enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.
 In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum
  felis eu pede mollis pretium. Integer tincidunt. Cras dapibus.', 'enlace noticia 2', 2, 2);

  insert into noticias(titulo, cuerpo, enlace, tipo_noticia, id_usuario)
  values ('noticia 3', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
  Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et
  magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis,
   ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis
   enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.
  In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum
   felis eu pede mollis pretium. Integer tincidunt. Cras dapibus.', 'enlace noticia 3', 3, 3);


-- Insert Comentarios
insert into comentarios(comentario, id_usuario,id_noticia )
values ('soy el comentario 1', 1, 1);
insert into comentarios(comentario, id_usuario,id_noticia )
values ('soy el comentario 2', 1, 1);
insert into comentarios(comentario, id_usuario,id_noticia )
values ('soy el comentario 3', 1, 1);

insert into comentarios(comentario, id_usuario,id_noticia )
values ('soy el comentario 1', 2, 2);
insert into comentarios(comentario, id_usuario,id_noticia )
values ('soy el comentario 2', 2, 2);
insert into comentarios(comentario, id_usuario,id_noticia )
values ('soy el comentario 3', 2, 2);

insert into comentarios(comentario, id_usuario,id_noticia )
values ('soy el comentario 1', 3, 3);
insert into comentarios(comentario, id_usuario,id_noticia )
values ('soy el comentario 2', 3, 3);
insert into comentarios(comentario, id_usuario,id_noticia )
values ('soy el comentario 3', 3, 3);
