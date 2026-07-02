<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\Lead\StoreLeadRequest;
use App\Models\Lead;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LeadFormController extends Controller
{
    /**
     * Создание новой заявки из публичной формы (модалка).
     */
    public function store(StoreLeadRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Если пришёл product_id — сохраняем связь
        if ($request->filled('product_id')) {
            $data['product_id'] = (int) $request->product_id;
        }

        // interested_products приходит как массив ID или как строка
        if (is_array($data['interested_products'] ?? null)) {
            $data['interested_products'] = array_map('intval', $data['interested_products']);
        } else {
            $data['interested_products'] = null;
        }

        $lead = Lead::create(array_merge($data, [
            'status' => Lead::STATUS_NEW,
        ]));

        // Здесь можно отправить уведомление админу (mail/telegram/slack)
        // event(new LeadCreated($lead));

        return response()->json([
            'success' => true,
            'message' => 'Заявка успешно отправлена. Мы свяжемся с вами в ближайшее время.',
            'lead_id' => $lead->id,
        ], 201);
    }

    public function cities(Request $request): JsonResponse
    {
        // Полный список городов (может храниться в БД, конфиге или отдельном файле)
        $allCities = [
            // Россия (топ-50)
            'Москва', 'Санкт-Петербург', 'Новосибирск', 'Екатеринбург', 'Казань',
            'Нижний Новгород', 'Челябинск', 'Самара', 'Омск', 'Ростов-на-Дону',
            'Уфа', 'Красноярск', 'Воронеж', 'Пермь', 'Волгоград',
            'Краснодар', 'Саратов', 'Тюмень', 'Тольятти', 'Ижевск',
            'Барнаул', 'Ульяновск', 'Иркутск', 'Хабаровск', 'Ярославль',
            'Владивосток', 'Махачкала', 'Томск', 'Оренбург', 'Кемерово',
            'Новокузнецк', 'Рязань', 'Астрахань', 'Набережные Челны', 'Пенза',
            'Липецк', 'Киров', 'Тула', 'Чебоксары', 'Калининград',
            'Брянск', 'Курск', 'Иваново', 'Магнитогорск', 'Улан-Удэ',
            'Тверь', 'Ставрополь', 'Нижний Тагил', 'Белгород', 'Архангельск',
            'Владимир', 'Сочи', 'Курган', 'Смоленск', 'Калуга',
            'Чита', 'Грозный', 'Волжский', 'Саранск', 'Сургут',
            'Тамбов', 'Орел', 'Владикавказ', 'Череповец', 'Мурманск',
            'Петрозаводск', 'Йошкар-Ола', 'Сыктывкар', 'Благовещенск', 'Якутск',
            'Петропавловск-Камчатский', 'Южно-Сахалинск', 'Магадан', 'Артём',
            // Китай (топ-20)
            'Пекин', 'Шанхай', 'Гуанчжоу', 'Шэньчжэнь', 'Тяньцзинь',
            'Чэнду', 'Ханчжоу', 'Ухань', 'Нанкин', 'Чунцин',
            'Шэньян', 'Сиань', 'Фошань', 'Дунгуань', 'Сучжоу',
            'Харбин', 'Циндао', 'Далянь', 'Сямынь', 'Нинбо',
            'Чанша', 'Шицзячжуан', 'Наньчан', 'Хэфэй', 'Тайюань',
            'Шаньтоу', 'Чжэнчжоу', 'Фучжоу', 'Куньмин', 'Хух-Хото',
            'Датун', 'Урумчи', 'Ланьчжоу', 'Синин', 'Иньчуань',
            'Лхаса', 'Гонконг', 'Макао'
        ];

        // Фильтруем по запросу, если передан параметр `query`
        $query = $request->input('query');
        if ($query) {
            $filtered = array_filter($allCities, function ($city) use ($query) {
                return mb_stripos($city, $query) !== false;
            });
            // Сортируем по релевантности (сначала те, что начинаются с запроса)
            usort($filtered, function ($a, $b) use ($query) {
                $aStarts = mb_stripos($a, $query) === 0;
                $bStarts = mb_stripos($b, $query) === 0;
                if ($aStarts && !$bStarts) return -1;
                if (!$aStarts && $bStarts) return 1;
                return strcasecmp($a, $b);
            });
            $result = array_values($filtered);
        } else {
            // Если запроса нет – возвращаем первые 20 городов (или все)
            $result = array_slice($allCities, 0, 20);
        }

        return response()->json($result);
    }
}
