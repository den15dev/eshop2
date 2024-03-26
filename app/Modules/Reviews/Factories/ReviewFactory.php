<?php

namespace App\Modules\Reviews\Factories;

use App\Modules\Reviews\Models\Review;
use App\Modules\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    protected $model = Review::class;


    public function definition(): array
    {
        $date_time = fake()->dateTimeBetween('-3 month');

        return [
            'sku_id' => 35,
            'user_id' => User::all('id')->random()->id,
            'term' => fake()->randomElement(['days', 'weeks', 'months']),
            'mark' => fake()->numberBetween(1, 5),
            'pros' => $this->getPros(),
            'cons' => $this->getCons(),
            'comnt' => $this->getComments(),
            'created_at' => $date_time,
            'updated_at' => $date_time,
        ];
    }


    private function getPros(): string
    {
        $arr = [
            "По сравнению с актуальной платформой intel, можно получить сопоставимую производительность в рабочих приложениях без использования водяного охлаждения.",
            "- Мощный, особенно по сравнению с моим прошлым i7 8700k.\n- Нет энергоэффективных ядер, только производительные.\n- Работает с памятью DDR5.\n- Прекрасное решение для игр в виртуалке.",
            "Мощный процессор, отлично подходит для многозадачности. Превосходно показал себя в программах 3D моделирования и играх. Не такой горячий как все говорят Воздушное охлаждение это доказало С кулером be quiet! DARK ROCK PRO 4 температура при длительных высоких нагрузках не поднималась выше 60 градусов",
            "Отличное соотношение цены и производительности на одно ядро, лучшее в 7000-й линейке на момент покупки",
            "брал как альтернативу 13700, есть возможность регулировки температур не сильно теряя в производительности, платформа am5 которая обещает долго жить",
        ];

        return $arr[array_rand($arr)];
    }

    private function getCons(): string
    {
        $arr = [
            "Много бракованных камней проверяйте сразу! Не только на запуск но и в тестах",
            "Очень долго включается комп\nгреется весьма ощутимо пришлось даунвольтить",
            "В режиме простоя постоянно пытается буститься до 5500, и из-за этого происходит его нагрев до 67* в следствии чего начинают  шуметь кульки от водянки 3х секц.",
            "Дурацкая форма крышки - наносить и вытирать термопасту не удобно\nНа одно ядро проигрывает более слабому 13600\n190ватт в стресс тесте чисто проц.  Вся система из розетки кушает 250 ватт",
            "Дорогая платформа. За нормальную сборку, даже без завалящей видеокарты, улетает полторы сотни. Все очень требовательно к хорошей вентиляции. Чип проца, при нагрузках, моментально, за секунду, нагревается под своей крышкой с 30 до 80-90 градусов и никакой радиатор не сможет это исправить.",
        ];

        return $arr[array_rand($arr)];
    }

    private function getComments(): string
    {
        $arr = [
            "После обугливающихся Дюронов, после Прескотов, из-за которых Интел заставил во всех корпусах в крышках сделать дыру для ТАС,  после многих лет всех этих суперэнергосбережений, очень холодных процов, узнать что для \"домашнего\" проца последнего поколения нужен кулер размером чуть-ли не вполсистемника.",
            "В простое у меня температура держится в районе ~44 градусов, предел температуры я ограничил на 80 градусах и выставил негативную курву -20 по всем ядрам (на -30 вылетало в cinebench r23, можно было попробовать другие значения в интервале между 30 и 20, но мне лень с этим возиться ради +0.x% прироста производительности), в итоге результат стресс теста в cinebench r23 28628 баллов.",
            "Брал за 36к, сожалею о покупке, так как в СЦ ДНСа все работает. А в моей сборке нет. При этом подкидывал 7600, все работает шикарно. В аиде, линпаке и тд",
            "тут нечего добавить работает как часики...\nвосторге советую не жалею и вы не пожалеете.\nбрал для различных целей как обработка видео и фото как и для графических программ так и для поиграть",
            "работает на частоте около 5 ггц при температура 65(простой)-80(нагрузка) градусов",
        ];

        return $arr[array_rand($arr)];
    }
}