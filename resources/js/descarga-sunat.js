(() => {
    const $ = (sel) => document.querySelector(sel);
    const $$ = (sel) => Array.from(document.querySelectorAll(sel));

    // --- Pestañas ---
    const tabIndividual = $('#tab-individual');
    const tabBloque = $('#tab-bloque');
    const panelIndividual = $('#panel-individual');
    const panelBloque = $('#panel-bloque');

    function activarTab(tab) {
        const esIndividual = tab === 'individual';
        tabIndividual.classList.toggle('active', esIndividual);
        tabBloque.classList.toggle('active', !esIndividual);
        panelIndividual.classList.toggle('hidden', !esIndividual);
        panelBloque.classList.toggle('hidden', esIndividual);
    }
    tabIndividual.addEventListener('click', () => activarTab('individual'));
    tabBloque.addEventListener('click', () => activarTab('bloque'));

    // --- Consulta individual (real) ---
    const form = $('#form-individual');
    const btnDescargar = $('#btn-descargar');
    const estado = $('#ds-estado');
    const resultado = $('#ds-resultado');
    const resumen = $('#ds-resumen');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        resultado.classList.add('hidden');
        estado.textContent = 'Descargando comprobante…';
        btnDescargar.disabled = true;

        const fd = new FormData(form);
        // checkbox consentimiento
        if (!fd.has('consentimiento')) fd.append('consentimiento', '0');

        try {
            const resp = await fetch('/descarga-sunat/consultar', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'Accept': 'application/zip, application/json',
                },
                body: fd,
            });

            if (!resp.ok) {
                let msg = 'No se pudo completar la descarga.';
                try {
                    const j = await resp.json();
                    if (j && j.mensaje) msg = j.mensaje;
                } catch (_) {}
                estado.textContent = msg;
                return;
            }

            const blob = await resp.blob();
            const cd = resp.headers.get('Content-Disposition') || '';
            const m = cd.match(/filename="?([^"]+)"?/);
            const filename = m ? m[1] : 'comprobante.zip';

            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            a.remove();
            URL.revokeObjectURL(url);

            estado.textContent = 'Descarga completada.';
            resumen.textContent = `Archivo: ${filename}`;
            resultado.classList.remove('hidden');
        } catch (err) {
            estado.textContent = 'Error de red. Intente nuevamente.';
        } finally {
            btnDescargar.disabled = false;
        }
    });

    // --- Consultas en bloque (simulada) ---
    const btnSimular = $('#btn-simular-bloque');
    const blkEstado = $('#blk-estado');
    const blkLog = $('#blk-log');
    const blkResultado = $('#blk-resultado');

    btnSimular.addEventListener('click', () => {
        const periodo = $('#blk-periodo').value;
        const ruc = $('#blk-ruc').value.trim();

        blkResultado.classList.add('hidden');
        blkLog.classList.remove('hidden');
        blkLog.textContent = '';
        blkEstado.textContent = 'Simulando…';

        const pasos = [
            `[${periodo}] Solicitando propuesta RCE a SUNAT (SIRE)…`,
            `[${periodo}] Ticket generado. Esperando procesamiento…`,
            `[${periodo}] Propuesta recibida: 24 comprobantes detectados.`,
            `[${periodo}] Descargando XML + CDR + PDF de cada comprobante…`,
            `[${periodo}] 24/24 comprobantes procesados.`,
            `[${periodo}] Empaquetando ZIP del período…`,
            `[${periodo}] ZIP listo para descarga.`,
        ];

        let i = 0;
        const timer = setInterval(() => {
            if (i >= pasos.length) {
                clearInterval(timer);
                blkEstado.textContent = 'Simulación completada.';
                blkResultado.classList.remove('hidden');
                // actualizar enlace WhatsApp con datos
                const link = blkResultado.querySelector('a');
                if (link) {
                    const msg = `Hola, quiero cotizar la descarga masiva de comprobantes del período ${periodo} para el RUC ${ruc || 'mi empresa'}.`;
                    link.href = `https://wa.me/${blkResultado.dataset.whatsapp || '51957129087'}?text=${encodeURIComponent(msg)}`;
                }
                return;
            }
            blkLog.textContent += pasos[i] + '\n';
            blkLog.scrollTop = blkLog.scrollHeight;
            i++;
        }, 600);
    });
})();