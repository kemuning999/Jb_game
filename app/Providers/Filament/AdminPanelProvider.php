<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('ANDRA JB')
            ->brandLogo(fn () => view('filament.brand-logo'))
            ->brandLogoHeight('2.5rem')
            ->font(
                'Inter',
                url: asset('fonts/filament/filament/inter/index.css'),
                provider: \Filament\FontProviders\LocalFontProvider::class,
            )
            ->colors([
                'primary' => Color::Indigo,
                'gray' => Color::Slate,
            ])
            ->navigationGroups([
                'Etalase Toko',
                'Penjualan',
                'Pengaturan Akses',
            ])
            ->renderHook('panels::head.end', fn () => new \Illuminate\Support\HtmlString('
                <style>
                    .brand-title-text { color: #0f172a; }
                    .dark .brand-title-text { color: #f8fafc !important; }
                    .footer-brand-text { color: #334155; }
                    .dark .footer-brand-text { color: #cbd5e1 !important; }
                    .fi-logo { display: inline-flex !important; align-items: center !important; }
                    .fi-logo svg, .fi-logo img { max-height: 2.5rem !important; }
                    .fi-sidebar-header { min-height: 4rem; display: flex; align-items: center; }
                </style>
            '))
            ->renderHook('panels::footer', fn () => view('filament.custom-footer'))
            ->sidebarCollapsibleOnDesktop()
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                \App\Filament\Widgets\StatsOverview::class,
                AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
