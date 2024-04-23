<p align="center"><a href="#" target="_blank"><img src="https://blotos.ru/wp-content/uploads/f/b/d/fbdb60147c4e1e4b924f6b85991ae9e0.png" width="300" alt="App Logo"></a></p>

## О приложении

Проект несуществующей клиники, созданный в образовательных целях, в котором реализовано:

- Авторизация, валидация полей формы, а также проверка введенной при регистрации даты рождения (возраст 18+), верификация адреса электронной почты, возможность сброса пароля.
- Разделение пользователей и функционала сайта по ролям и типам пользователей (пациент/администратор и врач).
- Сохранение часового пояса пользователя при регистрации/авторизации, отображение расписания врачей в одном времени для разных часовых поясов.
- Возможность записи к врачу, отображение занятых окон в расписании врачей другим цветом без возможности записаться на это же время.
- Возможность добавления отзывов и оценок (1-5) по желанию у авторизованных пользователей, отображение времени добавления отзывов в соответствии с часовым поясом пользователя.
- Отображение записей к врачу в личном кабинете со счётчиком активных (не просроченных) записей на иконке для входа в личный кабинет в разделе навигации, возможность отмены не просроченной записи. Приветствие пользователя в личном кабинете в зависимости от времени суток в его часовом поясе.
- Возможность добавления, редактирования и удаления специальностей, врачей, расписания врачей у пользователей с ролью администратор. Добавление расписания реализовано в виде таблицы строк для заполнения, равных кол-ву дней следующего месяца, для недавно добавленных врачей реализована возможность добавить расписание на текущий месяц. По факту добавления расписания происходит запись в БД о добавлении расписания по конкретному врачу для исключения повторных попыток добавления.
- При добавлении врача на указанную почту отправляется автоматически сгенерированный пароль для входа в личный кабинет врача, при изменении почты генерируется новый пароль и отправляется на новую почту.
- В личном кабинете врача отображаются все записанные на сегодняшний день пациенты, окна с записанным пациентом и не истекшие по времени отличаются цветом и доступны для открытия и заполнения деталей приёма. После сохранения изменений у врача в выбранном приеме и у пациента в личном кабинете появляется кнопка для открытия/скачивания заключения в виде файла PDF.



## Использованные технологии и библиотеки

- **[Laravel](https://laravel.com/)**
- **[Laravel Breeze](https://github.com/laravel/breeze)**
- **[DOMPDF Wrapper for Laravel](https://github.com/barryvdh/laravel-dompdf)**
- **[Ajax/jQuery](https://jquery.com/)**
- **[Moment.js](https://momentjs.com/)**
- **[Bootstrap](https://getbootstrap.com/)**
- **[Carbon](https://carbon.nesbot.com/docs/)**
- **[Tailwind CSS](https://tailwindcss.com/)**
