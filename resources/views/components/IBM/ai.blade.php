<section class="agency-ai" dir="rtl" aria-labelledby="agency-ai-title">
	<div class="agency-ai__inner">
		<div class="agency-ai__intro">
			<span class="agency-ai__eyebrow">مساعد وكالة الحاج عيسى</span>
			<h2 id="agency-ai-title">اسألنا عن سيارتك القادمة<span>.</span></h2>
			<p>إجابات سريعة حول السيارات المتوفرة، الأسعار والمواصفات.</p>
		</div>

		<div class="agency-ai__chat" data-ai-chat>
			<div class="agency-ai__messages" data-ai-messages aria-live="polite">
				<div class="agency-ai__message agency-ai__message--assistant">
					مرحباً بك. أنا مساعد وكالة الحاج عيسى، كيف يمكنني مساعدتك في اختيار سيارتك؟
				</div>
			</div>

			<form class="agency-ai__form" data-ai-form>
				@csrf
				<label class="sr-only" for="agency-ai-input">اكتب سؤالك</label>
				<input id="agency-ai-input" type="text" name="message" maxlength="1000"
					   placeholder="مثال: ما السيارات المتوفرة؟" autocomplete="off" required>
				<button type="submit" aria-label="إرسال السؤال" title="إرسال السؤال">
					<i class="fa-solid fa-paper-plane" aria-hidden="true"></i>
				</button>
			</form>
			<small class="agency-ai__hint">المعلومات المعروضة مبنية على بيانات المعرض الحالية.</small>
		</div>
	</div>
</section>

<style>
	.agency-ai { padding: 72px 0; background: linear-gradient(135deg, #f5f9fc 0%, #eef5f8 100%); }
	.agency-ai__inner { display: grid; grid-template-columns: minmax(0, .8fr) minmax(320px, 1.2fr); gap: 42px; align-items: center; max-width: 1140px; margin: 0 auto; padding: 0 15px; }
	.agency-ai__eyebrow { color: #4b9fe1; font-size: 11px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; }
	.agency-ai h2 { margin: 10px 0 12px; color: #182b3d; font-size: clamp(28px, 4vw, 44px); font-weight: 900; line-height: 1.15; }
	.agency-ai h2 span { color: #4b9fe1; }
	.agency-ai__intro p { margin: 0; color: #607181; font-size: 15px; }
	.agency-ai__chat { padding: 18px; background: #fff; border: 1px solid #dce8ef; border-radius: 10px; box-shadow: 0 16px 36px rgba(26, 61, 86, .09); }
	.agency-ai__messages { display: flex; flex-direction: column; gap: 10px; min-height: 130px; max-height: 280px; margin-bottom: 14px; overflow-y: auto; }
	.agency-ai__message { max-width: 88%; padding: 10px 13px; border-radius: 8px; color: #253746; font-size: 13px; line-height: 1.7; white-space: pre-wrap; }
	.agency-ai__message--assistant { align-self: flex-start; background: #edf5fa; }
	.agency-ai__message--user { align-self: flex-end; background: #4b9fe1; color: #fff; }
	.agency-ai__message--error { background: #fff1f1; color: #b42318; }
	.agency-ai__form { display: flex; gap: 8px; }
	.agency-ai__form input { min-width: 0; flex: 1; padding: 11px 13px; border: 1px solid #d5e1e8; border-radius: 6px; outline: none; font-size: 13px; }
	.agency-ai__form input:focus { border-color: #4b9fe1; box-shadow: 0 0 0 3px rgba(75, 159, 225, .14); }
	.agency-ai__form button { width: 44px; border: 0; border-radius: 6px; background: #4b9fe1; color: #fff; cursor: pointer; transition: background .2s ease; }
	.agency-ai__form button:hover { background: #287bbd; }
	.agency-ai__form button:disabled { cursor: wait; opacity: .65; }
	.agency-ai__hint { display: block; margin-top: 9px; color: #82909b; font-size: 10px; }
	.sr-only { position: absolute; width: 1px; height: 1px; padding: 0; margin: -1px; overflow: hidden; clip: rect(0, 0, 0, 0); white-space: nowrap; border: 0; }
	@media (max-width: 767px) { .agency-ai__inner { grid-template-columns: 1fr; gap: 24px; } .agency-ai { padding: 48px 0; } }
</style>

<script>
	(() => {
		const chat = document.querySelector('[data-ai-chat]');
		if (!chat || chat.dataset.initialized) return;
		chat.dataset.initialized = 'true';

		const form = chat.querySelector('[data-ai-form]');
		const input = form.querySelector('input[name="message"]');
		const messages = chat.querySelector('[data-ai-messages]');
		const button = form.querySelector('button');
		const token = form.querySelector('input[name="_token"]').value;

		const addMessage = (text, type) => {
			const message = document.createElement('div');
			message.className = `agency-ai__message agency-ai__message--${type}`;
			message.textContent = text;
			messages.appendChild(message);
			messages.scrollTop = messages.scrollHeight;
			return message;
		};

		form.addEventListener('submit', async (event) => {
			event.preventDefault();
			const question = input.value.trim();
			if (!question || button.disabled) return;

			addMessage(question, 'user');
			input.value = '';
			button.disabled = true;
			const loading = addMessage('جارٍ إعداد الرد...', 'assistant');

			try {
				const response = await fetch('{{ route('ai.chat') }}', {
					method: 'POST',
					headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': token },
					body: JSON.stringify({ message: question }),
				});
				const data = await response.json();
				loading.remove();
				addMessage(data.message || 'تعذر إعداد الرد حالياً.', response.ok ? 'assistant' : 'error');
			} catch (error) {
				loading.remove();
				addMessage('تعذر الاتصال بالمساعد. يرجى التواصل مباشرة مع وكالة الحاج عيسى.', 'error');
			} finally {
				button.disabled = false;
				input.focus();
			}
		});
	})();
</script>
