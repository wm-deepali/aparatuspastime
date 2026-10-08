<script>
(function () {
  // Password show/hide: <button data-toggle-password="input-id">
  document.querySelectorAll('[data-toggle-password]').forEach((btn) => {
    btn.addEventListener('click', () => {
      const input = document.getElementById(btn.dataset.togglePassword);
      if (!input) return;
      const show = input.type === 'password';
      input.type = show ? 'text' : 'password';
      btn.querySelector('i').className = show ? 'fa-regular fa-eye-slash text-xs' : 'fa-regular fa-eye text-xs';
    });
  });

  document.querySelectorAll('form[data-auth-form]').forEach((form) => {
    const formError = form.querySelector('[data-form-error]');
    const submitBtn = form.querySelector('button[type="submit"]');
    let redirecting = false;

    function showFormError(msg) {
      formError.textContent = msg || '';
      formError.classList.toggle('hidden', !msg);
    }

    function clearErrors() {
      form.querySelectorAll('[data-error-for]').forEach((el) => { el.textContent = ''; el.classList.add('hidden'); });
      form.querySelectorAll('.border-red-400').forEach((el) => el.classList.remove('border-red-400'));
      showFormError('');
    }

    form.addEventListener('submit', async (e) => {
      e.preventDefault();
      clearErrors();
      submitBtn.disabled = true;
      submitBtn.classList.add('opacity-60');

      try {
        const res = await fetch(form.action, {
          method: 'POST',
          headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
          body: new FormData(form),
        });

        let data = {};
        try { data = await res.json(); } catch (_) {}

        if (res.ok && data.status) {
          redirecting = true;
          window.location.href = data.redirect || '/';
          return;
        }

        if (res.status === 422 && data.errors) {
          Object.entries(data.errors).forEach(([field, msgs]) => {
            const slot = form.querySelector('[data-error-for="' + field + '"]');
            if (slot) {
              slot.textContent = msgs[0];
              slot.classList.remove('hidden');
              form.querySelector('[name="' + field + '"]')?.classList.add('border-red-400');
            } else {
              showFormError(msgs[0]);
            }
          });
          return;
        }

        showFormError(res.status === 419
          ? 'Your session expired. Please refresh the page and try again.'
          : (data.message || 'Something went wrong. Please try again.'));
      } catch (_) {
        showFormError('Network error. Please try again.');
      } finally {
        if (!redirecting) {
          submitBtn.disabled = false;
          submitBtn.classList.remove('opacity-60');
        }
      }
    });
  });
})();
</script>