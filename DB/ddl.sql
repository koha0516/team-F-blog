CREATE
DATABASE
    blog_app;
USE
blog_app;

CREATE
USER 'grant_all_user'@'localhost' IDENTIFIED BY 'T4tZhGD-GRUfDtUgF6';
GRANT ALL
ON blog_app.* TO 'grant_all_user'@'localhost';

-- ユーザー
CREATE TABLE users
(
    user_id       int auto_increment,
    user_name     varchar(64) not null,
    user_birth    varchar(32) not null,
    user_mail     varchar(64) not null unique,
    salt          varchar(20) not null,
    password      varchar(64) not null,
    create_at     timestamp   DEFAULT CURRENT_TIMESTAMP,
    update_at     timestamp   DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    delete_frag   int         not null default 0,
    primary key (user_id)
);

-- タグ
CREATE TABLE tags
(
    tag_id   int not null,
    tag_name varchar(32) not null,
    primary key (tag_id)
);

-- 記事
CREATE TABLE articles
(
    article_id      int auto_increment,
    title           varchar(64)    not null,
    article_content varchar(10000) not null unique,
    tag_id          int            not null,
    user_id         int            not null,
    published       int            not null,
    create_at       timestamp      DEFAULT CURRENT_TIMESTAMP,
    update_at       timestamp      DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    delete_frag     int            not null default 0,
    primary key (article_id),
    foreign key (tag_id) references tags (tag_id),
    foreign key (user_id) references users (user_id)
);

-- フォロー
CREATE TABLE follow
(
    follow_id           int         auto_increment,
    follow_user_id      int         not null,
    followed_user_id    int         not null,
    create_at           timestamp   DEFAULT CURRENT_TIMESTAMP,
    delete_frag         int         not null default 0,
    primary key (follow_id),
    foreign key (follow_user_id) references users (user_id),
    foreign key (followed_user_id) references users (user_id)
);


--いいね
CREATE TABLE likes
(
    article_id      int         not null,
    like_user_id    int         not null,
    create_at       timestamp   DEFAULT CURRENT_TIMESTAMP,
    primary key (article_id,like_user_id),
    foreign key (article_id) references articles (article_id),
    foreign key (like_user_id) references users (user_id)
);

--コメント
CREATE TABLE comments
(
    comment_id          int             auto_increment,
    article_id          int             not null,
    comment_user_id     int             not null,
    comment_content     varchar(500)    not null unique,
    create_at           timestamp       DEFAULT CURRENT_TIMESTAMP,
    delete_frag         int             not null default 0,
    primary key (comment_id),
    foreign key (article_id) references articles (article_id),
    foreign key (comment_user_id) references users (user_id)
);