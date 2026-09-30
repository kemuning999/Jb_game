<svg viewBox="0 0 140 140" fill="none" xmlns="http://www.w3.org/2000/svg" {{ $attributes->merge(['class' => 'w-full h-full']) }}>
    <!-- ANDRA JB - Official Brand Vector Logo -->
    <defs>
        <linearGradient id="andra-accent-grad" x1="0%" y1="0%" x2="100%" y2="100%">
            <stop offset="0%" stop-color="#4f46e5" />
            <stop offset="100%" stop-color="#06b6d4" />
        </linearGradient>
    </defs>

    <!-- Outer Precision Hexagonal Shield Frame (Subtle) -->
    <path d="M70 10 L122 36 L122 96 L70 126 L18 96 L18 36 Z" 
          stroke="currentColor" 
          stroke-width="3" 
          stroke-linejoin="round" 
          opacity="0.12" />

    <!-- Apex Letter 'A' (Sharp Dynamic Crown) -->
    <path d="M70 18 L108 84 L92 84 L70 44 L48 84 L32 84 Z" 
          fill="currentColor" />

    <!-- Intersecting 'J' Swoop (Left Core) -->
    <path d="M52 58 H64 V96 C64 106 56 114 44 114 C34 114 26 107 24 98 L36 94 C37 98 40 101 44 101 C48 101 52 97 52 93 V58 Z" 
          fill="currentColor" />

    <!-- Intersecting 'B' Loops (Right Core) -->
    <path fill-rule="evenodd" clip-rule="evenodd" 
          d="M74 54 H98 C107 54 114 60.5 114 69 C114 74.5 110.5 79.5 105 82 C112 85 116 91.5 116 99 C116 109.5 107.5 118 97 118 H74 V54 Z M86 65 V79 H97 C101.5 79 105 75.5 105 71.5 C105 67.5 101.5 65 97 65 H86 Z M86 89 V107 H97 C102 107 106 103 106 98 C106 93 102 89 97 89 H86 Z" 
          fill="currentColor" />

    <!-- Cyber Crossbar Accent (Unifying AJB) -->
    <path d="M46 72 L94 72" 
          stroke="url(#andra-accent-grad)" 
          stroke-width="5" 
          stroke-linecap="round" />

    <!-- Glowing Core Dot -->
    <circle cx="70" cy="96" r="3.5" fill="url(#andra-accent-grad)" />
</svg>
