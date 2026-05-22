@extends('admin.layouts.app')
@section('pagetitle', 'Researcher | Kulvriksh')
@section('admin-content')
    @php
        $lang = $report->translated_language ?? 'en';
        $top_tagline = 'Padma Purana';
        // Language arrays for labels
        $labels = [
            'en' => [
                'kulvriksh_id' => 'Kulvriksh ID',
                'lineage' => 'Lineage',
                'cast' => 'Cast',
                'subspecies' => 'SubCaste',
                'surname' => 'Surname',
                'credit' => 'Branch',
                'gotra' => 'Gotra',
                'pravar' => 'Pravar',
                'vedas' => 'Vedas',
                'upaveda' => 'Upaveda',
                'branch' => 'Shakha',
                'peak' => 'Sikha',
                'formula' => 'Sutra',
                'gotra_devi' => 'Gotra Devi',
                'ishta_devi' => 'Ishta Devi',
                'ishtadev' => 'Ishtadev',
                'kuldevi' => 'Kuldevi',
                'kuladevata' => 'Kuladevata',
                'supportive_mother' => 'Sahayak Dev',
                'river' => 'River',
                'ancestor_shrine' => 'Ancestor Shrine',
                'tirth_purohit' => 'Tirth Purohit',
                'original_location' => 'Original Location',
                'kuldevi_dosh' => 'Kuldevi dosh',
                'patriarchy' => 'Pitru Dosh',
                'download_report' => 'Download Report',
            ],
            'hi' => [
                'kulvriksh_id' => 'कुलवृक्ष आईडी',
                'lineage' => 'वंश',
                'cast' => 'जाति',
                'subspecies' => 'उपजाति',
                'surname' => 'उपनाम',
                'credit' => 'शाख',
                'gotra' => 'गोत्र',
                'pravar' => 'प्रवर',
                'vedas' => 'वेद',
                'upaveda' => 'उपवेद',
                'branch' => 'शाखा',
                'peak' => 'शिखा',
                'formula' => 'सूत्र',
                'gotra_devi' => 'गोत्र देवी',
                'ishta_devi' => 'इष्ट देवी',
                'ishtadev' => 'इष्टदेव',
                'kuldevi' => 'कुलदेवी',
                'kuladevata' => 'कुलदेवता',
                'supportive_mother' => 'सहायक देव',
                'river' => 'नदी',
                'ancestor_shrine' => 'पूर्वज तीर्थ',
                'tirth_purohit' => 'तीर्थ पुरोहित',
                'original_location' => 'मूल स्थान',
                'kuldevi_dosh' => 'कुलदेवी दोष',
                'patriarchy' => 'पितृ दोष',
                'download_report' => 'रिपोर्ट डाउनलोड करें',
            ],
            'gu' => [
                'kulvriksh_id' => 'કુલવૃક્ષ આઈડી',
                'lineage' => 'વંશ',
                'cast' => 'જાતિ',
                'subspecies' => 'ઉપજાતિ',
                'surname' => 'ઉપનામ',
                'credit' => 'શાખ',
                'gotra' => 'ગોત્ર',
                'pravar' => 'પ્રવર',
                'vedas' => 'વેદ',
                'upaveda' => 'ઉપવેદ',
                'branch' => 'શાખા',
                'peak' => 'શિખા',
                'formula' => 'સૂત્ર',
                'gotra_devi' => 'ગોત્ર દેવી',
                'ishta_devi' => 'ઇષ્ટ દેવી',
                'ishtadev' => 'ઇષ્ટદેવ',
                'kuldevi' => 'કુલદેવી',
                'kuladevata' => 'કુલદેવતા',
                'supportive_mother' => 'સહાયક દેવ',
                'river' => 'નદી',
                'ancestor_shrine' => 'પૂર્વજ મંદિર',
                'tirth_purohit' => 'તીર્થ પુરોહિત',
                'original_location' => 'મૂળ સ્થાન',
                'kuldevi_dosh' => 'કુલદેવી દોષ',
                'patriarchy' => 'પિતૃ દોષ',
                'download_report' => 'રિપોર્ટ ડાઉનલોડ કરો',
            ],
        ];

        // Get current language labels
        $currentLabels = $labels[$lang] ?? $labels['en'];

        // Translate data values if language is not English
        $originalLang = 'en'; // Assuming original data is in English
        if ($lang !== 'en') {
            $report->lineage = translateText($report->lineage ?? '', $originalLang, $lang);
            $report->caste = translateText($report->caste ?? '', $originalLang, $lang);
            $report->subspecies = translateText($report->subspecies ?? '', $originalLang, $lang);
            $report->surname = translateText($report->surname ?? '', $originalLang, $lang);
            $report->credit = translateText($report->credit ?? '', $originalLang, $lang);
            $report->gotra = translateText($report->gotra ?? '', $originalLang, $lang);
            $report->pravar = translateText($report->pravar ?? '', $originalLang, $lang);
            $report->vedas = translateText($report->vedas ?? '', $originalLang, $lang);
            $report->upaveda = translateText($report->upaveda ?? '', $originalLang, $lang);
            $report->branch = translateText($report->branch ?? '', $originalLang, $lang);
            $report->peak = translateText($report->peak ?? '', $originalLang, $lang);
            $report->formula = translateText($report->formula ?? '', $originalLang, $lang);
            $report->gotra_devi = translateText($report->gotra_devi ?? '', $originalLang, $lang);
            $report->ishta_devi = translateText($report->ishta_devi ?? '', $originalLang, $lang);
            $report->ishtadev = translateText($report->ishtadev ?? '', $originalLang, $lang);
            $report->kuldevi = translateText($report->kuldevi ?? '', $originalLang, $lang);
            $report->kuldevata = translateText($report->kuldevata ?? '', $originalLang, $lang);
            $report->supportive_mother = translateText($report->supportive_mother ?? '', $originalLang, $lang);
            $report->river = translateText($report->river ?? '', $originalLang, $lang);
            $report->ancestor_shrine = translateText($report->ancestor_shrine ?? '', $originalLang, $lang);
            $report->tirth_purohit = translateText($report->tirth_purohit ?? '', $originalLang, $lang);
            $report->original_location = translateText($report->original_location ?? '', $originalLang, $lang);
            $report->kuldevi_dash = translateText($report->kuldevi_dash ?? '', $originalLang, $lang);
            $report->patriarchy = translateText($report->patriarchy ?? '', $originalLang, $lang);
            $report->name = translateText($report->name ?? '', $originalLang, $lang);
            $report->top_tagline = translateText($report->top_tagline ?? $top_tagline, $originalLang, $lang);
            $report->kul_tagline = translateText($report->kul_tagline ?? '', $originalLang, $lang);
            $report->title = translateText($report->title ?? '', $originalLang, $lang);
            $report->description = translateText($report->description ?? '', $originalLang, $lang);
        }
    @endphp
    <style>
        body {
            font-family: "Outfit", sans-serif;
            background-color: #f7f3ed;
            margin: 0;
        }

        .card {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            position: relative;
            max-width: 600px;
            margin: auto;
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-image: url({{ asset('assets/admin/images/bg.png') }});

        }

        .main-border {
            position: relative;
            padding: 20px;
            border: 2px solid #DE6C27;
            height: 748px;
        }

        /* .main-border::before,
                            .main-border::after {
                                content: '';
                                position: absolute;
                                left: 50%;
                                transform: translateX(-50%);
                                background-repeat: no-repeat;
                                width: 70px;
                                height: 30px;
                                background-image: url({{ asset('assets/admin/images/vector-bg.png') }});
                            }

                            .main-border::before {
                                top: -15px;
                            }

                            .main-border::after {
                                bottom: -15px;
                                background-image: url({{ asset('assets/admin/images/vector-bg-1.png') }});
                            } */

        .header {
            position: relative;
            display: flex;
            margin-bottom: 10px;
            justify-content: center;
            gap: 15px;
            width: 100%;
            align-items: center;
        }

        .header img.logo {
            position: relative;
            max-width: 140px;
            background-color: #fff;
            border-radius: 7px;
            padding: 8px;
            mix-blend-mode: multiply;
        }

        .kulvriksh-idbox {
            position: relative;
            background: #DE6C27;
            color: #fff;
            padding: 10px 13px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            display: inline-block;
        }

        .title {
            position: relative;
            text-align: center;
            line-height: normal;
            font-size: 18px;
            font-weight: 600;
            color: #DE6C27;
        }

        .quote {
            position: relative;
            font-size: 14px;
            font-weight: 530;
            line-height: normal;
            text-align: justify;
            color: #D1232A;
            margin: 10px 0;
        }

        .quote span {
            display: block;
            margin: 10px 0px;
            font-weight: bold;
            text-align: center !important;
        }

        .main-image {
            position: relative;
            text-align: center;
            margin: auto;
            margin-bottom: 10px;
            max-width: 155px;
        }

        .main-image img {
            position: relative;
            width: auto;
            min-height: 200px;
            max-height: 200px;
            object-fit: cover;
            border: 5px solid #fff;
            margin: 0;
        }

        .highlight-box {
            position: relative;
            font-size: 16px;
            font-weight: 600;
            line-height: normal;
            text-align: center;
            color: #fff;
            background: #DE6C27;
            padding: 10px 15px;
            border-radius: 7px;
            max-width: 400px;
            margin: auto;
            margin-bottom: 10px;
        }

        .info-section {
            position: relative;
            /* display: flex; */
            justify-content: space-between;
            /* gap: 20px; */
            margin-bottom: 15px;
        }

        .info-box {
            position: relative;
            width: 100%;
            padding: 5px 10px;
            border-radius: 5px;
            border: 2px solid #DE6C27;
        }

        table {
            position: relative;
            width: 100%;
        }

        .info-box table td {
            position: relative;
            font-size: 14px;
            font-weight: 400;
            line-height: normal;
            color: #D1232A;
            margin: 5px 0px;
        }

        .info-box table td span {
            font-weight: 600;
            color: #DE6C27;
        }

        .watermark-bg {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80%;
            opacity: .2;
        }

        .watermark-bg img {
            width: 100%;
        }

        .sub-title {
            position: relative;
            text-align: center;
            line-height: normal;
            font-size: 16px;
            font-weight: 600;
            color: #DE6C27;
            text-decoration: underline;
            padding: 10px 0;
        }

        .top-fixedbox {
            position: relative;
            text-align: center;
        }

        .top-fixedbox p {
            position: relative;
            font-size: 16px;
            font-weight: 500;
            line-height: normal;
            color: #D1232A;
            margin-bottom: 10px;
        }

        .logo-bottom {
            position: absolute;
            bottom: 0;
            margin-bottom: 5px;
            left: 50%;
            max-width: 140px;
            transform: translateX(-50%);
        }
    </style>

    <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
        <div class="flex-grow-1">
            <a href="{{ url('admin/research-reports/view/' . request()->id) }}" class="btn btn-outline-dark"> <i class="ri-arrow-left-line"></i> Back to Researcher Report</a>

        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="watermark-bg"><img src="{{ asset('assets/admin/images/watermark.png') }}" alt="kulvriksh-bg"></div>
                <div class="main-border">
                    <div class="header">
                        {{-- <img src="{{ asset('assets/admin/images/logo-bg.png') }}" alt="logo" class="logo"> --}}
                        <div class="kulvriksh-idbox text-center">{{ $currentLabels['kulvriksh_id'] }} - {{ $report->client->kulvrisk_id ?? '' }}</div>
                    </div>

                    <div class="top-fixedbox">
                        <p><strong>
                                काहं कोऽहं कुलं किंमे सम्बन्धः कीदृशोमम । <br>
                                स्वस्व धर्मो न लुप्येत तोंचं चिन्तयेद बुधः ।।</strong>
                        </p>
                        <p>
                            मैं कौन किस जाति का हूँ, मेरा कुल वंश क्या है, किससे मेरा सम्बन्ध है। <br>
                            अपने अपने कुलवंश धर्म लुप्त न होवे, ऐसा विचार करें।
                        </p>
                    </div>

                    {{-- <div class="title">{{ $report->name ?? '' }}</div> --}}
                    <div class="quote"><span>|| पद्मपुराण ||</span>
                        <div class="text-center highlight-box">{{ $report->top_tagline ?? '' }}</div>
                    </div>
                    <div class="main-image">
                        <img src="{{ asset($report->image ?? '') }}" onerror="this.onerror=null; this.src='{{ asset('assets/admin/images/devi.png') }}';" alt="img">
                    </div>
                    <div class="highlight-box">
                        {{ $report->kul_tagline ?? '' }}
                    </div>
                    <div class="d-flex justify-content-between gap-1">
                        <div class="info-box grid-col-2">
                            <table>
                                @if ($report->lineage)
                                    <tr>
                                        <td><span>{{ $currentLabels['lineage'] }}:</span></td>
                                        <td>{{ $report->lineage ?? '' }}</td>
                                    </tr>
                                @endif
                                @if ($report->caste)
                                    <tr>
                                        <td><span>{{ $currentLabels['cast'] }}:</span></td>
                                        <td>{{ $report->caste ?? '' }}</td>
                                    </tr>
                                @endif
                                @if ($report->subspecies)
                                    <tr>
                                        <td><span>{{ $currentLabels['subspecies'] }}:</span></td>
                                        <td>{{ $report->subspecies ?? '' }}</td>
                                    </tr>
                                @endif
                                @if ($report->surname)
                                    <tr>
                                        <td><span>{{ $currentLabels['surname'] }}:</span></td>
                                        <td>{{ $report->surname ?? '' }}</td>
                                    </tr>
                                @endif
                                @if ($report->credit)
                                    <tr>
                                        <td><span>{{ $currentLabels['credit'] }}:</span></td>
                                        <td>{{ $report->credit ?? '' }}</td>
                                    </tr>
                                @endif
                                @if ($report->gotra)
                                    <tr>
                                        <td><span>{{ $currentLabels['gotra'] }}:</span></td>
                                        <td>{{ $report->gotra ?? '' }}</td>
                                    </tr>
                                @endif
                                @if ($report->pravar)
                                    <tr>
                                        <td><span>{{ $currentLabels['pravar'] }}:</span></td>
                                        <td>{{ $report->pravar ?? '' }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                        <div class="info-box grid-col-2">
                            <table>
                                @if ($report->vedas)
                                    <tr>
                                        <td><span>{{ $currentLabels['vedas'] }}:</span></td>
                                        <td>{{ $report->vedas ?? '' }}</td>
                                    </tr>
                                @endif
                                @if ($report->upaveda)
                                    <tr>
                                        <td><span>{{ $currentLabels['upaveda'] }}:</span></td>
                                        <td>{{ $report->upaveda ?? '' }}</td>
                                    </tr>
                                @endif
                                @if ($report->branch)
                                    <tr>
                                        <td><span>{{ $currentLabels['branch'] }}:</span></td>
                                        <td>{{ $report->branch ?? '' }}</td>
                                    </tr>
                                @endif
                                @if ($report->peak)
                                    <tr>
                                        <td><span>{{ $currentLabels['peak'] }}:</span></td>
                                        <td>{{ $report->peak ?? '-' }}</td>
                                    </tr>
                                @endif
                                @if ($report->formula)
                                    <tr>
                                        <td><span>{{ $currentLabels['formula'] }}:</span></td>
                                        <td>{{ $report->formula ?? '-' }}</td>
                                    </tr>
                                @endif
                                @if ($report->gotra_devi)
                                    <tr>
                                        <td><span>{{ $currentLabels['gotra_devi'] }}:</span></td>
                                        <td>{{ $report->gotra_devi ?? '' }}</td>
                                    </tr>
                                @endif
                                @if ($report->ishta_devi)
                                    <tr>
                                        <td><span>{{ $currentLabels['ishta_devi'] }}:</span></td>
                                        <td>{{ $report->ishta_devi ?? '' }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                        <img src="{{ asset('assets/admin/images/logo-bg.png') }}" alt="logo" class="logo-bottom">
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="watermark-bg"><img src="{{ asset('assets/admin/images/watermark.png') }}" alt="kulvriksh-bg"></div>
                <div class="main-border">
                    <div class="info-section">
                        <div class="header">
                            <div class="kulvriksh-idbox">{{ $currentLabels['kulvriksh_id'] }} - {{ $report->client->kulvrisk_id ?? '' }}</div>
                        </div>
                        <div class="info-box mb-2">
                            <table>
                                @if ($report->ishtadev)
                                    <tr>
                                        <td><span>{{ $currentLabels['ishtadev'] }}:</span></td>
                                        <td>{{ $report->ishtadev ?? '-' }}</td>
                                    </tr>
                                @endif
                                @if ($report->kuldevi)
                                    <tr>
                                        <td><span>{{ $currentLabels['kuldevi'] }}:</span></td>
                                        <td>{{ $report->kuldevi ?? '' }}</td>
                                    </tr>
                                @endif
                                @if ($report->kuldevata)
                                    <tr>
                                        <td><span>{{ $currentLabels['kuladevata'] }}:</span></td>
                                        <td>{{ $report->kuldevata ?? '-' }}</td>
                                    </tr>
                                @endif
                                @if ($report->supportive_mother)
                                    <tr>
                                        <td><span>{{ $currentLabels['supportive_mother'] }}:</span></td>
                                        <td>{{ $report->supportive_mother ?? '' }}</td>
                                    </tr>
                                @endif
                                @if ($report->river)
                                    <tr>
                                        <td><span>{{ $currentLabels['river'] }}:</span></td>
                                        <td>{{ $report->river ?? '' }}</td>
                                    </tr>
                                @endif
                                @if ($report->ancestor_shrine)
                                    <tr>
                                        <td><span>{{ $currentLabels['ancestor_shrine'] }}:</span></td>
                                        <td>{{ $report->ancestor_shrine ?? '' }}</td>
                                    </tr>
                                @endif
                                @if ($report->tirth_purohit)
                                    <tr>
                                        <td><span>{{ $currentLabels['tirth_purohit'] }}:</span></td>
                                        <td>{{ $report->tirth_purohit ?? '-' }}</td>
                                    </tr>
                                @endif
                                @if ($report->original_location)
                                    <tr>
                                        <td><span>{{ $currentLabels['original_location'] }}:</span></td>
                                        <td>{{ $report->original_location ?? '' }}</td>
                                    </tr>
                                @endif
                                @if ($report->kuldevi_dash)
                                    <tr>
                                        <td><span>{{ $currentLabels['kuldevi_dosh'] }}:</span></td>
                                        <td>{{ $report->kuldevi_dash ?? '-' }}</td>
                                    </tr>
                                @endif
                                @if ($report->patriarchy)
                                    <tr>
                                        <td><span>{{ $currentLabels['patriarchy'] }}:</span></td>
                                        <td>{{ $report->patriarchy ?? '-' }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>

                        <div class="highlight-box">{{ $report->title }}</div>
                        @php
                            $description = $report->description ?? '';
                            $firstChunkSize = 2100;
                            $subsequentChunkSize = 3500;

                            // Get first chunk
                            $firstChunk = substr($description, 0, $firstChunkSize);

                            // Get remaining text
                            $remainingText = substr($description, $firstChunkSize);

                            // Split remaining text into chunks of 4500
                            $remainingChunks = str_split($remainingText, $subsequentChunkSize);

                            // Combine first chunk with remaining chunks
                            $chunks = array_merge([$firstChunk], $remainingChunks);
                        @endphp

                        <div class="quote">{{ $chunks[0] ?? '' }}</div>

                    </div>
                    <img src="{{ asset('assets/admin/images/logo-bg.png') }}" alt="logo" class="logo-bottom">

                    @if (!(count($chunks) > 1) && !($report->history_title || $report->history_description) && !($report->title || $report->description))
                        <img src="{{ asset('assets/admin/images/logo-bg.png') }}" alt="logo" class="logo-bottom">
                    @endif
                </div>
            </div>

            @if (count($chunks) > 1)
                @for ($i = 1; $i < count($chunks); $i++)
                    <div class="card mt-3">
                        <div class="watermark-bg"><img src="{{ asset('assets/admin/images/watermark.png') }}" alt="kulvriksh-bg"></div>
                        <div class="main-border">
                            <div class="info-section">
                                <div class="header">
                                    <div class="kulvriksh-idbox">{{ $currentLabels['kulvriksh_id'] }} - {{ $report->client->kulvrisk_id ?? '' }}</div>
                                </div>
                                <div class="quote text-justify">{{ $chunks[$i] }}</div>
                            </div>
                            @if ($i == count($chunks) - 1 && !($report->history_title || $report->history_description))
                                <img src="{{ asset('assets/admin/images/logo-bg.png') }}" alt="logo" class="logo-bottom">
                            @endif
                        </div>
                    </div>
                @endfor
            @endif

            {{-- add hostory title disscription --}}
            @php
                $historyDescription = $report->history_description ?? '';
                $firstChunkSize = 3000;
                $subsequentChunkSize = 3000;

                // Get first chunk
                $firstChunk = substr($historyDescription, 0, $firstChunkSize);

                // Get remaining text
                $remainingText = substr($historyDescription, $firstChunkSize);

                // Split remaining text into chunks of 4500
                $remainingChunks = str_split($remainingText, $subsequentChunkSize);

                // Combine first chunk with remaining chunks
                $chunksHistroy = array_merge([$firstChunk], $remainingChunks);
            @endphp

            @if ($report->history_description || $report->history_title)
                <div class="card mt-3">
                    <div class="watermark-bg"><img src="{{ asset('assets/admin/images/watermark.png') }}" alt="kulvriksh-bg"></div>
                    <div class="main-border">
                        <div class="info-section">
                            <div class="header">
                                <div class="kulvriksh-idbox">{{ $currentLabels['kulvriksh_id'] }} - {{ $report->client->kulvrisk_id ?? '' }}</div>
                            </div>
                            <div class="highlight-box">{{ $report->history_title }}</div>
                            <div class="quote">{{ $chunksHistroy[0] ?? '' }}</div>
                        </div>
                        @if (!(count($chunksHistroy) > 1))
                            <img src="{{ asset('assets/admin/images/logo-bg.png') }}" alt="logo" class="logo-bottom">
                        @endif
                    </div>
                </div>
            @endif

            @if (count($chunksHistroy) > 1)
                @for ($i = 1; $i < count($chunksHistroy); $i++)
                    <div class="card mt-3">
                        <div class="watermark-bg"><img src="{{ asset('assets/admin/images/watermark.png') }}" alt="kulvriksh-bg"></div>

                        <div class="main-border">
                            <div class="info-section">
                                <div class="header">
                                    <div class="kulvriksh-idbox">{{ $currentLabels['kulvriksh_id'] }} - {{ $report->client->kulvrisk_id ?? '' }}</div>
                                </div>
                                <div class="quote text-justify">{{ $chunksHistroy[$i] }}</div>
                            </div>
                            @if ($i == count($chunksHistroy) - 1)
                                <img src="{{ asset('assets/admin/images/logo-bg.png') }}" alt="logo" class="logo-bottom">
                            @endif
                        </div>
                    </div>
                @endfor
            @endif

        </div>
    </div>

    <!-- Add download button -->
    <div class="text-center mt-3 mb-4">
        <button id="downloadBtn" class="btn btn-primary">{{ $currentLabels['download_report'] }}</button>
    </div>

    <!-- Include html2canvas and jsPDF libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
        document.getElementById('downloadBtn').addEventListener('click', function() {
            // Get all cards
            const cards = document.querySelectorAll('.card');

            // Create a new jsPDF instance
            const {
                jsPDF
            } = window.jspdf;
            const pdf = new jsPDF('p', 'mm', 'a4');

            // Process each card
            const processCard = (index) => {
                if (index >= cards.length) {
                    // All cards processed, save the PDF
                    pdf.save('kulvriksh-report.pdf');
                    return;
                }

                const card = cards[index];
                html2canvas(card, {
                    scale: 2,
                    useCORS: true,
                    logging: false,
                    allowTaint: true,
                    windowWidth: card.scrollWidth,
                    windowHeight: card.scrollHeight
                }).then(canvas => {
                    const imgData = canvas.toDataURL('image/png');

                    // Add new page for each card except the first one
                    if (index > 0) {
                        pdf.addPage();
                    }

                    // Calculate dimensions to fit the page
                    const imgWidth = 210; // A4 width in mm
                    const imgHeight = (canvas.height * imgWidth) / canvas.width;

                    // Add the image to the PDF
                    pdf.addImage(imgData, 'PNG', 0, 0, imgWidth, imgHeight);

                    // Process next card
                    processCard(index + 1);
                });
            };

            // Start processing from the first card
            processCard(0);
        });
    </script>

@endsection
