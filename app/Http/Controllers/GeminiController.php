<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GeminiController extends Controller
{
    public function chat(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'min:1', 'max:1000'],
        ]);

        $apiKey = config('services.gemini.key');

        if (blank($apiKey)) {
            return response()->json([
                'message' => 'المساعد الذكي غير مفعّل حالياً. يرجى التواصل مباشرة مع وكالة الحاج عيسى.',
            ], 503);
        }

        $inventory = Ad::active()
            ->with(['category:id,name', 'attributes:id,name,label'])
            ->latest()
            ->limit(30)
            ->get()
            ->map(function (Ad $ad): array {
                return [
                    'العنوان' => $ad->title,
                    'السعر' => $ad->price !== null ? number_format((float) $ad->price) . ' دج' : 'غير محدد',
                    'الفئة' => $ad->category?->name ?? 'سيارة',
                    'الحالة' => $ad->condition_text,
                    'المدينة' => $ad->city,
                    'المواصفات' => $ad->attributes->mapWithKeys(fn ($attribute) => [
                        $attribute->label ?: $attribute->name => $attribute->pivot->value,
                    ])->all(),
                ];
            });

        $systemInstruction = <<<'PROMPT'
أنت "مساعد وكالة الحاج عيسى"، المساعد الذكي الرسمي والافتراضي لوكالة الحاج عيسى لبيع السيارات.
تحدث بالعربية الفصحى المبسطة أو باللهجة الجزائرية الودودة، وبنبرة ترحيبية ومحترمة وموثوقة.
أجب حصرياً عن السيارات، السيارات المعروضة في الوكالة، مواصفاتها وأسعارها، وخدمات الوكالة مثل التسهيلات والتسليم ومتابعة الطلبات والتواصل والحجز.
لا تخترع أي سعر أو مواصفة أو توفر أو خدمة. استخدم فقط بيانات المعرض المرفقة، وإذا لم توجد المعلومة فقل بوضوح إنها غير متوفرة ووجّه العميل للتواصل مباشرة مع الوكالة.
شجّع العميل باختصار على تصفح معرض السيارات أو زيارة مقر الوكالة عند الحاجة.
إذا كان السؤال خارج عالم السيارات أو وكالة الحاج عيسى، اعتذر باختصار واذكر أنك متخصص في سيارات الوكالة وخدماتها.
اجعل الرد مباشراً ومختصراً، ولا تدّعِ أنك موظف بشري.
PROMPT;

        $prompt = $systemInstruction . "\n\nبيانات السيارات النشطة الحالية (قد تكون فارغة):\n"
            . json_encode($inventory->values()->all(), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
            . "\n\nسؤال العميل:\n" . $validated['message'];

        try {
            $response = Http::timeout(25)
                ->acceptJson()
                ->post('https://generativelanguage.googleapis.com/v1beta/models/'
                    . config('services.gemini.model') . ':generateContent?key=' . urlencode($apiKey), [
                        'contents' => [
                            ['role' => 'user', 'parts' => [['text' => $prompt]]],
                        ],
                        'generationConfig' => [
                            'temperature' => 0.2,
                            'maxOutputTokens' => 500,
                        ],
                    ]);

            if ($response->failed()) {
                report(new \RuntimeException('Gemini API error: ' . $response->body()));

                return response()->json([
                    'message' => 'تعذر الوصول إلى المساعد حالياً. يرجى التواصل مباشرة مع وكالة الحاج عيسى.',
                ], 502);
            }

            $message = collect($response->json('candidates.0.content.parts', []))
                ->pluck('text')
                ->filter()
                ->implode("\n");

            return response()->json([
                'message' => $message ?: 'لم أتمكن من إعداد رد الآن. يرجى التواصل مباشرة مع الوكالة.',
            ]);
        } catch (\Throwable $exception) {
            report($exception);

            return response()->json([
                'message' => 'حدث عطل مؤقت. يرجى التواصل مباشرة مع وكالة الحاج عيسى.',
            ], 502);
        }
    }
}