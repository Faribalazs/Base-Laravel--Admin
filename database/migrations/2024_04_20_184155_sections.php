<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('page');
            $table->string('section_name');
            $table->json('title')->nullable();
            $table->json('content')->nullable();
            $table->json('btn_text')->nullable();
            $table->json('btn_link')->nullable();
            $table->integer('section_number')->nullable();
            $table->integer('order')->nullable();
            $table->boolean('status')->nullable();
            $table->timestamps();
        });

        DB::table('sections')->insert([
            [
                'page' => 'home',
                'section_name' => 'main-image-section',
                'title' => json_encode([
                    'sr' => 'Alat dobrog majstora',
                    'rs-cyrl' => 'Алат доброг мајстора',
                ]),
                'content' => json_encode([
                    'sr' => 'Pored svog svakodnevnog posla ne stižeš da se baviš papirologijom – izradom PONUDA. Portal PONUDA MAJSTORA predstavlja rešenje ovog problema. Kreiraj PONUDU na svom TELEFONU ili RAČUNARU. Za svega nekoliko minuta, ponuda će stići INVESTITORU.',
                    'rs-cyrl' => 'Поред свог свакодневног посла не стижеш да се бавиш папирологијом – израдом ПОНУДА. Портал ПОНУДА МАЈСТОРА представља решење овог проблема. Креирај ПОНУДУ на свом ТЕЛЕФОНУ или РАЧУНАРУ. За свега неколико минута, понуда ће стићи ИНВЕСТИТОРУ.',
                ]),
                'btn_text' => json_encode([
                    'sr' => 'Button text',
                    'rs-cyrl' => 'Button text',
                ]),
                'btn_link' => json_encode([
                    'sr' => '#',
                    'rs-cyrl' => '#',
                ]),
                'section_number' => 1,
                'order' => 1,
                'status' => true,
            ],
            [
                'page' => 'slider',
                'section_name' => 'slider-one',
                'title' => json_encode([
                    'sr' => 'Premeravanje objekta i sređivanje podataka',
                    'rs-cyrl' => 'Премеравање објекта и сређивање података',
                ]),
                'content' => json_encode([
                    'sr' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi Lorem ipsum dolor',
                    'rs-cyrl' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi Lorem ipsum dolor',
                ]),
                'btn_text' => null,
                'btn_link' => null,
                'section_number' => 2,
                'order' => 1,
                'status' => true,
            ],
            [
                'page' => 'slider',
                'section_name' => 'slider-two',
                'title' => json_encode([
                    'sr' => 'Unošenje podataka na portal PONUDA MAJSTORA i generisanje PONUDE',
                    'rs-cyrl' => 'Уношење података на портал ПОНУДА МАЈСТОРА и генерисање ПОНУДЕ',
                ]),
                'content' => json_encode([
                    'sr' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi Lorem ipsum dolor',
                    'rs-cyrl' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi Lorem ipsum dolor',
                ]),
                'btn_text' => null,
                'btn_link' => null,
                'section_number' => 2,
                'order' => 2,
                'status' => true,
            ],
            [
                'page' => 'slider',
                'section_name' => 'slider-three',
                'title' => json_encode([
                    'sr' => 'Automatsko slanje PONUDE na klijentov e-mail',
                    'rs-cyrl' => 'Аутоматско слање ПОНУДЕ на клијентов е-маил',
                ]),
                'content' => json_encode([
                    'sr' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi Lorem ipsum dolor',
                    'rs-cyrl' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi Lorem ipsum dolor',
                ]),
                'btn_text' => null,
                'btn_link' => null,
                'section_number' => 2,
                'order' => 3,
                'status' => true,
            ],
            [
                'page' => 'slider',
                'section_name' => 'slider-four',
                'title' => json_encode([
                    'sr' => 'Dogovor o izvođenju radova',
                    'rs-cyrl' => 'Договор о извођењу радова',
                ]),
                'content' => json_encode([
                    'sr' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi Lorem ipsum dolor',
                    'rs-cyrl' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi Lorem ipsum dolor',
                ]),
                'btn_text' => null,
                'btn_link' => null,
                'section_number' => 2,
                'order' => 4,
                'status' => true,
            ],
            [
                'page' => 'home',
                'section_name' => 'after-slider-section',
                'title' => json_encode([
                    'sr' => 'Završni tekst',
                    'rs-cyrl' => 'Завршни текст',
                ]),
                'content' => json_encode([
                    'sr' => '<p class="home-section-des">
                                Portal PONUDA MAJSTORA je namenjen MAJSTORIMA – PREDUZETNICIMA koji žele da svoje vreme na izradama PONUDA svedu na minimalan nivo, a da pri tome njihove PONUDE budu izrađene po najvišim TEHNIČKIM i PRAVNO – FORMALNIM pravilima struke.
                             </p>
                             <p class="home-section-des">
                                Uz pomoć portala PONUDA MAJSTORA,  MAJSTOR – PREDUZETNIK svoje slobodno vreme više neće morati trošiti na bavljenje „papirologijom“, nego na neophodan odmor i relaksaciju u krugu porodice i prijatelja.
                             </p>
                             <p class="home-section-des">
                                Izrada dokumenata je toliko pojednostavljena, da se PONUDA može napraviti uz upotrebu mobilnog telefona ili računara, za vreme pauze za doručak ili kafu.
                             </p>
                             <p class="home-section-des">
                                Slanje PONUDE investitoru se obavlja automatski na e-mail.
                             </p>
                             <p class="home-section-des">
                                Ukoliko je potrebno, uz PONUDU moguće je automatski napraviti i odgovarajući UGOVOR za izvođenje radova.
                             </p>
                             <p class="home-section-des">
                                Kreiranjem platforme „PONUDA MAJSTORA“ želeli smo da MAJSTORE – PREDUZETNIKE rasteretimo nepotrebnog gubitka i onako kratkog slobodnog vremena i da im omogućimo da se bave samo onim poslom koji spada u njihovu osnovnu delatnost.
                             </p>
                             <p class="home-section-des">
                                Administrativni deo posla će umesto njih uraditi platforma „PONUDA MAJSTORA“.
                             </p>'
                        ,
                    'rs-cyrl' => '
                            <p class="home-section-des">
                                Портал ПОНУДА МАЈСТОРА је намењен МАЈСТОРИМА – ПРЕДУЗЕТНИЦИМА који желе да своје време на израдама ПОНУДА сведу на минималан ниво, а да при томе њихове ПОНУДЕ буду израђене по највишим ТЕХНИЧКИМ и ПРАВНО – ФОРМАЛНИМ правилима струке.
                            </p>
                            <p class="home-section-des">
                                Уз помоћ портала ПОНУДА МАЈСТОРА,  МАЈСТОР – ПРЕДУЗЕТНИК своје слободно време више неће морати трошити на бављење „папирологијом“, него на неопходан одмор и релаксацију у кругу породице и пријатеља.
                            </p>
                            <p class="home-section-des">
                                Израда докумената је толико поједностављена, да се ПОНУДА може направити уз употребу мобилног телефона или рачунара, за време паузе за доручак или кафу.
                            </p>
                            <p class="home-section-des">
                                Слање ПОНУДЕ инвеститору се обавља аутоматски на е-маил.
                            </p>
                            <p class="home-section-des">
                                Уколико је потребно, уз ПОНУДУ могуће је аутоматски направити и одговарајући УГОВОР за извођење радова.
                            </p>
                            <p class="home-section-des">
                                Креирањем платформе „ПОНУДА МАЈСТОРА“ желели смо да МАЈСТОРЕ – ПРЕДУЗЕТНИКЕ растеретимо непотребног губитка и онако кратког слободног времена и да им омогућимо да се баве само оним послом који спада у њихову основну делатност.
                            </p>
                            <p class="home-section-des">
                                Административни део посла ће уместо њих урадити платформа „ПОНУДА МАЈСТОРА“.
                            </p>',
                    ]),
                'btn_text' => null,
                'btn_link' => null,
                'section_number' => 3,
                'order' => 1,
                'status' => true,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};
