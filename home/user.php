<div class = 'container-fluid'>
    <div class = 'row'>
        <div class = 'col-lg-10'>
        </div>
        <?php
        if ($_COOKIE['user'] == 'user_oblast')
        {
            $important = array('Беззубов Геннадий Анатольевич', 'Богуславский Владимир Сергеевич', 'Пупков Валерий Николаевич', 'Тарасов Сергей Николаевич', 'Туркин Геннадий Юрьевич', 'Холодов Виктор Иванович',
                'Быковский Валерий Викторович', 'Гайдаров Александр Витальевич', 'Марценюк Роман Викторович', 'Сурженко Наталья Ивановна', 'Шведиков Валерий Анатольевич', 'Яценко Вячеслав Владимирович',
                'Бойко Олег Викторович', 'Еременко Анатолий Алексеевич', 'Жаданова Наталия Петровна', 'Жилкова Ирина Ивановна', 'Запорожцев Александр Алексеевич', 'Зеленый Валерий Васильевич',
                'Зубков Сергей Александрович', 'Каргинов Павел Николаевич', 'Кирияков Николай Николаевич', 'Гончаров Андрей Николаевич', 'Грабовский Валерий Михайлович', 'Долголенко Олег Борисович',
                'Долгополова Людмила Александровна', 'Дорохов Михаил Николаевич', 'Ковалев Николай Сергеевич', 'Козин Александр Сергеевич', 'Колесников Андрей Николаевич', 'Копачев Сергей Николаевич',
                'Король Александр Викторович', 'Косенко Константин Анатольевич', 'Лисогор Юрий Николаевич', 'Лукьянов Алексей Иванович', 'Лысенко Алексей Александрович', 'Максименко Татьяна Васильевна',
                'Морнев Александр Валентинович', 'Мосейко Николай Михайлович', 'Булыгин Александр Алексеевич', 'Окопный Владимир Леонидович', 'Панченко Николай Николаевич', 'Перков Михаил Николаевич',
                'Радионенко Дмитрий Иванович', 'Раевский Сергей Николаевич', 'Репин Роман Юрьевич', 'Салтовский Геннадий Григорьевич', 'Самсонов Александр Алексеевич', 'Сафронов Вячеслав Алексеевич',
                'Трегубов Николай Васильевич', 'Хворост Павел Егорович', 'Черепов Андрей Николаевич', 'Дрынкин Григорий Александрович');

            ?>
            <div style = 'background: black; color: red; padding-top: 10px; width: 100%; font-size: 40px; font-weight: bold; text-align: center;'>
                Внимание! Учетная запись user_oblast более не актуальна!<br>
                Для получение новой учетной записи обратитесь к непосредственному руководителю!
            </div>
    </div>


            <div style = 'padding-top: 50px; padding-bottom: 10px; text-align: center; font-size: 30px;'>
                <span style = 'text-decoration: underline;'>Информация о новых учетных записях доведена до следующих лиц</span>:
            </div>
            <div class = 'row' style = 'padding-bottom: 50px;'>
                <div class = 'col-lg-2'></div>
            <?php
                asort($important);
                $count = 0;
                foreach ($important as $key => $val)
                {
                    if (($count != 0) && ($count % 13 == 0))
                    { echo '</ul></div>'; }
                    if (($count == 0) || ($count % 13 == 0))
                    { echo "<div class = 'col-lg-2 col-md-3 col-sm-3' style = 'float: left;'><ul>"; }
                    echo "<li>{$val}</li>";
                    $count++;
                }
                $count = 0;
                ?>
                    <div class = 'col-lg-2'></div>
            </div>


        <?php } ?>
        <!-- <div class = 'col-lg-2' style = 'height: 170px;'>
            <div style = 'width: 100%; height: 150px; margin: auto;'>
                <form method = 'post'>
                    <div style = 'width: 100%; height: 100px; border: solid 1px black; border-bottom: 0;'>
                        <textarea name = 'mail_text' placeholder = 'Текст сообщения...' style = 'resize: none; width: 100%; height: 100%;'></textarea>
                    </div>
                    <div style = 'width: 100%; height: 50px; border: solid 1px black;'>
                        <input name = 'send_mail' style = 'width: 100%; height: 100%; border-radius: 0; font-weight: bolder;' type="submit" class="btn btn-success" value = 'Отправить'>
                    </div>
                </form>
            </div>
        </div>
        <div class = 'col-lg-6' style = 'height: 170px;'>
            Доброго времени суток, уважаемый пользователь!<br>
            Скорее всего ты уже заметил, что данный сервис находится в стадии разработки и постоянно дорабатывается.
            Именно поэтому хотелось бы узнать, чего по твоему мнению не хватает. Пожалуйста, заполни форму слева. Не стесняйся.
            Можешь писать о любых нюансах, начиная с дизайна и заканчивая функционалом. Твой вклад в развитее проекта - неоценим!
        </div> -->      <!-- Отправка письма -->

</div>




