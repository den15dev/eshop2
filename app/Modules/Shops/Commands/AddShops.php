<?php

namespace App\Modules\Shops\Commands;

use App\Modules\Shops\Models\Shop;
use Illuminate\Console\Command;

class AddShops extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-shops';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill DB with shops';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->createShops();
        $this->info('Shops added to DB');
    }

    private function createShops(): void
    {
        $records = [
            [
                "name" => '{"en":"«Metropolis» shopping center","ru":"ТЦ «Метрополис»","de":"Einkaufszentrum «Metropolis»"}',
                "address" => '{"en":"Leningradskoye sh., 16A, building 4, «Metropolis» shopping center","ru":"Ленинградское ш., 16А, стр. 4, ТЦ «Метрополис»","de":"Leningradskoye sh., 16A, Gebäude 4, Einkaufszentrum «Metropolis»"}',
                "location" => [55.82362, 37.49649],
                "opening_hours" => [[9, 20], [9, 20], [9, 20], [9, 20], [9, 20], [10, 18], []],
                "info" => '{"en":"The store is located on the 2nd floor of the «Metropolis» shopping center, pavilion K204. Parking is free on weekdays at the shopping center.","ru":"Магазин находится на 2 этаже торгового центра «Метрополис», павильон К204. На территории торгового центра по будним дням парковка бесплатная.","de":"Das Geschäft befindet sich im 2. Stock des Einkaufszentrums «Metropolis», Pavillon K204. Das Parken im Einkaufszentrum ist werktags kostenlos."}',
            ],
            [
                "name" => '{"en":"«Shchelkovsky» shopping center","ru":"ТЦ «Щёлковский»","de":"Einkaufszentrum «Shchelkovsky»"}',
                "address" => '{"en":"Shchelkovskoye sh., 75, «Shchelkovsky» shopping center","ru":"Щёлковское ш., 75, ТЦ «Щёлковский»","de":"Shchelkovskoye Sh., 75, Einkaufszentrum «Shchelkovsky»"}',
                "location" => [55.81116, 37.80088],
                "opening_hours" => [[9, 20], [9, 20], [9, 20], [9, 20], [9, 20], [9, 20], [10, 18]],
                "info" => '{"en":"The store is located within walking distance from the Komsomolskaya metro station, «Shchelkovsky» shopping center, 3rd floor, pavilion 318.","ru":"Магазин находится в нескольких минутах ходьбы от станции метро Комсомольская, торговый центр «Щёлковский», 3 этаж, павильон 318.","de":"Das Geschäft befindet sich nur wenige Gehminuten von der U-Bahn-Station Komsomolskaya, Einkaufszentrum «Shchelkovsky», 3. Etage, Pavillon 318 entfernt."}',
            ],
            [
                "name" => '{"en":"«Gorod» shopping center","ru":"ТЦ «Город»","de":"Einkaufszentrum «Gorod»"}',
                "address" => '{"en":"w. Entuziastov, 12, bldg. 2, shopping center «Gorod»","ru":"ш. Энтузиастов, 12, корп. 2, ТЦ «Город»","de":"w. Entuziastov, 12, Geb. 2, Einkaufszentrum «Gorod»"}',
                "location" => [55.74739, 37.70706],
                "opening_hours" => [[9, 20], [9, 20], [9, 20], [9, 20], [9, 20], [10, 18], []],
                "info" => '{"en":"The store is located on the 3rd floor of the «Gorod» shopping center. To find us, take the elevator to the 3rd floor, then go left to the end of the hall, then turn right.","ru":"Магазин находится на 3 этаже торгового центра «Город». Чтобы найти нас, поднимитесь на лифте на 3 этаж, далее идите налево до конца холла, затем поверните направо.","de":"Das Geschäft befindet sich im 3. Stock des Einkaufszentrums «Gorod». Um uns zu finden, fahren Sie mit dem Aufzug in die 3. Etage, gehen Sie dann links bis zum Ende der Halle und biegen Sie dann rechts ab."}',
            ],
            [
                "name" => '{"en":"«Mozaika» shopping center","ru":"ТЦ «Мозаика»","de":"Einkaufszentrum «Mozaika»"}',
                "address" => '{"en":"7th Kozhukhovskaya st., 9, «Mozaika» shopping center","ru":"7-я Кожуховская ул., 9, ТЦ «Мозаика»","de":"7. Kozhukhovskaya Str., 9, Einkaufszentrum «Mozaika»"}',
                "location" => [55.71066, 37.67488],
                "opening_hours" => [[9, 20], [9, 20], [9, 20], [9, 20], [9, 20], [10, 18], []],
                "info" => '{"en":"The store is located on the 1st floor of the «Mozaika» shopping center, pavilion K105. Parking is free on weekdays at the shopping center.","ru":"Магазин находится на 1 этаже торгового центра «Мозаика», павильон К105. На территории торгового центра по будним дням парковка бесплатная.","de":"Das Geschäft befindet sich im 1. Stock des Einkaufszentrums «Mozaika», Pavillon K105. Das Parken im Einkaufszentrum ist werktags kostenlos."}',
            ],
            [
                "name" => '{"en":"«Cheryomushki» shopping center","ru":"ТЦ «Черёмушки»","de":"Einkaufszentrum «Cheryomushki»"}',
                "address" => '{"en":"Profsoyuznaya st., 56, «Cheryomushki» shopping center","ru":"Профсоюзная ул., 56, ТЦ «Черёмушки»","de":"Profsoyuznaya Str., 56, Einkaufszentrum «Cheryomushki»"}',
                "location" => [55.67021, 37.55203],
                "opening_hours" => [[9, 20], [9, 20], [9, 20], [9, 20], [9, 20], [9, 20], [10, 18]],
                "info" => '{"en":"The store is located within walking distance from the Polezhaevskaya metro station, «Cheryomushki» shopping center, 3rd floor, pavilion 318.","ru":"Магазин находится в нескольких минутах ходьбы от станции метро Полежаевская, торговый центр «Черёмушки», 3 этаж, павильон 318.","de":"Das Geschäft befindet sich nur wenige Gehminuten von der U-Bahn-Station Polezhaevskaya, Einkaufszentrum «Cheryomushki», 3. Etage, Pavillon 318 entfernt."}',
            ],
        ];

        foreach ($records as $index => &$record) {
            $record['location'] = json_encode($record['location']);
            $record['opening_hours'] = json_encode($record['opening_hours']);
            $record['images'] = NULL;
            $record['sort'] = $index + 1;
            $record['is_active'] = true;
        }

        Shop::upsert($records, 'id');
    }
}
