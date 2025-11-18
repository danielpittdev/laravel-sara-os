export default async function peticion(form, config = {}) {
  const alerta = form.querySelector('.alerta');
  const formData = new FormData(form);

  // Botón submit
  const btn = form.querySelector('button[type=submit]');
  if (btn) {
    btn.classList.add('cursor-not-allowed', 'opacity-50');
    btn.disabled = true;
  }

  // Limpieza previa de alerta
  if (alerta) {
    alerta.classList.remove('active', 'bg-red-50', 'border-red-600/20');
    alerta.innerHTML = '';
  }

  // Limpieza previa de inputs con errores
  if (config.highlightInputs) {
    form.querySelectorAll('input, select, textarea').forEach(input => {
      input.classList.remove('border-red-500', 'bg-red-50');
      const nextMsg = input.nextElementSibling;
      if (nextMsg?.classList.contains('input-error-msg')) nextMsg.remove();
    });
  }

  // Configuración de cabeceras
  const headers = config.headers || {};

  // Agregar token Bearer si existe en localStorage
  const token = localStorage.getItem('token');
  if (token) headers['Authorization'] = `Bearer ${token}`;

  try {
    const response = await axios.post(form.action, formData, {
      headers,
      withCredentials: true, // Para cookies de sesión
    });

    const resp = response.data;
    const status = response.status;
    const mensaje = resp.mensaje ?? 'Acción completada';
    const redirect = resp.redirect;

    // Guardar token automáticamente si el backend lo devuelve
    if (resp.token) localStorage.setItem('token', resp.token);

    if ([200, 201].includes(status)) {
      if (config.showAlert !== false && alerta) {
        alerta.classList.add('active', 'bg-green-50', 'border-green-600/20');
        alerta.innerHTML = `<p class="text-green-600">${mensaje}</p>`;
      }

      if (config.resetForm) form.reset();
      if (config.reload) setTimeout(() => window.location.reload(), 200);
      if (redirect) window.location.href = redirect;
    }

  } catch (err) {
    // Reactivar botón
    if (btn) {
      btn.classList.remove('cursor-not-allowed', 'opacity-50');
      btn.disabled = false;
    }

    const responseData = err.response?.data;
    if (alerta) alerta.classList.add('active', 'bg-red-50', 'border-red-600/20');

    if (err.response?.status === 422) {
      const errors = responseData.errores || responseData.errors || {};
      const globalMsg = responseData.mensaje ?? 'Por favor corrige los errores';
      if (alerta) alerta.innerHTML = `<p class="text-red-700">${globalMsg}</p>`;

      if (config.highlightInputs) {
        Object.keys(errors).forEach(fieldName => {
          const escapedName = fieldName.replace(/([[\].])/g, '\\$1');
          const input = form.querySelector(`[name="${escapedName}"]`);
          if (input) {
            input.classList.add('border-red-500', 'bg-red-50');

            const errorMsg = document.createElement('p');
            errorMsg.className = 'input-error-msg text-red-600 text-sm mt-1';
            errorMsg.innerText = errors[fieldName].join(', ');
            input.insertAdjacentElement('afterend', errorMsg);
          }
        });
      }
    } else {
      const msg = responseData?.mensaje ?? 'Ha ocurrido un error';
      if (alerta) alerta.innerHTML = `<p class="text-red-700">${msg}</p>`;
    }
  }
}

window.peticion = peticion;