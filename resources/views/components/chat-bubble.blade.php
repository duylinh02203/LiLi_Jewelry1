<div id="chatbot-toggle" onclick="toggleChatbot()">
    <img src="{{ asset('cms/assets/images/chat-icon.png') }}" alt="" width="50" height="50">
</div>

<div id="chatbot-box">
    <div id="chatbot-header">
        <span>LiLi Jewelry</span>
        <div class="wrap-chat">
            <span onclick="clearChatHistory()" style="cursor:pointer; margin-right: 10px;">
                <i class="fa-solid fa-trash"></i>
            </span>
            <span onclick="toggleChatbot()" style="cursor:pointer;">
                <i class="fa-solid fa-xmark"></i>
            </span>
        </div>
    </div>

    <div id="chatbot-messages"></div>
    <div id="chatbot-input">
        <input type="text" id="chat-input" placeholder="Nhập tin nhắn..."
            onkeydown="if(event.key==='Enter') sendMessage();">
        <button onclick="sendMessage()"><i class="fa-solid fa-paper-plane"></i></button>
    </div>
</div>

<style>
    :root {
        --primary-color: #007bff;
        --secondary-color: white;
        --text-color: #1a1a1a;
        --border-radius: 20px;
        --box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    }

    #chat-input {
        margin-right: 10px;
    }

    #chatbot-toggle {
        position: fixed;
        bottom: 120px;
        right: 13px;
        color: white;
        border-radius: 50%;
        cursor: pointer;
        z-index: 10000;
        box-shadow: var(--box-shadow);
        font-size: 20px;
    }

    #chatbot-box {
        position: fixed;
        bottom: 70px;
        right: 70px;
        width: 360px;
        height: 500px;
        background: var(--secondary-color);
        border-radius: var(--border-radius);
        display: none;
        flex-direction: column;
        overflow: hidden;
        box-shadow: var(--box-shadow);
        z-index: 9999;
    }

    #chatbot-header {
        background: var(--primary-color);
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        display: flex;
        justify-content: space-between;
    }

    #chatbot-messages {
        flex: 1;
        padding: 15px;
        overflow-y: auto;
        font-size: 14px;
        background: var(--secondary-color);
        display: flex;
        flex-direction: column;
    }

    #chatbot-messages div {
        margin: 6px 0;
        padding: 8px;
        border-radius: var(--border-radius);
        word-wrap: break-word;
        white-space: pre-wrap;
        display: inline-block;
        max-width: 80%;
    }

    #chatbot-messages div.user {
        margin-left: auto;
        background: var(--primary-color);
        color: white;
    }

    #chatbot-messages div.bot {
        margin-right: auto;
        background: #e9f7ff;
        color: var(--text-color);
    }

    #chatbot-messages div.error {
        color: red;
        text-align: center;
        font-size: 12px;
        background: none;
        display: block;
    }

    #chatbot-input {
        display: flex;
        align-items: center;
        padding: 10px;
        border-top: 1px solid #ddd;
    }

    #chatbot-input input {
        flex: 1;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: var(--border-radius);
        font-size: 14px;
    }

    #chatbot-input button {
        padding: 10px 15px;
        background: var(--primary-color);
        color: white;
        border-radius: var(--border-radius);
        border: none;
        font-size: 14px;
    }

    /* ✅ KHUNG SẢN PHẨM GỌN GÀNG NHẤT */
    .bot .product-card {
        background: white;
        border-radius: 8px;
        padding: 6px 8px;
        margin: 4px 0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        max-width: 100%;
        font-size: 13px;
        line-height: 1.2;
        box-sizing: border-box;
    }

    .product-card img {
        width: 100%;
        border-radius: 6px;
        margin-bottom: 4px;
    }

    .product-card div {
        margin-bottom: 2px;
    }

    .product-card button {
        background: #007bff;
        color: white;
        padding: 4px 8px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 13px;
        margin-top: 2px;
    }

    .product-card a {
        text-decoration: none;
        display: inline-block;
    }
</style>

<script>
    function toggleChatbot() {
        const chatbotBox = document.getElementById('chatbot-box');
        chatbotBox.style.display = chatbotBox.style.display === 'flex' ? 'none' : 'flex';
        if (chatbotBox.style.display === 'flex') {
            loadChatHistory();
        }
    }

    function sendMessage() {
        const input = document.getElementById('chat-input');
        const message = input.value.trim();
        const chatBox = document.getElementById('chatbot-messages');

        if (!message) return;

        const userObj = {
            role: 'user',
            parts: [{
                text: message
            }]
        };
        appendMessage(userObj);
        addToHistory(userObj);
        input.value = '';

        fetch("{{ route('chat.ajax') }}", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                },
                body: JSON.stringify({
                    prompt: message
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && Array.isArray(data.history) && data.history.length > 0) {
                    const lastMsg = data.history[data.history.length - 1];
                    if (lastMsg && lastMsg.role === 'model') {
                        appendMessage(lastMsg);
                        addToHistory(lastMsg);
                    }
                } else {
                    const errorMsg = {
                        role: 'error',
                        parts: [{
                            text: data.message || 'Lỗi không xác định.'
                        }]
                    };
                    appendMessage(errorMsg);
                    addToHistory(errorMsg);
                }
            })
            .catch(() => {
                const errorMsg = {
                    role: 'error',
                    parts: [{
                        text: 'Lỗi kết nối đến máy chủ.'
                    }]
                };
                appendMessage(errorMsg);
                addToHistory(errorMsg);
            });
    }

    function appendMessage(msgObj) {
        const chatBox = document.getElementById('chatbot-messages');
        chatBox.innerHTML += renderMessageDiv(msgObj);
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    function addToHistory(msgObj) {
        let history = JSON.parse(localStorage.getItem('chatHistory')) || [];
        history.push(msgObj);
        localStorage.setItem('chatHistory', JSON.stringify(history));
    }

    function renderMessageDiv(msg) {
        if (!msg || !msg.role || !msg.parts || !Array.isArray(msg.parts)) return '';
        const text = msg.parts[0]?.text || '';
        if (msg.role === 'user') {
            return `<div class="user">${text}</div>`;
        } else if (msg.role === 'model' || msg.role === 'bot') {
            return `<div class="bot">${text}</div>`;
        } else if (msg.role === 'error') {
            return `<div class="error"><em>${text}</em></div>`;
        } else {
            return `<div>${text}</div>`;
        }
    }

    function loadChatHistory() {
        const chatBox = document.getElementById('chatbot-messages');
        let history = JSON.parse(localStorage.getItem('chatHistory')) || [];
        if (history.length === 0) {
            const welcomeObj = {
                role: 'bot',
                parts: [{
                    text: 'Chào bạn, bạn cần mình hỗ trợ gì?'
                }]
            };
            chatBox.innerHTML = renderMessageDiv(welcomeObj);
            localStorage.setItem('chatHistory', JSON.stringify([welcomeObj]));
        } else {
            chatBox.innerHTML = history.map(renderMessageDiv).join('');
        }
        chatBox.scrollTop = chatBox.scrollHeight;
    }

    function clearChatHistory() {
        fetch("{{ route('chat.clearHistory') }}", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                }
            })
            .then(response => response.json())
            .then(data => {
                const chatBox = document.getElementById('chatbot-messages');
                if (data.success) {
                    const welcomeObj = {
                        role: 'bot',
                        parts: [{
                            text: 'Chào bạn đến với LiLi Jewelry! Hãy cho mình biết bạn đang quan tâm đến loại trang sức nào ✨'
                        }]
                    };
                    chatBox.innerHTML = renderMessageDiv(welcomeObj);
                    localStorage.setItem('chatHistory', JSON.stringify([welcomeObj]));
                }
            });
    }
</script>
