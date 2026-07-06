<footer class="bg-navy text-white">
    <div class="max-w-container-max mx-auto px-gutter py-16">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12">
            <div class="md:col-span-4">
                <img src="{{ asset('images/AA Consultores.png') }}" alt="Aguilar & Arce" width="256" height="256" class="object-contain w-20 h-20 mb-4 opacity-80">
                <p class="text-white/60 text-sm leading-relaxed max-w-xs">Consultoría estratégica de alto nivel para un mundo impulsado por datos. Transformamos números en decisiones.</p>
            </div>
            <div class="md:col-span-2">
                <h4 class="font-semibold text-white/80 mb-6 text-sm uppercase tracking-widest">Servicios</h4>
                <nav class="flex flex-col gap-3">
                    <a class="text-white/50 hover:text-white transition-colors text-sm" href="#servicios">Contabilidad</a>
                    <a class="text-white/50 hover:text-white transition-colors text-sm" href="#servicios">Auditoría</a>
                    <a class="text-white/50 hover:text-white transition-colors text-sm" href="#servicios">Tax Advisory</a>
                    <a class="text-white/50 hover:text-white transition-colors text-sm" href="#servicios">M&amp;A</a>
                </nav>
            </div>
            <div class="md:col-span-2">
                <h4 class="font-semibold text-white/80 mb-6 text-sm uppercase tracking-widest">Empresa</h4>
                <nav class="flex flex-col gap-3">
                    <a class="text-white/50 hover:text-white transition-colors text-sm" href="#nosotros">Nosotros</a>
                    <a class="text-white/50 hover:text-white transition-colors text-sm" href="#blog">Blog</a>
                    <a class="text-white/50 hover:text-white transition-colors text-sm" href="#contacto">Contacto</a>
                    <a class="text-white/50 hover:text-white transition-colors text-sm" href="#">Carreras</a>
                </nav>
            </div>
            <div class="md:col-span-4">
                <h4 class="font-semibold text-white/80 mb-6 text-sm uppercase tracking-widest">Conectar</h4>
                <div class="flex gap-4 mb-6">
                    <a class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-colors" href="#" aria-label="LinkedIn">
                        <span class="material-symbols-outlined text-white">linkedin</span>
                    </a>
                    <a class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-colors" href="#" aria-label="Instagram">
                        <span class="material-symbols-outlined text-white">instagram</span>
                    </a>
                    <a class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center hover:bg-white/20 transition-colors" href="#" aria-label="WhatsApp">
                        <span class="material-symbols-outlined text-white">call</span>
                    </a>
                </div>
                <p class="text-white/40 text-sm">contacto@aguilar-arce.com</p>
            </div>
        </div>
    </div>
    <div class="border-t border-white/5">
        <div class="max-w-container-max mx-auto px-gutter py-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-white/40 text-sm">&copy; {{ date('Y') }} Aguilar &amp; Arce Consultores. Todos los derechos reservados.</p>
            <div class="flex gap-6">
                <a class="text-white/40 hover:text-white text-sm transition-colors" href="#">Privacidad</a>
                <a class="text-white/40 hover:text-white text-sm transition-colors" href="#">Términos</a>
            </div>
        </div>
    </div>
</footer>
