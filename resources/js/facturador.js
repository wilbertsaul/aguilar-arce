/**
 * Simulador de Facturación Electrónica — Aguilar & Arce Consultores
 * ------------------------------------------------------------------
 * JS vanilla (sin dependencias, sin Livewire). Réplica del flujo del facturador.
 * Cálculos idénticos al facturador real: por línea, subtotal = total / 1.18
 * y IGV = total - subtotal (18%). Todo ocurre en el navegador: no se envía
 * nada a SUNAT ni se guardan datos.
 */
document.addEventListener('DOMContentLoaded', () => {
    const app = document.getElementById('facturador-app');
    if (!app) return;

    const CONFIG = JSON.parse(document.getElementById('facturador-data').textContent);

    // ===== Estado =====
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
    });

    function defaultItem() {
        const s = CONFIG.servicios[0];
        return { cantidad: 1, descripcion: s.descripcion, precio: s.precio };
    }

    let state = initialState();

    // ===== Helpers =====
    const $ = (sel) => app.querySelector(sel);
    const $$ = (sel) => Array.from(app.querySelectorAll(sel));

    function money(n, moneda = state.moneda) {
        const symbol = moneda === 'PEN' ? 'S/' : '$';
        return symbol + ' ' + (Number.isFinite(n) ? n : 0).toLocaleString('es-PE', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2,
        });
    }

    const num = (n) => (Number.isFinite(n) ? n : 0).toLocaleString('es-PE', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });

    function escapeHtml(str) {
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

    const lineTotal = (item) => (parseFloat(item.cantidad) || 0) * (parseFloat(item.precio) || 0);

    // Totales estilo facturador real: cada línea incluye IGV (precio con IGV).
    function calc() {
        let gravadas = 0, igv = 0, total = 0;
        state.items.forEach((item) => {
            const t = lineTotal(item);
            const sub = t / 1.18;
            gravadas += sub;
            igv += t - sub;
            total += t;
        });
        gravadas = Math.round(gravadas * 100) / 100;
        igv = Math.round(igv * 100) / 100;
        total = Math.round(total * 100) / 100;
        return { gravadas, igv, total };
    }

    // ===== Número a letras (es-PE) =====
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
        let out = [];
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

    // ===== Navegación del stepper =====
    function goToStep(step) {
        state.step = step;
        $$('.panel').forEach((p) => p.classList.toggle('hidden', Number(p.dataset.panel) !== step));
        $$('.stepper-step').forEach((el) => {
            const s = Number(el.dataset.step);
            el.classList.toggle('active', s === step);
            el.classList.toggle('done', s < step);
            const dot = el.querySelector('.stepper-dot');
            if (s < step) dot.textContent = '✓';
            else dot.textContent = String(s);
        });
        $('#step-indicator').textContent = `Paso ${step} de 5`;
        $('#btn-prev').classList.toggle('invisible', step === 1);
        $('#btn-next').classList.toggle('hidden', step === 5);
        if (step === 5) buildPreview();
        app.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function validationError(step) {
        if (step === 2) {
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
                    showClienteError('doc', 'El DNI debe tener 8 dígitos (o déjelo vacío para CONSUMIDOR FINAL).');
                    return 'cliente';
                }
                if (doc !== '' && !nombre) {
                    showClienteError('nombre', 'Ingrese el nombre del cliente o use CONSUMIDOR FINAL.');
                    return 'cliente';
                }
            }
        }
        if (step === 3) {
            hideError('items');
            const hayValido = state.items.some((it) => it.descripcion.trim() !== '' && lineTotal(it) > 0);
            if (!hayValido) {
                showError('items', 'Agregue al menos un servicio con descripción y precio mayor a cero.');
                return 'items';
            }
        }
        return null;
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

    // ===== Paso 1: tipo de comprobante =====
    $$('.tipo-card').forEach((card) => {
        card.addEventListener('click', () => {
            state.tipo = card.dataset.tipo;
            $$('.tipo-card').forEach((c) => c.classList.remove('selected'));
            card.classList.add('selected');
            clearClienteErrors();
        });
    });

    // ===== Paso 2: cliente =====
    const docInput = $('#cliente-doc');
    const nombreInput = $('#cliente-nombre');
    const direccionInput = $('#cliente-direccion');

    docInput.addEventListener('input', () => {
        const v = docInput.value.replace(/\D/g, '').slice(0, 11);
        docInput.value = v;
        state.cliente.doc = v;
        clearClienteErrors();

        const label = $('#cliente-tipo-label');
        if (v.length === 11) label.textContent = '(RUC)';
        else if (v.length === 8) label.textContent = '(DNI)';
        else label.textContent = '(DNI o RUC)';

        const found = CONFIG.clientes.find((c) => c.doc === v);
        if (found) {
            state.cliente.nombre = found.nombre;
            state.cliente.direccion = found.direccion;
            nombreInput.value = found.nombre;
            direccionInput.value = found.direccion;
        }
    });

    nombreInput.addEventListener('input', () => { state.cliente.nombre = nombreInput.value; clearClienteErrors(); });
    direccionInput.addEventListener('input', () => { state.cliente.direccion = direccionInput.value; });

    $('#btn-consumidor-final').addEventListener('click', () => {
        if (state.tipo === 'F') {
            clearClienteErrors();
            showClienteError('doc', 'Las facturas requieren RUC. Cambie a Boleta o ingrese el RUC del cliente.');
            return;
        }
        clearClienteErrors();
        state.cliente = { doc: '', nombre: 'CONSUMIDOR FINAL', direccion: '' };
        docInput.value = '';
        nombreInput.value = 'CONSUMIDOR FINAL';
        direccionInput.value = '';
    });

    // ===== Paso 3: items =====
    function renderItems() {
        const tbody = $('#items-body');
        tbody.innerHTML = '';

        // datalist con los servicios demo
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
            row.className = 'border-b border-outline-variant/50';
            row.innerHTML = `
                <td class="py-3 pr-2">
                    <input type="number" min="1" step="1" value="${item.cantidad}" data-idx="${i}" data-field="cantidad"
                        class="item-input w-16 bg-white border border-outline-variant rounded-lg px-2 py-2 text-sm text-navy focus:border-teal-accent outline-none">
                </td>
                <td class="py-3 pr-2">
                    <input type="text" list="lista-servicios" value="${escapeHtml(item.descripcion)}" data-idx="${i}" data-field="descripcion"
                        class="item-input w-full bg-white border border-outline-variant rounded-lg px-3 py-2 text-sm text-navy focus:border-teal-accent outline-none">
                </td>
                <td class="py-3 pr-2">
                    <input type="number" min="0" step="0.01" value="${item.precio}" data-idx="${i}" data-field="precio"
                        class="item-input w-28 bg-white border border-outline-variant rounded-lg px-2 py-2 text-sm text-right font-mono text-navy focus:border-teal-accent outline-none">
                </td>
                <td class="py-3 pr-2 text-right font-mono text-sm font-bold text-navy item-total">${money(lineTotal(item))}</td>
                <td class="py-3 text-center">
                    <button type="button" class="remove-item w-8 h-8 inline-flex items-center justify-center rounded-lg text-grey-metallic hover:text-error hover:bg-error/10 transition-colors" data-idx="${i}" title="Quitar servicio" ${state.items.length === 1 ? 'style="opacity:0.3; pointer-events:none;"' : ''}>
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
        const idx = Number(btn.dataset.idx);
        state.items.splice(idx, 1);
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

    // ===== Paso 4: condiciones =====
    $$('.moneda-toggle').forEach((btn) => {
        btn.addEventListener('click', () => {
            state.moneda = btn.dataset.moneda;
            $$('.moneda-toggle').forEach((b) => b.classList.remove('active'));
            btn.classList.add('active');
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

    // ===== Paso 5: vista previa (réplica del comprobante) =====
    function buildPreview() {
        const c = calc();
        const esBoleta = state.tipo === 'B';
        state.serie = esBoleta ? 'B001' : 'F001';
        state.numero = String(Math.floor(Math.random() * 8000) + 1000).padStart(8, '0');

        const tipoDocLabel = esBoleta ? 'BOLETA' : 'FACTURA';
        const esRuc = /^\d{11}$/.test(state.cliente.doc);
        const docLabel = esRuc ? 'RUC' : 'DNI';
        const clienteDoc = state.cliente.doc || (esBoleta ? 'CONSUMIDOR FINAL' : '-');
        const nombre = (state.cliente.nombre.trim() || 'CONSUMIDOR FINAL').toUpperCase();
        const direccion = state.cliente.direccion.trim();
        const monedaNombre = state.moneda === 'PEN' ? 'SOLES' : 'DOLARES AMERICANOS';
        const simbolo = state.moneda === 'PEN' ? 'S/' : '$';
        const forma = state.formaPago === 'contado' ? 'CONTADO' : 'CREDITO';
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
                        <img src="${CONFIG.logo}" alt="Logo" style="height:54px; margin:auto;">
                    </td>
                    <td style="width:44%; text-align:center; vertical-align:middle; padding:4px;">
                        <div style="font-weight:bold; font-size:13px;">${escapeHtml(CONFIG.razonSocial)}</div>
                        <div style="font-size:11px;">RUC: ${escapeHtml(CONFIG.ruc)}</div>
                        <div style="font-size:9px;">${escapeHtml(CONFIG.direccion)}</div>
                    </td>
                    <td style="width:32%; text-align:center; vertical-align:middle; padding:4px;">
                        <div style="display:inline-block; border:2px solid #000; font-weight:bold; padding:3px 10px; font-size:12px;">${tipoDocLabel} ELECTRONICA</div>
                        <div style="font-weight:bold; font-size:14px; margin-top:5px;">${state.serie}-${state.numero}</div>
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
                    Emitido en el simulador web de Aguilar &amp; Arce Consultores.<br>
                    Autorizado mediante el Sistema de Emision Electronica - SIMULACION.
                </div>
                <div class="qr-box"></div>
            </div>`;
    }

    // ===== Emisión simulada =====
    $('#btn-emitir').addEventListener('click', () => {
        const btn = $('#btn-emitir');
        const text = $('#btn-emitir-text');
        btn.disabled = true;
        btn.classList.add('opacity-70', 'cursor-wait');
        text.textContent = 'Enviando a SUNAT...';

        setTimeout(() => {
            $('#res-numero').textContent = `${state.serie}-${state.numero}`;
            $('#res-fecha').textContent = fechaHoy();
            $('#res-hash').textContent = randomHash();
            $('#emision-result').classList.remove('hidden');

            btn.disabled = false;
            btn.classList.remove('opacity-70', 'cursor-wait');
            text.textContent = 'Emitir comprobante (simulado)';

            $('#emision-result').scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 1200);
    });

    $('#btn-reiniciar').addEventListener('click', () => {
        state = initialState();
        docInput.value = '';
        nombreInput.value = '';
        direccionInput.value = '';
        $('#observaciones').value = '';
        $$('.tipo-card').forEach((c) => c.classList.remove('selected'));
        app.querySelector('.tipo-card[data-tipo="B"]').classList.add('selected');
        $$('.moneda-toggle').forEach((b) => b.classList.toggle('active', b.dataset.moneda === 'PEN'));
        $$('.forma-pago-toggle').forEach((b) => b.classList.toggle('active', b.dataset.forma === 'contado'));
        $('#emision-result').classList.add('hidden');
        clearClienteErrors();
        hideError('items');
        renderItems();
        goToStep(1);
    });

    // ===== Botones de navegación =====
    $('#btn-next').addEventListener('click', () => {
        const error = validationError(state.step);
        if (error) return;
        if (state.step < 5) goToStep(state.step + 1);
    });

    $('#btn-prev').addEventListener('click', () => {
        if (state.step > 1) {
            clearClienteErrors();
            hideError('items');
            goToStep(state.step - 1);
        }
    });

    // ===== Init =====
    app.querySelector('.tipo-card[data-tipo="B"]').classList.add('selected');
    renderItems();
});
