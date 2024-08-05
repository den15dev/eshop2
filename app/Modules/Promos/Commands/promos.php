<?php

return [
    [
        'name' => json_encode([
            'ru' => 'Скидка до 10% на игровые видеокарты NVIDIA',
            'en' => 'Up to 10% off NVIDIA Gaming Graphics Cards',
            'de' => 'Bis zu 10 % Rabatt auf NVIDIA-Gaming-Grafikkarten',
        ], JSON_UNESCAPED_UNICODE),
        'slug' => str('Up to 10% off NVIDIA Gaming Graphics Cards')->slug()->value(),
        'starts_at' => now()->startOfMonth()->isoFormat('YYYY-MM-DD HH:mm:ss'),
        'ends_at' => now()->startOfMonth()->addMonths(4)->isoFormat('YYYY-MM-DD HH:mm:ss'),
        'description' => json_encode([
            'ru' => 'Графические процессоры NVIDIA GeForce RTX 40 обеспечивают невероятную скорость для игр и творчества. Они созданы на основе сверхэффективной архитектуры NVIDIA Ada Lovelace, которая обеспечивает качественный скачок как в производительности, так и в графических возможностях на базе ИИ. Погрузитесь в виртуальные миры с трассировкой лучей и сверхвысоким FPS с минимальной задержкой. Используйте новые возможности для творчества с беспрецедентным ускорением рабочего процесса.',
            'en' => 'NVIDIA GeForce RTX 40 Series GPUs are beyond fast for gamers and creators. They\'re powered by the ultra-efficient NVIDIA Ada Lovelace architecture which delivers a quantum leap in both performance and AI-powered graphics. Experience lifelike virtual worlds with ray tracing and ultra-high FPS gaming with the lowest latency. Discover revolutionary new ways to create and unprecedented workflow acceleration.',
            'de' => 'Die Grafikprozessoren der NVIDIA GeForce RTX 40-Serie sind mehr als schnell – für Gamer und Entwickler. Sie basieren auf der ultraeffizienten NVIDIA Ada Lovelace-Architektur, die sowohl bei Leistung als auch bei KI-gestützter Grafik einen Quantensprung ermöglicht. Erlebe realistische virtuelle Welten mit Raytracing und Ultra-High-FPS-Gaming mit extrem niedriger Latenz. Entdecke revolutionäre neue Möglichkeiten für die Erstellung und Beschleunigung von Workflows in nie dagewesenem Maße.',
        ], JSON_UNESCAPED_UNICODE),
    ],

    [
        'name' => json_encode([
            'ru' => 'Скидка до 5% на процессоры AMD Ryzen 5000',
            'en' => 'Up to 5% off AMD Ryzen 5000 processors',
            'de' => 'Bis zu 5 % Rabatt auf AMD Ryzen 5000-Prozessoren',
        ], JSON_UNESCAPED_UNICODE),
        'slug' => str('Up to 5% off AMD Ryzen 5000 processors')->slug()->value(),
        'starts_at' => now()->startOfMonth()->isoFormat('YYYY-MM-DD HH:mm:ss'),
        'ends_at' => now()->startOfMonth()->addMonths(3)->isoFormat('YYYY-MM-DD HH:mm:ss'),
        'description' => json_encode([
            'ru' => 'Только процессоры AMD Ryzen оснащены моделями с эксклюзивной технологией AMD 3D V-Cache, позволяющей значительно повысить производительность в играх. AMD сочетает в себе свои топовые процессоры серии Ryzen 7000X3D с колоссальной встроенной памятью объемом до 144 МБ в сочетании с самыми совершенными процессорными ядрами, которые только можно найти в игровом ПК, чтобы энтузиасты могли использовать возможности максимальной производительности для игр и творчества. в одном чипе. С процессорами AMD Ryzen никакая рабочая нагрузка не является запретной.',
            'en' => 'Only AMD Ryzen processors feature models with exclusive AMD 3D V-Cache technology for a massive gaming performance boost. AMD combines its top-end Ryzen 7000X3D series processors, with up to a colossal 144MB of on-chip memory, paired with the most advanced processor cores you can get in a gaming PC so enthusiasts can harness the power of the ultimate gaming and creator performance in one chip. No workload is off limits with AMD Ryzen processors.',
            'de' => 'Nur AMD Ryzen Prozessoren bieten Modelle mit exklusiver AMD 3D V-Cache Technologie für eine massive Performance-Steigerung. AMD kombiniert seine Ryzen 7000X3D-Serie Spitzenprozessoren mit einem riesigen On-Chip-Speicher mit 144 MB und den fortschrittlichsten Prozessorkernen, die für einen Gaming-PC verfügbar sind, damit Enthusiasten ultimatives Gaming und Creator-Performance in einem einzigen Chip nutzen können. Mit AMD Ryzen Prozessoren ist keine Auslastung mehr zu hoch.',
        ], JSON_UNESCAPED_UNICODE),
    ],

    [
        'name' => json_encode([
            'ru' => 'Скидка до 7% на процессоры Intel 13-го поколения',
            'en' => 'Up to 7% off Intel 13-Series Processors',
            'de' => 'Bis zu 7 % Rabatt auf Intel-Prozessoren der 13er-Serie',
        ], JSON_UNESCAPED_UNICODE),
        'slug' => str('Up to 7% off Intel 13-Series Processors')->slug()->value(),
        'starts_at' => now()->startOfMonth()->isoFormat('YYYY-MM-DD HH:mm:ss'),
        'ends_at' => now()->startOfMonth()->addMonths(3)->isoFormat('YYYY-MM-DD HH:mm:ss'),
        'description' => json_encode([
            'ru' => 'Процессоры Intel Core 13-го поколения развивают гибридную архитектуру производительности с поддержкой до восьми высокопроизводительных ядер (P-ядро) и до 16 эффективных ядер (E-ядро) в сочетании с рабочими нагрузками, интеллектуально маршрутизируемыми Intel Thread Director. Создан для геймеров, которым нужна максимальная производительность для новейших игр, а также возможность справляться с другими рабочими нагрузками. Новые ПК на базе процессоров Intel Core 13-го поколения делают все это возможным.',
            'en' => '13th Gen Intel Core processors advances performance hybrid architecture with up to eight Performance-cores (P-core) and up to 16 Efficient-cores (E-core), combined with workloads intelligently routed by Intel Thread Director. Built for gamers looking for maximum performance to play the latest games, while also having the capabilities to tackle other workloads. New 13th Gen Intel Core processor-based PCs make it all possible.',
            'de' => 'Mit einer Erhöhung der Kernanzahl verwenden diese Prozessoren weiterhin Intels leistungsfähige Hybridarchitektur, um Ihre Spiele, die Content-Gestaltung und Produktivität zu optimieren. Nutzen Sie die branchenführende Bandbreite von bis zu 16 PCIe 5.0 Lanes und DDR5 Arbeitsspeicher bis zu 5600 MT/s. Erhöhen Sie die Leistung Ihrer CPU mit einer leistungsstarken Suite an Tuning- und Übertaktungswerkzeugen. Genießen Sie Ihre Lieblingserlebnisse auf bis zu 4 gleichzeitigen 4K60-Displays oder bis zu 8K60 HDR-Video mit dynamischer Geräuschunterdrückung.',
        ], JSON_UNESCAPED_UNICODE),
    ],
];
