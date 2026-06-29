<section class="relative pt-32 pb-24 md:pt-48 md:pb-40 overflow-hidden">
    <div class="max-w-container-max mx-auto px-gutter grid grid-cols-1 md:grid-cols-12 gap-base items-center">
        <div class="md:col-span-8 z-10">
            <h1 class="font-display-lg text-display-lg-mobile md:text-display-lg text-primary mb-8 leading-tight">
                {{ $hero['titulo'] ?? 'Transformamos números en' }} <br>
                <span class="italic font-normal">{{ $hero['subtitulo'] ?? 'decisiones estratégicas.' }}</span>
            </h1>
            <p class="font-body-lg text-on-surface-variant max-w-lg mb-12">
                {{ $hero['descripcion'] ?? 'Acompañamos a las empresas líderes en su evolución financiera y tecnológica mediante una visión audaz y datos precisos.' }}
            </p>
            <div class="flex items-center gap-12">
                <a class="group flex items-center gap-4 font-label-sm text-primary tracking-widest uppercase" href="#servicios">
                    Explorar servicios
                    <span class="material-symbols-outlined group-hover:translate-x-2 transition-transform">arrow_forward</span>
                </a>
            </div>
        </div>
        <div class="hidden md:block md:col-span-4 relative h-[600px] mt-12 md:mt-0">
            <div class="absolute inset-0 bg-secondary-container/20 -rotate-3 rounded-xl"></div>
            <div class="absolute inset-0 bg-cover bg-center rounded-xl shadow-2xl z-0" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDUUbCS0pwExAHFQ9iMjpBNW3qWYrZKFxrt27KEYWE-8hMTiNcCqal5o976ULodSPqeL2Z29KHUe67jwGSyNfLM0YiVf-8bTnphCWpnJsM3tbA3Jo0YsAtPAaKBlgdJvG4P-St5Rw3vNSJ3tysiWnO_YGamoFCoJ1MyVyNiIxwu4GwnxsykiKz9t-XquBV6QdZZ91WgVVsuTRjNzVQffqMmvbboSyCDXhsuJZkTcwKtJB4CsonfBCUPeSkSfmGbxRA0P-t7UBfwxn9t')"></div>
        </div>
    </div>
    <div class="absolute top-0 right-0 w-1/2 h-full bg-surface-container-low -z-10 opacity-50"></div>
</section>
