<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Products; 

class ChatController extends Controller
{
    public function askAI(Request $request)
    {
        // Nhận tin nhắn từ giao diện gửi lên
        $userMessage = $request->input('message');

        // 1. Kéo dữ liệu thực tế từ Database (Chỉ lấy món CÒN HÀNG)
        $availableProducts = Products::where('stock_status', 'AVAILABLE')->get();

        // Ép danh sách thành 1 đoạn văn bản để AI dễ đọc
        $menuList = $availableProducts->map(function($p) {
            return "- " . $p->name . " (Giá: " . number_format($p->price) . "đ) - Mô tả: " . $p->description;
        })->implode("\n");

        // 2. "Bơm" bối cảnh (Prompt Engineering)
        $systemPrompt = "Bạn là nhân viên tư vấn cực kỳ nhiệt tình và thân thiện của quán Trà Gói. " 
                    . "Hãy tư vấn ngắn gọn, dễ hiểu và thêm emoji cho sinh động. "
                    . "Dưới đây là danh sách CÁC MÓN ĐANG CÒN HÀNG hôm nay:\n" 
                    . $menuList 
                    . "\n\nTUYỆT ĐỐI không được bịa ra món không có trong danh sách trên. Khách hỏi: ";
                    
        // 3. Gửi request sang Google Gemini API (SỬ DỤNG GEMINI 2.5 FLASH)
        $response = Http::withoutVerifying()->withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . env('GEMINI_API_KEY'), [
            'contents' => [
                [
                    'role' => 'user', 
                    'parts' => [['text' => $systemPrompt . $userMessage]]
                ]
            ]
        ]);

        // 4. Xử lý kết quả trả về
        if ($response->successful()) {
            $data = $response->json();
            $aiReply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Dạ quán em đang hơi đông, anh chị đợi chút nhé!';
            return response()->json(['reply' => $aiReply]);
        }

        // Đã đổi lại thành 500 để ẩn lỗi kỹ thuật với khách hàng
        return response()->json(['reply' => 'Xin lỗi, hệ thống AI đang bảo trì, vui lòng thử lại sau!'], 500);
    }
}