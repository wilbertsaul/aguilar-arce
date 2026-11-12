/**
 * BYTFACT — Simulador de facturación electrónica
 * ---------------------------------------------------------------
 * JS vanilla (sin dependencias, sin Livewire).
 *
 * - Emisión 100% simulada (marca de agua, sin valor tributario).
 * - Consulta de DNI/RUC real vía JSON.PE con cupo por visitante,
 *   caché compartida en servidor y fallback a modo demo.
 * - Cálculos por línea: subtotal = total / 1.18, IGV = total - subtotal.
 */
document.addEventListener('DOMContentLoaded', () => {
    const app = document.getElementById('facturador-app');
    if (!app) return;

    const CONFIG = JSON.parse(document.getElementById('facturador-data').textContent);
    const TOTAL_STEPS = 7;
    const CONFIG_KEY = 'bytfact:config';

    const initialState = () => ({
        step: 1,
        tipo: 'B',
        cliente: { doc: '', nombre: '', direccion: '' },
        items: [defaultItem()],
        moneda: 'PEN',
        formaPago: 'contado',
        observaciones: '',
        serie: null,
        numero: null,
        config: {
            ambiente: 'beta',
            probado: false,
            demo: false,
        },
    });

    function defaultItem() {
        const s = CONFIG.servicios[0];
        return { cantidad: 1, descripcion: s.descripcion, precio: s.precio };
    }

    let state = initialState();

    // ===== Helpers =====
    const $ = (sel) => app.querySelector(sel);
    const $$ = (sel) => Array.from(app.querySelectorAll(sel));

    const money = (n, moneda = state.moneda) => {
        const symbol = moneda === 'PEN' ? 'S/' : '$';
        return symbol + ' ' + (Number.isFinite(n) ? n : 0).toLocaleString('es-PE', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        });
    };

    const num = (n) => (Number.isFinite(n) ? n : 0).toLocaleString('es-PE', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });

    const escapeHtml = (str) => String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');

    const lineTotal = (item) => (parseFloat(item.cantidad) || 0) * (parseFloat(item.precio) || 0);

    function calc() {
        let gravadas = 0, igv = 0, total = 0;
        state.items.forEach((item) => {
            const t = lineTotal(item);
            const sub = t / 1.18;
            gravadas += sub;
            igv += t - sub;
            total += t;
        });
        return {
            gravadas: Math.round(gravadas * 100) / 100,
            igv: Math.round(igv * 100) / 100,
            total: Math.round(total * 100) / 100,
        };
    }

    // ===== Número a letras =====
    const UNIDADES = ['', 'UN', 'DOS', 'TRES', 'CUATRO', 'CINCO', 'SEIS', 'SIETE', 'OCHO', 'NUEVE'];
    const TEENS = ['DIEZ', 'ONCE', 'DOCE', 'TRECE', 'CATORCE', 'QUINCE', 'DIECISEIS', 'DIECISIETE', 'DIECIOCHO', 'DIECINUEVE'];
    const DECENAS = ['', '', 'VEINTE', 'TREINTA', 'CUARENTA', 'CINCUENTA', 'SESENTA', 'SETENTA', 'OCHENTA', 'NOVENTA'];
    const CENTENAS = ['', 'CIENTO', 'DOSCIENTOS', 'TRESCIENTOS', 'CUATROCIENTOS', 'QUINIENTOS', 'SEISCIENTOS', 'SETECIENTOS', 'OCHOCIENTOS', 'NOVECIENTOS'];

    function dosDigitos(n) {
        if (n < 10) return UNIDADES[n];
        if (n < 20) return TEENS[n - 10];
        const d = Math.floor(n / 10), u = n % 10;
        if (d === 2) return u === 0 ? 'VEINTE' : 'VEINTI' + UNIDADES[u];
        return DECENAS[d] + (u > 0 ? ' Y ' + UNIDADES[u] : '');
    }

    function tresDigitos(n) {
        if (n === 0) return '';
        if (n === 100) return 'CIEN';
        const c = Math.floor(n / 100), resto = n % 100;
        return [c > 0 ? CENTENAS[c] : '', resto > 0 ? dosDigitos(resto) : ''].filter(Boolean).join(' ');
    }

    function enteroEnLetras(n) {
        if (n === 0) return 'CERO';
        const out = [];
        const millones = Math.floor(n / 1000000);
        const miles = Math.floor((n % 1000000) / 1000);
        const resto = n % 1000;
        if (millones > 0) out.push(millones === 1 ? 'UN MILLON' : tresDigitos(millones) + ' MILLONES');
        if (miles > 0) out.push(miles === 1 ? 'MIL' : tresDigitos(miles) + ' MIL');
        if (resto > 0) out.push(tresDigitos(resto));
        return out.join(' ');
    }

    function numeroALetras(n) {
        const entero = Math.floor(n);
        const centavos = Math.round((n - entero) * 100);
        return enteroEnLetras(entero) + ' CON ' + String(centavos).padStart(2, '0') + '/100';
    }

    function fechaHoy() {
        const d = new Date();
        const pad = (x) => String(x).padStart(2, '0');
        return `${pad(d.getDate())}/${pad(d.getMonth() + 1)}/${d.getFullYear()}`;
    }

    function randomHash() {
        const chars = 'abcdef0123456789';
        let out = '';
        for (let i = 0; i < 32; i++) out += chars[Math.floor(Math.random() * chars.length)];
        return out;
    }

    // ===== Navegación =====
    function goToStep(step) {
        state.step = step;
        $$('.panel').forEach((p) => p.classList.toggle('hidden', Number(p.dataset.panel) !== step));
        $$('.stepper-step').forEach((el) => {
            const s = Number(el.dataset.step);
            el.classList.toggle('active', s === step);
            el.classList.toggle('done', s < step);
            const dot = el.querySelector('.stepper-dot');
            dot.textContent = s < step ? '✓' : String(s);
        });
        $('#step-indicator').textContent = `Paso ${step} de ${TOTAL_STEPS}`;
        $('#btn-prev').classList.toggle('invisible', step === 1);
        $('#btn-next').classList.toggle('hidden', step === TOTAL_STEPS);
        if (step === TOTAL_STEPS) buildPreview();
        app.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function showError(key, msg) {
        const el = document.getElementById(key + '-error');
        if (el) { el.textContent = msg; el.classList.remove('hidden'); }
    }

    function hideError(key) {
        const el = document.getElementById(key + '-error');
        if (el) el.classList.add('hidden');
    }

    function showClienteError(field, msg) {
        const el = document.getElementById('cliente-' + field + '-error');
        if (el) { el.textContent = msg; el.classList.remove('hidden'); }
    }

    function clearClienteErrors() {
        hideError('cliente-doc');
        hideError('cliente-nombre');
    }

    function validationError(step) {
        // Paso 2: configuración (se permite seguir en modo demo)
        if (step === 2) {
            if (!state.config.probado && !state.config.demo) {
                $('#config-warning').classList.remove('hidden');
                $('#config-warning').scrollIntoView({ behavior: 'smooth', block: 'center' });
                return 'config';
            }
        }

        // Paso 4: cliente
        if (step === 4) {
            clearClienteErrors();
            const doc = state.cliente.doc.trim();
            const esRuc = /^\d{11}$/.test(doc);
            const esDni = /^\d{8}$/.test(doc);
            const nombre = state.cliente.nombre.trim();

            if (state.tipo === 'F') {
                if (!esRuc) {
                    showClienteError('doc', 'Una factura requiere el RUC del cliente (11 dígitos).');
                    return 'cliente';
                }
                if (!nombre) {
                    showClienteError('nombre', 'Ingrese la razón social del cliente.');
                    return 'cliente';
                }
            } else {
                if (doc !== '' && !esDni && !esRuc) {
                    showClienteError('doc', 'El DNI debe tener 8 dígitos (o déjelo vacío para consumidor final).');
                    return 'cliente';
                }
                if (doc !== '' && !nombre) {
                    showClienteError('nombre', 'Ingrese el nombre del cliente o use consumidor final.');
                    return 'cliente';
                }
            }
        }

        // Paso 5: servicios
        if (step === 5) {
            hideError('items');
            const hayValido = state.items.some((it) => it.descripcion.trim() !== '' && lineTotal(it) > 0);
            if (!hayValido) {
                showError('items', 'Agregue al menos un servicio con descripción y precio mayor a cero.');
                return 'items';
            }
        }

        return null;
    }

    // ===== Configuración del ambiente (simulada) =====
    const cfg = {
        ruc: $('#cfg-ruc'),
        razon: $('#cfg-razon'),
        cert: $('#cfg-cert'),
        certPass: $('#cfg-cert-pass'),
        solUser: $('#cfg-sol-user'),
        solPass: $('#cfg-sol-pass'),
    };

    function guardarConfig() {
        const data = {
            ruc: cfg.ruc.value.trim(),
            razon: cfg.razon.value.trim(),
            ambiente: state.config.ambiente,
            probado: state.config.probado,
        };
        try { localStorage.setItem(CONFIG_KEY, JSON.stringify(data)); } catch (e) { /* modo privado */ }
    }

    function restaurarConfig() {
        try {
            const raw = localStorage.getItem(CONFIG_KEY);
            if (!raw) return;
            const data = JSON.parse(raw);
            if (data.ruc) cfg.ruc.value = data.ruc;
            if (data.razon) cfg.razon.value = data.razon;
            if (data.ambiente === 'produccion') {
                state.config.ambiente = 'produccion';
                $$('.ambiente-toggle').forEach((b) => b.classList.toggle('active', b.dataset.ambiente === 'produccion'));
            }
            if (data.probado) {
                state.config.probado = true;
                marcarConectado('Conexión verificada anteriormente en este navegador.');
            }
        } catch (e) { /* configuración corrupta */ }
    }

    $$('.ambiente-toggle').forEach((btn) => {
        btn.addEventListener('click', () => {
            state.config.ambiente = btn.dataset.ambiente;
            $$('.ambiente-toggle').forEach((b) => b.classList.remove('active'));
            btn.classList.add('active');
            state.config.probado = false;
            $('#conexion-estado').textContent = '';
            $('#conexion-log').classList.add('hidden');
        });
    });

    function marcarConectado(texto) {
        const estado = $('#conexion-estado');
        estado.innerHTML = `<span class="byt-status-ok"><span class="material-symbols-outlined text-[14px]">check_circle</span> Conexión establecida</span> <span class="ml-1">${escapeHtml(texto)}</span>`;
    }

    const logLineas = (ambiente) => ambiente === 'produccion'
        ? [
            '[1/5] Leyendo certificado digital ......... OK (vigente)',
            '[2/5] Conectando con e-factura.sunat.gob.pe:443 ... TLS 1.2',
            '[3/5] Autenticando RUC y usuario SOL secundario ... OK',
            '[4/5] Enviando solicitud de prueba (billService) ...',
            '[5/5] Respuesta SUNAT: código 0 · "El comprobante fue aceptado"',
            'Conexión establecida con el ambiente PRODUCCIÓN.',
        ]
        : [
            '[1/5] Leyendo certificado digital ......... OK (vigente)',
            '[2/5] Conectando con e-beta.sunat.gob.pe:443 ... TLS 1.2',
            '[3/5] Autenticando RUC y usuario SOL secundario ... OK',
            '[4/5] Enviando solicitud de prueba (billService) ...',
            '[5/5] Respuesta SUNAT: código 0 · "El proceso de homologación fue exitoso"',
            'Conexión establecida con el ambiente BETA (homologación).',
        ];

    let probando = false;

    $('#btn-probar').addEventListener('click', () => {
        if (probando) return;
        probando = true;

        const btn = $('#btn-probar');
        const log = $('#conexion-log');
        const estado = $('#conexion-estado');
        btn.disabled = true;
        log.classList.remove('hidden');
        log.textContent = '';
        estado.textContent = 'Validando credenciales y certificado...';
        $('#config-warning').classList.add('hidden');

        const lineas = logLineas(state.config.ambiente);
        lineas.forEach((linea, i) => {
            setTimeout(() => {
                log.textContent += linea + '\n';
                log.scrollTop = log.scrollHeight;

                if (i === lineas.length - 1) {
                    state.config.probado = true;
                    state.config.demo = false;
                    probando = false;
                    btn.disabled = false;
                    marcarConectado(state.config.ambiente === 'produccion'
                        ? 'Producción · RUC ' + (cfg.ruc.value.trim() || '—')
                        : 'Beta / homologación · RUC ' + (cfg.ruc.value.trim() || '—'));
                    guardarConfig();
                }
            }, 380 * (i + 1));
        });
    });

    $('#btn-continuar-demo').addEventListener('click', () => {
        state.config.demo = true;
        $('#config-warning').classList.add('hidden');
        goToStep(3);
    });

    cfg.ruc.addEventListener('input', () => {
        cfg.ruc.value = cfg.ruc.value.replace(/\D/g, '').slice(0, 11);
        state.config.probado = false;
    });
    cfg.razon.addEventListener('input', () => { state.config.probado = false; });

    // ===== Paso 3: tipo de comprobante =====
    $$('.tipo-card').forEach((card) => {
        card.addEventListener('click', () => {
            state.tipo = card.dataset.tipo;
            $$('.tipo-card').forEach((c) => c.classList.remove('selected'));
            card.classList.add('selected');
            clearClienteErrors();
        });
    });

    // ===== Paso 4: cliente + consulta real =====
    const docInput = $('#cliente-doc');
    const nombreInput = $('#cliente-nombre');
    const direccionInput = $('#cliente-direccion');

    function pintarCupo(restantes) {
        if (!Number.isFinite(restantes)) return;
        $('#consulta-cupo').textContent = restantes > 0
            ? `Consultas reales disponibles hoy: ${restantes}`
            : 'Sin consultas reales por hoy · puedes seguir en modo demo';
    }

    function pill(contenido, tipo) {
        const el = $('#consulta-pill');
        el.className = tipo === 'ok' ? 'byt-status-ok' : 'byt-status-demo';
        el.innerHTML = contenido;
        el.classList.remove('hidden');
    }

    function limpiarPill() {
        const el = $('#consulta-pill');
        el.classList.add('hidden');
        el.innerHTML = '';
    }

    docInput.addEventListener('input', () => {
        const v = docInput.value.replace(/\D/g, '').slice(0, 11);
        docInput.value = v;
        state.cliente.doc = v;
        clearClienteErrors();
        limpiarPill();

        const label = $('#cliente-tipo-label');
        if (v.length === 11) label.textContent = '(RUC)';
        else if (v.length === 8) label.textContent = '(DNI)';
        else label.textContent = '(DNI o RUC)';
    });

    docInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            consultarDocumento();
        }
    });

    nombreInput.addEventListener('input', () => { state.cliente.nombre = nombreInput.value; clearClienteErrors(); });
    direccionInput.addEventListener('input', () => { state.cliente.direccion = direccionInput.value; });

    async function consultarDocumento() {
        const doc = state.cliente.doc.trim();

        if (!/^\d{8}$|^\d{11}$/.test(doc)) {
            showClienteError('doc', 'Escribe un DNI de 8 dígitos o un RUC de 11 dígitos.');
            return;
        }

        clearClienteErrors();

        const btn = $('#btn-consultar');
        btn.disabled = true;
        pill('<span class="material-symbols-outlined text-[14px] animate-spin">progress_activity</span> Consultando padrón...', 'demo');

        try {
            const response = await fetch(CONFIG.consulta.endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                },
                body: JSON.stringify({ documento: doc }),
            });

            const data = await response.json();

            if (response.ok && data.ok) {
                state.cliente.nombre = data.nombre || '';
                state.cliente.direccion = (data.datos && data.datos.direccion) || '';
                nombreInput.value = state.cliente.nombre;
                direccionInput.value = state.cliente.direccion;

                const fuente = data.fuente === 'cache'
                    ? 'caché del sistema'
                    : (data.tipo === 'DNI' ? 'RENIEC' : 'SUNAT');

                pill(`<span class="material-symbols-outlined text-[14px]">verified</span> ${escapeHtml(data.tipo)} verificado · ${escapeHtml(fuente)}`, 'ok');
                pintarCupo(data.restantes);

                const estadoSunat = data.datos && data.datos.estado ? ` · ${data.datos.estado}` : '';
                $('#consulta-cupo').textContent += estadoSunat;
                return;
            }

            // Sin cupo, provedor caído o documento inexistente → modo demo.
            pill('<span class="material-symbols-outlined text-[14px]">science</span> Modo demo', 'demo');
            pintarCupo(data.restantes);
            $('#consulta-cupo').textContent = data.mensaje || 'Completa los datos manualmente para continuar.';

            if (data.motivo === 'no_encontrado') {
                showClienteError('doc', data.mensaje || 'Documento no encontrado.');
            }
        } catch (e) {
            pill('<span class="material-symbols-outlined text-[14px]">cloud_off</span> Sin conexión · modo demo', 'demo');
            $('#consulta-cupo').textContent = 'No se pudo consultar el padrón. Completa los datos a mano para continuar.';
        } finally {
            btn.disabled = false;
        }
    }

    $('#btn-consultar').addEventListener('click', consultarDocumento);

    $('#btn-consumidor-final').addEventListener('click', () => {
        if (state.tipo === 'F') {
            clearClienteErrors();
            showClienteError('doc', 'Las facturas requieren RUC. Cambia a boleta o ingresa el RUC del cliente.');
            return;
        }
        clearClienteErrors();
        limpiarPill();
        state.cliente = { doc: '', nombre: 'CONSUMIDOR FINAL', direccion: '' };
        docInput.value = '';
        nombreInput.value = 'CONSUMIDOR FINAL';
        direccionInput.value = '';
    });

    $('#btn-cliente-demo').addEventListener('click', () => {
        const demo = CONFIG.clientes.find((c) => (state.tipo === 'F' ? c.tipo === 'RUC' : true)) || CONFIG.clientes[0];
        clearClienteErrors();
        state.cliente = { doc: demo.doc, nombre: demo.nombre, direccion: demo.direccion };
        docInput.value = demo.doc;
        nombreInput.value = demo.nombre;
        direccionInput.value = demo.direccion;
        pill('<span class="material-symbols-outlined text-[14px]">science</span> Datos de ejemplo · no consume cupo', 'demo');
        $('#consulta-cupo').textContent = 'Los datos de ejemplo son ficticios y no gastan consultas reales.';
    });

    // ===== Paso 5: items =====
    function renderItems() {
        const tbody = $('#items-body');
        tbody.innerHTML = '';

        let datalist = document.getElementById('lista-servicios');
        if (!datalist) {
            datalist = document.createElement('datalist');
            datalist.id = 'lista-servicios';
            CONFIG.servicios.forEach((s) => {
                const opt = document.createElement('option');
                opt.value = s.descripcion;
                datalist.appendChild(opt);
            });
            app.appendChild(datalist);
        }

        state.items.forEach((item, i) => {
            const row = document.createElement('tr');
            row.className = 'border-b border-byt-line/60';
            row.innerHTML = `
                <td class="py-3 pr-2">
                    <input type="number" min="1" step="1" value="${item.cantidad}" data-idx="${i}" data-field="cantidad"
                        class="item-input w-16 byt-input !px-2 !py-2 text-sm">
                </td>
                <td class="py-3 pr-2">
                    <input type="text" list="lista-servicios" value="${escapeHtml(item.descripcion)}" data-idx="${i}" data-field="descripcion"
                        class="item-input w-full byt-input !py-2 text-sm">
                </td>
                <td class="py-3 pr-2">
                    <input type="number" min="0" step="0.01" value="${item.precio}" data-idx="${i}" data-field="precio"
                        class="item-input w-28 byt-input !px-2 !py-2 text-sm text-right font-mono">
                </td>
                <td class="py-3 pr-2 text-right font-mono text-sm font-bold text-byt-navy item-total">${money(lineTotal(item))}</td>
                <td class="py-3 text-center">
                    <button type="button" class="remove-item w-8 h-8 inline-flex items-center justify-center rounded-lg text-byt-grey hover:text-error hover:bg-error/10 transition-colors" data-idx="${i}" title="Quitar servicio" ${state.items.length === 1 ? 'style="opacity:0.3; pointer-events:none;"' : ''}>
                        <span class="material-symbols-outlined text-[18px]">close</span>
                    </button>
                </td>`;
            tbody.appendChild(row);
        });

        updateTotals();
    }

    function updateTotals() {
        const c = calc();
        $('#tot-op-gravadas').textContent = money(c.gravadas);
        $('#tot-igv').textContent = money(c.igv);
        $('#tot-total').textContent = money(c.total);
    }

    $('#items-body').addEventListener('input', (e) => {
        const input = e.target.closest('.item-input');
        if (!input) return;
        const idx = Number(input.dataset.idx);
        const field = input.dataset.field;
        let value = input.value;
        if (field === 'cantidad' || field === 'precio') {
            value = parseFloat(value) || 0;
            if (field === 'cantidad' && value < 1) value = 1;
        }
        state.items[idx][field] = value;
        hideError('items');

        const row = input.closest('tr');
        if (row) {
            const totalCell = row.querySelector('.item-total');
            if (totalCell) totalCell.textContent = money(lineTotal(state.items[idx]));
        }
        updateTotals();
    });

    $('#items-body').addEventListener('click', (e) => {
        const btn = e.target.closest('.remove-item');
        if (!btn) return;
        state.items.splice(Number(btn.dataset.idx), 1);
        if (state.items.length === 0) state.items.push(defaultItem());
        renderItems();
    });

    $('#btn-add-item').addEventListener('click', () => {
        state.items.push({ cantidad: 1, descripcion: '', precio: 0 });
        renderItems();
        const rows = $('#items-body').querySelectorAll('tr');
        const last = rows[rows.length - 1];
        if (last) last.querySelector('.item-input[data-field="descripcion"]').focus();
        hideError('items');
    });

    // ===== Paso 6: condiciones =====
    $$('.moneda-toggle').forEach((btn) => {
        btn.addEventListener('click', () => {
            state.moneda = btn.dataset.moneda;
            $$('.moneda-toggle').forEach((b) => b.classList.remove('active'));
            btn.classList.add('active');
            updateTotals();
        });
    });

    $$('.forma-pago-toggle').forEach((btn) => {
        btn.addEventListener('click', () => {
            state.formaPago = btn.dataset.forma;
            $$('.forma-pago-toggle').forEach((b) => b.classList.remove('active'));
            btn.classList.add('active');
        });
    });

    $('#observaciones').addEventListener('input', (e) => { state.observaciones = e.target.value; });

    // ===== Paso 7: vista previa =====
    function buildPreview() {
        const c = calc();
        const esBoleta = state.tipo === 'B';
        const emisor = {
            razonSocial: cfg.razon.value.trim() || CONFIG.emisor.razonSocial,
            ruc: cfg.ruc.value.trim() || CONFIG.emisor.ruc,
            direccion: CONFIG.emisor.direccion,
            telefono: CONFIG.emisor.telefono,
            email: CONFIG.emisor.email,
        };

        state.serie = esBoleta ? 'B001' : 'F001';
        if (state.numero === null) {
            state.numero = (Math.floor(Math.random() * 8000) + 1000).toString().padStart(8, '0');
        }

        const tipoDocLabel = esBoleta ? 'BOLETA' : 'FACTURA';
        const esRuc = /^\d{11}$/.test(state.cliente.doc);
        const docLabel = esRuc ? 'RUC' : 'DNI';
        const clienteDoc = state.cliente.doc || (esBoleta ? 'CONSUMIDOR FINAL' : '-');
        const nombre = (state.cliente.nombre.trim() || 'CONSUMIDOR FINAL').toUpperCase();
        const direccion = state.cliente.direccion.trim();
        const monedaNombre = state.moneda === 'PEN' ? 'SOLES' : 'DOLARES AMERICANOS';
        const simbolo = state.moneda === 'PEN' ? 'S/' : '$';
        const forma = state.formaPago === 'contado' ? 'CONTADO' : 'CREDITO';
        const ambiente = state.config.ambiente === 'produccion' ? 'PRODUCCION' : 'BETA';

        const items = state.items.filter((it) => it.descripcion.trim() !== '' && lineTotal(it) > 0);

        const rows = items.map((it) => {
            const total = lineTotal(it);
            const sub = total / 1.18;
            return `<tr>
                <td>${parseInt(it.cantidad) || 1}</td>
                <td>ZZ</td>
                <td>${escapeHtml(it.descripcion)}</td>
                <td style="text-align:right">${simbolo} ${num(parseFloat(it.precio) || 0)}</td>
                <td style="text-align:right">${simbolo} ${num(sub)}</td>
            </tr>`;
        }).join('');

        const obsRow = state.observaciones.trim()
            ? `<tr><td style="width:30%">OBSERVACIONES:</td><td>${escapeHtml(state.observaciones)}</td></tr>`
            : '';

        $('#invoice-preview').innerHTML = `
            <div class="watermark-simulacion"></div>
            <table style="width:100%; border-collapse:collapse; margin-bottom:6px;">
                <tr>
                    <td style="width:24%; text-align:center; vertical-align:middle; padding:4px;">
                        <img src="${CONFIG.sistema.logo}" alt="BYTFACT" style="height:34px; margin:auto;">
                    </td>
                    <td style="width:44%; text-align:center; vertical-align:middle; padding:4px;">
                        <div style="font-weight:bold; font-size:13px;">${escapeHtml(emisor.razonSocial)}</div>
                        <div style="font-size:11px;">RUC: ${escapeHtml(emisor.ruc)}</div>
                        <div style="font-size:9px;">${escapeHtml(emisor.direccion)}</div>
                        <div style="font-size:9px;">${escapeHtml(emisor.telefono)} · ${escapeHtml(emisor.email)}</div>
                    </td>
                    <td style="width:32%; text-align:center; vertical-align:middle; padding:4px;">
                        <div style="display:inline-block; border:2px solid #000; font-weight:bold; padding:3px 10px; font-size:12px;">${tipoDocLabel} ELECTRONICA</div>
                        <div style="font-weight:bold; font-size:14px; margin-top:5px;">${state.serie}-${state.numero}</div>
                        <div style="font-size:8px;">AMBIENTE: ${ambiente}</div>
                    </td>
                </tr>
            </table>

            <table class="inv-table" style="margin-bottom:8px; font-size:10px;">
                <tr><td style="width:32%">FECHA DE EMISION:</td><td>${fechaHoy()}</td></tr>
                <tr><td>SENIOR(ES):</td><td>${escapeHtml(nombre)}</td></tr>
                <tr><td>${docLabel}:</td><td>${escapeHtml(clienteDoc)}</td></tr>
                <tr><td>DIRECCION:</td><td>${escapeHtml(direccion || '-')}</td></tr>
                <tr><td>MONEDA:</td><td>${monedaNombre}</td></tr>
                <tr><td>CONDICION DE PAGO:</td><td>${forma}</td></tr>
                ${obsRow}
            </table>

            <table class="inv-table" style="margin-bottom:8px;">
                <thead>
                    <tr><th>CANT.</th><th>UNID.</th><th>DESCRIPCION</th><th style="text-align:right">P. UNIT.</th><th style="text-align:right">VALOR VTA.</th></tr>
                </thead>
                <tbody>${rows}</tbody>
            </table>

            <table class="inv-table inv-totals" style="margin-bottom:8px;">
                <tr><td>OP. GRAVADAS</td><td style="text-align:right">${simbolo} ${num(c.gravadas)}</td></tr>
                <tr><td>IGV 18%</td><td style="text-align:right">${simbolo} ${num(c.igv)}</td></tr>
                <tr style="font-weight:bold"><td>IMPORTE TOTAL</td><td style="text-align:right">${simbolo} ${num(c.total)}</td></tr>
            </table>

            <div style="font-size:10px; margin-bottom:10px;"><strong>SON:</strong> ${numeroALetras(c.total)} ${monedaNombre}</div>

            <div style="display:flex; justify-content:space-between; align-items:flex-start; gap:12px;">
                <div style="font-size:8px; max-width:62%; line-height:1.5;">
                    Representacion impresa del comprobante electronico.<br>
                    Emitido con <strong>bytfact.</strong> — facturación electrónica.<br>
                    Simulación sin valor tributario. No autorizado por SUNAT.
                </div>
                <div class="qr-box byt"></div>
            </div>`;
    }

    // ===== Emisión simulada =====
    $('#btn-emitir').addEventListener('click', () => {
        const btn = $('#btn-emitir');
        const text = $('#btn-emitir-text');
        btn.disabled = true;
        text.textContent = 'Firmando XML UBL 2.1...';

        setTimeout(() => { text.textContent = 'Enviando a SUNAT...'; }, 700);
        setTimeout(() => { text.textContent = 'Esperando CDR...'; }, 1500);

        setTimeout(() => {
            $('#res-numero').textContent = `${state.serie}-${state.numero}`;
            $('#res-fecha').textContent = fechaHoy();
            $('#res-hash').textContent = randomHash();
            $('#emision-result').classList.remove('hidden');

            btn.disabled = false;
            text.textContent = 'Emitir comprobante (simulado)';

            $('#emision-result').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 2300);
    });

    $('#btn-reiniciar').addEventListener('click', () => {
        const ambiente = state.config.ambiente;
        const probado = state.config.probado;
        const demo = state.config.demo;

        state = initialState();
        state.config = { ambiente, probado, demo };

        docInput.value = '';
        nombreInput.value = '';
        direccionInput.value = '';
        $('#observaciones').value = '';
        $$('.tipo-card').forEach((c) => c.classList.remove('selected'));
        app.querySelector('.tipo-card[data-tipo="B"]').classList.add('selected');
        $$('.moneda-toggle').forEach((b) => b.classList.toggle('active', b.dataset.moneda === 'PEN'));
        $$('.forma-pago-toggle').forEach((b) => b.classList.toggle('active', b.dataset.forma === 'contado'));
        $('#emision-result').classList.add('hidden');
        limpiarPill();
        $('#consulta-cupo').textContent = '';
        clearClienteErrors();
        hideError('items');
        renderItems();
        goToStep(1);
    });

    // ===== Botones de navegación =====
    $('#btn-next').addEventListener('click', () => {
        if (validationError(state.step)) return;
        if (state.step < TOTAL_STEPS) goToStep(state.step + 1);
    });

    $('#btn-prev').addEventListener('click', () => {
        if (state.step > 1) {
            clearClienteErrors();
            hideError('items');
            $('#config-warning').classList.add('hidden');
            goToStep(state.step - 1);
        }
    });

    // ===== Init =====
    app.querySelector('.tipo-card[data-tipo="B"]').classList.add('selected');
    restaurarConfig();
    pintarCupo(CONFIG.consulta.limitePorIp);
    renderItems();
});
