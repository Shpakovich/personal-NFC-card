<script>
    export default {
        name: "buy",
        layout: "buy"
    }
</script>

<template>
        <v-container class="py-11 px-4 xl:flex xl:flex-col xl:h-full justify-between app-container">
            <v-row class="hello-block">
                <v-col class="flex">
                    <img class="m-auto iphone-img" src="./../assets/images/buy/iphone_bg.jpg" alt="">
                </v-col>
                <v-col>
                    <h1 class="font-gilroy text-4xl mb-6" >
                        MyID — Электронная визиsтка
                    </h1>
                    <p class="font-gilroy text-xl" >
                        в которой можно указывать ссылки на все свои социальные сети и добавлять контакты.<br>
                        Она позволит любому, кто прислонит телефон к метке перейти в соц. сеть, позвонить, начать чат в мессенджере, открыть сайт, прослушать плейлист, перевести деньги и так далее без дополнительных действий.
                    </p>
                </v-col>
            </v-row>

            <v-row class="info-block">
                <v-col class="flex flex-col justify-center">
                    <h2 class="font-gilroy text-4xl mb-6" >
                        Наполняй свой профиль данными
                    </h2>
                    <p class="font-gilroy text-xl" >
                        После регистрации пользователю предлагается заполнить имя или nickname, указать род деятельности и написать пару слов о себе.
                        <br><br>
                        Эта информация будет в «шапке» вашего профиля и вы в любой момент сможете её изменить.
                    </p>
                </v-col>
                <v-col>
                    <img class="m-auto screen-img" src="../assets/images/buy/profile.svg" alt="">
                </v-col>
            </v-row>

            <v-row class="info-block__reverse">
                <v-col>
                    <img class="m-auto screen-img" src="../assets/images/buy/tags.svg" alt="">
                </v-col>
                <v-col class="flex flex-col justify-center">
                    <h2 class="font-gilroy text-4xl mb-6" >
                        Выбирай из 23 готовых TAG-ов или добавляйте свои
                    </h2>
                    <p class="font-gilroy text-xl" >
                        Пользователю предлагается указать ссылки на социальные сети из 6 категорий.
                        <br><br>
                        Если нужно добавить ссылку на свою сеть, можно создать свою карточку.
                    </p>
                </v-col>
            </v-row>

            <v-row class="info-block">
                <v-col class="flex flex-col justify-center">
                    <h2 class="font-gilroy text-4xl mb-6" >
                        Отслеживай просмотры профиля по периодам 👀
                    </h2>
                    <p class="font-gilroy text-xl" >
                        Раздел с показами количества просмотров профиля за день/неделю/месяц/всё время.
                        <br><br>
                        Есть возможность подключения аналитики на сайт и сбор/показ количества кликов по каждому контакту.
                    </p>
                </v-col>
                <v-col>
                    <img class="m-auto screen-img" src="../assets/images/buy/watches.svg" alt="">
                </v-col>
            </v-row>

            <v-row class="info-block__reverse">
                <v-col>
                    <v-row class="justify-center">
                        <img class="mr-4" src="../assets/images/buy/favorite.svg" alt="" style="height: 45%; width: 45%">
                        <img src="../assets/images/addFavorite.gif" alt="" style="height: 45%; width: 35%; border-radius: 15%;">
                    </v-row>
                </v-col>
                <v-col class="flex flex-col justify-center">
                    <h2 class="font-gilroy text-4xl mb-6" >
                        Добавляй людей в избранноеи легко находи их ⭐
                    </h2>
                    <p class="font-gilroy text-xl" >
                        В личном кабинете доступен раздел "Избранное", там можно увидеть сохранённые контакты и перейти к ним в профиль в любой момент.
                        <br><br>
                        Сохранить контакт легко, просто нажмите на ⭐ при просмотре профиля.
                    </p>
                </v-col>
            </v-row>

           <v-row class="flex-nowrap tags-block">
               <img class="my-auto mr-12 tag1-img" src="../assets/images/buy/tags1.png" alt="">
               <div class="sm:pt-8 pt-4" style="max-height: 504px;">
                   <h2 class="font-gilroy text-4xl mb-6" >
                       Брендирование NFC Меток
                   </h2>
                   <p class="font-gilroy text-xl mb-8" >
                       Мы предоставляем NFC метки с чипом Ntag213 работающим по стандартам ИСО. Метки с обратной стороны покрыты анти-металлом и содержат клейкий слой для фиксации на любой поверхности.
                       <br><br>
                       На лицевую сторону можно нанести ваш дизайн. Размер метки 30мм по диаметру. Она защищена от попадания пыли и воды.
                   </p>
                   <img class="ml-auto tag2-img" src="../assets/images/buy/tags2.png" alt="">
               </div>
           </v-row>


            <v-row>
                <h2 class="font-gilroy text-4xl mb-6" >
                    Мы развиваемся с каждым новым клиентом&nbsp;🚀
                </h2>
                <p class="font-gilroy text-xl mb-8" >
                    Сейчас продукт полностью готов, протестирован и уже используется.<br>
                    Но у нас есть много идей как его улучшить:

                </p>
                <v-row>
                    <v-col class="flex flex-col justify-center goal-col">
                        <img class="my-auto" src="../assets/images/buy/metrik.png" alt="">
                        <p class="font-gilroy text-xl mt-4 text-center" >
                            Подключение метрики и аналитики
                        </p>
                    </v-col>
                    <v-col class="flex flex-col justify-center goal-col">
                        <img class="my-auto" src="../assets/images/buy/sentry.svg" alt="">
                        <p class="font-gilroy text-xl mt-4 text-center" >
                            Логирование ошибок и обнаружение «узких» мест
                        </p>
                    </v-col>
                    <v-col class="flex flex-col justify-center goal-col">
                        <img class="my-auto" src="../assets/images/buy/2profile.png" alt="">
                        <p class="font-gilroy text-xl mt-4 text-center" >
                            Добавление нескольких карточек профиля у пользователя
                        </p>
                    </v-col>
                    <v-col class="flex flex-col justify-center goal-col">
                        <img class="my-auto" style="border-radius: 35px;" src="../assets/images/buy/theme.png" alt="">
                        <p class="font-gilroy text-xl mt-4 text-center" >
                            Персонализация карточек и выбор темы
                        </p>
                    </v-col>
                </v-row>
            </v-row>

            <v-row class="sm:my-16 contact-block">
                <v-col class="m-auto">
                    <h2 class="font-gilroy text-center text-4xl mb-6">
                        Контакты для связи:
                    </h2>
                    <v-row class="mb-6 justify-center">
                        <img class="mr-4" style="width: 50px;" src="https://media.myid-card.ru/2021/08/23/6953a801-d901-4388-8175-8ed41da39b99.svg" alt="">
                        <a class="text-xl font-gilroy my-auto" href="https://t.me/shpakovich" target="_blank">https://t.me/shpakovich</a>
                    </v-row>
                    <v-row class="mb-6 justify-center">
                        <img class="mr-4" style="width: 50px;" src="https://media.myid-card.ru/2021/08/23/42399a54-0e15-4d25-86a4-67fbdf4e4566.svg" alt="">
                        <a class="text-xl font-gilroy my-auto" href="https://api.whatsapp.com/send?phone=+7%20(926)%20310-17-34" target="_blank">WhatsApp</a>
                    </v-row>
                    <v-row class="mb-6 justify-center">
                        <img class="mr-4" style="width: 50px;" src="https://media.myid-card.ru/2021/08/23/54940623-e9d0-4641-9a4e-d80a03cca84d.svg" alt="">
                        <a class="text-xl font-gilroy my-auto" href="mailto:myidcard.ru@gmail.com" target="_blank">myidcard.ru@gmail.com</a>
                    </v-row>
                </v-col>
                <v-col class="justify-center mt-12">
                    <p class="font-gilroy text-xl" >
                        С текущим функционалом цена за брендированную метку составляет:<br>
                        350₽ при заказе от 500 штук;<br>
                        300₽ при заказе от 2000 штук;<br>
                        250₽ при заказе от 5000 штук;<br>
                        <br>
                        При необходимости доработки софта цены и сроки дополнительно обсуждаются с заказчиком.

                    </p>
                </v-col>
            </v-row>
        </v-container>
</template>

<style lang="scss">
    .hello-block {
        @media (min-width: 1280px) { // todo вынести в переменную
            max-height: 768px;
        }

        @media (max-width: 640px) { // todo вынести в переменную
            flex-direction: column-reverse !important;
        }
    }

    .info-block {
        @media (min-width: 640px) { // todo вынести в переменную
            max-height: 503px;
        }
        @media (max-width: 640px) { // todo вынести в переменную
            flex-direction: column !important;
            margin-bottom: 32px !important;
        }
        &__reverse {
            @media (max-width: 640px) { // todo вынести в переменную
                flex-direction: column-reverse !important;
                margin-bottom: 32px !important;
            }
        }
    }

    .tags-block {
        @media (min-width: 640px) { // todo вынести в переменную
            max-height: 675px;
            height: 650px;
        }
        @media (max-width: 640px) { // todo вынести в переменную
            flex-direction: column !important;
            margin-bottom: 64px !important;
        }
    }

    .contact-block {
        @media (max-width: 640px) { // todo вынести в переменную
            flex-direction: column-reverse !important;
        }
    }

    .iphone-img {
        height: auto;
        border-radius: 50%;

        @media (max-width: 640px) { // todo вынести в переменную
            width: 50%;
        }
    }

    .tag1-img {
        @media (min-width: 640px) { // todo вынести в переменную
            width: 35%;
        }
        @media (max-width: 640px) { // todo вынести в переменную
            width: 55%;
        }
    }

    .tag2-img {
        width: 40%;
    }

    .goal-col {
        @media (max-width: 640px) { // todo вынести в переменную
            width: 50% !important;
            flex-basis: auto;
        }
    }

    .screen-img {
        width: 45%;

        @media (max-width: 640px) { // todo вынести в переменную
            width: 50%;
        }
    }
</style>
