<style>
#ef-chat-toggle { position: fixed; right: 1.25rem; bottom: 1.25rem; z-index: 70; }
#ef-chat-toggle button { padding: 0; border: none; background: transparent; box-shadow: none; display:inline-flex; align-items:center; justify-content:center; outline: none; }
#ef-chat-toggle img{ width:128px; height:128px; border-radius:9999px; display:block; }
#ef-chat-panel { position: fixed; right: 1.25rem; bottom: 9.5rem; z-index: 75; width: 360px; max-width: calc(100% - 2rem); height: 480px; background: #fff; border-radius: 12px; box-shadow: 0 20px 40px rgba(2,6,23,0.2); display:none; flex-direction:column; overflow:hidden; }
#ef-chat-panel.open { display:flex; }
#ef-chat-panel .ef-header{ padding: 12px 16px; background: #0ea5a0; color: white; display:flex; align-items:center; justify-content:space-between; }
#ef-chat-panel .ef-body{ padding: 16px; overflow-y:auto; flex:1; scroll-behavior: smooth; }
#ef-chat-panel .ef-footer{ padding: 10px; border-top:1px solid #eee; display:flex; gap:8px; }
@media (max-width:640px){ #ef-chat-panel{ right:8px; left:8px; width:auto; bottom:9.5rem; height:420px; } }

/* CSS cho animation dấu chấm đang gõ */
.typing-dot { animation: typing 1.4s infinite ease-in-out both; }
.typing-dot:nth-child(1) { animation-delay: -0.32s; }
.typing-dot:nth-child(2) { animation-delay: -0.16s; }
@keyframes typing { 0%, 80%, 100% { transform: scale(0); } 40% { transform: scale(1); } }
</style>

<div id="ef-chat-toggle" aria-hidden="false">
  <button id="ef-open-chat" aria-label="Mở chat">
    <img src="{{ asset('images/chatbox.png') }}" alt="Chatbot" onerror="efFallbackImage(this)" class="w-32 h-32 object-cover rounded-full shadow-lg hover:scale-105 transition-transform" />
  </button>
</div>

<div id="ef-chat-panel" role="dialog" aria-hidden="true" aria-label="Chatbox">
  <div class="ef-header bg-amber-800">
    <div class="font-bold flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
            <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z" />
        </svg>
        Trợ lý AI
    </div>
    <button id="ef-close-chat" aria-label="Đóng chat" class="text-white hover:text-gray-200 font-bold text-2xl leading-none">&times;</button>
  </div>
  <div class="ef-body" id="ef-chat-body">
    <div class="mb-3 text-left">
        <div class="inline-block bg-gray-100 text-gray-800 px-3 py-2 rounded-lg text-sm">
            Xin chào! Mình là trợ lý AI của quán. Bạn cần tư vấn món gì hôm nay? ☕
        </div>
    </div>
  </div>
  <div class="ef-footer">
    <input id="ef-chat-input" type="text" placeholder="Hỏi AI về đồ uống..." class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-amber-800" />
    <button id="ef-chat-send" class="bg-amber-800 hover:bg-amber-900 transition-colors text-white px-4 py-2 rounded-lg text-sm font-bold flex items-center justify-center min-w-[60px]">
        Gửi
    </button>
  </div>
</div>

<script>
(function(){
  const toggleBtn = document.getElementById('ef-open-chat');
  const panel = document.getElementById('ef-chat-panel');
  const closeBtn = document.getElementById('ef-close-chat');
  const sendBtn = document.getElementById('ef-chat-send');
  const input = document.getElementById('ef-chat-input');
  const body = document.getElementById('ef-chat-body');

  function open(){ panel.classList.add('open'); panel.setAttribute('aria-hidden','false'); input.focus(); }
  function close(){ panel.classList.remove('open'); panel.setAttribute('aria-hidden','true'); }

  toggleBtn && toggleBtn.addEventListener('click', function(){ if(panel.classList.contains('open')) close(); else open(); });
  closeBtn && closeBtn.addEventListener('click', close);

  function appendMessage(text, fromUser){
    const wrapper = document.createElement('div');
    wrapper.className = fromUser ? 'mb-3 text-right flex justify-end' : 'mb-3 text-left flex justify-start';
    
    const bubble = document.createElement('div');
    bubble.className = fromUser 
        ? 'inline-block bg-amber-800 text-white px-3 py-2 rounded-lg rounded-br-none text-sm max-w-[85%]' 
        : 'inline-block bg-gray-100 text-gray-800 px-3 py-2 rounded-lg rounded-bl-none text-sm max-w-[85%]';
    
    // Xử lý xuống dòng cho text
    bubble.innerHTML = text.replace(/\n/g, '<br>');
    
    wrapper.appendChild(bubble);
    body.appendChild(wrapper);
    body.scrollTop = body.scrollHeight;
  }

  // Cập nhật hàm Send thành Async để gọi API
  sendBtn && sendBtn.addEventListener('click', async function(){ 
      const v = (input.value || '').trim(); 
      if(!v) return; 
      
      // 1. In câu hỏi của User
      appendMessage(v, true); 
      input.value = ''; 
      input.disabled = true; // Khóa input trong lúc chờ
      sendBtn.innerHTML = '...';

      // 2. Tạo bubble "Đang gõ..." của AI
      const loadingId = 'loading-' + Date.now();
      const loadingWrapper = document.createElement('div');
      loadingWrapper.id = loadingId;
      loadingWrapper.className = 'mb-3 text-left flex justify-start';
      loadingWrapper.innerHTML = `
        <div class="inline-block bg-gray-100 text-gray-800 px-4 py-3 rounded-lg rounded-bl-none text-sm flex gap-1 items-center">
            <div class="w-1.5 h-1.5 bg-gray-400 rounded-full typing-dot"></div>
            <div class="w-1.5 h-1.5 bg-gray-400 rounded-full typing-dot"></div>
            <div class="w-1.5 h-1.5 bg-gray-400 rounded-full typing-dot"></div>
        </div>
      `;
      body.appendChild(loadingWrapper);
      body.scrollTop = body.scrollHeight;

      // 3. Gửi Request lên Laravel Backend
      try {
          // Lưu ý: Đảm bảo bạn đã khai báo route 'chat.ask' trong web.php
          const response = await fetch('{{ route("chat.ask") }}', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/json',
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
              body: JSON.stringify({ message: v })
          });

          const data = await response.json();
          
          // Xóa hiệu ứng đang gõ
          document.getElementById(loadingId)?.remove();

          // In câu trả lời thực tế của AI
          if(response.ok && data.reply) {
              appendMessage(data.reply, false);
          } else {
              appendMessage("Xin lỗi, hệ thống AI đang gặp sự cố nhỏ. Quý khách vui lòng thử lại sau!", false);
          }

      } catch (error) {
          document.getElementById(loadingId)?.remove();
          appendMessage("Không thể kết nối đến máy chủ. Vui lòng kiểm tra lại mạng!", false);
      } finally {
          // Mở khóa input
          input.disabled = false;
          sendBtn.innerHTML = 'Gửi';
          input.focus();
      }
  });

  input && input.addEventListener('keydown', function(e){ if(e.key === 'Enter'){ sendBtn.click(); }});
})();

function efFallbackImage(img){
  try {
    img.onerror = null;
    var svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#ffffff"><path d="M12 2a10 10 0 100 20 10 10 0 000-20zM7.5 11.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM20 14.5c0 2.485-3.582 4.5-8 4.5s-8-2.015-8-4.5V12l1.5-1.5L7 12v2.5c0 .833 2.865 2.5 5 2.5s5-1.667 5-2.5V12l.5-1.5L20 12v2.5z"/></svg>';
    img.src = 'data:image/svg+xml;utf8,' + encodeURIComponent(svg);
  } catch(e) {
    img.src = 'data:image/svg+xml;utf8,' + encodeURIComponent('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#ef4444"><rect width="24" height="24"/></svg>');
  }
}
</script>