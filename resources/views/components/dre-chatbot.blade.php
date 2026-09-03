<div class="dre-chatbot" id="dre-chatbot" data-endpoint="{{ route('api.chat') }}" data-reset-endpoint="{{ route('api.chat.delete') }}" data-feedback-endpoint="{{ route('api.chat.feedback') }}" data-open="false">
    <section class="dre-chatbot__panel" id="dre-chatbot-panel" role="dialog" aria-modal="false" aria-label="Asistente virtual DRE Huánuco" aria-hidden="true">
        <header class="dre-chatbot__header">
            <div class="dre-chatbot__identity">
                <span class="dre-chatbot__seal" aria-hidden="true">
                    <img src="{{ asset('img/iconchat.svg') }}" alt="" width="34" height="34" loading="lazy" decoding="async">
                </span>
                <div>
                    <h2>Asistente DRE</h2>
                    <p class="dre-chatbot__availability"><span></span> Orientación institucional en línea</p>
                </div>
            </div>
            <div class="dre-chatbot__header-actions">
                <button type="button" data-chat-reset title="Reiniciar conversación" aria-label="Reiniciar conversación">
                    <svg viewBox="0 0 24 24" fill="none"><path d="M3 12a9 9 0 1 0 3-6.7L3 8"/><path d="M3 3v5h5"/></svg>
                </button>
                <button type="button" data-chat-close title="Cerrar" aria-label="Cerrar asistente">
                    <svg viewBox="0 0 24 24" fill="none"><path d="m6 6 12 12M18 6 6 18"/></svg>
                </button>
            </div>
        </header>

        <div class="dre-chatbot__notice">
            <span>Información oficial</span>
            Asistente con IA. No envíes datos personales. Verifica datos importantes.
        </div>

        <div class="dre-chatbot__messages" data-chat-messages aria-busy="false">
            <article class="dre-chatbot__message dre-chatbot__message--assistant">
                <div class="dre-chatbot__avatar" aria-hidden="true">
                    <img src="{{ asset('img/iconchat.svg') }}" alt="" width="34" height="34" decoding="async">
                </div>
                <div class="dre-chatbot__bubble">
                    <strong data-chat-welcome-title>Hola, ¿cómo puedo ayudarte?</strong>
                    <p data-chat-welcome-body>Puedo orientarte para encontrar convocatorias, comunicados, noticias, documentos y servicios de la DRE Huánuco.</p>
                </div>
            </article>
            <div class="dre-chatbot__suggestions" data-chat-suggestions>
                <button type="button">Ver convocatorias vigentes</button>
                <button type="button">Buscar documentos de gestión</button>
                <button type="button">Últimas noticias educativas</button>
            </div>
        </div>

        <form class="dre-chatbot__composer" data-chat-form>
            <label for="dre-chatbot-input" class="sr-only">Escribe tu consulta</label>
            <textarea id="dre-chatbot-input" data-chat-input rows="1" maxlength="1600" placeholder="Escribe tu consulta…"></textarea>
            <button type="submit" class="dre-chatbot__send" aria-label="Enviar consulta">
                <svg viewBox="0 0 24 24" fill="none"><path d="m22 2-7 20-4-9-9-4 20-7Z"/><path d="M22 2 11 13"/></svg>
            </button>
        </form>
        <span class="sr-only" data-chat-status aria-live="polite" aria-atomic="true"></span>
        <p class="dre-chatbot__fineprint">Verifica los requisitos y plazos en la publicación oficial.</p>
    </section>

    <div class="dre-chatbot__welcome" data-chat-greeting>
        <button type="button" class="dre-chatbot__welcome-close" data-chat-greeting-close aria-label="Cerrar mensaje">×</button>
        <button type="button" class="dre-chatbot__welcome-content" data-chat-open-message>
            <span class="dre-chatbot__welcome-kicker">Asistente DRE</span>
            <strong>Hola 👋 ¿Cómo puedo ayudarte?</strong>
            <span>Haz una consulta sobre nuestros servicios.</span>
        </button>
        <span class="dre-chatbot__welcome-tail"></span>
    </div>

    <button type="button" class="dre-chatbot__launcher" data-chat-open aria-label="Abrir orientación ciudadana" aria-controls="dre-chatbot-panel" aria-expanded="false">
        <span class="dre-chatbot__launcher-icon">
            <img src="{{ asset('img/iconchat.svg') }}" alt="" width="54" height="54" decoding="async">
        </span>
        <span class="dre-chatbot__launcher-status" aria-hidden="true"></span>
    </button>
</div>
