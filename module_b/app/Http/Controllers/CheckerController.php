<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CheckerController extends Controller
{
    public function checkGTIN(Request $request) {
        $data = [];
        $gtinInputs = $request->except('_token');

        // 2. Используем foreach для перебора ассоциативных ключей и значений
        // $key будет 'GTIN_1', $gtinValue будет 'awd'
        foreach ($gtinInputs as $key => $gtinValue) {

            // Убедимся, что мы обрабатываем только поля GTIN, и пропускаем пустые.
            if (str_starts_with($key, 'GTIN_') && !empty($gtinValue)) {

                // Удаляем лишние пробелы на всякий случай
                $gtinCode = trim($gtinValue);

                // Проверяем наличие в базе данных
                $exists = Product::query()->where("GTIN", $gtinCode)->exists();

                // Записываем результат: [0 => код GTIN, 1 => true/false]
                // Элемент массива теперь нумерованный, что соответствует ожиданию в Blade.
                $data[] = [$gtinCode, $exists];
            }
        }

        return redirect()->back()->with("result", $data);
    }
}
