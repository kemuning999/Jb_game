<div id="jb-splash-overlay" 
     class="fixed inset-0 z-[999999] flex flex-col items-center justify-center bg-white text-slate-900 select-none overflow-hidden" 
     style="display: none; pointer-events: all; cursor: wait;">

    <!-- Delicate Ambient Glow & Particles Layer -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute w-[600px] h-[600px] rounded-full bg-slate-100 blur-3xl -top-20 -left-20 pointer-events-none"></div>
        <div class="absolute w-[500px] h-[500px] rounded-full bg-indigo-50/60 blur-3xl -bottom-20 -right-20 pointer-events-none"></div>

        <!-- Floating Micro-Particles -->
        <div class="particle-spark absolute w-1.5 h-1.5 rounded-full bg-slate-300 opacity-60 top-1/4 left-1/3 animate-ping" style="animation-duration: 2.5s;"></div>
        <div class="particle-spark absolute w-2 h-2 rounded-full bg-indigo-200 opacity-50 top-1/3 right-1/4 animate-pulse" style="animation-duration: 3s;"></div>
        <div class="particle-spark absolute w-1.5 h-1.5 rounded-full bg-slate-400 opacity-40 bottom-1/3 left-1/4 animate-bounce" style="animation-duration: 3.5s;"></div>
        <div class="particle-spark absolute w-2 h-2 rounded-full bg-slate-200 opacity-70 bottom-1/4 right-1/3 animate-ping" style="animation-duration: 2.8s;"></div>
    </div>

    <!-- Center Cinematic JB Logo Box -->
    <div id="splash-logo-container" 
         class="relative z-10 flex flex-col items-center justify-center p-8 transition-all duration-700 ease-out">
        
        <!-- Logo Outer Glow & Soft Shadow -->
        <div class="relative flex items-center justify-center">
            
            <!-- Soft Expanding Ambient Ring (Cinematic Splash) -->
            <div id="splash-pulse-ring" class="absolute -inset-8 rounded-full border border-slate-200/80 scale-75 opacity-0 transition-all duration-1000 ease-out pointer-events-none"></div>
            
            <!-- Logo JB Emblem Badge -->
            <div id="splash-emblem-badge" 
                 class="relative w-32 h-32 sm:w-36 sm:h-36 rounded-3xl bg-white border border-slate-200/80 shadow-[0_20px_50px_rgba(0,0,0,0.06)] flex items-center justify-center p-5 overflow-hidden transform scale-95 opacity-0 transition-all duration-700 ease-out">
                
                <!-- The JB Logo SVG -->
                <div class="w-full h-full text-slate-950 flex items-center justify-center">
                    <x-jb-logo />
                </div>

                <!-- Light Streak Beam (Sweeps from left to right) -->
                <div id="splash-light-streak" 
                     class="absolute inset-y-0 w-24 bg-gradient-to-r from-transparent via-white/80 to-transparent skew-x-[-25deg] transform -translate-x-[250%] pointer-events-none transition-transform duration-1000 ease-in-out"></div>
            </div>
        </div>

        <!-- Typography: ANDRA JB & Tagline -->
        <div id="splash-text-container" class="mt-6 text-center space-y-1 opacity-0 transform translate-y-3 transition-all duration-600 ease-out">
            <span class="block text-xl sm:text-2xl font-black tracking-widest text-slate-900 uppercase">
                ANDRA JB
            </span>
            <span class="block text-[11px] font-bold tracking-[0.3em] text-slate-400 uppercase">
                White Premium Gaming Marketplace
            </span>
        </div>

        <!-- Micro Loading Shimmer Indicator -->
        <div id="splash-shimmer-bar" class="w-28 h-1 rounded-full bg-slate-100 overflow-hidden mt-6 opacity-0 transition-opacity duration-500">
            <div class="w-full h-full bg-slate-900 rounded-full animate-[shimmer_1.5s_infinite]"></div>
        </div>
    </div>
</div>

<style>
@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}
</style>

<script>
(function() {
    const splashOverlay = document.getElementById('jb-splash-overlay');
    const splashLogoContainer = document.getElementById('splash-logo-container');
    const splashEmblemBadge = document.getElementById('splash-emblem-badge');
    const splashLightStreak = document.getElementById('splash-light-streak');
    const splashPulseRing = document.getElementById('splash-pulse-ring');
    const splashText = document.getElementById('splash-text-container');
    const shimmerBar = document.getElementById('splash-shimmer-bar');
    const navbarLogoBadge = document.getElementById('navbar-logo-badge');
    const navbarBrandText = document.getElementById('navbar-brand-text');

    if (!splashOverlay) return;

    // Cek session storage (atau paksa muncul dengan query ?intro=1)
    const urlParams = new URLSearchParams(window.location.search);
    const forceIntro = urlParams.has('intro') || urlParams.has('splash');
    const alreadyPlayed = sessionStorage.getItem('jbgame_white_splash');

    if (alreadyPlayed && !forceIntro) {
        // Jika sudah pernah melihat di sesi ini, biarkan navbar normal
        if (navbarLogoBadge) navbarLogoBadge.style.opacity = '1';
        return;
    }

    // Aktifkan overlay putih & kunci scroll
    splashOverlay.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    if (navbarLogoBadge) navbarLogoBadge.style.opacity = '0'; // Sembunyikan dulu logo navbar untuk efek morfing

    // Alur Cinematic Splash Logo JB:
    // 1. (t = 200ms): Logo JB muncul perlahan + sedikit membesar
    setTimeout(() => {
        splashEmblemBadge.style.opacity = '1';
        splashEmblemBadge.style.transform = 'scale(1.08)';
        splashText.style.opacity = '1';
        splashText.style.transform = 'translateY(0)';
        shimmerBar.style.opacity = '1';
    }, 200);

    // 2. (t = 900ms): Light streak menyapu melewati logo JB
    setTimeout(() => {
        splashLightStreak.style.transform = 'translateX(300%)';
        splashPulseRing.style.opacity = '0.7';
        splashPulseRing.style.transform = 'scale(1.35)';
    }, 900);

    // 3. (t = 1600ms): Dramatic reveal - Logo JB menjadi sangat jelas & tajam
    setTimeout(() => {
        splashEmblemBadge.style.transform = 'scale(1.15)';
        splashEmblemBadge.style.boxShadow = '0 30px 60px rgba(0,0,0,0.08)';
        splashPulseRing.style.opacity = '0';
        splashPulseRing.style.transform = 'scale(1.8)';
    }, 1600);

    // 4. (t = 2400ms): TRANSISI KEAJAIBAN - Logo mengecil dan meluncur mulus tepat ke posisi Navbar!
    setTimeout(() => {
        if (!navbarLogoBadge) {
            // Fallback jika navbar logo tidak ditemukan
            splashOverlay.style.opacity = '0';
            setTimeout(() => {
                splashOverlay.remove();
                document.body.style.overflow = '';
                sessionStorage.setItem('jbgame_white_splash', 'shown');
            }, 600);
            return;
        }

        // Hitung koordinat presisi navbar logo badge di layar (FLIP Transition)
        const targetRect = navbarLogoBadge.getBoundingClientRect();
        const badgeRect = splashEmblemBadge.getBoundingClientRect();

        const deltaX = (targetRect.left + targetRect.width / 2) - (badgeRect.left + badgeRect.width / 2);
        const deltaY = (targetRect.top + targetRect.height / 2) - (badgeRect.top + badgeRect.height / 2);
        const scaleFactor = targetRect.width / badgeRect.width;

        // Hilangkan teks pembantu splash secara halus
        splashText.style.opacity = '0';
        splashText.style.transform = 'translateY(10px)';
        shimmerBar.style.opacity = '0';

        // Animasikan Emblem meluncur tepat ke posisi navbar
        splashEmblemBadge.style.transition = 'all 750ms cubic-bezier(0.16, 1, 0.3, 1)';
        splashEmblemBadge.style.transform = `translate(${deltaX}px, ${deltaY}px) scale(${scaleFactor})`;
        splashEmblemBadge.style.borderRadius = '1rem'; // Sesuaikan border radius navbar (rounded-2xl)

        // Fade out background putih splash untuk memperlihatkan Hero Section di baliknya
        setTimeout(() => {
            splashOverlay.style.transition = 'opacity 500ms ease-out';
            splashOverlay.style.opacity = '0';
        }, 300);

        // Setelah meluncur sampai di tujuan (t = 750ms dari mulai terbang)
        setTimeout(() => {
            navbarLogoBadge.style.opacity = '1';
            navbarLogoBadge.classList.add('animate-pulse');
            setTimeout(() => navbarLogoBadge.classList.remove('animate-pulse'), 1000);

            splashOverlay.remove();
            document.body.style.overflow = '';
            sessionStorage.setItem('jbgame_white_splash', 'shown');
        }, 750);

    }, 2400);

})();
</script>
